<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'axis' => 'x',
    'format' => null,
    'field' => 'index',
    'position' => null,
    'tickValues' => null,
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
    'axis' => 'x',
    'format' => null,
    'field' => 'index',
    'position' => null,
    'tickValues' => null,
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

$field ??= $axis === 'x' ? 'date' : $field;
?>

<template <?php echo e($attributes->merge([
    'name' => 'axis',
    'axis' => $axis,
    'format' => $format,
    'position' => $position,
    'tick-values' => is_string($tickValues) ? $tickValues : json_encode($tickValues),
])); ?> <?php if($field): ?> field="<?php echo e($field); ?>" <?php endif; ?>>
    <?php echo e($slot); ?>

</template><?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\axis\index.blade.php ENDPATH**/ ?>