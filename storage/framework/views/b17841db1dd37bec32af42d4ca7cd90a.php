<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'field' => null,
    'format' => null,
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
    'field' => null,
    'format' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
$format = is_array($format) ? \Illuminate\Support\Js::encode($format) : $format;

$classes = Flux::classes()
    ->add('opacity-0 data-active:opacity-100 absolute flex flex-col rounded-lg overflow-hidden shadow-lg border border-zinc-200 bg-white dark:border-zinc-500 dark:bg-zinc-700');
?>

<template name="tooltip">
    <div <?php echo e($attributes->class($classes)); ?>>
        <?php echo e($slot); ?>

    </div>
</template><?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\tooltip\index.blade.php ENDPATH**/ ?>