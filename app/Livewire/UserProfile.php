<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use App\Livewire\Traits\Blockable;
use App\Livewire\Traits\HasFollowers;

class UserProfile extends BaseComponent
{
    use Blockable, HasFollowers;

    public User $user;
    
    public function mount($username)
    {
        $this->user = User::whereUsername($username)
            ->firstOrFail();
        
        $this->prepareUserAccess();
    }
        
    public function render()
    {
        return view('livewire.user-profile.index');
    }
}