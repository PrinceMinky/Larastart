<section>
    <!-- Display heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Users') }}</x-slot>
        <x-slot name="subheading">{{ __('A comprehensive list of your websites users.') }}</x-slot>

        <x-slot name="actions">
            <flux:button wire:click="showForm" variant="primary">Add User</flux:button>
        </x-slot>
    </x-page-heading>

    <!-- Search/Filters and Actions -->
    <div class="flex gap-2">
        <div class="w-2/4">
            <x-admin.user-management.users.search />
        </div>

        <flux:spacer />
        
        <div class="flex gap-2">
            <x-admin.user-management.users.multiple-actions />
        </div>
    </div>

    <!-- Users Table -->
    <flux:checkbox.group>
    <flux:table :paginate="$this->users" class="mt-3">
        <flux:table.columns>
            <flux:table.column class="w-0 overflow-hidden p-0 m-0">
                <flux:checkbox.all
                    :x-show="($this->users->count() <= 1)?true:false"
                />
            </flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'date_of_birth'" :direction="$sortDirection" wire:click="sort('date_of_birth')">Age</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection" wire:click="sort('email')">Email</flux:table.column>
            <flux:table.column>Role(s)</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">Joined</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->users as $user)
                <x-admin.user-management.users.row :$user />
            @endforeach
        </flux:table.rows>
    </flux:table>
    </flux:checkbox.group>

    <!-- Add/Edit User Form -->
    <x-admin.user-management.users.form-modal />

    <!-- Delete User Modal -->
    <x-admin.user-management.users.delete-modal />
</section>