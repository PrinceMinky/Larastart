<?php

namespace App\Livewire;

use App\Notifications\AcceptedFollowRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use App\Livewire\BaseComponent;
use App\Notifications\UserFollowed;

class FollowRequests extends BaseComponent
{
    #[Computed]
    public function requests()
    {
        return Auth::user()
            ->followers()
            ->whereStatus('pending')
            ->orderByPivot('created_at', 'desc')
            ->get();
    }

    public function accept($requestId)
    {
        $user = Auth::user();
        $request = $this->getPendingFollowRequest($user, $requestId);

        if (! $request) return;

        $request->pivot->update(['status' => 'accepted']);

        $this->deleteNotification($user, $request->id);

        $user->notify(new UserFollowed($request, 'accepted'));
        $request->notify(new AcceptedFollowRequest($user));

        $this->toast([
            'text' => 'Follow request approved.',
            'variant' => 'success',
        ]);

        $this->dispatch('refreshNotifications');
    }

    public function deny($requestId)
    {
        $user = Auth::user();
        $request = $this->getPendingFollowRequest($user, $requestId);

        if (! $request) return;

        $user->followers()->detach($requestId);

        $this->deleteNotification($user, $requestId);

        $this->toast([
            'text' => 'Follow request denied.',
            'variant' => 'danger',
        ]);

        $this->dispatch('refreshNotifications');
    }

    protected function getPendingFollowRequest($user, $requestId)
    {
        return $user->followers()
            ->wherePivot('follower_id', $requestId)
            ->wherePivot('status', 'pending')
            ->first();
    }

    protected function updateNotification($user, $requestId, array $newData)
    {
        $notification = $user->notifications()
            ->whereJsonContains('data->user_id', $requestId)
            ->whereJsonContains('data->action', '{name} requested to follow you.')
            ->first();

        if ($notification) {
            $notification->update([
                'data' => array_merge($notification->data, $newData),
            ]);
        }
    }

    protected function deleteNotification($user, $requestId)
    {
        $notification = $user->notifications()
            ->whereJsonContains('data->user_id', $requestId)
            ->whereJsonContains('data->action', '{name} requested to follow you.')
            ->first();

        if ($notification) {
            $notification->delete();
        }
    }

    public function render()
    {
        return view('livewire.follow-requests');
    }
}