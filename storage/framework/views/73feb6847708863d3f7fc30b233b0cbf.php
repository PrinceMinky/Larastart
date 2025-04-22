<div class="flex flex-col gap-2">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

    <?php if (isset($component)) { $__componentOriginal2c0221d484a89ec064e3e897045d7950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2c0221d484a89ec064e3e897045d7950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.likes-modal','data' => ['likedUsers' => $this->likedUsers]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.likes-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['likedUsers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->likedUsers)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2c0221d484a89ec064e3e897045d7950)): ?>
<?php $attributes = $__attributesOriginal2c0221d484a89ec064e3e897045d7950; ?>
<?php unset($__attributesOriginal2c0221d484a89ec064e3e897045d7950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2c0221d484a89ec064e3e897045d7950)): ?>
<?php $component = $__componentOriginal2c0221d484a89ec064e3e897045d7950; ?>
<?php unset($__componentOriginal2c0221d484a89ec064e3e897045d7950); ?>
<?php endif; ?>
</div><?php /**PATH C:\Users\micha\Herd\larastart\resources\views/components/user-post/show.blade.php ENDPATH**/ ?>