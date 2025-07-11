<section>
    <!-- Display heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Kanban Board') }}</x-slot>
        <x-slot name="subheading">{{ __('Our place of work.') }}</x-slot>
        
        <x-slot name="actions">
            @can('create kanban columns')
            <flux:button
                wire:click="showColumnForm"
            >
                Add Column
            </flux:button>
            @endcan
        </x-slot>
    </x-page-heading>

    <div class="flex flex-col gap-4 lg:flex-row w-full min-h-screen">
        <!-- Main Kanban Area (columns/cards) -->
        <div class="w-full lg:w-2/3 order-2 lg:order-1">
            <x-admin.kanban-board.breadcrumbs />
            
            <x-drag-scroll-container>
                <x-sort class="flex gap-4" handle="updateColumnPosition" permissions="edit kanban columns">
                    @foreach ($board->columns as $column)
                        <x-admin.kanban-board.column :$column />
                    @endforeach
                </x-sort>
            </x-drag-scroll-container>
        </div>

        <!-- Sidebar (users, notes, etc.) -->
        <div class="w-full lg:w-1/3 order-1 lg:order-2">
            <div class="flex justify-between items-center">
                <flux:heading size="lg">Board Owner</flux:heading>
            </div>

            <flux:table>
                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell class="flex items-center gap-2 sm:gap-4">
                            <flux:avatar :name="$this->currentBoard->owner->name" color="auto" />

                            <div class="flex flex-col">
                                <flux:heading>
                                    <flux:link class="!no-underline" :href="route('profile.show', ['username' => $this->currentBoard->owner->username])">
                                        {{ $this->currentBoard->owner->name }}
                                    </flux:link>
                                    @if ($this->currentBoard->owner->is_me())
                                        <flux:badge size="sm" color="blue" class="ml-1 max-sm:hidden">You</flux:badge>
                                    @endif
                                </flux:heading>
                                <flux:text class="max-sm:hidden">{{ $this->currentBoard->owner->email }}</flux:text>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>

            <div class="flex justify-between items-center">
                <flux:heading size="lg">Team members</flux:heading>

                <flux:button size="sm" icon="plus" wire:click="showAssociateForm">Associate</flux:button>
            </div>

            <flux:table>
                <flux:table.rows>
                    @foreach ($this->currentBoard->users->sortBy('name') as $user)
                        <flux:table.row>
                            <flux:table.cell>
                                <div class="w-full flex justify-between items-center gap-2 sm:gap-4">
                                    <div class="flex gap-2 sm:gap-4">
                                        <flux:avatar :name="$user->name" color="auto" />

                                        <div class="flex flex-col">
                                            <flux:heading>
                                                <flux:link class="!no-underline" :href="route('profile.show', ['username' => $user->username])">
                                                    {{ $user->name }}
                                                </flux:link>

                                                @if (auth()->id() === $user->id)
                                                    <flux:badge size="sm" color="blue" class="ml-1 max-sm:hidden">You</flux:badge>
                                                @endif
                                            </flux:heading>
                                            <flux:text class="max-sm:hidden">{{ $user->email }}</flux:text>
                                        </div>
                                    </div>

                                    @if (auth()->id() !== $user->id)
                                    <div class="flex justify-end">
                                        <flux:button
                                            size="sm"
                                            variant="subtle"
                                            icon="trash"
                                            class="shrink-0"
                                            wire:click="removeUser({{ $user->id }})"
                                        />
                                    </div>
                                    @endif
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>
    </div>
    <!-- Column Modal -->
    <x-admin.kanban-board.column-modal />
    
    <!-- Card Modal -->
    <x-admin.kanban-board.card-modal  />
    
    <!-- Invite Users Modal  -->
    <x-admin.kanban-board.associate-users-modal />
    
    <!-- Confirm Delete Column Modal -->
    <x-admin.kanban-board.delete-column-confirm-form />

    <!-- Confirm Delete Card Modal -->
    <x-admin.kanban-board.delete-card-confirm-form />
</section>