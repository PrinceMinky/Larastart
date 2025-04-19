@if($this->permissions()->count() !== 0)
<flux:button wire:confirm="Are you sure you wish to download this file?" wire:click="export" icon="archive-box-arrow-down">Export</flux:button>
@endif