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

            <x-admin.user-management.users.export-button />
        </div>
    </div>

    <!-- Users Table -->
    <div class="relative">
        <flux:checkbox.group>
        <flux:table :paginate="$this->users" class="relative mt-3" wire:loading.class="opacity-50" wire:target="create,update,delete,deleteSelected,search,sort">
            <flux:table.columns>
                <flux:table.column class="w-0 overflow-hidden p-0 m-0">
                    @if($this->users->count() >= 2)
                        <flux:checkbox.all />
                    @endif
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
        
        <div class="absolute inset-0 flex" wire:loading wire:target="create,update,delete,deleteSelected,search,sort">
            <flux:icon.loading class="size-12 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
        </div>
    </div>

    <!-- Add/Edit User Form -->
    <x-admin.user-management.users.form-modal />

    <!-- Delete User Modal -->
    <x-admin.user-management.users.delete-modal />
</section>