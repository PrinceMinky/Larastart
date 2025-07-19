<section class="flex flex-col gap-2">
    <!-- Heading & Subheading -->
    <x-page-heading>
        <x-slot name="heading">Badwords Management</x-slot.heading>
        <x-slot name="subheading">A comprehensive list of badwords.</x-slot.heading>
        
        <x-slot name="actions">
            <div class="flex gap-1">
                <flux:button x-on:click="$flux.modal('badwords-form').show()">Add Badword</flux:button>
                {{-- <flux:button x-on:click="$flux.modal('badword-settings-form').show()" icon="cog" square /> --}}
            </div>
        </x-slot>
    </x-page-heading>

    <!-- Search -->
    <div class="flex">
        <div class="w-1/2">
            <flux:input wire:model.live="search" placeholder="Search Users" clearable />
        </div>

        <div class="w-1/2 flex justify-end items-center gap-2" x-cloak x-show="$wire.selectedItems.length > 0">
            <flux:text><span x-text="$wire.selectedItems.length"></span> selected</flux:text>

            <flux:separator orientation="vertical" variant="subtle" :faint="true" />

            <flux:button variant="danger" wire:click="deleteSelected">
                Delete
            </flux:button>
        </div>
    </div>

    <!-- Display Badwords -->
    @if($this->badwords->count() !== 0)
    <flux:checkbox.group>
        <flux:table :paginate="$this->badwords" class="table-fixed w-full">
            <flux:table.columns>
                <flux:table.column class="w-8 text-center">
                    <flux:checkbox.all />
                </flux:table.column>

                <flux:table.column 
                    sortable 
                    :sorted="$sortBy === 'id'" 
                    :direction="$sortDirection" 
                    wire:click="sort('id')" 
                    class="w-8 text-center"
                >
                    #
                </flux:table.column>

                <flux:table.column sortable :sorted="$sortBy === 'word'" :direction="$sortDirection" wire:click="sort('word')">Badword</flux:table.column>
                
                @if(config('larastart.replace_badwords'))
                    <flux:table.column sortable :sorted="$sortBy === 'replacement'" :direction="$sortDirection" wire:click="sort('replacement')">Replacement</flux:table.column>
                @endif

                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($this->badwords as $badword)
                    <flux:table.row :key="$badword->id">
                        <flux:table.cell class="whitespace-nowrap">
                            <flux:checkbox wire:model="selectedItems" :value="$badword->id" />
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">
                            <flux:text variant="subtle">
                                {{ $badword->id }}
                            </flux:text>
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">
                            <x-inline-edit 
                                :model="$badword" 
                                field="word" 
                                permission="edit badwords" 
                            />
                        </flux:table.cell>
                        @if(config('larastart.replace_badwords'))
                        <flux:table.cell class="whitespace-nowrap">
                            <x-inline-edit 
                                :model="$badword" 
                                field="replacement" 
                                permission="edit badwords" 
                            />
                        </flux:table.cell>
                        @endif
                        <flux:table.cell class="text-right">
                            <flux:button variant="danger" size="sm" icon="trash" wire:click="showConfirmDeleteForm({{ $badword->id }})" />
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:checkbox.group>
    @else
        <flux:card size="sm" class="text-center">
            <flux:text>
                @if($this->search)
                    No badwords found, please refine your search.
                @else
                    No badwords added to database. Why not <flux:link x-on:click="$flux.modal('badwords-form').show()" class="cursor-pointer">add some</flux:link>.
                @endif
            </flux:text>
        </flux:card>
    @endif

    <!-- Form -->
    <flux:modal name="badwords-form" class="w-full">
        <form wire:submit="create" class="flex flex-col gap-4">
            <flux:input wire:model="word" label="Word" placeholder="Enter word..."  />

            @if(config('larastart.replace_badwords'))
            <flux:input wire:model="replacement" label="Replacement Word" placeholder="Enter replacement..." />
            @endif

            <div class="flex justify-end">
                <flux:button type="submit">Add Badword</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Confirm Delete -->
    <flux:modal name="delete-badword-form" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete badword?</flux:heading>

                <flux:subheading>
                    <p>You're about to delete a badword.</p>
                    <p>This action cannot be reversed.</p>
                </flux:subheading>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="delete" autofocus>Delete permission</flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Badword Management Settings -->
    <flux:modal name="badword-settings-form" class="w-full">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Settings</flux:heading>

                <flux:subheading>Global settings for badwords management.</flux:subheading>
            </div>

            <div>
                <flux:switch wire:model.live="replace_badwords" label="Replace Badwords" description="If selected - badwords will be automatically replaced with asterisks. Otherwise you'll need to choose replacement words yourself." align="right" />
            </div>
        </div>
    </flux:modal>
</section>
