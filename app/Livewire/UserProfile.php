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
    use WithModal, WithBlockedUser, HasFollowers;

    public User $user;

    public $modalType = '';
    
    public function mount($username)
    {
        $this->user = User::whereUsername($username)
            ->with(['posts'])
            ->firstOrFail();
        
        if (Auth::check()) {
            $this->cacheBlockStatusData();
            
            if ($this->isBlockedBy($this->user->id, Auth::id())) {
                return redirect()->route('error.404'); 
            }
            
            if (Auth::id() == $this->user->id) {
                $this->preloadFollowData();
            }
        }
        
        $this->initializeBlockStatus();
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