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
        </div>
    </div>

    <!-- Show Permissions Table -->
    <flux:checkbox.group>
    <flux:table :paginate="$this->permissions" class="mt-3">
        <flux:table.columns>
            <flux:table.column class="w-0 overflow-hidden p-0 m-0">
                <flux:checkbox.all
                    :x-show="($this->permissions->count() <= 0)?true:false"
                />
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

    <!-- Add/Edit Permission Form -->
    <x-admin.user-management.permissions.form-modal />

    <!-- Delete Permission Modal -->
    <x-admin.user-management.permissions.delete-modal />
</section>