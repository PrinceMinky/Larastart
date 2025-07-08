<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'items' => null,
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
    'items' => null,
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
    ->add('block overflow-x-auto border-b border-zinc-200 dark:border-white/10 bg-zinc-50 rounded-t-[calc(0.5rem-1px)] w-full')
    ->add('dark:bg-white/[6%]')
    ->add('dark:border-white/5')
;
?>

<ui-toolbar <?php echo e($attributes->class($classes)); ?> wire:ignore aria-label="<?php echo e(__('Formatting')); ?>">
    <div class="h-10 p-2 flex gap-2 items-center">
        <?php if ($slot->isNotEmpty()): ?>
            <?php echo e($slot); ?>

        <?php else: ?>
            <?php if ($items !== null): ?>
                <?php foreach (str($items)->explode(' ') as $item): ?>
                    <?php if ($item === '|') $item = 'separator'; ?>
                    <?php if ($item === '~') $item = 'spacer'; ?>
                    <?php if (!Flux::componentExists($name = 'editor.' . $item)) throw new \Exception("Flux component [{$name}] does not exist."); ?><?php if (isset($component)) { $__componentOriginal30b5bb0cb11def64cb1082268387ac9f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30b5bb0cb11def64cb1082268387ac9f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve([
    'view' => (app()->version() >= 12 ? hash('xxh128', 'flux') : md5('flux')) . '::' . 'editor.' . $item,
    'data' => $__env->getCurrentComponentData(),
] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::' . 'editor.' . $item); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes($attributes->getAttributes()); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30b5bb0cb11def64cb1082268387ac9f)): ?>
<?php $attributes = $__attributesOriginal30b5bb0cb11def64cb1082268387ac9f; ?>
<?php unset($__attributesOriginal30b5bb0cb11def64cb1082268387ac9f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30b5bb0cb11def64cb1082268387ac9f)): ?>
<?php $component = $__componentOriginal30b5bb0cb11def64cb1082268387ac9f; ?>
<?php unset($__componentOriginal30b5bb0cb11def64cb1082268387ac9f); ?>
<?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginalb3020fc53d721e68043f7e74aedfbcda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb3020fc53d721e68043f7e74aedfbcda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb3020fc53d721e68043f7e74aedfbcda)): ?>
<?php $attributes = $__attributesOriginalb3020fc53d721e68043f7e74aedfbcda; ?>
<?php unset($__attributesOriginalb3020fc53d721e68043f7e74aedfbcda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb3020fc53d721e68043f7e74aedfbcda)): ?>
<?php $component = $__componentOriginalb3020fc53d721e68043f7e74aedfbcda; ?>
<?php unset($__componentOriginalb3020fc53d721e68043f7e74aedfbcda); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.separator','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.separator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4)): ?>
<?php $attributes = $__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4; ?>
<?php unset($__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4)): ?>
<?php $component = $__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4; ?>
<?php unset($__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc89b1aa3fd770c4db1743912e69577f2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc89b1aa3fd770c4db1743912e69577f2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.bold','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.bold'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc89b1aa3fd770c4db1743912e69577f2)): ?>
<?php $attributes = $__attributesOriginalc89b1aa3fd770c4db1743912e69577f2; ?>
<?php unset($__attributesOriginalc89b1aa3fd770c4db1743912e69577f2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc89b1aa3fd770c4db1743912e69577f2)): ?>
<?php $component = $__componentOriginalc89b1aa3fd770c4db1743912e69577f2; ?>
<?php unset($__componentOriginalc89b1aa3fd770c4db1743912e69577f2); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal717262a791a778fae7795a2b2b33e702 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal717262a791a778fae7795a2b2b33e702 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.italic','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.italic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal717262a791a778fae7795a2b2b33e702)): ?>
<?php $attributes = $__attributesOriginal717262a791a778fae7795a2b2b33e702; ?>
<?php unset($__attributesOriginal717262a791a778fae7795a2b2b33e702); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal717262a791a778fae7795a2b2b33e702)): ?>
<?php $component = $__componentOriginal717262a791a778fae7795a2b2b33e702; ?>
<?php unset($__componentOriginal717262a791a778fae7795a2b2b33e702); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal3361c60de558751e042b10a9d95ef1a6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3361c60de558751e042b10a9d95ef1a6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.strike','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.strike'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3361c60de558751e042b10a9d95ef1a6)): ?>
<?php $attributes = $__attributesOriginal3361c60de558751e042b10a9d95ef1a6; ?>
<?php unset($__attributesOriginal3361c60de558751e042b10a9d95ef1a6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3361c60de558751e042b10a9d95ef1a6)): ?>
<?php $component = $__componentOriginal3361c60de558751e042b10a9d95ef1a6; ?>
<?php unset($__componentOriginal3361c60de558751e042b10a9d95ef1a6); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.separator','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.separator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4)): ?>
<?php $attributes = $__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4; ?>
<?php unset($__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4)): ?>
<?php $component = $__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4; ?>
<?php unset($__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc4038b5fc7f75517349265bf20371867 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc4038b5fc7f75517349265bf20371867 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.bullet','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.bullet'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc4038b5fc7f75517349265bf20371867)): ?>
<?php $attributes = $__attributesOriginalc4038b5fc7f75517349265bf20371867; ?>
<?php unset($__attributesOriginalc4038b5fc7f75517349265bf20371867); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc4038b5fc7f75517349265bf20371867)): ?>
<?php $component = $__componentOriginalc4038b5fc7f75517349265bf20371867; ?>
<?php unset($__componentOriginalc4038b5fc7f75517349265bf20371867); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginald07cce6d0687c074cf7f7997b4a83ef8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald07cce6d0687c074cf7f7997b4a83ef8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.ordered','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.ordered'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald07cce6d0687c074cf7f7997b4a83ef8)): ?>
<?php $attributes = $__attributesOriginald07cce6d0687c074cf7f7997b4a83ef8; ?>
<?php unset($__attributesOriginald07cce6d0687c074cf7f7997b4a83ef8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald07cce6d0687c074cf7f7997b4a83ef8)): ?>
<?php $component = $__componentOriginald07cce6d0687c074cf7f7997b4a83ef8; ?>
<?php unset($__componentOriginald07cce6d0687c074cf7f7997b4a83ef8); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal246ecd1b3cce44351dfe3a6751f67bc8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal246ecd1b3cce44351dfe3a6751f67bc8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.blockquote','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.blockquote'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal246ecd1b3cce44351dfe3a6751f67bc8)): ?>
<?php $attributes = $__attributesOriginal246ecd1b3cce44351dfe3a6751f67bc8; ?>
<?php unset($__attributesOriginal246ecd1b3cce44351dfe3a6751f67bc8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal246ecd1b3cce44351dfe3a6751f67bc8)): ?>
<?php $component = $__componentOriginal246ecd1b3cce44351dfe3a6751f67bc8; ?>
<?php unset($__componentOriginal246ecd1b3cce44351dfe3a6751f67bc8); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.separator','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.separator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4)): ?>
<?php $attributes = $__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4; ?>
<?php unset($__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4)): ?>
<?php $component = $__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4; ?>
<?php unset($__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal2165c83f34fbba06c7c0eb1c393a5540 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2165c83f34fbba06c7c0eb1c393a5540 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.link','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2165c83f34fbba06c7c0eb1c393a5540)): ?>
<?php $attributes = $__attributesOriginal2165c83f34fbba06c7c0eb1c393a5540; ?>
<?php unset($__attributesOriginal2165c83f34fbba06c7c0eb1c393a5540); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2165c83f34fbba06c7c0eb1c393a5540)): ?>
<?php $component = $__componentOriginal2165c83f34fbba06c7c0eb1c393a5540; ?>
<?php unset($__componentOriginal2165c83f34fbba06c7c0eb1c393a5540); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.separator','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.separator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4)): ?>
<?php $attributes = $__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4; ?>
<?php unset($__attributesOriginalf0aa19853d70afa91a56d59eb48f6ff4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4)): ?>
<?php $component = $__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4; ?>
<?php unset($__componentOriginalf0aa19853d70afa91a56d59eb48f6ff4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal0e9e77d34a47e2bbfffbe6a49a749999 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9e77d34a47e2bbfffbe6a49a749999 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.align','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.align'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e9e77d34a47e2bbfffbe6a49a749999)): ?>
<?php $attributes = $__attributesOriginal0e9e77d34a47e2bbfffbe6a49a749999; ?>
<?php unset($__attributesOriginal0e9e77d34a47e2bbfffbe6a49a749999); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e9e77d34a47e2bbfffbe6a49a749999)): ?>
<?php $component = $__componentOriginal0e9e77d34a47e2bbfffbe6a49a749999; ?>
<?php unset($__componentOriginal0e9e77d34a47e2bbfffbe6a49a749999); ?>
<?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</ui-toolbar>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\editor\toolbar.blade.php ENDPATH**/ ?>