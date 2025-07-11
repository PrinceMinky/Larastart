<?php

namespace App\Livewire\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Trait Blockable
 *
 * Adds user blocking functionality for Livewire components.
 * Includes methods for blocking/unblocking users, checking block status,
 * and preventing access to blocked profiles.
 */
trait Blockable
{
    /**
     * Indicates whether the authenticated user has blocked the viewed user.
     */
    public bool $isBlocked = false;

    /**
     * List of user IDs the authenticated user has blocked.
     */
    public array $blockedUserIds = [];

    /**
     * List of user IDs who have blocked the authenticated user.
     */
    public array $blockedByUserIds = [];

    /**
     * Initialize block status for the current user context.
     */
    public function initializeBlockStatus(): void
    {
        $this->isBlocked = $this->checkBlockStatus();
    }

    /**
     * Toggle block/unblock state for the viewed user.
     */
    public function toggleBlock(): void
    {
        $authUser = Auth::user();

        if (! $authUser || ! isset($this->user)) {
            return;
        }

        if ($this->isBlocked) {
            $this->unblockUser($authUser);
            $status = [
                'heading' => 'User Unblocked',
                'text' => "You have unblocked {$this->user->name}.",
                'variant' => 'success',
            ];
        } else {
            $this->blockUser($authUser);
            $status = [
                'heading' => 'User Blocked',
                'text' => "You have blocked {$this->user->name}.",
                'variant' => 'danger',
            ];
        }

        $this->toast($status);
    }

    /**
     * Unblock the viewed user.
     *
     * @param User $authUser
     */
    protected function unblockUser(User $authUser): void
    {
        $authUser->blockedUsers()->detach($this->user->id);
        $this->blockedUserIds = array_diff($this->blockedUserIds, [$this->user->id]);
        $this->isBlocked = false;
    }

    /**
     * Block the viewed user.
     *
     * @param User $authUser
     */
    protected function blockUser(User $authUser): void
    {
        if (! in_array($this->user->id, $this->blockedUserIds)) {
            // Remove mutual follow relationships
            $authUser->following()->detach($this->user->id);
            $this->user->following()->detach($authUser->id);

            // Block the user
            $authUser->blockedUsers()->attach($this->user->id);
            $this->blockedUserIds[] = $this->user->id;
        }

        $this->isBlocked = true;
    }

    /**
     * Cache blocked/blocked-by users for the authenticated user.
     */
    protected function cacheBlockStatusData(): void
    {
        if (! Auth::check()) {
            return;
        }

        $this->blockedUserIds = Auth::user()->blockedUsers()
            ->pluck('blocked_user_id')
            ->toArray();

        $this->blockedByUserIds = Auth::user()->blockedByUsers()
            ->pluck('user_id')
            ->toArray();
    }

    /**
     * Check if the authenticated user has blocked the viewed user.
     *
     * @return bool
     */
    public function checkBlockStatus(): bool
    {
        if (! Auth::check() || ! isset($this->user)) {
            return false;
        }

        if (! empty($this->blockedUserIds)) {
            return in_array($this->user->id, $this->blockedUserIds);
        }

        return Auth::user()->blockedUsers()
            ->where('blocked_user_id', $this->user->id)
            ->exists();
    }

    /**
     * Check if a user is blocked by another user.
     *
     * @param int $blockerId
     * @param int $blockedId
     * @return bool
     */
    public function isBlockedBy(int $blockerId, int $blockedId): bool
    {
        if (isset($this->blockedByUserIds) && $blockerId === $this->user->id) {
            return in_array($blockerId, $this->blockedByUserIds);
        }

        Log::debug('Fallback check for block status', [
            'blockerId' => $blockerId,
            'blockedId' => $blockedId,
        ]);

        if (! Auth::check()) {
            return false;
        }

        $blocker = User::find($blockerId);
        if (! $blocker) {
            return false;
        }

        return $blocker->blockedUsers()
            ->where('blocked_user_id', $blockedId)
            ->exists();
    }

    /**
     * Abort request if the authenticated user is blocked by the viewed user.
     *
     * @return void
     */
    public function verifyAccessRestrictions(): void
    {
        if ($this->isBlockedBy($this->user->id, Auth::id())) {
            abort(404);
        }
    }

    /**
     * Prepare all access data: preload block status and abort if blocked.
     */
    public function prepareUserAccess(): void
    {
        $this->cacheBlockStatusData();
        $this->initializeBlockStatus();
        $this->verifyAccessRestrictions();
    }
}