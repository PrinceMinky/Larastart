<?php

namespace App\Livewire\Traits;

use App\Models\User;
use App\Notifications\UserFollowed;
use App\Livewire\Traits\WithModal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

/**
 * Trait HasFollowers
 *
 * Provides follower/following functionality for Livewire components,
 * including following/unfollowing users, computing counts, and determining
 * UI states (like follow button labels).
 */
trait HasFollowers
{
    use WithModal;

    public $followingIds = [];
    public $followerIds = [];
    public $followStatuses = [];
    public $modalType = '';
    public $search = '';

    // Cache containers to prevent duplicate queries
    protected $followDataCache = [];
    protected $relationshipCache = [];
    protected $mutualFollowersCache = null;

    /**
     * Follow a user. Automatically sets status to pending if user is private.
     */
    public function follow(int $userId): void
    {
        if (!Auth::check()) {
            redirect()->route('login');
            return;
        }

        if (Auth::id() === $userId) {
            return;
        }

        $user = User::select('id', 'is_private')->findOrFail($userId);
        $status = $user->is_private ? 'pending' : 'accepted';

        Auth::user()->following()->syncWithoutDetaching([$userId => ['status' => $status]]);
        
        // Clear caches and reload data
        $this->clearFollowCaches();
        $this->preloadFollowData();

        $user->notify(new UserFollowed(Auth::user(), $status));
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(int $userId): void
    {
        if (!Auth::check()) {
            redirect()->route('login');
            return;
        }

        if (Auth::id() === $userId) {
            return;
        }

        Auth::user()->following()->detach($userId);

        // Clear caches and reload data
        $this->clearFollowCaches();
        $this->preloadFollowData();

        if ($this->getFollowing()->isEmpty() && method_exists($this, 'resetAndCloseModal')) {
            $this->resetAndCloseModal();
        }
    }

    #[Computed]
    public function followingCount(): int
    {
        $cacheKey = 'following_count_' . $this->user->id;
        
        if (isset($this->followDataCache[$cacheKey])) {
            return $this->followDataCache[$cacheKey];
        }

        $this->followDataCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return $this->user->following()->wherePivot('status', 'accepted')->count();
        });

