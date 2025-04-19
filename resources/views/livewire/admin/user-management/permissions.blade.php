<section>
    <!-- Display Heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Permissions') }}</x-slot>
        <x-slot name="subheading">{{ __('Permissions that are assigned to use groups.') }}</x-slot>

        <x-slot name="actions">
            <flux:button wire:click="showForm" wire:target="showForm" variant="primary">Add Permission</flux:button>
        </x-slot>
    </x-page-heading>

    <!-- Search/Filters and Actions -->
    <div class="flex gap-2">
        <div class="w-2/4">
            <x-admin.user-management.permissions.search />
        </div>

        <flux:spacer />
        
        <div class="flex gap-2">
            <x-admin.user-management.permissions.multiple-actions />

            <x-admin.user-management.permissions.export-button />
        </div>
    </div>

    <!-- Show Permissions Table -->
    <div class="relative">
        <flux:checkbox.group>
        <flux:table :paginate="$this->permissions" class="mt-3" wire:loading.class="opacity-50" wire:target="create,update,delete,deleteSelected,search,sort">
            <flux:table.columns>
                <flux:table.column class="w-0 overflow-hidden p-0 m-0">
                    @if($this->permissions->count() != 0)
                        <flux:checkbox.all />
                    @endif
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->permissions as $permission)
                    <x-admin.user-management.permissions.row :$permission />
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="3">No permissions added.</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
        </flux:checkbox.group>
        
        <div class="absolute inset-0 flex" wire:loading wire:target="create,update,delete,deleteSelected,search,sort">
            <flux:icon.loading class="size-12 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
        </div>
    </div>

    <!-- Add/Edit Permission Form -->
    <x-admin.user-management.permissions.form-modal />

    <!-- Delete Permission Modal -->
    <x-admin.user-management.permissions.delete-modal />
</section>