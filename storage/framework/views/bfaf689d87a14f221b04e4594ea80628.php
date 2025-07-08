<section>
    <!-- Display Heading -->
    <?php if (isset($component)) { $__componentOriginal8026f1991abb42645b4d7cc7ace47942 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8026f1991abb42645b4d7cc7ace47942 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('heading', null, []); ?> <?php echo e(__('Users')); ?> <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8026f1991abb42645b4d7cc7ace47942)): ?>
<?php $attributes = $__attributesOriginal8026f1991abb42645b4d7cc7ace47942; ?>
<?php unset($__attributesOriginal8026f1991abb42645b4d7cc7ace47942); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8026f1991abb42645b4d7cc7ace47942)): ?>
<?php $component = $__componentOriginal8026f1991abb42645b4d7cc7ace47942; ?>
<?php unset($__componentOriginal8026f1991abb42645b4d7cc7ace47942); ?>
<?php endif; ?>

    <!-- Display Search -->
    <div class="mb-6">
        <?php if (isset($component)) { $__componentOriginal1363f59e7685992dd960f1c1e93199aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1363f59e7685992dd960f1c1e93199aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-search.search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-search.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1363f59e7685992dd960f1c1e93199aa)): ?>
<?php $attributes = $__attributesOriginal1363f59e7685992dd960f1c1e93199aa; ?>
<?php unset($__attributesOriginal1363f59e7685992dd960f1c1e93199aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1363f59e7685992dd960f1c1e93199aa)): ?>
<?php $component = $__componentOriginal1363f59e7685992dd960f1c1e93199aa; ?>
<?php unset($__componentOriginal1363f59e7685992dd960f1c1e93199aa); ?>
<?php endif; ?>
    </div>

    <!-- Display Users -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
        <?php $__currentLoopData = $this->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginaleba2515cc6fc1a09129cfedc4658dd6e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleba2515cc6fc1a09129cfedc4658dd6e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-search.card','data' => ['user' => $user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-search.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleba2515cc6fc1a09129cfedc4658dd6e)): ?>
<?php $attributes = $__attributesOriginaleba2515cc6fc1a09129cfedc4658dd6e; ?>
<?php unset($__attributesOriginaleba2515cc6fc1a09129cfedc4658dd6e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleba2515cc6fc1a09129cfedc4658dd6e)): ?>
<?php $component = $__componentOriginaleba2515cc6fc1a09129cfedc4658dd6e; ?>
<?php unset($__componentOriginaleba2515cc6fc1a09129cfedc4658dd6e); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($component)) { $__componentOriginal460af0af147e5c473bd44cf084c50f42 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal460af0af147e5c473bd44cf084c50f42 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::pagination','data' => ['class' => 'mt-6','paginator' => $this->users]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-6','paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->users)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal460af0af147e5c473bd44cf084c50f42)): ?>
<?php $attributes = $__attributesOriginal460af0af147e5c473bd44cf084c50f42; ?>
<?php unset($__attributesOriginal460af0af147e5c473bd44cf084c50f42); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal460af0af147e5c473bd44cf084c50f42)): ?>
<?php $component = $__componentOriginal460af0af147e5c473bd44cf084c50f42; ?>
<?php unset($__componentOriginal460af0af147e5c473bd44cf084c50f42); ?>
<?php endif; ?>
</section><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\livewire\user-search\index.blade.php ENDPATH**/ ?>