        return $this->followDataCache[$cacheKey];
    }

    #[Computed]
    public function followerCount(): int
    {
        $cacheKey = 'follower_count_' . $this->user->id;
        
        if (isset($this->followDataCache[$cacheKey])) {
            return $this->followDataCache[$cacheKey];
        }

        $this->followDataCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return $this->user->followers()->wherePivot('status', 'accepted')->count();
        });

        return $this->followDataCache[$cacheKey];
    }

    /**
     * Get the followers of the current user, optionally filtered by search.
     */
    public function getFollowers()
    {
        $cacheKey = 'followers_data_' . $this->user->id . '_' . md5($this->search);
        
        if (isset($this->relationshipCache[$cacheKey])) {
            return $this->relationshipCache[$cacheKey];
        }

        // Get followers with eager loading to prevent N+1 queries
        $followers = $this->user->followers()
            ->select('users.id', 'users.name', 'users.username', 'users.is_private')
            ->wherePivot('status', 'accepted')
            ->orderByPivot('created_at', 'desc')
            ->get();

        // Partition authenticated user to top
        $partitioned = $followers->partition(fn($user) => $user->id === Auth::id());
        $followers = $partitioned->flatten();

        // Apply search filter if provided
        if (!empty($this->search)) {
            $term = strtolower($this->search);
            $followers = $followers->filter(fn($user) =>
                str_contains(strtolower($user->name), $term) ||
                str_contains(strtolower($user->username), $term)
            );
        }

        $this->relationshipCache[$cacheKey] = $followers->values();
        return $this->relationshipCache[$cacheKey];
    }

    /**
     * Get the users the current user is following, optionally filtered by search.
     */
    public function getFollowing()
    {
        $cacheKey = 'following_data_' . $this->user->id . '_' . md5($this->search);
        
        if (isset($this->relationshipCache[$cacheKey])) {
            return $this->relationshipCache[$cacheKey];
        }

        // Get following with eager loading to prevent N+1 queries
        $following = $this->user->following()
            ->select('users.id', 'users.name', 'users.username', 'users.is_private')
            ->wherePivot('status', 'accepted')
            ->orderByPivot('created_at', 'desc')
            ->get();

        // Partition authenticated user to top
        $partitioned = $following->partition(fn($user) => $user->id === Auth::id());
        $following = $partitioned->flatten();

        // Apply search filter if provided
        if (!empty($this->search)) {
            $term = strtolower($this->search);
            $following = $following->filter(fn($user) =>
                str_contains(strtolower($user->name), $term) ||
                str_contains(strtolower($user->username), $term)
            );
        }

        $this->relationshipCache[$cacheKey] = $following->values();
        return $this->relationshipCache[$cacheKey];
    }

    /**
     * Preload follower and following data into local arrays with optimized queries.
     */
    protected function preloadFollowData(): void
    {
        if (!Auth::check()) {
            return;
        }

        $cacheKey = 'follow_preload_' . Auth::id();
        
        if (isset($this->followDataCache[$cacheKey])) {
            $cached = $this->followDataCache[$cacheKey];
            $this->followingIds = $cached['following_ids'];
            $this->followerIds = $cached['follower_ids'];
            $this->followStatuses = $cached['statuses'];
            return;
        }

        // Single optimized query to get all following relationships
        $followingData = Auth::user()->following()
            ->select('users.id', 'follows.status')
            ->get();

        // Single optimized query to get all follower relationships
        $followerData = Auth::user()->followers()
            ->select('users.id')
            ->wherePivot('status', 'accepted')
            ->get();

        $this->followingIds = $followingData->pluck('id')->toArray();
        $this->followerIds = $followerData->pluck('id')->toArray();
        $this->followStatuses = $followingData->pluck('pivot.status', 'id')->toArray();

        // Cache the results
        $this->followDataCache[$cacheKey] = [
            'following_ids' => $this->followingIds,
            'follower_ids' => $this->followerIds,
            'statuses' => $this->followStatuses,
        ];
    }

    /**
     * Check if the authenticated user is following the given user.
     */
    public function isFollowing(int $userId): bool
    {
        if (!Auth::check()) {
            return false;
        }

        if (empty($this->followingIds)) {
            $this->preloadFollowData();
        }

        return in_array($userId, $this->followingIds);
    }

    /**
     * Get the follow status (accepted/pending) for a given user.
     */
    public function getFollowStatus(int $userId): ?string
    {
        if (!Auth::check()) {
            return null;
        }

        if (empty($this->followStatuses)) {
            $this->preloadFollowData();
        }

        return $this->followStatuses[$userId] ?? null;
    }

    /**
     * Determine if the given user is following the authenticated user.
     */
    public function isBeingFollowedBy(int $userId): bool
    {
        if (!Auth::check()) {
            return false;
        }

        if (empty($this->followerIds)) {
            $this->preloadFollowData();
        }

        return in_array($userId, $this->followerIds);
    }

    /**
     * Determine follow button state for a given user.
     * 
     * @return string|null one of: 'following', 'pending', 'follow_back', 'follow'
     */
    public function getFollowButtonState(int $userId): ?string
    {
        if (!Auth::check() || Auth::id() === $userId) {
            return null;
        }

        $cacheKey = 'follow_state_' . Auth::id() . '_' . $userId;
        
        if (isset($this->followDataCache[$cacheKey])) {
            return $this->followDataCache[$cacheKey];
        }

        $isFollowing = $this->isFollowing($userId);
        $status = $this->getFollowStatus($userId);
        $isFollowedBack = $this->isBeingFollowedBy($userId);

        $state = match (true) {
            $isFollowing && $status === 'accepted' => 'following',
            $isFollowing && $status === 'pending' => 'pending',
            $isFollowedBack && !$isFollowing => 'follow_back',
            default => 'follow',
        };

        $this->followDataCache[$cacheKey] = $state;
        return $state;
    }

    /**
     * Optimized mutual followers computation with caching.
     */
    #[Computed]
    public function mutualFollowers()
    {
        if (!Auth::check() || !isset($this->user)) {
            return collect();
        }

        if ($this->mutualFollowersCache !== null) {
            return $this->mutualFollowersCache;
        }

        $cacheKey = 'mutual_followers_' . Auth::id() . '_' . $this->user->id;
        
        $this->mutualFollowersCache = Cache::remember($cacheKey, now()->addMinutes(15), function () {
            // Single optimized query using whereHas for better performance
            return User::whereHas('followers', function ($query) {
                    $query->where('follower_id', $this->user->id)
                          ->where('status', 'accepted');
                })
                ->whereHas('followers', function ($query) {
                    $query->where('follower_id', Auth::id())
                          ->where('status', 'accepted');
                })
                ->limit(50) // Prevent excessive loading
                ->get();
        });

        return $this->mutualFollowersCache;
    }

    /**
     * Open the follow modal with a specific view (followers/following).
     */
    public function openModalType(string $type): void
    {
        $this->modalType = $type;
        $this->search = '';
        $this->showModal('follow-modal');
    }

    /**
     * Bulk preload follow relationships for multiple users to prevent N+1 queries.
     */
    public function preloadBulkFollowStates(Collection $users): void
    {
        if (!Auth::check() || $users->isEmpty()) {
            return;
        }

        $userIds = $users->pluck('id')->toArray();
        $cacheKey = 'bulk_follow_states_' . Auth::id() . '_' . md5(implode(',', $userIds));
        
        if (isset($this->followDataCache[$cacheKey])) {
            return;
        }

        // Single query to get all follow relationships
        $followingStates = Auth::user()->following()
            ->select('users.id', 'follows.status')
            ->whereIn('users.id', $userIds)
            ->get()
            ->keyBy('id');

        // Single query to get all follower relationships
        $followerStates = Auth::user()->followers()
            ->select('users.id')
            ->whereIn('users.id', $userIds)
            ->wherePivot('status', 'accepted')
            ->get()
            ->keyBy('id');

        // Cache individual states
        foreach ($userIds as $userId) {
            $followStateKey = 'follow_state_' . Auth::id() . '_' . $userId;
            $isFollowing = $followingStates->has($userId);
            $status = $followingStates->get($userId)?->pivot->status;
            $isFollowedBack = $followerStates->has($userId);

            $state = match (true) {
                $isFollowing && $status === 'accepted' => 'following',
                $isFollowing && $status === 'pending' => 'pending',
                $isFollowedBack && !$isFollowing => 'follow_back',
                default => 'follow',
            };

            $this->followDataCache[$followStateKey] = $state;
        }

        $this->followDataCache[$cacheKey] = true;
    }

    /**
     * Clear all follow-related caches.
     */
    protected function clearFollowCaches(): void
    {
        $this->followDataCache = [];
        $this->relationshipCache = [];
        $this->mutualFollowersCache = null;
        $this->followingIds = [];
        $this->followerIds = [];
        $this->followStatuses = [];

        // Clear Laravel cache
        if (Auth::check()) {
            Cache::forget('follow_preload_' . Auth::id());
            Cache::forget('following_count_' . $this->user->id);
            Cache::forget('follower_count_' . $this->user->id);
            Cache::forget('mutual_followers_' . Auth::id() . '_' . $this->user->id);
        }
    }

    /**
     * Clear search-related caches when search term changes.
     */
    public function updatedSearch(): void
    {
        // Clear only search-related caches
        $searchKeys = array_filter(
            array_keys($this->relationshipCache),
            fn($key) => str_contains($key, 'followers_data_') || str_contains($key, 'following_data_')
        );

        foreach ($searchKeys as $key) {
            unset($this->relationshipCache[$key]);
        }
    }

    /**
     * Initialize follow data on component mount.
     */
    public function mount(): void
    {
        if (Auth::check()) {
            $this->preloadFollowData();
        }
    }

    /**
     * Get optimized follow statistics.
     */
    public function getFollowStats(): array
    {
        $cacheKey = 'follow_stats_' . $this->user->id;
        
        if (isset($this->followDataCache[$cacheKey])) {
            return $this->followDataCache[$cacheKey];
        }

        $this->followDataCache[$cacheKey] = Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return [
                'followers_count' => $this->user->followers()->wherePivot('status', 'accepted')->count(),
                'following_count' => $this->user->following()->wherePivot('status', 'accepted')->count(),
                'pending_requests' => $this->user->followers()->wherePivot('status', 'pending')->count(),
            ];
        });

        return $this->followDataCache[$cacheKey];
    }
}