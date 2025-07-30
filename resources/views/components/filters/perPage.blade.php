<div class="flex items-center gap-2">
    <flux:text>Showing</flux:text>

    <flux:select wire:model.live="perPage" placeholder="Select per page">
        @foreach($this->pagesList as $page)
            <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
        @endforeach
    </flux:select>

    <flux:text>items</flux:text>
</div>