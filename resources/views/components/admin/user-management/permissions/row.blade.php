<flux:table.row :key="$permission->id">
    <flux:table.cell class="whitespace-nowrap"><flux:checkbox wire:model="selectedPermissionIds" value="{{ $permission->id }}" /></flux:table.cell>
    <flux:table.cell class="whitespace-nowrap">{{ $permission->name }}</flux:table.cell>
    <flux:table.cell class="text-right whitespace-nowrap">
        <flux:dropdown>
            <flux:button icon="ellipsis-horizontal" size="sm" />

            <flux:menu>
                <flux:menu.item icon="pencil" wire:click="showForm({{ $permission->id }})">Edit Permission</flux:menu.item>
                <flux:menu.item icon="trash" wire:click="showConfirmDeleteForm({{ $permission->id }})" variant="danger">Delete Permission</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:table.cell>
</flux:table.row>