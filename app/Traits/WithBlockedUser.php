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
        
        Log::debug('cacheBlockStatusData called', [
            'auth_id' => Auth::id(),
            'user_id' => $this->user->id ?? 'null'
        ]);

        $this->blockedUserIds = Auth::user()->blockedUsers()
            ->pluck('blocked_user_id')
            ->toArray();
        
        $this->blockedByUserIds = Auth::user()->blockedByUsers()
            ->pluck('user_id')
            ->toArray();

        Log::debug('cacheBlockStatusData results', [
            'blockedUserIds' => $this->blockedUserIds,
            'blockedByUserIds' => $this->blockedByUserIds
        ]);
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
        Log::debug('isBlockedBy called', [
            'blockerId' => $blockerId,
            'blockedId' => $blockedId,
            'user_id' => $this->user->id ?? 'null',
            'auth_id' => Auth::check() ? Auth::id() : 'guest',
            'blockedByUserIds_set' => isset($this->blockedByUserIds),
            'blockedByUserIds' => $this->blockedByUserIds ?? []
        ]);

        if (isset($this->blockedByUserIds) && $blockerId == $this->user->id) {
            Log::debug('Checking blockedByUserIds cache', [
                'blockerId' => $blockerId,
                'blockedByUserIds' => $this->blockedByUserIds,
                'is_blocked' => in_array($blockerId, $this->blockedByUserIds)
            ]);
            return in_array($blockerId, $this->blockedByUserIds);
        }

        Log::debug('Falling back to database query', [
            'blockerId' => $blockerId,
            'blockedId' => $blockedId,
            'auth_check' => Auth::check()
        ]);

        if (!Auth::check()) {
            Log::debug('Auth check failed, returning false');
            return false;
        }

        $blocker = User::find($blockerId);
        if (!$blocker) {
            Log::debug('Blocker not found', ['blockerId' => $blockerId]);
            return false;
        }

        $exists = $blocker->blockedUsers()->where('blocked_user_id', $blockedId)->exists();
        Log::debug('Database query result', [
            'blockerId' => $blockerId,
            'blockedId' => $blockedId,
            'exists' => $exists
        ]);

        return $exists;
    }
}