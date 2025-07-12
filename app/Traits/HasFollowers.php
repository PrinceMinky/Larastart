<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

trait HasFollowers
{
    // Static cache to prevent duplicate queries within the same request
    protected static $followCache = [];
    protected static $followerCache = [];
    
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withPivot('status')->withTimestamps();
    }
    
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withPivot('status')->withTimestamps();
    }

    /**
     * Cache-optimized method to get followers with accepted status
     */
    public function getAcceptedFollowers()
    {
        $cacheKey = "user_followers_{$this->id}";
        
        if (isset(static::$followerCache[$cacheKey])) {
            return static::$followerCache[$cacheKey];
        }

        static::$followerCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return $this->followers()->wherePivot('status', 'accepted')->get();
        });

        return static::$followerCache[$cacheKey];
    }

    /**
     * Cache-optimized method to get following with accepted status
     */
    public function getAcceptedFollowing()
    {
        $cacheKey = "user_following_{$this->id}";
        
        if (isset(static::$followCache[$cacheKey])) {
            return static::$followCache[$cacheKey];
        }

        static::$followCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return $this->following()->wherePivot('status', 'accepted')->get();
        });

        return static::$followCache[$cacheKey];
    }

    public function isFollowing(User $user)
    {
        // Check if relation is already loaded
        if ($this->relationLoaded('following')) {
            return $this->following->contains('id', $user->id);
        }

        // Use static cache to prevent duplicate queries
        $cacheKey = "is_following_{$this->id}_{$user->id}";
        
        if (isset(static::$followCache[$cacheKey])) {
            return static::$followCache[$cacheKey];
        }

        static::$followCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $this->following()->where('following_id', $user->id)->exists();
        });

        return static::$followCache[$cacheKey];
    }

    public function followRequests()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->wherePivot('status', 'pending');
    }

    /**
     * Optimized mutual followers calculation
     */
    public function getMutualFollowersProperty()
    {
        if (!Auth::check()) {
            return collect(); 
        }

        $cacheKey = "mutual_followers_" . Auth::id() . "_{$this->id}";

        return Cache::remember($cacheKey, now()->addMinutes(15), function () {
            // Use a single query to get mutual followers
            return User::whereHas('followers', function ($query) {
                $query->where('follower_id', $this->id)
                      ->where('status', 'accepted');
            })->whereHas('followers', function ($query) {
                $query->where('follower_id', Auth::id())
                      ->where('status', 'accepted');
            })->get();
        });
    }

    /**
     * Check if user follows the current user
     */
    public function followsMe()
    {
        if (!Auth::check()) {
            return false;
        }

        $cacheKey = "follows_me_{$this->id}_" . Auth::id();
        
        if (isset(static::$followCache[$cacheKey])) {
            return static::$followCache[$cacheKey];
        }

        // Check if relation is loaded first
        if ($this->relationLoaded('following')) {
            static::$followCache[$cacheKey] = $this->following->contains('id', Auth::id());
            return static::$followCache[$cacheKey];
        }

        static::$followCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(5), function () {
            return $this->following()->where('following_id', Auth::id())->exists();
        });

        return static::$followCache[$cacheKey];
    }

    /**
     * Optimized access control with better caching
     */
    public function hasAccessToUser($user, $permissions = null)
    {
        static $accessCache = [];
        
        // Check permissions first (most likely to grant access)
        if ($permissions !== null) {
            if (is_array($permissions)) {
                foreach ($permissions as $permission) {
                    if (Auth::user()->can($permission)) {
                        return true;
                    }
                }
            } elseif (Auth::user()->can($permissions)) {
                return true;
            }
        }

        // Check if it's the same user or public profile
        if ($this->me($user->id) || !$user->is_private) {
            return true;
        }

        $cacheKey = 'access_' . Auth::id() . '_' . $user->id;
        
        // Check static cache first
        if (array_key_exists($cacheKey, $accessCache)) {
            return $accessCache[$cacheKey];
        }

        // Use Laravel cache with optimized query
        $accessCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $user->followers()
                ->where('follower_id', Auth::id())
                ->wherePivot('status', 'accepted')
                ->limit(1)
                ->exists();
        });

        return $accessCache[$cacheKey];
    }

    /**
     * Bulk load relationships to prevent N+1 queries
     * Call this method when you need to access follow relationships for multiple users
     */
    public function preloadFollowRelationships(Collection $users)
    {
        if (!Auth::check()) {
            return;
        }

        $userIds = $users->pluck('id')->toArray();
        
        // Preload following relationships
        $followingData = $this->following()
            ->whereIn('following_id', $userIds)
            ->get()
            ->keyBy('id');

        // Preload followers relationships  
        $followersData = $this->followers()
            ->whereIn('follower_id', $userIds)
            ->get()
            ->keyBy('id');

        // Cache the results
        foreach ($userIds as $userId) {
            $followingCacheKey = "is_following_{$this->id}_{$userId}";
            $followerCacheKey = "follows_me_{$this->id}_{$userId}";
            
            static::$followCache[$followingCacheKey] = $followingData->has($userId);
            static::$followCache[$followerCacheKey] = $followersData->has($userId);
        }
    }

    /**
     * Clear follow-related caches when follow status changes
     */
    public function clearFollowCaches($targetUserId = null)
    {
        if ($targetUserId) {
            // Clear specific user caches
            Cache::forget("is_following_{$this->id}_{$targetUserId}");
            Cache::forget("follows_me_{$targetUserId}_{$this->id}");
            Cache::forget("access_{$this->id}_{$targetUserId}");
            Cache::forget("access_{$targetUserId}_{$this->id}");
        }
        
        // Clear general caches
        Cache::forget("user_followers_{$this->id}");
        Cache::forget("user_following_{$this->id}");
        
        // Clear mutual followers cache for all users
        Cache::flush(); // Consider using more specific cache tags if available
        
        // Clear static caches
        static::$followCache = [];
        static::$followerCache = [];
    }

    /**
     * Get follow stats with caching
     */
    public function getFollowStats()
    {
        $cacheKey = "follow_stats_{$this->id}";
        
        return Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return [
                'followers_count' => $this->followers()->wherePivot('status', 'accepted')->count(),
                'following_count' => $this->following()->wherePivot('status', 'accepted')->count(),
                'pending_requests' => $this->followRequests()->count(),
            ];
        });
    }
}