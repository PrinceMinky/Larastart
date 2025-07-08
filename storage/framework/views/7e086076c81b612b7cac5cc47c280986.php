<?php $iconTrailing = $iconTrailing ??= $attributes->pluck('icon:trailing'); ?>
<?php $iconVariant = $iconVariant ??= $attributes->pluck('icon:variant'); ?>

<?php foreach (([ 'variant', 'size' ]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'iconTrailing' => null,
    'iconVariant' => null, // This is null as the default is set below depending on the tab variant...
    'variant' => null,
    'accent' => true,
    'name' => null,
    'icon' => null,
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
    'iconTrailing' => null,
    'iconVariant' => null, // This is null as the default is set below depending on the tab variant...
    'variant' => null,
    'accent' => true,
    'name' => null,
    'icon' => null,
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
if ($variant === 'pills') {
    $classes = Flux::classes()
        ->add('flex whitespace-nowrap gap-2 items-center px-3 rounded-full text-sm font-medium')
        ->add('bg-zinc-800/5 dark:bg-white/5 hover:bg-zinc-800/10 dark:hover:bg-white/10 text-zinc-600 hover:text-zinc-800 dark:text-white/70 dark:hover:text-white')
        ->add(match ($accent) {
            true => 'data-selected:bg-(--color-accent) hover:data-selected:bg-(--color-accent)',
            false => 'data-selected:bg-zinc-800 dark:data-selected:bg-white',
        })
        ->add(match ($accent) {
            true => 'data-selected:text-(--color-accent-foreground) hover:data-selected:text-(--color-accent-foreground)',
            false => 'data-selected:text-white dark:data-selected:text-zinc-800',
        })
        ->add('[&[disabled]]:opacity-50 dark:[&[disabled]]:opacity-75 [&[disabled]]:cursor-default [&[disabled]]:pointer-events-none')
        ;

    $iconClasses = Flux::classes('size-5');
    $iconVariant ??= 'outline';
} elseif ($variant === 'segmented') {
    $classes = Flux::classes()
        ->add('flex whitespace-nowrap flex-1 justify-center items-center gap-2')
        ->add('rounded-md data-selected:shadow-xs')
        ->add('text-sm font-medium text-zinc-600 hover:text-zinc-800 dark:hover:text-white dark:text-white/70 data-selected:text-zinc-800 dark:data-selected:text-white')
        ->add('data-selected:bg-white dark:data-selected:bg-white/20')
        ->add('[&[disabled]]:opacity-50 dark:[&[disabled]]:opacity-75 [&[disabled]]:cursor-default [&[disabled]]:pointer-events-none')
        ->add(match ($size) {
            'sm' => 'px-3 text-sm',
            default => 'px-4',
        })
        ;

    $iconClasses = Flux::classes('size-5 text-zinc-500 dark:text-zinc-400 [[data-flux-tab][data-selected]_&]:text-zinc-800 dark:[[data-flux-tab][data-selected]_&]:text-white');
    $iconVariant ??= 'mini';
} else {
    $classes = Flux::classes()
        ->add('flex whitespace-nowrap gap-2 items-center px-2')
        ->add('-mb-px') // We want the "selected" tab's bottom border to overlap the tab group's bottom border...
        ->add('border-b-[2px] border-transparent')
        ->add('text-sm font-medium text-zinc-400 dark:text-white/50')
        ->add(match($accent) {
            true => 'data-selected:border-(--color-accent-content) data-selected:text-(--color-accent-content) hover:data-selected:text-(--color-accent-content) hover:text-zinc-800 dark:hover:text-white',
            false => 'data-selected:border-zinc-800 data-selected:text-zinc-800 dark:data-selected:border-white dark:data-selected:text-white hover:text-zinc-800 dark:hover:text-white',
        })
        ->add('[&[disabled]]:opacity-50 dark:[&[disabled]]:opacity-75 [&[disabled]]:cursor-default [&[disabled]]:pointer-events-none')
        ;

    $iconClasses = Flux::classes('size-5');
    $iconVariant ??= 'outline';
}

if ($name) {
    $attributes = $attributes->merge([
        'name' => $name,
        'wire:key' => $name,
    ]);
}
?>

<?php if (isset($component)) { $__componentOriginal41290c80ee95fab383f81660ba8bf860 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41290c80ee95fab383f81660ba8bf860 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button-or-link','data' => ['attributes' => $attributes->class($classes),'dataFluxTab' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button-or-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->class($classes)),'data-flux-tab' => true]); ?>
    <?php if (is_string($icon) && $icon !== ''): ?>
        <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['icon' => $icon,'variant' => $iconVariant,'class' => ''.$iconClasses.'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconVariant),'class' => ''.$iconClasses.'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
    <?php elseif ($icon): ?>
        <?php echo e($icon); ?>

    <?php endif; ?>

    <?php echo e($slot); ?>


    <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
        <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['icon' => $iconTrailing,'variant' => 'micro']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconTrailing),'variant' => 'micro']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
    <?php elseif ($iconTrailing): ?>
        <?php echo e($iconTrailing); ?>

    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41290c80ee95fab383f81660ba8bf860)): ?>
<?php $attributes = $__attributesOriginal41290c80ee95fab383f81660ba8bf860; ?>
<?php unset($__attributesOriginal41290c80ee95fab383f81660ba8bf860); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41290c80ee95fab383f81660ba8bf860)): ?>
<?php $component = $__componentOriginal41290c80ee95fab383f81660ba8bf860; ?>
<?php unset($__componentOriginal41290c80ee95fab383f81660ba8bf860); ?>
<?php endif; ?>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\tab\index.blade.php ENDPATH**/ ?>