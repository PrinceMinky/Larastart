<?php foreach (([ 'variant' ]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'size' => null,
    'variant' => null,
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
    'size' => null,
    'variant' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
if ($variant === 'pills') {
    $classes = Flux::classes()
        ->add('flex gap-4 h-8')
        ;
} elseif ($variant === 'segmented') {
    $classes = Flux::classes()
        ->add('block inline-flex p-1')
        ->add('rounded-lg bg-zinc-800/5 dark:bg-white/10')
        ->add($size === 'sm' ? 'h-8 py-[3px] px-[3px]' : 'h-10 p-1')
        ->add($size === 'sm' ? match ($variant) {
            'segmented' => '-my-px h-[calc(2rem+2px)]',
            default => '',
        } : '')
        ;
} else {
    $classes = Flux::classes()
        ->add('flex gap-4 h-10')
        ->add('border-b border-zinc-800/10 dark:border-white/20')
        ;
}
?>

<ui-tabs <?php echo e($attributes->class($classes)); ?> data-flux-tabs>
    <?php echo e($slot); ?>

</ui-tabs>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\tabs.blade.php ENDPATH**/ ?>