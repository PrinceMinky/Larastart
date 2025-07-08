<ui-select autocomplete clear="esc" data-flux-autocomplete <?php echo e($attributes->only('filter')->merge(['filter' => true])); ?>>
    <?php if (isset($component)) { $__componentOriginal26c546557cdc09040c8dd00b2090afd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26c546557cdc09040c8dd00b2090afd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::input.index','data' => ['attributes' => $attributes->except('filter')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->except('filter'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal26c546557cdc09040c8dd00b2090afd0)): ?>
<?php $attributes = $__attributesOriginal26c546557cdc09040c8dd00b2090afd0; ?>
<?php unset($__attributesOriginal26c546557cdc09040c8dd00b2090afd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal26c546557cdc09040c8dd00b2090afd0)): ?>
<?php $component = $__componentOriginal26c546557cdc09040c8dd00b2090afd0; ?>
<?php unset($__componentOriginal26c546557cdc09040c8dd00b2090afd0); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal859ee58fe485b3e6a24806d339316bc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal859ee58fe485b3e6a24806d339316bc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::autocomplete.items','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::autocomplete.items'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php echo e($slot); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal859ee58fe485b3e6a24806d339316bc0)): ?>
<?php $attributes = $__attributesOriginal859ee58fe485b3e6a24806d339316bc0; ?>
<?php unset($__attributesOriginal859ee58fe485b3e6a24806d339316bc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal859ee58fe485b3e6a24806d339316bc0)): ?>
<?php $component = $__componentOriginal859ee58fe485b3e6a24806d339316bc0; ?>
<?php unset($__componentOriginal859ee58fe485b3e6a24806d339316bc0); ?>
<?php endif; ?>
</ui-select>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\src/../stubs/resources/views/flux/autocomplete/index.blade.php ENDPATH**/ ?>