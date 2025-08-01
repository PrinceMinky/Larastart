<?php

namespace App\Livewire\Auth;

use App\Events\PasswordSent;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class ForgotPassword extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        $user = User::where('email', $this->email)->first();
        event(new PasswordSent($user));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}
