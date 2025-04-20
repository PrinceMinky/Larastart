@php
    $formatted = format_post($text, 750);
@endphp

<div x-data="{ expanded: false }" class="post-content">
    <flux:text x-show="!expanded" class="break-all short-text">
        {!! $formatted['short_text'] !!}

        @if ($formatted['truncated'])
        <flux:link variant="subtle" @click="expanded = !expanded" class="cursor-pointer">
            <span x-show="!expanded">Show More</span>
        </flux:link>
        @endif
    </flux:text>
    
    <flux:text x-show="expanded" class="break-all">
        {!! $formatted['full_text'] !!}
    </flux:text>
</div>