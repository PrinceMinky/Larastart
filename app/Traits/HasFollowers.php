<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

trait HasFollowers
{
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
}
