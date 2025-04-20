<div class="flex gap-2 items-center" x-show="$wire.selectedPermissionIds.length > 0">
    @can('delete permissions')
    <flux:text>
        <span x-text="$wire.selectedPermissionIds.length"></span> selected
    </flux:text>

    <flux:separator vertical class="my-2" />

    <form wire:submit="deleteSelected">
        <flux:button type="submit" variant="danger" wire:target="deleteSelected">Delete</flux:button>
    </form>

    <flux:separator vertical class="my-2" />
    @endcan
</div>