<?php

namespace App\Livewire\Admin\UserManagement;

use App\Livewire\BaseComponent;
use App\Livewire\Traits\Searchable;
use App\Livewire\Traits\Sortable;
use App\Livewire\Traits\WithModal;
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
        static $cachedRoles = null; 
    
        if ($cachedRoles) {
            return $cachedRoles; 
        }
        
        $query = Role::query();
        $query->with('permissions');

        $this->applySorting($query);
        $this->applySearch($query);
    
        return $cachedRoles = $query->paginate(25); 
    }

    #[Computed]
    /**
     * Return permissions as a Collection, cached as array internally.
     *
     * @return \Illuminate\Support\Collection
     */
    public function permissions(): Collection
    {
        $array = $this->getCachedList('permissions', fn() => Permission::all()->toArray());

        return collect($array);
    }

    public function showForm($id = null): void
    {
        ($id) ? $this->loadRoleData($id) : $this->reset();

        $this->showModal('show-role-form');
    }

    public function showConfirmDeleteForm($id = null): void
    {
        $this->loadRoleData($id);

        $this->showModal('delete-role-form');
    }

    public function showPermissionsModal($id = null): void
    {
        ($id) ? $this->loadRoleData($id) : $this->reset();

        $this->showModal('show-permissions-modal');
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

        $this->closeModal();
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

        $this->closeModal();
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

        $this->closeModal();
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
        $this->closeModal();
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
        $this->authorize('export roles');
        
        return Role::toCsv();
    }

    public function render(): View
    {
        return view('livewire.admin.user-management.roles');
    }
}
