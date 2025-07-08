@props(['hideScrollbar' => true])

<div
    @class([
        'overflow-x-auto cursor-grab min-h-[400px] sm:min-h-[500px] md:min-h-[600px] lg:min-h-[800px] relative',
        'hide-scrollbar' => $hideScrollbar === true,
    ])
    x-data="scrollContainer()" 
    x-init="init()"
    x-on:destroy="destroy()"
>
    {{ $slot }}
</div>
