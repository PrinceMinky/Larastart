<x-sort.item :key="$column['id']">
    <div 
            class="rounded-lg w-80 max-w-80 bg-zinc-400/5 dark:bg-zinc-900
            {{ $this->selectedColumn === $column->slug ? '
            shadow border-2 border-solid
            border-zinc-900 dark:border-white
            shadow-zinc-400 dark:shadow-zinc-500
            ' : '' }}"
        >
        <div class="px-4 py-4 flex justify-between items-start">
            <div>
                <flux:heading class="flex gap-2 items-center">
                    <x-sort.handle :permissions="['edit kanban boards']" />
                    
                    <flux:link :href="route('admin.kanban_board', [$this->currentBoard->slug, $column->slug])" class="!no-underline">
                        {{ $column->title }}
                    </flux:link>
                </flux:heading>
                <flux:subheading class="mb-0!">{{ count($column->cards) }} tasks</flux:subheading>
            </div>

            <x-admin.kanban-board.column-actions :$column />
        </div>

        <!-- CARD SORTING -->
        <x-sort 
            class="relative flex flex-col gap-2 px-2"
            group="cards"
            handle="updateCardPosition"
            permissions="edit kanban cards"
            :key="$column->id"
        >
            @foreach ($column->cards as $card)
                <x-admin.kanban-board.card :sortable="true" :actions="true" :$card />
            @endforeach
        </x-sort>

        <div class="px-2 py-2">
            @can('create kanban cards')
            <flux:button wire:click="showCreateCardForm({{ $column->id }})"
                        variant="subtle"
                        icon="plus"
                        size="sm"
                        class="w-full justify-start! mt-1">
                Add Task
            </flux:button>
            @endcan
        </div>
    </div>
</x-sort.item>