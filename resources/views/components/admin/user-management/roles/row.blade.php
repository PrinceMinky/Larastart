<flux:table.row :key="$role->id">
    <flux:table.cell class="whitespace-nowrap">
        @if(! in_array($role->id, [1,2,3]))
        <flux:checkbox wire:model="selectedRoleIds" value="{{ $role->id }}" />
        @endif
    </flux:table.cell>
    
    <flux:table.cell class="whitespace-nowrap">{{ $role->name }}</flux:table.cell>
    <flux:table.cell class="whitespace-nowrap items centre">
        <flux:button icon="eye" variant="ghost" inset="top bottom left right" wire:click="showPermissionsModal({{ $role->id }})">
            {{ ($role->id === 1) ? $this->permissions->count() : $role->permissions->count() }}
        </flux:button>
    </flux:table.cell>
    <flux:table.cell class="text-right whitespace-nowrap">
        
        @if(! in_array($role->id, [1]))
        <flux:dropdown>
            <flux:button icon="ellipsis-horizontal" size="sm" />

            <flux:menu>
                <flux:menu.item icon="pencil" wire:click="showForm({{ $role->id }})">Edit Permission</flux:menu.item>

                @if(! in_array($role->id, [1,2,3]))
                <flux:menu.item icon="trash" wire:click="showConfirmDeleteForm({{ $role->id }})" variant="danger">Delete Permission</flux:menu.item>
                @endif
            </flux:menu>
        </flux:dropdown>
        @endif
    </flux:table.cell>
</flux:table.row>