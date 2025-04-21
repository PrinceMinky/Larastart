<?php

namespace App\Livewire\Admin\UserManagement;

use App\Enums\Country;
use App\Livewire\BaseComponent;
use App\Models\User;
use App\Traits\Searchable;
use App\Traits\Sortable;
use App\Traits\WithModal;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Title('User Management')]
#[Layout('components.layouts.admin')]
class UserList extends BaseComponent
{
    use Searchable, Sortable, WithModal, WithPagination;

    public ?int $userId = 0;

    public string $name = '';

    public string $username = '';

    public string $email = '';

    public ?Carbon $date_of_birth;
    
    public Country $country;

    public string $password = '';

    public bool $is_private = false;

    public $roles = [];

    public bool $isSuperAdmin = false;

    public array $selectedUserIds = [];

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9._-]+$/', Rule::unique(User::class)->ignore($this->userId)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->userId)],
            'date_of_birth' => ['required', Rule::date()->before(today()->subYears(13))],
            'roles' => 'required',
            'password' => ['nullable', 'string', Rules\Password::defaults()],
        ];
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        static $cachedUsers = null;
    
        if ($cachedUsers) {
            return $cachedUsers;
        }
    
        $query = User::query();
        $query->with('roles:name');
        $query->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query);
        $this->applySearch($query, ['name', 'username', 'email']);
    
        return $cachedUsers = $query->paginate(25);
    }

    #[Computed]
    public function roles(): Collection
    {
        return Role::all();
    }

    public function showForm($id = null): void
    {
        (! $id) ? $this->reset() : $this->loadUserData($id);

        $this->resetAndShowModal('show-user-form');
    }

    public function showConfirmDeleteForm($id = null): void
    {
        $this->loadUserData($id);

        $this->resetAndShowModal('delete-user-form');
    }

    public function save(): void
    {
        $this->validate();

        (! $this->userId) ? $this->create() : $this->update();
    }

    public function create(): void
    {
        $this->authorize('create users');

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'country' => $this->country,
            'is_private' => $this->is_private,
            'password' => ($this->password) ? $this->password : 'password',
        ]);
        $user->syncRoles($this->roles);

        $this->toast([
            'heading' => 'User created',
            'text' => 'User has been successfully created.',
            'variant' => 'success',
        ]);

        $this->resetAndCloseModal();
    }

    public function update(): void
    {
        $this->authorize('edit users');

        $user = User::findOrFail($this->userId);
        $user->update(array_merge([
            'id' => $this->userId,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'country' => $this->country,
            'is_private' => $this->is_private,
        ], !empty($this->password) ? ['password' => $this->password] : []));

        $user->syncRoles($this->roles);

        $this->toast([
            'heading' => 'User updated',
            'text' => 'User has been successfully updated.',
            'variant' => 'success',
        ]);

        $this->resetAndCloseModal();
    }

    public function delete(): void
    {
        $this->authorize('delete users');

        $user = User::findOrFail($this->userId);
        $user->delete();

        $this->toast([
            'heading' => 'User Deleted',
            'text' => 'User has been successfully deleted.',
            'variant' => 'danger'
        ]);

        $this->resetAndCloseModal();
    }

    public function deleteSelected(): void
    {
        $this->authorize('delete users');

        User::whereIn('id', $this->selectedUserIds)->delete();

        $this->toast([
            'heading' => 'Users deleted',
            'text' => 'Users have successfully been deleted.',
            'variant' => 'danger',
        ]);

        $this->reset('selectedUserIds');
        $this->resetAndCloseModal();
    }

    public function impersonate($id): void
    {
        $this->authorize('impersonate users');

        $user = User::findOrFail($id);
        Auth::loginUsingId($user->id);

        $this->toast([
            'heading' => 'Impersonating User',
            'text' => 'You are now logged in as user: ' . $user->name,
            'variant' => 'success',
        ]);

        $this->redirectRoute('dashboard', navigate: true);
    }

    private function loadUserData($id = null): void
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->date_of_birth = $user->date_of_birth;
        $this->country = $user->country;
        $this->is_private = $user->is_private;
        $this->roles = $user->getRoleNames();
        $this->isSuperAdmin = $user->hasRole('Super Admin');
    }

    public function export()
    {
        $this->authorize('export users');
        
        return User::toCsv();
    }

    public function render(): View
    {
        return view('livewire.admin.user-management.index');
    }
}
