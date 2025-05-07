<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use App\Traits\HasFollowers;
use App\Traits\WithBlockedUser;
use App\Traits\WithModal;
use Illuminate\Support\Facades\Auth;

class UserProfile extends BaseComponent
{
    use WithBlockedUser, HasFollowers;

    public User $user;

    public $modalType = '';
    
    public function mount($username)
    {
        $this->user = User::whereUsername($username)
            ->with(['posts'])
            ->firstOrFail();
        
        $this->prepareUserAccess();
    }
        
    public function render()
    {
        return view('livewire.user-profile.index');
    }
}