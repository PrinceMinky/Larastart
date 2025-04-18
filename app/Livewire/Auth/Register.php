<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $username = '';

    public string $email = '';

    public ?Carbon $date_of_birth;

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9._-]+$/', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'date_of_birth' => ['required', Rule::date()->before(today()->subYears(13))],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['date_of_birth'] = Carbon::parse($validated['date_of_birth']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->assignRole($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    private function assignRole(User $user)
    {
        if ($user->id === 1) {
            $user->assignRole('Super Admin');
        } else {
            $user->assignRole('User');
        }
    }
}
