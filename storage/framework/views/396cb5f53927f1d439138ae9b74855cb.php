<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'toolbar' => null,
    'invalid' => null,
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
    'toolbar' => null,
    'invalid' => null,
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

$classes = Flux::classes()
    ->add('block w-full')
    ->add('shadow-xs [&[disabled]]:shadow-none border rounded-lg')
    ->add('bg-white dark:bg-white/10 dark:[&[disabled]]:bg-white/[7%]')
    ->add('**:data-[slot=content]:text-base! sm:**:data-[slot=content]:text-sm!')
    ->add('**:data-[slot=content]:text-zinc-700 dark:**:data-[slot=content]:text-zinc-300')
    ->add('[&[disabled]_[data-slot=content]]:text-zinc-500 dark:[&[disabled]_[data-slot=content]]:text-zinc-400')
    ->add($invalid ? 'border-red-500' : 'border-zinc-200 border-b-zinc-300/80 dark:border-white/10')
    ;
?>

<?php if (isset($component)) { $__componentOriginal33e2911d6f1e72999cb4ebd3c5d00431 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal33e2911d6f1e72999cb4ebd3c5d00431 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::with-field','data' => ['attributes' => $attributes]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::with-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>
    <ui-editor <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> aria-label="<?php echo e(__('Rich text editor')); ?>" data-flux-control data-flux-editor>
        <?php if ($slot->isEmpty()): ?>
            <?php if (isset($component)) { $__componentOriginalc73f093bfb6ea4af3cc83f29a80ce2f0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc73f093bfb6ea4af3cc83f29a80ce2f0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.toolbar','data' => ['items' => $toolbar]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($toolbar)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc73f093bfb6ea4af3cc83f29a80ce2f0)): ?>
<?php $attributes = $__attributesOriginalc73f093bfb6ea4af3cc83f29a80ce2f0; ?>
<?php unset($__attributesOriginalc73f093bfb6ea4af3cc83f29a80ce2f0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc73f093bfb6ea4af3cc83f29a80ce2f0)): ?>
<?php $component = $__componentOriginalc73f093bfb6ea4af3cc83f29a80ce2f0; ?>
<?php unset($__componentOriginalc73f093bfb6ea4af3cc83f29a80ce2f0); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc1864f977a34044eec4c6cf6e917211a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1864f977a34044eec4c6cf6e917211a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.content','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc1864f977a34044eec4c6cf6e917211a)): ?>
<?php $attributes = $__attributesOriginalc1864f977a34044eec4c6cf6e917211a; ?>
<?php unset($__attributesOriginalc1864f977a34044eec4c6cf6e917211a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc1864f977a34044eec4c6cf6e917211a)): ?>
<?php $component = $__componentOriginalc1864f977a34044eec4c6cf6e917211a; ?>
<?php unset($__componentOriginalc1864f977a34044eec4c6cf6e917211a); ?>
<?php endif; ?>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </ui-editor>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal33e2911d6f1e72999cb4ebd3c5d00431)): ?>
<?php $attributes = $__attributesOriginal33e2911d6f1e72999cb4ebd3c5d00431; ?>
<?php unset($__attributesOriginal33e2911d6f1e72999cb4ebd3c5d00431); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal33e2911d6f1e72999cb4ebd3c5d00431)): ?>
<?php $component = $__componentOriginal33e2911d6f1e72999cb4ebd3c5d00431; ?>
<?php unset($__componentOriginal33e2911d6f1e72999cb4ebd3c5d00431); ?>
<?php endif; ?>

    <?php
        $__assetKey = '3447330347-0';

        ob_start();
    ?>
<?php if (isset($component)) { $__componentOriginal08076212bc4e61c27be4bf0ae753a7ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal08076212bc4e61c27be4bf0ae753a7ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.scripts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal08076212bc4e61c27be4bf0ae753a7ee)): ?>
<?php $attributes = $__attributesOriginal08076212bc4e61c27be4bf0ae753a7ee; ?>
<?php unset($__attributesOriginal08076212bc4e61c27be4bf0ae753a7ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal08076212bc4e61c27be4bf0ae753a7ee)): ?>
<?php $component = $__componentOriginal08076212bc4e61c27be4bf0ae753a7ee; ?>
<?php unset($__componentOriginal08076212bc4e61c27be4bf0ae753a7ee); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalb65a7bfca08c3e76369573ab6caa2ad7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb65a7bfca08c3e76369573ab6caa2ad7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::editor.styles','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::editor.styles'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb65a7bfca08c3e76369573ab6caa2ad7)): ?>
<?php $attributes = $__attributesOriginalb65a7bfca08c3e76369573ab6caa2ad7; ?>
<?php unset($__attributesOriginalb65a7bfca08c3e76369573ab6caa2ad7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb65a7bfca08c3e76369573ab6caa2ad7)): ?>
<?php $component = $__componentOriginalb65a7bfca08c3e76369573ab6caa2ad7; ?>
<?php unset($__componentOriginalb65a7bfca08c3e76369573ab6caa2ad7); ?>
<?php endif; ?>
    <?php
        $__output = ob_get_clean();

        // If the asset has already been loaded anywhere during this request, skip it...
        if (in_array($__assetKey, \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$alreadyRunAssetKeys)) {
            // Skip it...
        } else {
            \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$alreadyRunAssetKeys[] = $__assetKey;

            // Check if we're in a Livewire component or not and store the asset accordingly...
            if (isset($this)) {
                \Livewire\store($this)->push('assets', $__output, $__assetKey);
            } else {
                \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$nonLivewireAssets[$__assetKey] = $__output;
            }
        }
    ?>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\editor\index.blade.php ENDPATH**/ ?>