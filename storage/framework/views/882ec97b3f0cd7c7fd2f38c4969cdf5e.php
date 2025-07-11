<div class="space-y-4">
    <div class="flex flex-col space-y-2">
        <?php if (isset($component)) { $__componentOriginal8583f620cdac2cafe0f63a2c1bd2101f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8583f620cdac2cafe0f63a2c1bd2101f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comments.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comments.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8583f620cdac2cafe0f63a2c1bd2101f)): ?>
<?php $attributes = $__attributesOriginal8583f620cdac2cafe0f63a2c1bd2101f; ?>
<?php unset($__attributesOriginal8583f620cdac2cafe0f63a2c1bd2101f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8583f620cdac2cafe0f63a2c1bd2101f)): ?>
<?php $component = $__componentOriginal8583f620cdac2cafe0f63a2c1bd2101f; ?>
<?php unset($__componentOriginal8583f620cdac2cafe0f63a2c1bd2101f); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalb45eade6f129d8af6681551d4d1caef6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb45eade6f129d8af6681551d4d1caef6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comments.form','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comments.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb45eade6f129d8af6681551d4d1caef6)): ?>
<?php $attributes = $__attributesOriginalb45eade6f129d8af6681551d4d1caef6; ?>
<?php unset($__attributesOriginalb45eade6f129d8af6681551d4d1caef6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb45eade6f129d8af6681551d4d1caef6)): ?>
<?php $component = $__componentOriginalb45eade6f129d8af6681551d4d1caef6; ?>
<?php unset($__componentOriginalb45eade6f129d8af6681551d4d1caef6); ?>
<?php endif; ?>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($this->getTotalCommentsCount()): ?>
        <?php if (isset($component)) { $__componentOriginal433ce941f996eb340534d0334a9983f2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433ce941f996eb340534d0334a9983f2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comments.order-buttons','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comments.order-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433ce941f996eb340534d0334a9983f2)): ?>
<?php $attributes = $__attributesOriginal433ce941f996eb340534d0334a9983f2; ?>
<?php unset($__attributesOriginal433ce941f996eb340534d0334a9983f2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433ce941f996eb340534d0334a9983f2)): ?>
<?php $component = $__componentOriginal433ce941f996eb340534d0334a9983f2; ?>
<?php unset($__componentOriginal433ce941f996eb340534d0334a9983f2); ?>
<?php endif; ?>

        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginalcdf4a435c6880c573e5345e739ea29eb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcdf4a435c6880c573e5345e739ea29eb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comments.item','data' => ['comment' => $comment]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comments.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['comment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($comment)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcdf4a435c6880c573e5345e739ea29eb)): ?>
<?php $attributes = $__attributesOriginalcdf4a435c6880c573e5345e739ea29eb; ?>
<?php unset($__attributesOriginalcdf4a435c6880c573e5345e739ea29eb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcdf4a435c6880c573e5345e739ea29eb)): ?>
<?php $component = $__componentOriginalcdf4a435c6880c573e5345e739ea29eb; ?>
<?php unset($__componentOriginalcdf4a435c6880c573e5345e739ea29eb); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        <?php if (isset($component)) { $__componentOriginale153655aa7ec549cc9d509e3c0e3257a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale153655aa7ec549cc9d509e3c0e3257a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.likes.modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('likes.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale153655aa7ec549cc9d509e3c0e3257a)): ?>
<?php $attributes = $__attributesOriginale153655aa7ec549cc9d509e3c0e3257a; ?>
<?php unset($__attributesOriginale153655aa7ec549cc9d509e3c0e3257a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale153655aa7ec549cc9d509e3c0e3257a)): ?>
<?php $component = $__componentOriginale153655aa7ec549cc9d509e3c0e3257a; ?>
<?php unset($__componentOriginale153655aa7ec549cc9d509e3c0e3257a); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\Users\micha\Herd\larastart\resources\views/livewire/comments.blade.php ENDPATH**/ ?>