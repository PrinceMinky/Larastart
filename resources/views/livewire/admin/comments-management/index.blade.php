<section class="flex flex-col gap-2">
    <!-- Heading -->
    <x-page-heading>
        <x-slot name="heading">Comments Management</x-slot>
        <x-slot name="subheading">A place to review your users comments.</x-slot>
    </x-page-heading>

    <!-- Search and Filters -->
    <div class="flex">
        <div class="flex gap-2 w-1/2">
            <flux:input wire:model.live="search" placeholder="Search Comments" clearable />

            {!! $this->filtersDropdown() !!}
            {!! $this->perPageForm() !!}
        </div>
    </div>

    <!-- Active Filters -->
    {!! $this->activeFilters() !!}

    <!-- Table of Conents -->
    <flux:table :paginate="$this->comments">
        <flux:table.columns>
            <flux:table.column 
                sortable                     
                :sorted="$sortBy === 'id'" 
                :direction="$sortDirection" 
                wire:click="sort('id')" 
                class="w-8"
            >
                ID
            </flux:table.column>

            <flux:table.column 
                sortable                     
                :sorted="$sortBy === 'body'" 
                :direction="$sortDirection" 
                wire:click="sort('body')" 
                class="w-200"
            >
                Body
            </flux:table.column>

            <flux:table.column
                sortable                     
                :sorted="$sortBy === 'users.name'" 
                :direction="$sortDirection" 
                wire:click="sort('users.name')" 
            >
                User
            </flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($this->comments as $comment)
                <flux:table.row :key="$comment->id">
                    <flux:table.cell>{{ $comment->id }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:link
                            :href="route('admin.comments.show', $comment->id)"
                            variant="subtle"
                        >
                            {{ Str::limit($comment->body, 100) }}
                        </flux:link>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:link
                            :href="$comment->user->url"
                            variant="subtle"
                        >
                            {{ $comment->user->name }}
                        </flux:link>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</section>