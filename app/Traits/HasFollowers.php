<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

trait HasFollowers
{
    public $followingIds = [];
    public $followerIds = [];
    public $followStatuses = [];

    public function follow($userId)
    {
        if (Auth::id() === $userId) {
            return;
        }
    
        $user = User::where('id', $userId)->select('id', 'is_private')->firstOrFail();
        $status = $user->is_private ? 'pending' : 'accepted';
    
        Auth::user()->following()->syncWithoutDetaching([$user->id => ['status' => $status]]);
    }
    
    public function unfollow($userId)
    {
        $user = User::where('id', $userId)->select('id', 'is_private')->firstOrFail();
        Auth::user()->following()->detach($user->id);
        
        if ($this->getFollowing()->isEmpty()) {
            $this->resetAndCloseModal();
        }
    }

    #[Computed]
    public function followingCount()
    {
        return $this->user->following->where('pivot.status', 'accepted')->count();
    }

    #[Computed]
    public function followerCount()
    {
        return $this->user->followers->where('pivot.status', 'accepted')->count();
    }

    public function getFollowers()
    {
        return $this->user->followers->where('pivot.status', 'accepted');
    }

    public function getFollowing()
    {
        return $this->user->following->where('pivot.status', 'accepted');
    }

    protected function preloadFollowData()
    {
        $this->followingIds = Auth::user()->following()->pluck('following_id')->toArray();
        $this->followerIds = Auth::user()->followers()->pluck('follower_id')->toArray();
        $this->followStatuses = Auth::user()->following()
            ->select('following_id', 'status')
            ->get()
            ->pluck('status', 'following_id')
            ->toArray();
    }

    public function isFollowing($userId)
    {
        if (Auth::check() && Auth::id() == $this->user->id) {
            return in_array($userId, $this->followingIds ?? []);
        }
        
        static $followingIds = null;
        
        if ($followingIds === null && Auth::check()) {
            $followingIds = Auth::user()->following()->pluck('following_id')->toArray();
        }
        
        return in_array($userId, $followingIds ?? []);
    }

    public function getFollowStatus($userId)
    {
        if (Auth::check() && Auth::id() == $this->user->id) {
            return $this->followStatuses[$userId] ?? null;
        }
        
        static $statuses = null;
        
        if ($statuses === null && Auth::check()) {
            $statuses = Auth::user()->following()
                ->select('following_id', 'status')
                ->get()
                ->pluck('status', 'following_id')
                ->toArray();
        }
        
        return $statuses[$userId] ?? null;
    }

    public function isBeingFollowedBy($userId)
    {
        if (Auth::check() && Auth::id() == $this->user->id) {
            return in_array($userId, $this->followerIds ?? []);
        }
        
        static $followerIds = null;
        
        if ($followerIds === null && Auth::check()) {
            $followerIds = Auth::user()->followers()->pluck('follower_id')->toArray();
        }
        
        return in_array($userId, $followerIds ?? []);
    }

    public function getFollowButtonState($userId)
    {
        if (!Auth::check() || Auth::id() === $userId) {
            return null;
        }
        
        $isFollowing = $this->isFollowing($userId);
        $followStatus = $this->getFollowStatus($userId);
        $isBeingFollowedBy = $this->isBeingFollowedBy($userId);
        
        if ($isFollowing && $followStatus === 'accepted') {
            return 'following';
        } elseif ($isFollowing && $followStatus === 'pending') {
            return 'pending';
        } elseif ($isBeingFollowedBy && !$isFollowing) {
            return 'follow_back';
        } else {
            return 'follow';
        }
    }

    protected function cacheFollowRelationships()
    {
        if (!Auth::check()) {
            return;
        }

        $currentUser = Auth::user();
        $currentUser->setRelation('following', $currentUser->following()->get());
        $currentUser->setRelation('followers', $currentUser->followers()->get());
        
        if ($this->user->id !== $currentUser->id) {
            $this->user->setRelation('followers', $this->user->followers()->get());
            $this->user->setRelation('following', $this->user->following()->get());
        }
    }

    #[Computed]
    public function mutualFollowers()
    {
        if (!Auth::check()) {
            return collect(); 
        }

        $profileFollowers = $this->user->followers->pluck('id');
        $authFollowers = Auth::user()->followers->pluck('id');
        $mutualFollowerIds = $profileFollowers->intersect($authFollowers);

        $mutualFollowers = User::whereIn('id', $mutualFollowerIds)->get();

        return $mutualFollowers;
    }
}
