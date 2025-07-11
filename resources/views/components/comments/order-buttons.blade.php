<div>
    <flux:radio.group wire:model.live="orderBy" variant="buttons">
        <flux:radio size="sm" value="{{ \App\Livewire\Comments::ORDER_NEWEST }}">Newest</flux:radio>
        <flux:radio size="sm" value="{{ \App\Livewire\Comments::ORDER_TOP }}">Top</flux:radio>
    </flux:radio.group>
</div>