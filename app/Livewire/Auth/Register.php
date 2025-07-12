<?php

namespace App\Livewire\Auth;

use App\Enums\Country;
use App\Events\UserCreated;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $username = '';

    public string $email = '';

    public ?Carbon $date_of_birth;

    public Country $country;

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
            'country' => ['required'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['date_of_birth'] = Carbon::parse($validated['date_of_birth']);

        event(new Registered(($user = User::create($validated))));
        event(new UserCreated($user));

        $this->assignRole($user);

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    private function assignRole(User $user)
    {
        if ($user->id === 1) {
            $this->createRolesAndPermissions();
            $user->assignRole('Super Admin');
        } else {
            $user->assignRole('User');
        }
    }

    private function createRolesAndPermissions()
    {
        $roles = ['Super Admin', 'Admin', 'User'];
        $permissions = [
            'view admin dashboard',

            'view users', 'create users', 'edit users', 'delete users', 'export users','impersonate users',
            'view roles', 'create roles', 'edit roles', 'delete roles', 'export roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions', 'export permissions'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            if ($roleName === 'Super Admin') {
                $role->givePermissionTo(Permission::all());
            } elseif ($roleName === 'Admin') {
                $role->givePermissionTo(['view admin dashboard']);
            }
        }
    }
}
