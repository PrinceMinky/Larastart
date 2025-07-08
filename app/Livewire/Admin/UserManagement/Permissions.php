<?php

namespace App\Livewire\Admin\UserManagement;

use App\Livewire\BaseComponent;
use App\Livewire\Traits\Searchable;
use App\Livewire\Traits\Sortable;
use App\Livewire\Traits\WithModal;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Title('Permissions Management')]
#[Layout('components.layouts.admin')]
class Permissions extends BaseComponent
{
    use Searchable, Sortable, WithModal, WithPagination;

    private const ACTIONS = ['view', 'create', 'edit', 'delete','export'];

    public $permissionId = '';

    public $name = '';

    public $createResource = false;

    public $selectedPermissionIds = [];

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('permissions', 'name')->ignore($this->permissionId),
            ],
        ];
    }

    #[Computed]
    public function permissions(): LengthAwarePaginator
    {
        static $cachedPermissions = null; 
    
        if ($cachedPermissions) {
            return $cachedPermissions; 
        }
        
        $query = Permission::query();
        $query->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query);
        $this->applySearch($query);
    
        return $cachedPermissions = $query->paginate(25); 
    }

    public function showForm($id = null): void
    {
        ($id) ? $this->loadPermissionData($id) : $this->reset();

        $this->showModal('show-permission-form');
    }

    public function showConfirmDeleteForm($id): void
    {
        $this->loadPermissionData($id);
        $this->showModal('delete-permission-form');
    }

    public function save(): void
    {
        $this->validate();

        $items = $this->processInputItems();

        if (empty($items)) {
            $this->addError('name', 'At least one valid permission name is required.');

            return;
        }

        if (! $this->validatePermissions($items)) {
            return;
        }

        $this->name = implode('|', $items);

        $this->permissionId ? $this->update() : $this->create();
    }

    private function processInputItems(): array
    {
        $items = explode('|', $this->name);
        $items = array_filter(array_map('trim', $items));

        return array_values(array_unique($items));
    }

    private function validatePermissions(array $items): bool
    {
        $errors = [];

        foreach ($items as $index => $item) {
            if (strlen($item) < 3) {
                $errors[] = "Item '$item' is too short (minimum 3 characters).";
            }

            if (strlen($item) > 100) {
                $errors[] = "Item '$item' is too long (maximum 100 characters).";
            }
        }

        if (! empty($errors)) {
            foreach ($errors as $error) {
                $this->addError('name', $error);
            }

            return false;
        }

        if ($this->createResource) {
            foreach ($items as $item) {
                $existingActions = [];

                foreach (self::ACTIONS as $action) {
                    $permissionName = sprintf('%s %s', $action, $item);
                    if (Permission::where('name', $permissionName)->exists()) {
                        $existingActions[] = $action;
                    }
                }

                if (! empty($existingActions)) {
                    $errors[] = "Resource '$item' already exists in the database.";
                }
            }
        } else {
            foreach ($items as $item) {
                $query = Permission::where('name', $item);

                if ($this->permissionId) {
                    $query->where('id', '!=', $this->permissionId);
                }

                if ($query->exists()) {
                    $errors[] = "Permission '$item' already exists in the database.";
                }
            }
        }

        if (! empty($errors)) {
            foreach ($errors as $error) {
                $this->addError('name', $error);
            }

            return false;
        }

        return true;
    }

    private function buildPermissionsToValidate(array $items): array
    {
        $permissionsToValidate = [];

        foreach ($items as $item) {
            if ($this->createResource) {
                foreach (self::ACTIONS as $action) {
                    $permissionsToValidate[] = sprintf('%s %s', $action, $item);
                }
            } else {
                $permissionsToValidate[] = $item;
            }
        }

        return $permissionsToValidate;
    }

    private function buildPermissionValidator(array $permissionsToValidate): \Illuminate\Validation\Validator
    {
        return Validator::make(
            ['permissions' => $permissionsToValidate],
            [
                'permissions' => 'required|array|min:1',
                'permissions.*' => [
                    'required',
                    'min:3',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        $query = Permission::where('name', $value);

                        if (! $this->createResource && $this->permissionId) {
                            $query->where('id', '!=', $this->permissionId);
                        }

                        if ($query->exists()) {
                            $fail("The permission '$value' already exists in the database.");
                        }
                    },
                ],
            ]
        );
    }

    public function create(): void
    {
        $this->authorize('create permissions');

        DB::transaction(function () {
            $permissionNames = $this->createPermissions();
            $this->assignPermissionsToSuperAdmin();

            return $permissionNames;
        });

        $plural = count($this->processInputItems()) > 1;

        $this->toast([
            'heading' => 'Permission'.($plural ? 's' : '').' created',
            'text' => 'Permission'.($plural ? 's have' : ' has').' successfully been created.',
            'variant' => 'success',
        ]);

        $this->closeModal();
    }

    private function createPermissions(): array
    {
        $items = $this->processInputItems();
        $permissionNames = [];

        foreach ($items as $item) {
            if ($this->createResource) {
                $resourcePermissions = $this->createResourcePermissions($item);
                $permissionNames = array_merge($permissionNames, $resourcePermissions);
            } else {
                $permissionName = $this->createSinglePermission($item);
                $permissionNames[] = $permissionName;
            }
        }

        return $permissionNames;
    }

    private function assignPermissionsToSuperAdmin(): void
    {
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if (! $superAdminRole) {
            return;
        }

        $permissions = Permission::all();
        $superAdminRole->givePermissionTo($permissions);
    }

    private function createResourcePermissions(string $resourceName): array
    {
        return collect(self::ACTIONS)
            ->map(fn ($action) => Permission::firstOrCreate([
                'name' => sprintf('%s %s', $action, $resourceName),
            ]))
            ->toArray();
    }

    private function createSinglePermission(string $permissionName): array
    {
        return [
            Permission::firstOrCreate([
                'name' => $permissionName,
            ]),
        ];
    }

    public function update(): void
    {
        $this->authorize('edit permissions');

        Permission::findOrFail($this->permissionId)->update(['name' => $this->name]);

        $this->toast([
            'heading' => 'Permission updated',
            'text' => 'Permission has been successfully updated.',
            'variant' => 'success',
        ]);

        $this->closeModal();
    }

    public function delete(): void
    {
        $this->authorize('delete permissions');

        Permission::where('id', $this->permissionId)->delete();

        $this->toast([
            'heading' => 'Permission deleted',
            'text' => 'Permission has successfully been deleted.',
            'variant' => 'danger',
        ]);

        $this->reset('selectedPermissionIds');
        $this->closeModal();
    }

    public function deleteSelected(): void
    {
        $this->authorize('delete permissions');

        Permission::whereIn('id', $this->selectedPermissionIds)->delete();

        $this->toast([
            'heading' => 'Permissions deleted',
            'text' => 'Permissions have successfully been deleted.',
            'variant' => 'danger',
        ]);

        $this->reset('selectedPermissionIds');
        $this->closeModal();
    }

    private function loadPermissionData($id): void
    {
        $permission = Permission::findOrFail($id);

        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->createResource = true;
    }

    public function export()
    {
        $this->authorize('export permissions');
        
        return Permission::toCsv();
    }

    public function render(): View
    {
        return view('livewire.admin.user-management.permissions');
    }
}
