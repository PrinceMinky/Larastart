<?php if (isset($component)) { $__componentOriginalc4bce27d2c09d2f98a63d67977c1c3ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc4bce27d2c09d2f98a63d67977c1c3ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::card.index','data' => ['wire:key' => ''.e($post->id).'','class' => 'relative flex flex-col gap-2 group','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => ''.e($post->id).'','class' => 'relative flex flex-col gap-2 group','size' => 'sm']); ?>
    <?php if (isset($component)) { $__componentOriginalb4ab67adfd99c49dda31b63405d32264 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb4ab67adfd99c49dda31b63405d32264 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.actions','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb4ab67adfd99c49dda31b63405d32264)): ?>
<?php $attributes = $__attributesOriginalb4ab67adfd99c49dda31b63405d32264; ?>
<?php unset($__attributesOriginalb4ab67adfd99c49dda31b63405d32264); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4ab67adfd99c49dda31b63405d32264)): ?>
<?php $component = $__componentOriginalb4ab67adfd99c49dda31b63405d32264; ?>
<?php unset($__componentOriginalb4ab67adfd99c49dda31b63405d32264); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal2f06c61d5b24261d357ea028f3e7826c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f06c61d5b24261d357ea028f3e7826c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.header','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2f06c61d5b24261d357ea028f3e7826c)): ?>
<?php $attributes = $__attributesOriginal2f06c61d5b24261d357ea028f3e7826c; ?>
<?php unset($__attributesOriginal2f06c61d5b24261d357ea028f3e7826c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2f06c61d5b24261d357ea028f3e7826c)): ?>
<?php $component = $__componentOriginal2f06c61d5b24261d357ea028f3e7826c; ?>
<?php unset($__componentOriginal2f06c61d5b24261d357ea028f3e7826c); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal445715c74923165120ddb7080e8b0105 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal445715c74923165120ddb7080e8b0105 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.content','data' => ['post' => $post,'editingPostId' => $this->editingPostId]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post),'editingPostId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->editingPostId)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal445715c74923165120ddb7080e8b0105)): ?>
<?php $attributes = $__attributesOriginal445715c74923165120ddb7080e8b0105; ?>
<?php unset($__attributesOriginal445715c74923165120ddb7080e8b0105); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal445715c74923165120ddb7080e8b0105)): ?>
<?php $component = $__componentOriginal445715c74923165120ddb7080e8b0105; ?>
<?php unset($__componentOriginal445715c74923165120ddb7080e8b0105); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalad226a58a6d27f2c253c5dfc0f79b74f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad226a58a6d27f2c253c5dfc0f79b74f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.interactions','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.interactions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad226a58a6d27f2c253c5dfc0f79b74f)): ?>
<?php $attributes = $__attributesOriginalad226a58a6d27f2c253c5dfc0f79b74f; ?>
<?php unset($__attributesOriginalad226a58a6d27f2c253c5dfc0f79b74f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad226a58a6d27f2c253c5dfc0f79b74f)): ?>
<?php $component = $__componentOriginalad226a58a6d27f2c253c5dfc0f79b74f; ?>
<?php unset($__componentOriginalad226a58a6d27f2c253c5dfc0f79b74f); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal3c6fb655ab5e18ed9d228a377d1063cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c6fb655ab5e18ed9d228a377d1063cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.summary','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.summary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c6fb655ab5e18ed9d228a377d1063cd)): ?>
<?php $attributes = $__attributesOriginal3c6fb655ab5e18ed9d228a377d1063cd; ?>
<?php unset($__attributesOriginal3c6fb655ab5e18ed9d228a377d1063cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c6fb655ab5e18ed9d228a377d1063cd)): ?>
<?php $component = $__componentOriginal3c6fb655ab5e18ed9d228a377d1063cd; ?>
<?php unset($__componentOriginal3c6fb655ab5e18ed9d228a377d1063cd); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc4bce27d2c09d2f98a63d67977c1c3ec)): ?>
<?php $attributes = $__attributesOriginalc4bce27d2c09d2f98a63d67977c1c3ec; ?>
<?php unset($__attributesOriginalc4bce27d2c09d2f98a63d67977c1c3ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc4bce27d2c09d2f98a63d67977c1c3ec)): ?>
<?php $component = $__componentOriginalc4bce27d2c09d2f98a63d67977c1c3ec; ?>
<?php unset($__componentOriginalc4bce27d2c09d2f98a63d67977c1c3ec); ?>
<?php endif; ?><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\components\user-post\card.blade.php ENDPATH**/ ?>