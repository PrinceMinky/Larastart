@props(['key' => null, 'handle' => null])

<div {{ $attributes }} x-sort:item="{{ $key }}" wire:key="{{ $key}}">
    @if($handle)
        <div class="flex gap-1">
            <x-sort.handle icon="{{ $handle }}" />

            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</div>