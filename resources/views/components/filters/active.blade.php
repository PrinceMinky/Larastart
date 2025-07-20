@if(!empty($filters) && count(array_filter($filters)))
    <div class="flex flex-wrap items-center gap-2 p-4 rounded-lg bg-zinc-800/[4%] dark:bg-white/[7%] text-zinc-800 dark:text-white">
        <flux:subheading class="text-sm font-medium text-zinc-800 dark:text-white">
            Active Filters:
        </flux:subheading>

        @php
            $filterConfig = $this->filterConfig();
            $processedKeys = [];
            
            // Create a mapping of input keys to their parent groups
            $inputKeyToGroup = [];
            $groupToInputKeys = [];
            
            foreach ($filterConfig as $configKey => $config) {
                if (($config['type'] ?? null) === 'input-group' && isset($config['inputs'])) {
                    $groupToInputKeys[$configKey] = array_keys($config['inputs']);
                    foreach (array_keys($config['inputs']) as $inputKey) {
                        $inputKeyToGroup[$inputKey] = [$configKey, $config];
                    }
                }
            }
        @endphp

        @foreach($filters as $key => $value)
            @continue(empty($value) || in_array($key, $processedKeys))

            @php
                // Check if this is an input group (stored as nested array)
                if (isset($filterConfig[$key]) && ($filterConfig[$key]['type'] ?? null) === 'input-group') {
                    $groupConfig = $filterConfig[$key];
                    
                    if (is_array($value)) {
                        $groupValues = [];
                        foreach ($groupConfig['inputs'] as $inputKey => $inputConfig) {
                            if (!empty($value[$inputKey] ?? null)) {
                                $placeholder = $inputConfig['placeholder'] ?? ucfirst(str_replace('_', ' ', $inputKey));
                                $groupValues[] = "$placeholder: {$value[$inputKey]}";
                            }
                        }
                        
                        if (!empty($groupValues)) {
                            $groupLabel = $groupConfig['label'] ?? ucfirst(str_replace('_', ' ', $key));
                            $displayText = implode(', ', $groupValues);
                            $processedKeys[] = $key;
            @endphp
                            
                            <flux:badge size="sm">
                                {{ $groupLabel }}: {{ $displayText }}
                                <flux:button
                                    wire:click="$set('filters.{{ $key }}', [])"
                                    icon="x-mark"
                                    variant="ghost"
                                    size="xs"
                                    title="Clear {{ $groupLabel }}"
                                />
                            </flux:badge>
                            
            @php
                            continue;
                        }
                    }
                    continue;
                }
                
                // Check if this key is part of an input group (individual keys)
                if (isset($inputKeyToGroup[$key])) {
                    [$groupKey, $groupConfig] = $inputKeyToGroup[$key];
                    
                    // Skip if we've already processed this group
                    if (in_array($groupKey, $processedKeys)) {
                        continue;
                    }
                    
                    // Collect all values for this input group from individual filter keys
                    $groupValues = [];
                    $hasValues = false;
                    
                    foreach ($groupConfig['inputs'] as $inputKey => $inputConfig) {
                        if (!empty($filters[$inputKey] ?? null)) {
                            $placeholder = $inputConfig['placeholder'] ?? ucfirst(str_replace('_', ' ', $inputKey));
                            $groupValues[] = "$placeholder: {$filters[$inputKey]}";
                            $hasValues = true;
                        }
                    }
                    
                    if ($hasValues) {
                        $groupLabel = $groupConfig['label'] ?? ucfirst(str_replace('_', ' ', $groupKey));
                        $displayText = implode(', ', $groupValues);
                        
                        // Mark this group as processed
                        $processedKeys[] = $groupKey;
                        // Also mark all individual keys as processed
                        foreach ($groupToInputKeys[$groupKey] as $inputKey) {
                            $processedKeys[] = $inputKey;
                        }
            @endphp
                        
                        <flux:badge size="sm">
                            {{ $groupLabel }}: {{ $displayText }}
                            <flux:button
                                wire:click="clearInputGroup('{{ $groupKey }}')"
                                icon="x-mark"
                                variant="ghost"
                                size="xs"
                                title="Clear {{ $groupLabel }}"
                            />
                        </flux:badge>
                        
            @php
                        continue;
                    }
                    
                    continue;
                }
                
                // Regular filter processing (not part of input group)
                $currentConfig = $filterConfig[$key] ?? [];
                $label = $currentConfig['label'] ?? ucfirst(str_replace('_', ' ', $key));
                $isBoolean = ($currentConfig['type'] ?? null) === 'switch';
                $displayCallback = $currentConfig['display'] ?? null;
                
                // More robust clear value handling
                $clearValue = match(true) {
                    $isBoolean => 'false',
                    is_array($value) => '[]',
                    is_numeric($value) => 'null',
                    default => "''"
                };
            @endphp

            @if(is_array($value))
                {{-- Handle array filters --}}
                @foreach($value as $index => $item)
                    @php
                        $display = is_callable($displayCallback)
                            ? $displayCallback($item)
                            : (is_object($item) && isset($item->name) ? $item->name : $item);
                        
                        // Create a safe array filter removal
                        $remainingItems = collect($value)->reject(fn($v, $k) => $k === $index)->values()->toJson();
                    @endphp
                    
                    <flux:badge size="sm">
                        {{ $label }}:
                        {{ $display }}
                        <flux:button
                            wire:click="$set('filters.{{ $key }}', {{ $remainingItems }})"
                            icon="x-mark"
                            variant="ghost"
                            size="xs"
                            title="Remove {{ $display }}"
                        />
                    </flux:badge>
                @endforeach
            @else
                {{-- Handle single value filters --}}
                @php
                    $display = match(true) {
                        $isBoolean => '',
                        is_callable($displayCallback) => $displayCallback($value),
                        is_object($value) && isset($value->name) => $value->name,
                        default => $value
                    };
                @endphp
                
                <flux:badge size="sm">
                    {{ $label }}
                    @if(!$isBoolean && $display)
                        : {{ $display }}
                    @endif
                    <flux:button
                        wire:click="$set('filters.{{ $key }}', {{ $clearValue }})"
                        icon="x-mark"
                        variant="ghost"
                        size="xs"
                        title="Clear {{ $label }}"
                    />
                </flux:badge>
            @endif
        @endforeach

        {{-- Clear all filters button --}}
        <flux:button
            wire:click="$call('clearAllFilters')"
            variant="ghost"
            size="sm"
        >
            Clear All
        </flux:button>
    </div>
@endif