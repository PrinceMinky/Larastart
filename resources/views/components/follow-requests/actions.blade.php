<div class="flex gap-2">    
    <flux:button wire:click="accept({{ $request->id }})" size="sm">Accept</flux:button>
    <flux:button wire:click="deny({{ $request->id }})" size="sm" variant="danger">Deny</flux:button>
</div>