<section>
    <!-- Display heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Users') }}</x-slot>
        <x-slot name="subheading">{{ __('A comprehensive list of your websites users.') }}</x-slot>

        <x-slot name="actions">
            @can('create users')
            <div class="flex gap-1">
                <flux:button wire:click="showForm" variant="primary">Add User</flux:button>

                @if (app()->environment('local'))
                    <flux:button wire:click="factory" variant="primary" color="teal">Factory: 100 users</flux:button>
                @endif
            </div>
            @endcan
        </x-slot>
    </x-page-heading>

    <!-- User Stats -->
    <div class="mb-3">
        <flux:radio.group 
            variant="cards" 
            class="max-sm:flex-col" 
            wire:model.live="filters.stats"
        >
            @foreach ($this->stats as $key => $stat)
                <flux:radio value="{{ $key }}">
                    <div class="flex-1">
                        <flux:heading class="leading-4">
                            {{ $stat['title'] }}
                        </flux:heading>

                        <flux:text size="sm" class="mt-1">
                            {{ $stat['value'] }}
                        </flux:text>

                        <div class="flex items-center gap-1 font-medium text-sm mt-2">
                            <flux:badge size="sm" :icon="$stat['trendUp'] ? 'arrow-trending-up' : 'arrow-trending-down'" icon:variant="micro" :color="$stat['trendUp'] ? 'green' : 'red'">
                                {{ $stat['trend'] }}
                            </flux:badge>
                        </div>
                    </div>
                </flux:radio>
            @endforeach
        </flux:radio.group>
    </div>

    <!-- Search/Filters and Actions -->
    <div class="flex gap-2">
        <div class="flex gap-2 w-2/4">
            <x-admin.user-management.users.search />

            <x-admin.user-management.users.filters-dropdown />
        </div>

        <flux:spacer />
        
        <div class="flex gap-2">
            <x-admin.user-management.users.multiple-actions />

            <x-admin.user-management.users.export-button />
        </div>
    </div>

    <!-- Active Filters Display -->
    <x-admin.user-management.users.active-filters-display :$filters />

    <!-- Users Table -->
    @if($this->users && $this->users->count() > 0)
    <div class="relative">
        <flux:checkbox.group>
        <flux:table :paginate="$this->users" class="relative mt-3" wire:loading.class="opacity-50" wire:target="create,update,delete,deleteSelected,search,sort,updatedFilters,clearFilters">
            <flux:table.columns>
                @can('delete users')
                <flux:table.column class="w-0 overflow-hidden p-0 m-0">
                    @if($this->users->count() >= 2)
                        <flux:checkbox.all />
                    @endif
                </flux:table.column>
                @endcan
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection" wire:click="sort('email')">Email</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'country'" :direction="$sortDirection" wire:click="sort('country')">Country</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'date_of_birth'" :direction="$sortDirection" wire:click="sort('date_of_birth')">Age</flux:table.column>
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
        
        <div class="opacity-25 absolute inset-0 flex" wire:loading wire:target="create,update,delete,deleteSelected,search,sort,updatedFilters,clearFilters,factory">
            <flux:icon.loading class="size-12 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
        </div>
    </div>
    @else
        <x-admin.user-management.users.empty-state />
    @endif

    <!-- Add/Edit User Form -->
    <x-admin.user-management.users.form-modal />

    <!-- Delete User Modal -->
    <x-admin.user-management.users.delete-modal />
</section>