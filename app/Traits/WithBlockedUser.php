<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait WithBlockedUser
{
    public bool $isBlocked = false;

    public function initializeBlockStatus()
    {
        $this->isBlocked = $this->checkBlockStatus();
    }

    public function checkBlockStatus()
    {
        return Auth::check() && Auth::user()->blockedUsers()->where('blocked_user_id', $this->user->id)->exists();
    }

    public function toggleBlock()
    {
        $authUser = Auth::user();
    
        if ($this->isBlocked) {
            $authUser->blockedUsers()->detach($this->user->id);
        } else {
            if (! $authUser->blockedUsers()->where('blocked_user_id', $this->user->id)->exists()) {
                $authUser->blockedUsers()->attach($this->user->id);
                $authUser->following()->detach($this->user->id);
                $this->user->following()->detach($authUser->id);
            }
        }
        
        $this->isBlocked = $authUser->blockedUsers()->where('blocked_user_id', $this->user->id)->exists();

        $status = $this->isBlocked
            ? ['heading' => 'User Blocked', 'text' => "You have blocked {$this->user->name}.", 'variant' => 'danger']
            : ['heading' => 'User Unblocked', 'text' => "You have unblocked {$this->user->name}.", 'variant' => 'success'];
    
        $this->toast($status);
    }
}