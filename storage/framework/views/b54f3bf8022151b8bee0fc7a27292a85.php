<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['key' => null, 'handle' => null]));

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

foreach (array_filter((['key' => null, 'handle' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div <?php echo e($attributes); ?> x-sort:item="<?php echo e($key); ?>" wire:key="<?php echo e($key); ?>">
    <?php if($handle): ?>
        <div class="flex gap-1">
            <?php if (isset($component)) { $__componentOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort.handle','data' => ['icon' => ''.e($handle).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort.handle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => ''.e($handle).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42)): ?>
<?php $attributes = $__attributesOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42; ?>
<?php unset($__attributesOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42)): ?>
<?php $component = $__componentOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42; ?>
<?php unset($__componentOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42); ?>
<?php endif; ?>

            <?php echo e($slot); ?>

        </div>
    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
</div><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\components\sort\item.blade.php ENDPATH**/ ?>