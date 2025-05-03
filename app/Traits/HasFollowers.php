<?php

namespace App\Traits;

use App\Traits\WithModal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

trait HasFollowers
{
    use WithModal;

    public $followingIds = [];
    public $followerIds = [];
    public $followStatuses = [];
    public $modalType = '';
    public $search = '';

    public function follow($userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() === $userId) {
            return;
        }
    
        $user = User::where('id', $userId)->select('id', 'is_private')->firstOrFail();
        $status = $user->is_private ? 'pending' : 'accepted';
    
        Auth::user()->following()->syncWithoutDetaching([$user->id => ['status' => $status]]);
        $this->cacheFollowRelationships();
    }
    
    public function unfollow($userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() === $userId) {
            return;
        }

        $user = User::where('id', $userId)->select('id', 'is_private')->firstOrFail();
        Auth::user()->following()->detach($user->id);
        
        if ($this->getFollowing()->isEmpty()) {
            if (method_exists($this, 'resetAndCloseModal')) {
                $this->resetAndCloseModal();
            }
        }
        $this->cacheFollowRelationships();
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
        $authUserId = Auth::id();
    
        $followers = $this->user->followers()
        ->wherePivot('status', 'accepted')
        ->orderByPivot('created_at', 'desc')
        ->get(); 
    
        $followers = $followers->partition(fn ($user) => $user->id === Auth::id())->flatten();
    
        if (!empty($this->search)) {
            $searchTerm = strtolower($this->search);
            $followers = $followers->filter(fn ($user) => 
                str_contains(strtolower($user->name), $searchTerm) ||
                str_contains(strtolower($user->username), $searchTerm)
            );
        }
    
        return $followers->values();
    }

    public function getFollowing()
    {
        $authUserId = Auth::id();
    
        $following = $this->user->following()
        ->wherePivot('status', 'accepted')
        ->orderByPivot('created_at', 'desc')
        ->get(); 
    
        $following = $following->partition(fn ($user) => $user->id === Auth::id())->flatten();
    
        if (!empty($this->search)) {
            $searchTerm = strtolower($this->search);
            $following = $following->filter(fn ($user) => 
                str_contains(strtolower($user->name), $searchTerm) ||
                str_contains(strtolower($user->username), $searchTerm)
            );
        }
    
        return $following->values();
    }

    protected function preloadFollowData()
    {
        $authUser = Auth::user()->load(['followers:id', 'following:id']); 

        $this->followingIds = $authUser->following->pluck('id')->toArray();
        $this->followerIds = $authUser->followers->pluck('id')->toArray();
        
        $this->followStatuses = Auth::user()->following()
            ->select('following_id', 'status')
            ->get()
            ->pluck('status', 'following_id')
            ->toArray();
    }

    public function isFollowing($userId)
    {
        if (!Auth::check()) {
            return false;
        }
        
        if (!isset($this->followingIds) || empty($this->followingIds)) {
            $this->preloadFollowData();
        }
        
        return in_array($userId, $this->followingIds ?? []);
    }

    public function getFollowStatus($userId)
    {
        if (!Auth::check()) {
            return null;
        }
        
        if (!isset($this->followStatuses) || empty($this->followStatuses)) {
            $this->preloadFollowData();
        }
        
        return $this->followStatuses[$userId] ?? null;
    }

    public function isBeingFollowedBy($userId)
    {
        if (!Auth::check()) {
            return false;
        }
        
        if (!isset($this->followerIds) || empty($this->followerIds)) {
            $this->preloadFollowData();
        }
        
        return in_array($userId, $this->followerIds ?? []);
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

        $mutualFollowers = User::whereIn('id', $mutualFollowerIds)->get();

        return $mutualFollowers;
    }
    
    public function showModal($type)
    {
        $this->modalType = $type;
        $this->search = '';
        $this->resetAndShowModal('showModal');
    }
}