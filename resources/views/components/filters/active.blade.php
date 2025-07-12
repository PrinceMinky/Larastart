@if(!empty($filters) && count(array_filter($filters)))
    <div class="flex flex-wrap gap-2 mt-3">
        <flux:subheading class="self-center">Active Filters:</flux:subheading>

        @foreach($filters as $key => $value)
            @continue(empty($value))

            @php
                $config = $config[$key] ?? [];
                $label = $config['label'] ?? ucfirst(str_replace('_', ' ', $key));
                $display = is_callable($config['display'] ?? null)
                    ? ($config['display'])($value)
                    : (is_array($value) ? implode(', ', $value) : $value);
                $clearValue = is_array($value) ? '[]' : "''";
            @endphp

            <flux:badge variant="outline" class="flex items-center gap-1">
                {{ $label }}: {{ $display }}
                <flux:button
                    wire:click="$set('filters.{{ $key }}', {{ $clearValue }})"
                    icon="x-mark"
                    variant="ghost"
                    size="xs"
                />
            </flux:badge>
        @endforeach
    </div>
@endif
