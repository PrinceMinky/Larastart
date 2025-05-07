<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $this->unblockUser($authUser);
            $status = [
                'heading' => 'User Unblocked', 
                'text' => "You have unblocked {$this->user->name}.", 
                'variant' => 'success'
            ];
        } else {
            $this->blockUser($authUser);
            $status = [
                'heading' => 'User Blocked', 
                'text' => "You have blocked {$this->user->name}.", 
                'variant' => 'danger'
            ];
        }
    
        $this->toast($status);
    }
    
    protected function unblockUser($authUser)
    {
        $authUser->blockedUsers()->detach($this->user->id);
        $this->blockedUserIds = array_diff($this->blockedUserIds, [$this->user->id]);
        $this->isBlocked = false;
    }
    
    protected function blockUser($authUser)
    {
        if (!in_array($this->user->id, $this->blockedUserIds)) {
            // Remove any existing follow relationships
            $authUser->following()->detach($this->user->id);
            $this->user->following()->detach($authUser->id);
            
            // Add to blocked users
            $authUser->blockedUsers()->attach($this->user->id);
            $this->blockedUserIds[] = $this->user->id;
        }
        
        $this->isBlocked = true;
    }

    protected function cacheBlockStatusData()
    {
        if (!Auth::check()) {
            return;
        }

        $this->blockedUserIds = Auth::user()->blockedUsers()
            ->pluck('blocked_user_id')
            ->toArray();
        
        $this->blockedByUserIds = Auth::user()->blockedByUsers()
            ->pluck('user_id')
            ->toArray();
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
            return in_array($blockerId, $this->blockedByUserIds);
        }

        Log::debug('Falling back to database query', [
            'blockerId' => $blockerId,
            'blockedId' => $blockedId,
            'auth_check' => Auth::check()
        ]);

        if (!Auth::check()) {
            return false;
        }

        $blocker = User::find($blockerId);
        if (!$blocker) {
            return false;
        }

        $exists = $blocker->blockedUsers()->where('blocked_user_id', $blockedId)->exists();

        return $exists;
    }

    public function verifyAccessRestrictions()
    {
        if ($this->isBlockedBy($this->user->id, Auth::id())) {
            abort(404);
        }
    }

    public function prepareUserAccess()
    {
        $this->cacheBlockStatusData();
        $this->initializeBlockStatus();
        $this->verifyAccessRestrictions();
    }
}