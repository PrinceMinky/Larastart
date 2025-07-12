<flux:dropdown position="bottom" align="end">
    <flux:button icon="funnel" icon:variant="micro">
        Filters

        @if($this->activeFiltersCount)
        <x-slot name="iconTrailing">
            <flux:badge size="sm" class="-mr-1" :class="$this->activeFiltersCount > 0 ? 'bg-primary-500 text-white' : ''">
                <span class="tabular-nums">{{ $this->activeFiltersCount }}</span>
            </flux:badge>
        </x-slot>
        @endif
    </flux:button>

    <flux:popover class="flex flex-col gap-4 min-w-64">
        <!-- Model Filter -->
        <flux:select wire:model.live="filters.model" variant="listbox" label="Model" placeholder="Select Model">
            @foreach($this->getModelsList() as $key => $model)
                <flux:select.option value="{{ $model }}">{{ $model }}</flux:select.option>
            @endforeach
        </flux:select>

        <!-- Causer Filter -->
        <flux:select wire:model.live="filters.causer_id" variant="listbox" searchable label="Caused By (User)" placeholder="All Users">
            @foreach($this->getUsersList() as $id => $name)
                <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
            @endforeach
        </flux:select>

        <!-- Date Filters -->
        <flux:date-picker type="date" wire:model.live="filters.start_date" label="Start Date" />
        <flux:date-picker type="date" wire:model.live="filters.end_date" label="End Date" />

        <!-- Clear Filters -->
        @if($this->activeFiltersCount > 0)
            <flux:button wire:click="clearFilters" variant="ghost" size="sm">
                Clear All Filters
            </flux:button>
        @endif

        <!-- Clear Filters Button -->
        @if($this->activeFiltersCount > 0)
        <div class="pt-2 border-t border-zinc-200 dark:border-zinc-700">
            <flux:button wire:click="clearFilters" variant="ghost" size="sm" class="w-full">
                Clear All Filters
            </flux:button>
        </div>
        @endif
    </flux:popover>
</flux:dropdown>