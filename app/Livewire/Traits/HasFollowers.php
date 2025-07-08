<?php

namespace App\Livewire\Traits;

use App\Models\User;
use App\Notifications\UserFollowed;
use App\Livewire\Traits\WithModal;
use Illuminate\Support\Facades\Auth;
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
        $this->cacheFollowRelationships();

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

        if ($this->getFollowing()->isEmpty() && method_exists($this, 'resetAndCloseModal')) {
            $this->resetAndCloseModal();
        }

        $this->cacheFollowRelationships();
    }

    #[Computed]
    public function followingCount(): int
    {
        return $this->user->following->where('pivot.status', 'accepted')->count();
    }

    #[Computed]
    public function followerCount(): int
    {
        return $this->user->followers->where('pivot.status', 'accepted')->count();
    }

    /**
     * Get the followers of the current user, optionally filtered by search.
     */
    public function getFollowers()
    {
        $followers = $this->user->followers()
            ->wherePivot('status', 'accepted')
            ->orderByPivot('created_at', 'desc')
            ->get()
            ->partition(fn($user) => $user->id === Auth::id())
            ->flatten();

        if (!empty($this->search)) {
            $term = strtolower($this->search);
            $followers = $followers->filter(fn($user) =>
                str_contains(strtolower($user->name), $term) ||
                str_contains(strtolower($user->username), $term)
            );
        }

        return $followers->values();
    }

    /**
     * Get the users the current user is following, optionally filtered by search.
     */
    public function getFollowing()
    {
        $following = $this->user->following()
            ->wherePivot('status', 'accepted')
            ->orderByPivot('created_at', 'desc')
            ->get()
            ->partition(fn($user) => $user->id === Auth::id())
            ->flatten();

        if (!empty($this->search)) {
            $term = strtolower($this->search);
            $following = $following->filter(fn($user) =>
                str_contains(strtolower($user->name), $term) ||
                str_contains(strtolower($user->username), $term)
            );
        }

        return $following->values();
    }

    /**
     * Preload follower and following data into local arrays.
     */
    protected function preloadFollowData(): void
    {
        $authUser = Auth::user()->load(['followers:id', 'following:id']);

        $this->followingIds = $authUser->following->pluck('id')->toArray();
        $this->followerIds = $authUser->followers->pluck('id')->toArray();

        $this->followStatuses = $authUser->following()
            ->select('following_id', 'status')
            ->get()
            ->pluck('status', 'following_id')
            ->toArray();
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

        $isFollowing = $this->isFollowing($userId);
        $status = $this->getFollowStatus($userId);
        $isFollowedBack = $this->isBeingFollowedBy($userId);

        return match (true) {
            $isFollowing && $status === 'accepted' => 'following',
            $isFollowing && $status === 'pending' => 'pending',
            $isFollowedBack && !$isFollowing => 'follow_back',
            default => 'follow',
        };
    }

    /**
     * Cache the follow relationships in memory and preload state.
     */
    protected function cacheFollowRelationships(): void
    {
        if (!Auth::check()) {
            return;
        }

        $currentUser = Auth::user();
        $currentUser->setRelation('following', $currentUser->following()->get());
        $currentUser->setRelation('followers', $currentUser->followers()->get());

        if (isset($this->user) && $this->user->id !== $currentUser->id) {
            $this->user->setRelation('followers', $this->user->followers()->get());
            $this->user->setRelation('following', $this->user->following()->get());
        }

        $this->preloadFollowData();
    }

    #[Computed]
    public function mutualFollowers()
    {
        if (!Auth::check() || !isset($this->user)) {
            return collect();
        }

        $profileFollowers = $this->user->followers->pluck('id');
        $authFollowers = Auth::user()->followers->pluck('id');
        $mutualFollowerIds = $profileFollowers->intersect($authFollowers);

        return User::whereIn('id', $mutualFollowerIds)->get();
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
}