@if($this->activeFiltersCount > 0)
<div class="flex flex-wrap gap-2 mt-3">
    <flux:subheading class="self-center">Active Filters:</flux:subheading>

    @if(!empty($filters['stats']))
        @php
            $statLabels = $this->getNeedsVerifiedEmailProperty() ? 
             [
                '0' => 'Total Users',
                '1' => 'Verified Users',
                '2' => 'Unverified Users',
                '3' => 'New Users (Last 30 Days)',
            ] : [
                '0' => 'Total Users',
                '1' => 'New Users (Last 30 Days)',
            ];
        @endphp

        <flux:badge variant="outline" class="flex items-center gap-1">
            {{ $statLabels[$filters['stats']] ?? ucfirst($filters['stats']) }}
            <flux:button 
                wire:click="$set('filters.stats', null)" 
                variant="ghost" 
                size="xs" 
                icon="x-mark" 
                class="ml-1 -mr-1" 
            />
        </flux:badge>
    @endif
    
    @if(!empty($filters['verified_email']))
        @foreach($filters['verified_email'] as $filter)
            <flux:badge variant="outline" class="flex items-center gap-1">
                Email: {{ ucfirst($filter) }}
                <flux:button 
                    wire:click="$set('filters.verified_email', {{ json_encode(array_diff($filters['verified_email'], [$filter])) }})"
                    variant="ghost" 
                    size="xs" 
                    icon="x-mark"
                    class="ml-1 -mr-1"
                />
            </flux:badge>
        @endforeach
    @endif

    @if(!empty($filters['roles']))
        @foreach($filters['roles'] as $role)
            <flux:badge variant="outline" class="flex items-center gap-1">
                Role: {{ $role }}
                <flux:button 
                    wire:click="$set('filters.roles', {{ json_encode(array_diff($filters['roles'], [$role])) }})"
                    variant="ghost" 
                    size="xs" 
                    icon="x-mark"
                    class="ml-1 -mr-1"
                />
            </flux:badge>
        @endforeach
    @endif

    @if(!empty($filters['account_type']))
        @foreach($filters['account_type'] as $type)
            <flux:badge variant="outline" class="flex items-center gap-1">
                Type: {{ ucfirst($type) }}
                <flux:button 
                    wire:click="$set('filters.account_type', {{ json_encode(array_diff($filters['account_type'], [$type])) }})"
                    variant="ghost" 
                    size="xs" 
                    icon="x-mark"
                    class="ml-1 -mr-1"
                />
            </flux:badge>
        @endforeach
    @endif

    @if(!empty($filters['countries']))
        @foreach($filters['countries'] as $countryValue)
            @php
                $countryLabel = collect($this->countries)->firstWhere('value', $countryValue)['label'] ?? $countryValue;
            @endphp
            <flux:badge variant="outline" class="flex items-center gap-1">
                Country: {{ $countryLabel }}
                <flux:button 
                    wire:click="$set('filters.countries', {{ json_encode(array_diff($filters['countries'], [$countryValue])) }})"
                    variant="ghost" 
                    size="xs" 
                    icon="x-mark"
                    class="ml-1 -mr-1"
                />
            </flux:badge>
        @endforeach
    @endif

    @if(!empty($filters['min_age']) && !empty($filters['max_age']))
        <flux:badge variant="outline" class="flex items-center gap-1">
            Age: {{ $filters['min_age'] }} - {{ $filters['max_age'] }}
            <flux:button 
                wire:click="resetAgeFilters" 
                variant="ghost" 
                size="xs" 
                icon="x-mark" 
                class="ml-1 -mr-1" 
            />
        </flux:badge>
    @elseif(!empty($filters['min_age']))
        <flux:badge variant="outline" class="flex items-center gap-1">
            @if(empty($filters['max_age']))
                Age: {{ $filters['min_age'] }} + 
            @else
                Min Age: {{ $filters['min_age'] }}
            @endif
            <flux:button 
                wire:click="$set('filters.min_age', null)" 
                variant="ghost" 
                size="xs" 
                icon="x-mark" 
                class="ml-1 -mr-1" 
            />
        </flux:badge>
    @elseif(!empty($filters['max_age']))
        <flux:badge variant="outline" class="flex items-center gap-1">
            @if(empty($filters['min_age']))
                Age: Under {{ $filters['max_age'] }}
            @else
                Max Age: {{ $filters['max_age'] }}
            @endif
            <flux:button 
                wire:click="$set('filters.max_age', null)" 
                variant="ghost" 
                size="xs" 
                icon="x-mark" 
                class="ml-1 -mr-1" 
            />
        </flux:badge>
    @endif

</div>
@endif