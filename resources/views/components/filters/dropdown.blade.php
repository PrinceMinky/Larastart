<flux:dropdown position="bottom" align="end">
    <flux:button icon="funnel" icon:variant="micro">
        Filters

        @if($activeFiltersCount)
            <x-slot name="iconTrailing">
                <flux:badge size="sm" class="-mr-1" :class="$activeFiltersCount > 0 ? 'bg-primary-500 text-white' : ''">
                    <span class="tabular-nums">{{ $activeFiltersCount }}</span>
                </flux:badge>
            </x-slot>
        @endif
    </flux:button>

    <flux:popover class="flex flex-col gap-4 w-130">
        @foreach($config as $key => $meta)
            @php
                $label = $meta['label'] ?? ucfirst(str_replace('_', ' ', $key));
                $type = $meta['type'] ?? 'text';
                $placeholder = $meta['placeholder'] ?? 'Enter ' . $label;
                $options = $meta['options'] ?? null;
                $searchable = $meta['searchable'] ?? false;
            @endphp

            @if($type === 'select' && (is_array($options) || $options instanceof \Illuminate\Support\Collection))
                <flux:select wire:model.live="filters.{{ $key }}"
                            variant="listbox"
                            label="{{ $label }}"
                            placeholder="{{ $placeholder }}"
                            searchable="{{ $searchable }}"
                >
                    @if(empty($options))
                        <flux:select.option value="">No users available</flux:select.option>
                    @else
                        @foreach($options as $optionKey => $optionLabel)
                            <flux:select.option value="{{ $optionKey }}">{{ $optionLabel->name }}</flux:select.option>
                        @endforeach
                    @endif
                </flux:select>

            @elseif($type === 'date')
                <flux:date-picker type="date" wire:model.live="filters.{{ $key }}" label="{{ $label }}" />

            @elseif($type === 'radio-group' && (is_array($options) || $options instanceof \Illuminate\Support\Collection))
                <flux:radio.group wire:model.live="filters.{{ $key }}" label="{{ $label }}">
                    @foreach($options as $optionKey => $optionLabel)
                        <flux:radio value="{{ $optionKey }}" label="{{ $optionLabel }}" />
                    @endforeach
                </flux:radio.group>

            @elseif($type === 'checkbox' && (is_array($options) || $options instanceof \Illuminate\Support\Collection))
                <flux:checkbox.group wire:model.live="filters.{{ $key }}" label="{{ $label }}">
                    @foreach($options as $optionKey => $optionLabel)
                        <flux:checkbox value="{{ $optionKey }}" label="{{ $optionLabel }}" />
                    @endforeach
                </flux:checkbox.group>

            @elseif($type === 'switch')
                <flux:switch wire:model.live="filters.{{ $key }}" label="{{ $label }}" />
            @elseif($type === 'input-group' && is_array($meta['inputs']))
                <flux:input.group label="{{ $label }}">
                    @foreach($meta['inputs'] as $inputKey => $inputMeta)
                        @php
                            $inputPlaceholder = is_array($inputMeta) ? ($inputMeta['placeholder'] ?? '') : $inputMeta;
                            $inputType = is_array($inputMeta) ? ($inputMeta['type'] ?? 'text') : 'text';
                        @endphp

                        @if($inputType === 'date')
                            <flux:date-picker wire:model.live="filters.{{ $key }}.{{ $inputKey }}" placeholder="{{ $inputPlaceholder }}" class="w-full" />
                        @else
                            <flux:input
                                wire:model.live="filters.{{ $key }}.{{ $inputKey }}"
                                type="{{ $inputType }}"
                                placeholder="{{ $inputPlaceholder }}"
                            />
                        @endif
                    @endforeach
                </flux:input.group>
            @else
                <flux:input wire:model.live="filters.{{ $key }}" label="{{ $label }}" placeholder="{{ $placeholder }}" />
            @endif
        @endforeach

        @if($activeFiltersCount > 0)
            <div class="pt-2 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button wire:click="clearFilters" variant="ghost" size="sm" class="w-full">
                    Clear All Filters
                </flux:button>
            </div>
        @endif
    </flux:popover>
</flux:dropdown>
