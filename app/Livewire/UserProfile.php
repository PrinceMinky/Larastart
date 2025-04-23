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

    protected function cacheFollowRelationships()
    {
        if (!Auth::check()) {
            return;
        }

        $currentUser = Auth::user();

        $currentUser->setRelation('following', 
            $currentUser->following()->get()
        );
        
        $currentUser->setRelation('followers', 
            $currentUser->followers()->get()
        );
        
        if ($this->user->id !== $currentUser->id) {
            $this->user->setRelation('followers', 
                $this->user->followers()->get()
            );
            
            $this->user->setRelation('following', 
                $this->user->following()->get()
            );
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