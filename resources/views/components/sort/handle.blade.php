@props([
    'icon' => 'arrows-right-left',
    'permissions' => null
])

@php
    $canSort = empty($permissions) || auth()->user()?->canAny($permissions);
@endphp

@if($canSort)
    <flux:icon :icon="$icon" x-sort:handle class="cursor-pointer" />
@endif