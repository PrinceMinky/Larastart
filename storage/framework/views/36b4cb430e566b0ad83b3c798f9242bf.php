<?php foreach (([ 'transition', 'expanded' ]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'transition' => false,
    'expanded' => false,
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
    'transition' => false,
    'expanded' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
$classes = Flux::classes()
    ->add('pt-2 text-sm text-zinc-500 dark:text-zinc-300')
    ;
?>

<div
    x-show="open"
    <?php if($transition): ?> x-collapse <?php endif; ?>
    <?php if(! $expanded): ?> x-cloak <?php endif; ?>
    data-flux-accordion-content
>
    <div <?php echo e($attributes->class($classes)); ?>>
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\accordion\content.blade.php ENDPATH**/ ?>