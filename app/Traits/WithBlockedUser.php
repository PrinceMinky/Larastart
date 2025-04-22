<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait WithBlockedUser
{
    public User $user;
    public bool $isBlocked = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->isBlocked = Auth::user()->blockedUsers()->where('blocked_user_id', $user->id)->exists();
    }

    public function toggleBlock()
    {
        $authUser = Auth::user();
    
        if ($this->isBlocked) {
            $authUser->blockedUsers()->detach($this->user->id);
        } else {
            $authUser->blockedUsers()->attach($this->user->id);
    
            $authUser->following()->detach($this->user->id);
            $this->user->following()->detach($authUser->id);
        }
    
        $this->isBlocked = !$this->isBlocked;

        $status = $this->isBlocked
        ? ['heading' => 'User Blocked', 'text' => "You have blocked {$this->user->name}.", 'variant' => 'danger']
        : ['heading' => 'User Unblocked', 'text' => "You have unblocked {$this->user->name}.", 'variant' => 'success'];
    
        $this->toast($status);
    }
}
