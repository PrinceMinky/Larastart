<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use App\Traits\HasFollowers;
use App\Traits\WithModal;

class UserProfile extends BaseComponent
{
    use WithModal, HasFollowers;

    public User $user;

    public $modalType = '';
    
    public function mount($username)
    {
        $this->user = User::whereUsername($username)->with(['posts','following','followers'])->firstOrFail();
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