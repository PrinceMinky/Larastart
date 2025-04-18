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
        </div>
    </div>

    <!-- Show Roles Table -->
    <flux:checkbox.group>
    <flux:table :paginate="$this->roles" class="mt-3">
        <flux:table.columns>
            <flux:table.column class="w-0 overflow-hidden p-0 m-0"><flux:checkbox.all /></flux:table.column>
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

    <!-- Add/Edit Role Form -->
    <x-admin.user-management.roles.form-modal />

    <!-- Delete Role Modal -->
    <x-admin.user-management.roles.delete-modal />

    <!-- Show Permissions Modal -->
    <x-admin.user-management.roles.permissions-modal />
</section>