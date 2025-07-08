<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

trait HasFollowers
{
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

    public function isFollowing(User $user)
    {
        if ($this->relationLoaded('following')) {
            return $this->following->contains('id', $user->id);
        }
        
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function followRequests()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->wherePivot('status', 'pending');
    }

    public function getMutualFollowersProperty()
    {
        if (!Auth::check()) {
            return collect(); 
        }

        $profileFollowers = $this->user->followers->pluck('id');

        $authFollowers = Auth::user()->followers->pluck('id');

        $mutualFollowerIds = $profileFollowers->intersect($authFollowers);

        return User::whereIn('id', $mutualFollowerIds)->get();
    }

    public function followsMe()
    {
        return $this->following->contains(Auth::id());
    }

    /**
     * Determine if authenticated user is the selected user or has a specific permission.
     * If permission is null, bypass the check.
     */
    public function hasAccessToUser($user, $permissions = null)
    {
        static $accessCache = [];
    
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
    
        if ($this->me($user->id) || !$user->is_private) {
            return true;
        }
    
        $cacheKey = 'access_' . Auth::id() . '_' . $user->id;
    
        if (array_key_exists($cacheKey, $accessCache)) {
            return $accessCache[$cacheKey];
        }
    
        // Check if cache exists before attempting to retrieve it
        if (!Cache::has($cacheKey)) {
            return $user->followers()
                ->where('follower_id', Auth::id())
                ->wherePivot('status', 'accepted')
                ->exists();
        }
    
        $accessCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $user->followers()
                ->where('follower_id', Auth::id())
                ->wherePivot('status', 'accepted')
                ->limit(1)
                ->exists();
        });
    
        return $accessCache[$cacheKey];
    }
}
