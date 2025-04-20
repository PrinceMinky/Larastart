<flux:table.row :key="$permission->id">
    @can('delete permissions')
    <flux:table.cell class="whitespace-nowrap"><flux:checkbox wire:model="selectedPermissionIds" value="{{ $permission->id }}" /></flux:table.cell>
    @endcan
    <flux:table.cell class="whitespace-nowrap">{{ $permission->name }}</flux:table.cell>
    <flux:table.cell class="text-right whitespace-nowrap">
        @canany(['edit permissions','delete permissions'])
        <flux:dropdown>
            <flux:button icon="ellipsis-horizontal" size="sm" />

            <flux:menu>
                @can('edit permissions')
                <flux:menu.item icon="pencil" wire:click="showForm({{ $permission->id }})">Edit Permission</flux:menu.item>
                @endcan

                @can('delete permissions')
                <flux:menu.item icon="trash" wire:click="showConfirmDeleteForm({{ $permission->id }})" variant="danger">Delete Permission</flux:menu.item>
                @endcan
            </flux:menu>
        </flux:dropdown>
        @endcanany
    </flux:table.cell>
</flux:table.row>