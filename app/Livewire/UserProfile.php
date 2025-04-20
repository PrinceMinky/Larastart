<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use App\Models\Post;
use App\Traits\WithModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class UserProfile extends BaseComponent
{
    use WithModal;

    public User $user;

    public $modalType = '';
    
    public function mount($username)
    {
        $this->user = User::whereUsername($username)->with(['posts','following','followers'])->first();
    }

    public function follow($userId)
    {
        $user = User::findOrFail($userId);
        $status = $user->is_private ? 'pending' : 'accepted';
    
        Auth::user()->following()->syncWithoutDetaching([$user->id => ['status' => $status]]);
    }
    
    public function unfollow($userId)
    {
        $user = User::findOrFail($userId);
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

    public function showModal($type)
    {
        $this->modalType = $type;

        $this->resetAndShowModal('showModal');
    }
        
    public function render()
    {
        return view('livewire.user-profile.index');
    }
}