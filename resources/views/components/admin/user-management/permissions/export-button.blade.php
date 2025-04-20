@if($this->permissions()->count() !== 0)
@can('export permissions')
<flux:button wire:confirm="Are you sure you wish to download this file?" wire:click="export" icon="archive-box-arrow-down">Export</flux:button>
@endcan
@endif