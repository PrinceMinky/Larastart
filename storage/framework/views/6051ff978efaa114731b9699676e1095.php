<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'field' => 'date',
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
    'field' => 'date',
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
?>

<div <?php echo e($attributes->class([
    'bg-zinc-50 border-b border-zinc-200 dark:bg-zinc-600 dark:border-zinc-500 flex justify-between items-center p-2',
    'text-xs font-medium [:where(&)]:text-zinc-800 dark:[:where(&)]:text-zinc-100'
    ])); ?>>
    <slot field="<?php echo e($field); ?>" <?php if($format): ?> format="<?php echo e($format); ?>" <?php endif; ?>></slot>
</div>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\tooltip\heading.blade.php ENDPATH**/ ?>