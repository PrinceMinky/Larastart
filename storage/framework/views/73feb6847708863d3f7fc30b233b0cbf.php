<div class="flex flex-col gap-2">
    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php if (isset($component)) { $__componentOriginal119ba1b0800dcb366bdaa8abd85a87ac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal119ba1b0800dcb366bdaa8abd85a87ac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.card','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal119ba1b0800dcb366bdaa8abd85a87ac)): ?>
<?php $attributes = $__attributesOriginal119ba1b0800dcb366bdaa8abd85a87ac; ?>
<?php unset($__attributesOriginal119ba1b0800dcb366bdaa8abd85a87ac); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal119ba1b0800dcb366bdaa8abd85a87ac)): ?>
<?php $component = $__componentOriginal119ba1b0800dcb366bdaa8abd85a87ac; ?>
<?php unset($__componentOriginal119ba1b0800dcb366bdaa8abd85a87ac); ?>
<?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php if (isset($component)) { $__componentOriginal0638ebfbd490c7a414275d493e14cb4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0638ebfbd490c7a414275d493e14cb4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::text','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>No posts created. <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0638ebfbd490c7a414275d493e14cb4e)): ?>
<?php $attributes = $__attributesOriginal0638ebfbd490c7a414275d493e14cb4e; ?>
<?php unset($__attributesOriginal0638ebfbd490c7a414275d493e14cb4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0638ebfbd490c7a414275d493e14cb4e)): ?>
<?php $component = $__componentOriginal0638ebfbd490c7a414275d493e14cb4e; ?>
<?php unset($__componentOriginal0638ebfbd490c7a414275d493e14cb4e); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

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
</div><?php /**PATH C:\Users\micha\Herd\larastart\resources\views/components/user-post/show.blade.php ENDPATH**/ ?>