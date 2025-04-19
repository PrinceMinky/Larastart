<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'selectedSuffix' => null,
    'placeholder' => null,
    'searchable' => null,
    'clearable' => null,
    'invalid' => null,
    'button' => null, // Deprecated...
    'trigger' => null,
    'search' => null, // Slot forwarding...
    'empty' => null, // Slot forwarding...
    'clear' => null,
    'close' => null,
    'size' => null,
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
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'selectedSuffix' => null,
    'placeholder' => null,
    'searchable' => null,
    'clearable' => null,
    'invalid' => null,
    'button' => null, // Deprecated...
    'trigger' => null,
    'search' => null, // Slot forwarding...
    'empty' => null, // Slot forwarding...
    'clear' => null,
    'close' => null,
    'size' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
$invalid ??= ($name && $errors->has($name));

$class= Flux::classes()
    ->add('w-full')
    // The below reverts styles added by Tailwind Forms plugin
    ->add('border-0 p-0 bg-transparent')
    ;

$trigger ??= $button;
?>

<ui-select
    clear="<?php echo e($clear ?? 'close esc select'); ?>"
    <?php if($close): ?> close="<?php echo e($close); ?>" <?php endif; ?>
    <?php echo e($attributes->class($class)->merge(['filter' => true])); ?>

    data-flux-control
    data-flux-select
>
    <?php if ($trigger): ?> <?php echo e($trigger); ?> <?php else: ?>
        <?php if (isset($component)) { $__componentOriginala270d528cd807f4937778c00a4d06f2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala270d528cd807f4937778c00a4d06f2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.button','data' => ['placeholder' => $placeholder,'invalid' => $invalid,'size' => $size,'clearable' => $clearable,'suffix' => $selectedSuffix]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($placeholder),'invalid' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($invalid),'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($size),'clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($clearable),'suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedSuffix)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala270d528cd807f4937778c00a4d06f2f)): ?>
<?php $attributes = $__attributesOriginala270d528cd807f4937778c00a4d06f2f; ?>
<?php unset($__attributesOriginala270d528cd807f4937778c00a4d06f2f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala270d528cd807f4937778c00a4d06f2f)): ?>
<?php $component = $__componentOriginala270d528cd807f4937778c00a4d06f2f; ?>
<?php unset($__componentOriginala270d528cd807f4937778c00a4d06f2f); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal7813a4341689867c6f488cb21095c2df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7813a4341689867c6f488cb21095c2df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.options','data' => ['search' => $search,'searchable' => $searchable,'empty' => $empty]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.options'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['search' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($search),'searchable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchable),'empty' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($empty)]); ?>
        <?php echo e($slot); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7813a4341689867c6f488cb21095c2df)): ?>
<?php $attributes = $__attributesOriginal7813a4341689867c6f488cb21095c2df; ?>
<?php unset($__attributesOriginal7813a4341689867c6f488cb21095c2df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7813a4341689867c6f488cb21095c2df)): ?>
<?php $component = $__componentOriginal7813a4341689867c6f488cb21095c2df; ?>
<?php unset($__componentOriginal7813a4341689867c6f488cb21095c2df); ?>
<?php endif; ?>
</ui-select>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\src/../stubs/resources/views/flux/select/variants/listbox.blade.php ENDPATH**/ ?>