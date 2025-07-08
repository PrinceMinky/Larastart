@props([
    'text' => null,
    'handle' => 'loadMore',
    'hasMore' => false,
    'icon' => true
])

<div>
    <div class="flex justify-center gap-4 py-4" wire:loading.flex>
        @if($icon)
            <flux:icon.loading />
        @endif

        @if($text)
            <flux:text variant="muted">{{ $text }}</flux:text>
        @endif
    </div>

    @if($hasMore)
        <div 
            x-data
            x-intersect.debounce.300ms="$wire.{{ $handle }}()"
            class="h-4 w-full">
        </div>
    @endif
</div>
