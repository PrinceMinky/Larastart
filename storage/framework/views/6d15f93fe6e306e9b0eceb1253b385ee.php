<?php foreach (([ 'variant' ]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variant' => 'check',
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
    'variant' => 'check',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
// This prevents variants picked up by `@aware()` from other wrapping components like flux::modal from being used here...
$variant = $variant !== 'check' && Flux::componentExists('select.indicator.variants.' . $variant)
    ? $variant
    : 'check';
?>

<?php if (!Flux::componentExists($name = 'select.indicator.variants.' . $variant)) throw new \Exception("Flux component [{$name}] does not exist."); ?><?php if (isset($component)) { $__componentOriginal489a17c12877464739da6b05d8b3a307 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal489a17c12877464739da6b05d8b3a307 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve([
    'view' => (app()->version() >= 12 ? hash('xxh128', 'flux') : md5('flux')) . '::' . 'select.indicator.variants.' . $variant,
    'data' => $__env->getCurrentComponentData(),
] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::' . 'select.indicator.variants.' . $variant); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes($attributes->getAttributes()); ?><?php echo e($slot); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal489a17c12877464739da6b05d8b3a307)): ?>
<?php $attributes = $__attributesOriginal489a17c12877464739da6b05d8b3a307; ?>
<?php unset($__attributesOriginal489a17c12877464739da6b05d8b3a307); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal489a17c12877464739da6b05d8b3a307)): ?>
<?php $component = $__componentOriginal489a17c12877464739da6b05d8b3a307; ?>
<?php unset($__componentOriginal489a17c12877464739da6b05d8b3a307); ?>
<?php endif; ?>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\select\indicator\index.blade.php ENDPATH**/ ?>