<?php foreach (([ 'indicator' ]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'filterable' => null,
    'indicator' => null,
    'loading' => null,
    'value' => null,
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
    'filterable' => null,
    'indicator' => null,
    'loading' => null,
    'value' => null,
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
    ->add('group/option overflow-hidden data-hidden:hidden group flex items-center px-2 py-1.5 w-full focus:outline-hidden')
    ->add('rounded-md')
    ->add('text-start text-sm font-medium')
    ->add('text-zinc-800 data-active:bg-zinc-100 [&[disabled]]:text-zinc-400 dark:text-white dark:data-active:bg-zinc-600 dark:[&[disabled]]:text-zinc-400')
    ;

$livewireAction = $attributes->whereStartsWith('wire:click')->isNotEmpty();
$alpineAction = $attributes->whereStartsWith('x-on:click')->isNotEmpty();

$loading ??= $loading ?? $livewireAction;

if ($loading) {
    $attributes = $attributes->merge(['wire:loading.attr' => 'data-flux-loading']);
}
?>

<ui-option
    <?php if($value !== null): ?> value="<?php echo e($value); ?>" <?php endif; ?>
    <?php if($value): ?> wire:key="<?php echo e($value); ?>" <?php endif; ?>
    <?php if($filterable === false): ?> filter="manual" <?php endif; ?>
    <?php if($livewireAction || $alpineAction): ?> action <?php endif; ?>
    <?php echo e($attributes->class($classes)); ?>

    data-flux-option
>
    <div class="w-6 shrink-0 [ui-selected_&]:hidden">
        <?php if (isset($component)) { $__componentOriginale1feb3c76345e617b84464390c54cc1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale1feb3c76345e617b84464390c54cc1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.indicator.index','data' => ['variant' => $indicator]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($indicator)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale1feb3c76345e617b84464390c54cc1f)): ?>
<?php $attributes = $__attributesOriginale1feb3c76345e617b84464390c54cc1f; ?>
<?php unset($__attributesOriginale1feb3c76345e617b84464390c54cc1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale1feb3c76345e617b84464390c54cc1f)): ?>
<?php $component = $__componentOriginale1feb3c76345e617b84464390c54cc1f; ?>
<?php unset($__componentOriginale1feb3c76345e617b84464390c54cc1f); ?>
<?php endif; ?>
    </div>

    <?php echo e($slot); ?>


    <?php if ($loading): ?>
        <?php if (isset($component)) { $__componentOriginalb06f0c5905a9427a630c5e299af7ce46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb06f0c5905a9427a630c5e299af7ce46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.loading','data' => ['class' => 'hidden [[data-flux-loading]>&]:block ms-auto text-zinc-400 [[data-flux-menu-item]:hover_&]:text-current','variant' => 'micro']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'hidden [[data-flux-loading]>&]:block ms-auto text-zinc-400 [[data-flux-menu-item]:hover_&]:text-current','variant' => 'micro']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb06f0c5905a9427a630c5e299af7ce46)): ?>
<?php $attributes = $__attributesOriginalb06f0c5905a9427a630c5e299af7ce46; ?>
<?php unset($__attributesOriginalb06f0c5905a9427a630c5e299af7ce46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb06f0c5905a9427a630c5e299af7ce46)): ?>
<?php $component = $__componentOriginalb06f0c5905a9427a630c5e299af7ce46; ?>
<?php unset($__componentOriginalb06f0c5905a9427a630c5e299af7ce46); ?>
<?php endif; ?>
    <?php endif; ?>
</ui-option>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\src/../stubs/resources/views/flux/select/option/variants/custom.blade.php ENDPATH**/ ?>