@props(['sortable' => false, 'actions' => false, 'card'])

@php
    $baseClasses = 'bg-white rounded-lg border border-zinc-200 dark:border-white/10 dark:bg-zinc-800 p-3 space-y-2 relative';
    $sortableClasses = $baseClasses . ' hover:shadow-md transition-shadow cursor-pointer';
    $wrapperClasses = $sortable ? $sortableClasses : $baseClasses;
@endphp

<x-sort.item
    :key="$card->id"
    class="{{ $wrapperClasses }}"
    onmouseenter="this.querySelector('.actions').style.display='block'"
    onmouseleave="this.querySelector('.actions').style.display='none'">

    @if($card->badges)
        <div class="flex gap-2">
            @foreach ($card->badges as $badge)
                <flux:badge :color="$badge['color']" size="sm">{{ $badge['title'] }}</flux:badge>
            @endforeach
        </div>
    @endif

    <div class="flex flex-col gap-0">
        <flux:link
            variant="subtle"
            :href="route('admin.kanban_board_card', [ $card->column->board_id, $card->column->id, $card->id, ])"
        >
            <flux:heading>{{ $card->title }}</flux:heading>
        </flux:link>

        @if($card->description)
            <flux:text>{{ $card->description }}</flux:text>
        @endif

        @if($card->due_at || $card->assigned_user_id && $card->user)
        <div class="mt-5 flex flex-col gap-0 ">
            @if ($card->due_status)
                <flux:text>
                    <span class="font-semibold">Due: </span>
                    <flux:badge size="sm" color="{{ $card->due_status['color'] }}">
                        {{ $card->due_status['text'] }}
                    </flux:badge>
                </flux:text>
            @endif

            @if($card->assigned_user_id && $card->user)
                <flux:text>
                    <span class="font-semibold">Assigned: </span>
                    
                    {{ $card->user->name }}
                </flux:text>
            @endif
        </div>
        @endif
    </div>

    @if($actions)
        @canany(['edit kanban cards', 'delete kanban cards'])
            <div class="actions absolute top-2 right-2" style="display: none;">
                <flux:dropdown position="bottom" align="end">
                    <flux:button size="sm" icon="ellipsis-horizontal" square />
                    <flux:navmenu>
                        @can('edit kanban cards')
                            <flux:navmenu.item icon="pencil" wire:click="showEditCardForm({{ $card->id }})">Edit Card</flux:navmenu.item>
                        @endcan

                        @can('delete kanban cards')
                            <flux:navmenu.item icon="x-mark" variant="danger" wire:click="showDeleteCardForm({{ $card->id }})">Delete Card</flux:navmenu.item>
                        @endcan
                    </flux:navmenu>
                </flux:dropdown>
            </div>
        @endcan
    @endif
</x-sort.item>
