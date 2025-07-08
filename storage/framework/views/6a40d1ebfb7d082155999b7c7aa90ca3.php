<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => null,
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
    'label' => null,
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
?>

<div <?php echo e($attributes->class(['flex items-center gap-2 p-2 text-xs [:where(&)]:text-zinc-500 dark:[:where(&)]:text-zinc-300'])); ?>>
    <?php echo e($slot); ?>


    <?php if(is_string($label) && $label !== ''): ?>
        <div class="text-zinc-800 dark:text-white"><?php echo e($label); ?></div>
    <?php elseif($label): ?>
        <?php echo e($label); ?>

    <?php endif; ?>

    <?php if($field): ?>
        <div class="flex-1"></div>

        <slot field="<?php echo e($field); ?>" <?php if($format): ?> format="<?php echo e($format); ?>" <?php endif; ?>></slot>
    <?php endif; ?>
</div><?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\tooltip\value.blade.php ENDPATH**/ ?>