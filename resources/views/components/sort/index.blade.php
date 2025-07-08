@props([
    'handle' =>null, 
    'group' => null, 
    'key' => null, 
    'permissions' => []
])

@php
    $canSort = empty($permissions) || auth()->user()?->canAny($permissions);
@endphp

<div 
    {{ $attributes }}
    
    @if($canSort)
        @if($group)
            x-sort:group="{{ $group }}"
        @endif

        @if($key !== null)
            x-sort="{{ '$wire.' . $handle . '($item, $position, ' . json_encode($key) . ')' }}"
        @else
            x-sort="{{ '$wire.' . $handle . '($item, $position)' }}"
        @endif
    @endif
>
    {{ $slot }}
</div>
