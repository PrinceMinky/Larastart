<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'placeholder' => null,
    'suffix' => null,
    'max' => null,
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
    'suffix' => null,
    'max' => null,
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
        ->add('truncate flex gap-2 text-start flex-1 text-zinc-700')
        ->add('[[disabled]_&]:text-zinc-500 dark:text-zinc-300 dark:[[disabled]_&]:text-zinc-400');
?>

<ui-selected x-ignore wire:ignore <?php echo e($attributes->class($classes)); ?>>
    <template name="placeholder">
        <span class="text-zinc-400 [[disabled]_&]:text-zinc-400/70 dark:text-zinc-400 dark:[[disabled]_&]:text-zinc-500" data-flux-select-placeholder>
            <?php echo e($placeholder); ?>

        </span>
    </template>

    <template name="overflow" max="<?php echo e($max ?? 1); ?>" >
        <div><slot name="count"></slot> <?php echo e($suffix ?? __('selected')); ?></div>
    </template>
</ui-selected>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\src/../stubs/resources/views/flux/select/selected.blade.php ENDPATH**/ ?>