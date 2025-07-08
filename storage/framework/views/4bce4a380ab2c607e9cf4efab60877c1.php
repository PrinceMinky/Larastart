<?php if (isset($component)) { $__componentOriginalc4bce27d2c09d2f98a63d67977c1c3ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc4bce27d2c09d2f98a63d67977c1c3ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::card.index','data' => ['key' => $request->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($request->id)]); ?>
    <div class="flex items-center justify-between gap-2">
        <?php if (isset($component)) { $__componentOriginalc33e50d4bc1d42821fb10b5db6a0ce92 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc33e50d4bc1d42821fb10b5db6a0ce92 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.follow-requests.user-info','data' => ['request' => $request]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('follow-requests.user-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['request' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($request)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc33e50d4bc1d42821fb10b5db6a0ce92)): ?>
<?php $attributes = $__attributesOriginalc33e50d4bc1d42821fb10b5db6a0ce92; ?>
<?php unset($__attributesOriginalc33e50d4bc1d42821fb10b5db6a0ce92); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc33e50d4bc1d42821fb10b5db6a0ce92)): ?>
<?php $component = $__componentOriginalc33e50d4bc1d42821fb10b5db6a0ce92; ?>
<?php unset($__componentOriginalc33e50d4bc1d42821fb10b5db6a0ce92); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalbfd48098a87aed520c7514ad0b82d2a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfd48098a87aed520c7514ad0b82d2a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.follow-requests.actions','data' => ['request' => $request]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('follow-requests.actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['request' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($request)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfd48098a87aed520c7514ad0b82d2a0)): ?>
<?php $attributes = $__attributesOriginalbfd48098a87aed520c7514ad0b82d2a0; ?>
<?php unset($__attributesOriginalbfd48098a87aed520c7514ad0b82d2a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfd48098a87aed520c7514ad0b82d2a0)): ?>
<?php $component = $__componentOriginalbfd48098a87aed520c7514ad0b82d2a0; ?>
<?php unset($__componentOriginalbfd48098a87aed520c7514ad0b82d2a0); ?>
<?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc4bce27d2c09d2f98a63d67977c1c3ec)): ?>
<?php $attributes = $__attributesOriginalc4bce27d2c09d2f98a63d67977c1c3ec; ?>
<?php unset($__attributesOriginalc4bce27d2c09d2f98a63d67977c1c3ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc4bce27d2c09d2f98a63d67977c1c3ec)): ?>
<?php $component = $__componentOriginalc4bce27d2c09d2f98a63d67977c1c3ec; ?>
<?php unset($__componentOriginalc4bce27d2c09d2f98a63d67977c1c3ec); ?>
<?php endif; ?><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\components\follow-requests\row.blade.php ENDPATH**/ ?>