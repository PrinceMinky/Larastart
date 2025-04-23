<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait WithBlockedUser
{
    public bool $isBlocked = false;
    
    public $blockedUserIds = [];

    public $blockedByUserIds = [];

    public function initializeBlockStatus()
    {
        $this->isBlocked = $this->checkBlockStatus();
    }

    public function toggleBlock()
    {
        $authUser = Auth::user();
    
        if ($this->isBlocked) {
            $authUser->blockedUsers()->detach($this->user->id);
            
            $this->blockedUserIds = array_diff($this->blockedUserIds, [$this->user->id]);
            $this->isBlocked = false;
            
            $status = ['heading' => 'User Unblocked', 'text' => "You have unblocked {$this->user->name}.", 'variant' => 'success'];
        } else {
            $needsBlocking = !in_array($this->user->id, $this->blockedUserIds);
            
            if ($needsBlocking) {
                $authUser->blockedUsers()->attach($this->user->id);
                
                $authUser->following()->detach($this->user->id);
                $this->user->following()->detach($authUser->id);
                
                $this->blockedUserIds[] = $this->user->id;
                $this->isBlocked = true;
            }
            
            $status = ['heading' => 'User Blocked', 'text' => "You have blocked {$this->user->name}.", 'variant' => 'danger'];
        }
    
        $this->toast($status);
    }

    protected function cacheBlockStatusData()
    {
        if (!Auth::check()) {
            return;
        }
        
        $this->blockedUserIds = Auth::user()->blockedUsers()
            ->pluck('blocked_user_id')
            ->toArray();
            
        if (Auth::id() == $this->user->id) {
            $this->blockedByUserIds = Auth::user()->blockedByUsers()
                ->pluck('user_id')
                ->toArray();
        }
    }

    public function checkBlockStatus()
    {
        if (!Auth::check()) {
            return false;
        }

        if (isset($this->blockedUserIds)) {
            return in_array($this->user->id, $this->blockedUserIds);
        }
        
        return Auth::user()->blockedUsers()->where('blocked_user_id', $this->user->id)->exists();
    }

    public function isBlockedBy($blockerId, $blockedId)
    {
        if (isset($this->blockedByUserIds) && $blockerId == $this->user->id) {
            return in_array($blockedId, $this->blockedByUserIds);
        }
        
        return Auth::check() && User::find($blockerId)->blockedUsers()->where('blocked_user_id', $blockedId)->exists();
    }
}