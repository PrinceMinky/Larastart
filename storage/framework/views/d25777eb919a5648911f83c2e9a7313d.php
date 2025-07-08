<section>
    <?php if (isset($component)) { $__componentOriginal7cf11b1cfc3450b0024110d6408f3b9a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7cf11b1cfc3450b0024110d6408f3b9a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.status-form','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.status-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7cf11b1cfc3450b0024110d6408f3b9a)): ?>
<?php $attributes = $__attributesOriginal7cf11b1cfc3450b0024110d6408f3b9a; ?>
<?php unset($__attributesOriginal7cf11b1cfc3450b0024110d6408f3b9a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7cf11b1cfc3450b0024110d6408f3b9a)): ?>
<?php $component = $__componentOriginal7cf11b1cfc3450b0024110d6408f3b9a; ?>
<?php unset($__componentOriginal7cf11b1cfc3450b0024110d6408f3b9a); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalbb6b8337f3fdd565dc633a94b6f90858 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb6b8337f3fdd565dc633a94b6f90858 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-post.show','data' => ['posts' => $this->posts()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-post.show'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['posts' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->posts())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb6b8337f3fdd565dc633a94b6f90858)): ?>
<?php $attributes = $__attributesOriginalbb6b8337f3fdd565dc633a94b6f90858; ?>
<?php unset($__attributesOriginalbb6b8337f3fdd565dc633a94b6f90858); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb6b8337f3fdd565dc633a94b6f90858)): ?>
<?php $component = $__componentOriginalbb6b8337f3fdd565dc633a94b6f90858; ?>
<?php unset($__componentOriginalbb6b8337f3fdd565dc633a94b6f90858); ?>
<?php endif; ?>
</section><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\livewire\user-post\index.blade.php ENDPATH**/ ?>