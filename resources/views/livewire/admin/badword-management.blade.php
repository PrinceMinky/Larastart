<section class="flex flex-col gap-2">
    <!-- Heading & Subheading -->
    <x-page-heading>
        <x-slot name="heading">Badwords Management</x-slot:heading>
        <x-slot name="subheading">A comprehensive list of badwords.</x-slot:heading>
        
        <x-slot name="actions">
            <div class="flex gap-1">
                <flux:button x-on:click="$flux.modal('import-form').show()" variant="ghost">Import</flux:button>
                <flux:button x-on:click="$wire.word = ''; $flux.modal('badwords-form').show()">Add Badword</flux:button>
            </div>
        </x-slot>
    </x-page-heading>

    <!-- Search -->
    <div class="flex">
        <div class="flex gap-2 w-1/2">
            <flux:input wire:model.live="search" placeholder="Search badwords..." clearable />
            
            {!! $this->perPageForm() !!}
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
                    No badwords added to database. Why not <flux:link x-on:click="$flux.modal('import-form').show()" class="cursor-pointer">add some</flux:link>.
                @endif
            </flux:text>
        </flux:card>
    @endif

    <!-- Add Badword Form -->
    <flux:modal name="badwords-form" class="w-full">
        <form wire:submit="create" class="flex flex-col gap-4">
            <flux:input wire:model="word" label="Word" placeholder="Enter word..."  />

            @if(config('larastart.replace_badwords'))
            <flux:input wire:model="replacement" label="Replacement Word" placeholder="Enter replacement..." />
            @endif

            <div class="flex justify-end gap-1">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit">Add Badword</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Import Form -->
    <flux:modal name="import-form" class="w-full max-w-2xl">
        <form wire:submit="import" class="flex flex-col gap-6">
            <div class="flex flex-col gap-0">
                <flux:heading size="lg">Import Badwords</flux:heading>
                <flux:subheading>
                    Select categories to import all words from those categories into your database.
                </flux:subheading>
            </div>

            <flux:checkbox.group wire:model="selectedCategories" label="Categories" variant="pills">
                @foreach($this->importCategories as $category)
                    <flux:checkbox 
                        :value="$category" 
                        :label="ucfirst(str_replace('-', ' ', $category))" 
                    />
                @endforeach
            </flux:checkbox.group>

            <div class="flex justify-end gap-1">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button 
                    variant="primary" 
                    color="teal" 
                    type="submit"
                >
                    Import Selected Categories
                </flux:button>
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

            <div class="flex justify-end gap-1">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="delete" autofocus>Delete badword</flux:button>
            </div>
        </div>
    </flux:modal>
</section>