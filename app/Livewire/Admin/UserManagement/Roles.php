<?php

namespace App\Livewire\Admin\UserManagement;

use App\Livewire\BaseComponent;
use App\Traits\Searchable;
use App\Traits\Sortable;
use App\Traits\WithModal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


#[Title('Roles Management')]
#[Layout('components.layouts.admin')]
class Roles extends BaseComponent
{
    use Searchable, Sortable, WithModal, WithPagination;

    public ?int $roleId = 0;

    public ?string $name = '';

    public array $selectedPermissions = [];

    public array $selectedRoleIds = [];

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:100', Rule::unique('roles', 'name')->ignore($this->roleId)],
        ];
    }

    #[Computed]
    public function roles(): LengthAwarePaginator
    {
        $query = Role::query();

        if ($this->sortBy) {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        $this->applySearch($query);

        return $query->paginate(25);
    }

    #[Computed]
    public function permissions(): Collection
    {
        return Permission::all();
    }

    public function showForm($id = null): void
    {
        ($id) ? $this->loadRoleData($id) : $this->reset();

        $this->resetAndShowModal('show-role-form');
    }

    public function showConfirmDeleteForm($id = null): void
    {
        $this->loadRoleData($id);

        $this->resetAndShowModal('delete-role-form');
    }

    public function showPermissionsModal($id = null): void
    {
        ($id) ? $this->loadRoleData($id) : $this->reset();

        $this->resetAndShowModal('show-permissions-modal');
    }

    public function save(): void
    {
        $this->validate();

        (! $this->roleId) ? $this->create() : $this->update();
    }

    public function create(): void
    {
        $this->authorize('create roles');

        $role = Role::create(['name' => $this->name]);

        $this->syncPermissions($role, $this->selectedPermissions);

        $this->toast([
            'heading' => 'Role created',
            'text' => 'Role has been successfully created.',
            'variant' => 'success',
        ]);

        $this->resetAndCloseModal();
    }

    public function update(): void
    {
        $this->authorize('edit roles');

        $role = Role::findOrFail($this->roleId);
        $role->update(['name' => $this->name]);

        $this->syncPermissions($role, $this->selectedPermissions);

        $this->toast([
            'heading' => 'Role updated',
            'text' => 'Role has been successfully updated.',
            'variant' => 'success',
        ]);

        $this->resetAndCloseModal();
    }

    public function delete(): void
    {
        $this->authorize('delete roles');

        $role = Role::findOrFail($this->roleId);
        $role->delete();

        $this->toast([
            'heading' => 'Role deleted',
            'text' => 'Role has successfully been deleted.',
            'variant' => 'danger',
        ]);

        $this->resetAndCloseModal();
    }

    public function deleteSelected(): void
    {
        $this->authorize('delete roles');

        Role::whereIn('id', $this->selectedRoleIds)->delete();

        $this->toast([
            'heading' => 'Roles deleted',
            'text' => 'Roles have successfully been deleted.',
            'variant' => 'danger',
        ]);

        $this->reset('selectedRoleIds');
        $this->resetAndCloseModal();
    }

    private function syncPermissions($role, $permissions): void
    {
        if (! empty($permissions)) {
            $validPermissions = Permission::whereIn('name', (array) $permissions)->pluck('name')->toArray();
            $role->syncPermissions($validPermissions);
        }
    }

    private function loadRoleData($id): void
    {
        $role = Role::findOrFail($id);

        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function export()
    {
        return Role::toCsv();
    }

    public function render(): View
    {
        return view('livewire.admin.user-management.roles');
    }
}
