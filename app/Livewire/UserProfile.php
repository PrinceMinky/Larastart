<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use App\Traits\HasFollowers;
use App\Traits\WithBlockedUser;
use App\Traits\WithModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class UserProfile extends BaseComponent
{
    use WithModal, WithBlockedUser, HasFollowers;

    public User $user;

    public $modalType = '';
    
    public function mount($username)
    {
        $this->user = User::whereUsername($username)
            ->with(['posts', 'following', 'followers'])
            ->firstOrFail();
    
        if (Auth::check() && $this->user->blockedUsers()->where('blocked_user_id', Auth::id())->exists()) {
            return redirect()->route('error.404'); 
        }
    
        if (Auth::check()) {
            Auth::user()->load(['following' => function($query) {
                $query->where('following_id', $this->user->id);
            }]);
        }
        
        $this->initializeBlockStatus();
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

        return User::whereIn('id', $mutualFollowerIds)->get();
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