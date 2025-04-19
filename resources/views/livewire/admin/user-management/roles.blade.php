<section>
    <!-- Display Heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Roles') }}</x-slot>
        <x-slot name="subheading">{{ __('Roles that are associated with your users.') }}</x-slot>

        <x-slot name="actions">
            <flux:button wire:click="showForm" variant="primary">Add Role</flux:button>
        </x-slot>
    </x-page-heading>

    <!-- Search/Filters and Actions -->
    <div class="flex gap-2">
        <div class="w-2/4">
            <x-admin.user-management.roles.search />
        </div>

        <flux:spacer />
        
        <div class="flex gap-2">
            <x-admin.user-management.roles.multiple-actions />

            <x-admin.user-management.roles.export-button />
        </div>
    </div>

    <!-- Show Roles Table -->
    <div class="relative">
        <flux:checkbox.group>
        <flux:table :paginate="$this->roles" class="mt-3" wire:loading.class="opacity-50" wire:target="create,update,delete,deleteSelected,search,sort">
            <flux:table.columns>
                <flux:table.column class="w-0 overflow-hidden p-0 m-0">
                    @if($this->roles->count() >= 4)
                        <flux:checkbox.all />
                    @endif
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                <flux:table.column>Permissions</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->roles as $role)
                    <x-admin.user-management.roles.row :$role />
                @empty
                    <flux:table.row>
                        <flux:table.cell class="whitespace-nowrap">No user-defined roles in database.</flux:table.cell>
                    </flux:table.row>                
                @endforelse
            </flux:table.rows>
        </flux:table>
        </flux:checkbox.group>

        <div class="absolute inset-0 flex" wire:loading wire:target="create,update,delete,deleteSelected,search,sort">
            <flux:icon.loading class="size-12 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
        </div>
    </div>

    <!-- Add/Edit Role Form -->
    <x-admin.user-management.roles.form-modal />

    <!-- Delete Role Modal -->
    <x-admin.user-management.roles.delete-modal />

    <!-- Show Permissions Modal -->
    <x-admin.user-management.roles.permissions-modal />
</section>