<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'placeholder' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'placeholder' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<ui-selected-date x-ignore wire:ignore class="truncate flex gap-2 text-start flex-1 text-zinc-700 [[disabled]_&]:text-zinc-500 dark:text-zinc-300 dark:[[disabled]_&]:text-zinc-400">
    <template name="placeholder">
        <span class="text-zinc-400 [[disabled]_&]:text-zinc-400/70 dark:text-zinc-400 dark:[[disabled]_&]:text-zinc-500" data-flux-date-picker-placeholder>
            <?php echo e($placeholder ?? new Illuminate\Support\HtmlString('<slot></slot>')); ?>

        </span>
    </template>

    <template name="date">
        <div dir="auto"><slot></slot></div>
    </template>
</ui-selected-date><?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\date-picker\selected.blade.php ENDPATH**/ ?>