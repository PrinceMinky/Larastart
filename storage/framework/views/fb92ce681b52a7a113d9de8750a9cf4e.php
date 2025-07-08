<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'invalid' => null,
    'clear' => null,
    'close' => null,
    'size' => null,
    'name' => null,
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
    'invalid' => null,
    'clear' => null,
    'close' => null,
    'size' => null,
    'name' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
// We only want to show the name attribute on the checkbox if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$invalid ??= ($name && $errors->has($name));

$class= Flux::classes()
    ->add('w-full');
?>

<ui-select
    clear="<?php echo e($clear ?? 'close esc select'); ?>"
    <?php if($close): ?> close="<?php echo e($close); ?>" <?php endif; ?>
    <?php echo e($attributes->class($class)->merge(['filter' => true])); ?>

    <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?>
    data-flux-control
    data-flux-select
>
    <?php echo e($slot); ?>

</ui-select>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\select\variants\custom.blade.php ENDPATH**/ ?>