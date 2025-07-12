<?php

namespace App\Livewire\Settings;

use App\Models\User;
use App\Enums\Country;
use App\Events\ProfileUpdated;
use App\Livewire\BaseComponent;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Profile extends BaseComponent
{
    public string $name = '';

    public string $username = '';

    public string $email = '';

    public $date_of_birth = '';
    
    public Country $country;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->username = Auth::user()->username;
        $this->email = Auth::user()->email;
        $this->date_of_birth = Auth::user()->date_of_birth;
        $this->country = Auth::user()->country;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'username' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9._-]+$/'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],

            'date_of_birth' => ['required', Rule::date()->before(today()->subYears(13))],
            'country' => ['required'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        event(new ProfileUpdated($user));

        $this->toast([
            'heading' => 'Profile updated',
            'text' => 'Your profile has been successfully updated..',
            'variant' => 'success',
        ]);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
