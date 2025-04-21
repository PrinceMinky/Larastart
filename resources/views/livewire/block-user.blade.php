<div class="flex flex-col">
    @if($isBlocked)
        <flux:button wire:click="toggleBlock">Unblock</flux:button>
    @else
        <flux:button wire:click="toggleBlock" variant="danger">Block</flux:button>
    @endif
</div>