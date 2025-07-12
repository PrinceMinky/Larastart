@props([
    'heading' => null,
    'subheading' => null,
    'actions' => null,
])

<div class="relative mb-4 w-full">
    <div class="flex">
        <div class="flex-1/2">
            <flux:heading size="xl" level="1">{{ $heading }}</flux:heading>
            <flux:subheading size="lg">{{ $subheading }}</flux:subheading>
        </div>

        <div class="flex items-center">
            {{ $actions }}
        </div>
    </div>
     
    <flux:separator variant="subtle" class="mt-4" />
</div>