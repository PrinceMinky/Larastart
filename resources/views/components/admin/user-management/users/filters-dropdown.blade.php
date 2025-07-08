<flux:dropdown position="bottom" align="end">
    <flux:button icon="funnel" icon:variant="micro">
        Filters

        <x-slot name="iconTrailing">
            <flux:badge size="sm" class="-mr-1" :class="$this->activeFiltersCount > 0 ? 'bg-primary-500 text-white' : ''">
                <span class="tabular-nums">{{ $this->activeFiltersCount }}</span>
            </flux:badge>
        </x-slot>
    </flux:button>

    <flux:popover class="flex flex-col gap-4 min-w-64">
        <!-- Email Verification Filter -->
        @if($this->needsVerifiedEmail)
        <div>
            <flux:subheading class="mb-2">Email Verification</flux:subheading>
            <flux:checkbox.group wire:model.live="filters.verified_email">
                <flux:checkbox value="verified" label="Verified" />
                <flux:checkbox value="unverified" label="Unverified" />
            </flux:checkbox.group>
        </div>
        @endif

        <!-- Role Filter -->
        <div>
            <flux:subheading class="mb-2">Roles</flux:subheading>
            <flux:select 
                wire:model.live="filters.roles" 
                variant="listbox" 
                multiple 
                placeholder="Choose roles..."
            >
                @foreach($this->roles() as $role)
                    <flux:select.option value="{{ $role->name }}">{{ $role->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <!-- Account Type Filter -->
        <div>
            <flux:subheading class="mb-2">Privacy Type</flux:subheading>
            <flux:checkbox.group wire:model.live="filters.account_type">
                <flux:checkbox value="public" label="Public" />
                <flux:checkbox value="private" label="Private" />
            </flux:checkbox.group>
        </div>

        <!-- Countries Filter -->
        <div>
            <flux:subheading class="mb-2">Countries</flux:subheading>
            <flux:select 
                searchable
                wire:model.live="filters.countries" 
                variant="listbox" 
                multiple 
                placeholder="Choose countries..."
            >
                @foreach($this->countries as $country)
                    <flux:select.option value="{{ $country['value'] }}">{{ $country['label'] }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <!-- Age Range Filter -->
        <div>
            <flux:subheading class="mb-2">Age Range</flux:subheading>
            <div class="flex items-center gap-2">
                <flux:input
                    type="number"
                    wire:model.live.debounce.500ms="filters.min_age"
                    min="0"
                    placeholder="Min Age"
                    class="w-full"
                />
                <span class="text-sm text-zinc-500">to</span>
                <flux:input
                    type="number"
                    wire:model.live.debounce.500ms="filters.max_age"
                    min="0"
                    placeholder="Max Age"
                    class="w-full"
                />
            </div>
        </div>

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