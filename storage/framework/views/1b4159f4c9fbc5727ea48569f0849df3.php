<?php foreach (([ 'disabled', 'variant' ]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'disabled' => null,
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
    'disabled' => null,
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
$classes = Flux::classes()
    ->add('group/accordion-heading flex items-center w-full')
    ->add('text-start text-sm font-medium')
    ->add(match ($variant) {
        default => 'justify-between [&>svg]:ms-6',
        'reverse' => 'flex-row-reverse justify-end [&>svg]:me-2',
    })
    ->add($disabled
        ? 'text-zinc-400 dark:text-zinc-400 cursor-default'
        : 'text-zinc-800 dark:text-white cursor-pointer'
    )
    ;
?>

<button type="button" <?php echo e($attributes->class($classes)); ?> <?php if($disabled): ?> disabled <?php endif; ?> data-flux-accordion-heading>
    <span class="flex-1"><?php echo e($slot); ?></span>

    <?php if ($variant === 'reverse'): ?>
        <?php if (isset($component)) { $__componentOriginal55515d2b9797b35ae664633ea084b48d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55515d2b9797b35ae664633ea084b48d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::accordion.icon','data' => ['pointing' => 'down','class' => 'hidden group-data-open/accordion-heading:block text-zinc-800! dark:text-white!']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::accordion.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pointing' => 'down','class' => 'hidden group-data-open/accordion-heading:block text-zinc-800! dark:text-white!']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55515d2b9797b35ae664633ea084b48d)): ?>
<?php $attributes = $__attributesOriginal55515d2b9797b35ae664633ea084b48d; ?>
<?php unset($__attributesOriginal55515d2b9797b35ae664633ea084b48d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55515d2b9797b35ae664633ea084b48d)): ?>
<?php $component = $__componentOriginal55515d2b9797b35ae664633ea084b48d; ?>
<?php unset($__componentOriginal55515d2b9797b35ae664633ea084b48d); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal55515d2b9797b35ae664633ea084b48d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55515d2b9797b35ae664633ea084b48d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::accordion.icon','data' => ['pointing' => 'right','class' => 'block group-data-open/accordion-heading:hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::accordion.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pointing' => 'right','class' => 'block group-data-open/accordion-heading:hidden']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55515d2b9797b35ae664633ea084b48d)): ?>
<?php $attributes = $__attributesOriginal55515d2b9797b35ae664633ea084b48d; ?>
<?php unset($__attributesOriginal55515d2b9797b35ae664633ea084b48d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55515d2b9797b35ae664633ea084b48d)): ?>
<?php $component = $__componentOriginal55515d2b9797b35ae664633ea084b48d; ?>
<?php unset($__componentOriginal55515d2b9797b35ae664633ea084b48d); ?>
<?php endif; ?>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal55515d2b9797b35ae664633ea084b48d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55515d2b9797b35ae664633ea084b48d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::accordion.icon','data' => ['pointing' => 'up','class' => 'hidden group-data-open/accordion-heading:block text-zinc-800! dark:text-white!']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::accordion.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pointing' => 'up','class' => 'hidden group-data-open/accordion-heading:block text-zinc-800! dark:text-white!']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55515d2b9797b35ae664633ea084b48d)): ?>
<?php $attributes = $__attributesOriginal55515d2b9797b35ae664633ea084b48d; ?>
<?php unset($__attributesOriginal55515d2b9797b35ae664633ea084b48d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55515d2b9797b35ae664633ea084b48d)): ?>
<?php $component = $__componentOriginal55515d2b9797b35ae664633ea084b48d; ?>
<?php unset($__componentOriginal55515d2b9797b35ae664633ea084b48d); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal55515d2b9797b35ae664633ea084b48d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55515d2b9797b35ae664633ea084b48d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::accordion.icon','data' => ['pointing' => 'down','class' => 'block group-data-open/accordion-heading:hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::accordion.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pointing' => 'down','class' => 'block group-data-open/accordion-heading:hidden']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55515d2b9797b35ae664633ea084b48d)): ?>
<?php $attributes = $__attributesOriginal55515d2b9797b35ae664633ea084b48d; ?>
<?php unset($__attributesOriginal55515d2b9797b35ae664633ea084b48d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55515d2b9797b35ae664633ea084b48d)): ?>
<?php $component = $__componentOriginal55515d2b9797b35ae664633ea084b48d; ?>
<?php unset($__componentOriginal55515d2b9797b35ae664633ea084b48d); ?>
<?php endif; ?>
    <?php endif; ?>
</button>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\accordion\heading.blade.php ENDPATH**/ ?>