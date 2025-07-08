@canany(['edit kanban columns','delete kanban columns'])
<flux:dropdown position="bottom" align="end">
    <flux:button variant="subtle" icon="ellipsis-horizontal" size="sm" />
    <flux:menu>
        @can('edit kanban columns')
        <flux:menu.item icon="pencil" wire:click="showColumnForm({{ $column['id'] }})">Edit Column</flux:menu.item>
        @endcan

        @can('delete kanban columns')
        <flux:menu.item variant="danger" icon="trash" wire:click="showDeleteColumnForm({{ $column['id'] }})">Delete Column</flux:menu.item>
        @endcan
    </flux:menu>
</flux:dropdown>
@endcan