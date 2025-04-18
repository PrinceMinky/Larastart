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
            <flux:button wire:click="showForm({{ $role->id }})" icon="pencil" size="sm" inset="top bottom" tooltip="Edit Role" />
        @endif

        @if(! in_array($role->id, [1,2,3]))
            <flux:button wire:click="showConfirmDeleteForm({{ $role->id }})" variant="danger" icon="trash" size="sm" inset="top bottom" tooltip="Delete Role" />
        @endif
    </flux:table.cell>
</flux:table.row>