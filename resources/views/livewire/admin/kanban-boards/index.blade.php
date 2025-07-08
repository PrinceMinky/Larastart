<section> 
    <!-- Display heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Kanban Boards') }}</x-slot>
        <x-slot name="subheading">{{ __('A list of boards') }}</x-slot>
        
        <x-slot name="actions">
            @can('create kanban boards')
            <flux:button wire:click="showForm">
                Add Board
            </flux:button>
            @endcan
        </x-slot>
    </x-page-heading>

    <!-- Search/Filters and Actions -->
    <div class="flex gap-2">
        <div class="flex gap-2 w-2/4">
            <!-- Breadcrumbs -->
            <flux:breadcrumbs class="mb-3">
                <flux:breadcrumbs.item>Kanban Boards</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:spacer />
        
        @can('delete kanban boards')
        <div class="flex gap-2">
            <div class="flex gap-2 items-center" x-cloak x-show="$wire.selectedUserIds.length > 0">
                @can('delete users')
                <flux:text>
                    <span x-text="$wire.selectedUserIds.length"></span> selected
                </flux:text>

                <flux:separator vertical class="my-2" />

                <form wire:submit="deleteSelected">
                    <flux:button type="submit" variant="danger" wire:target="deleteSelected">Delete</flux:button>
                </form>

                <flux:separator vertical class="my-2" />
                @endcan
            </div>
        </div>
        @endcan
    </div>

    <!-- Table -->
    @if($this->boards->count() > 0)
    <flux:checkbox.group>
    <flux:table :paginate="$this->boards">
        <flux:table.columns>
            @can('delete kanban boards')
            <flux:table.column class="w-0 overflow-hidden p-0 m-0">
                <flux:checkbox.all />
            </flux:table.column>
            @endcan

            <flux:table.column 
                sortable 
                :sorted="$sortBy === 'title'" 
                :direction="$sortDirection" 
                wire:click="sort('title')">
                Title
            </flux:table.column>

            <flux:table.column 
                sortable 
                :sorted="$sortBy === 'owner'" 
                :direction="$sortDirection" 
                wire:click="sort('owner')">
                Owner
            </flux:table.column>

            <flux:table.column 
                sortable 
                :sorted="$sortBy === 'members'" 
                :direction="$sortDirection" 
                wire:click="sort('members')">
                Members
            </flux:table.column>

            <flux:table.column 
                sortable 
                :sorted="$sortBy === 'badges'" 
                :direction="$sortDirection" 
                wire:click="sort('badges')">
                Badges
            </flux:table.column>

            <flux:table.column 
                sortable 
                :sorted="$sortBy === 'created_at'" 
                :direction="$sortDirection" 
                wire:click="sort('created_at')">
                Created At
            </flux:table.column>

            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->boards as $board)
                <flux:table.row :key="$board->id">
                    @can('delete kanban boards')
                    <flux:table.cell>
                        <flux:checkbox wire:model="selectedUserIds" value="{{ $board->id }}" />
                    </flux:table.cell>
                    @endcan

                    <flux:table.cell>
                        @if(!$this->canViewBoard($board))
                            <flux:tooltip content="You are not authorised to view this board.">
                                <span class="flex gap-0 items-center">
                                    <flux:icon.lock-closed variant="micro" />
                                    {{ $board->title }}
                                </span>
                            </flux:tooltip>
                        @else
                            <flux:link :href="route('admin.kanban_board', ['id' => $board->id])" variant="subtle">
                                {{ $board->title }}
                            </flux:link>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:link :href="route('profile.show', ['username' => $board->owner->username])" variant="subtle">
                            {{ $board->owner->name }}
                        </flux:link>
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $board->users->count() }}
                    </flux:table.cell>

                    <flux:table.cell>
                        @foreach ($board->badges as $badge)
                            <flux:badge :color="$badge['color']">
                                {{ $badge['title'] }}
                            </flux:badge>
                        @endforeach
                    </flux:table.cell>

                    <flux:table.cell>{{ $board->created_at->format('jS F Y') }}</flux:table.cell>

                    @canany(['edit kanban boards','delete kanban boards'])
                    <flux:table.cell class="flex justify-end">
                        <flux:dropdown position="bottom" align="end">
                            <flux:button square icon="ellipsis-horizontal" size="sm" />

                            <flux:menu>
                                @can('edit kanban boards')
                                <flux:menu.item icon="pencil" wire:click="showForm({{ $board->id }})">Edit</flux:menu.item>
                                @endcan

                                @can('delete kanban boards')
                                <flux:menu.item icon="trash" variant="danger" wire:click="showDeleteForm({{ $board->id }})">Delete</flux:menu.item>
                                @endcan
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                    @endcanany
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
    </flux:checkbox.group>
    @else
        <flux:card class="px-4 py-6 text-center">
            <flux:icon.clipboard-document-list class="mx-auto" />
            <flux:text class="mt-2">No boards have been added yet</flux:text>
        </flux:card>
    @endif

    <!-- Add/Edit Form -->
    @canany(['create kanban boards','edit kanban boards'])
    <flux:modal name="board-form" class="w-full">
        <flux:heading>{{ !$this->boardId ? "Add Board" : "Edit Board" }}</flux:heading>

        <form wire:submit="save" class="my-6 w-full space-y-6">
            <!-- Title -->
            <flux:input 
                wire:model="title"
                :label="__('Title')"
                type="text"
                required
                :placeholder="__('Title')"
            />

            <!-- Template (on creation only) -->
            @if(!$this->boardId)
                <flux:select wire:model.live="selectedTemplate" :label="__('Template (optional)')" :nullable="true">
                    <flux:select.option value="">{{ __('-- Select a Template --') }}</flux:select.option>
                    @foreach (\App\Enums\KanbanTemplates::cases() as $template)
                        <flux:select.option value="{{ $template->value }}">{{ __($template->label()) }}</flux:select.option>
                    @endforeach
                </flux:select>

                @if($this->selectedTemplate && $this->columnsPreview)
                    <flux:card size="sm">
                        <flux:heading class="font-semibold">{{ __('Columns that will be created:') }}</flux:heading>

                        @foreach ($this->columnsPreview as $column)
                            <flux:text>{{ $column }}</flux:text>
                        @endforeach
                    </flux:card>
                @endif
            @endif

            <flux:separator text="Badge Management" />

            <!-- Add Badge Controls -->
            <flux:autocomplete wire:model="badgeTitle" label="Badge Title" placeholder="Select or type badge title...">
                @foreach(\App\Enums\KanbanBadgeNames::options() as $title)
                    <flux:autocomplete.item>{{ $title }}</flux:autocomplete.item>
                @endforeach
            </flux:autocomplete>

            <flux:select wire:model="badgeColor" label="Badge Color" placeholder="Select color..."> 
                @foreach(\App\Enums\FluxColor::options() as $color)
                    <flux:select.option :value="$color">{{ ucfirst($color) }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:button type="button" wire:click="addBadge">Add Badge</flux:button>

            <!-- Preview Existing Badges -->
            <div class="flex gap-2 flex-wrap">
                @foreach ($this->badges as $index => $badge)
                    <flux:badge :color="$badge['color']">
                        {{ $badge['title'] }}
                        <flux:badge.close wire:click="removeBadge({{ $index }})" />
                    </flux:badge>
                @endforeach
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:button x-on:click="$flux.modal('board-form').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
    @endcan

    <!-- Delete Form -->
    @can('delete kanban boards')
    <flux:modal name="delete-form" class="min-w-[22rem]">
        <form wire:submit="delete" class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Board?</flux:heading>

                <flux:subheading>
                    <p>You're about to delete a board.</p>
                    <p>This action cannot be reversed.</p>
                </flux:subheading>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" autofocus>Delete board</flux:button>
            </div>
        </form>
    </flux:modal>
    @endcan
</section>