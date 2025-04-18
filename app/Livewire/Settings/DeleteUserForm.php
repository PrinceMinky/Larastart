<?php

namespace App\Livewire\Settings;

use App\Livewire\Actions\Logout;
use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class DeleteUserForm extends BaseComponent
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->toast([
            'heading' => 'Account deleted',
            'text' => 'Your account has successfully been deleted.',
            'variant' => 'danger',
        ]);

        $this->redirect('/', navigate: true);
    }
}
