<div class="flex gap-2 items-center" x-cloak x-show="$wire.selectedUserIds.length > 0">
    @can('delete users')
    <flux:text>
        <span x-text="$wire.selectedUserIds.length"></span> selected
    </flux:text>

    <flux:separator vertical class="my-2" />

    <form wire:submit="deleteSelected">
        <flux:button type="submit" variant="danger" wire:target="deleteSelected">Delete</flux:button>
    </form>

    <flux:separator vertical class="my-2" />
    @endcan
</div>