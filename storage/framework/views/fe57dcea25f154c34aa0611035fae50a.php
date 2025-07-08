<?php if (isset($component)) { $__componentOriginalc4cbba45ed073bedf6d5fbbd59b58e48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc4cbba45ed073bedf6d5fbbd59b58e48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::navbar.item','data' => ['badge' => $unreadCount,'badgeColor' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::navbar.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadCount),'badge-color' => 'green']); ?>
        <?php if (isset($component)) { $__componentOriginal2357204bbfb73ef228c684f3b7e8f9fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2357204bbfb73ef228c684f3b7e8f9fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.bell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.bell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2357204bbfb73ef228c684f3b7e8f9fa)): ?>
<?php $attributes = $__attributesOriginal2357204bbfb73ef228c684f3b7e8f9fa; ?>
<?php unset($__attributesOriginal2357204bbfb73ef228c684f3b7e8f9fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2357204bbfb73ef228c684f3b7e8f9fa)): ?>
<?php $component = $__componentOriginal2357204bbfb73ef228c684f3b7e8f9fa; ?>
<?php unset($__componentOriginal2357204bbfb73ef228c684f3b7e8f9fa); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc4cbba45ed073bedf6d5fbbd59b58e48)): ?>
<?php $attributes = $__attributesOriginalc4cbba45ed073bedf6d5fbbd59b58e48; ?>
<?php unset($__attributesOriginalc4cbba45ed073bedf6d5fbbd59b58e48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc4cbba45ed073bedf6d5fbbd59b58e48)): ?>
<?php $component = $__componentOriginalc4cbba45ed073bedf6d5fbbd59b58e48; ?>
<?php unset($__componentOriginalc4cbba45ed073bedf6d5fbbd59b58e48); ?>
<?php endif; ?><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\components\notifications\dropdown\button.blade.php ENDPATH**/ ?>