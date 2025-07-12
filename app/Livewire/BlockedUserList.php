<?php

namespace App\Livewire;

use App\Models\User;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class BlockedUserList extends BaseComponent
{
    #[Computed]
    public function blockedUsers()
    {
        return Auth::user()->blockedUsers()->get();
    }

    public function unblock($id)
    {
        // find the user
        $user = User::findOrFail($id);
        
        // remove the relationship
        Auth::user()->blockedUsers()->detach($user->id);

        // ui feedback
        $this->toast([
            'heading' => 'User Unblocked',
            'text' => 'You have unblocked this '.$user->name.' successfully.',
            'variant' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.blocked-user-list');
    }
}
