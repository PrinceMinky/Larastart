<div class="flex flex-col gap-3 w-full">
    <!--[if BLOCK]><![endif]--><?php if($this->user->is_me()): ?>
        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['wire:navigate' => true,'href' => route('settings.profile'),'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:navigate' => true,'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('settings.profile')),'size' => 'sm']); ?>Edit Profile <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginala83b57cdd6be5e0a881eb76b1b82e91b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala83b57cdd6be5e0a881eb76b1b82e91b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-profile.follow-button','data' => ['user' => $this->user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-profile.follow-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala83b57cdd6be5e0a881eb76b1b82e91b)): ?>
<?php $attributes = $__attributesOriginala83b57cdd6be5e0a881eb76b1b82e91b; ?>
<?php unset($__attributesOriginala83b57cdd6be5e0a881eb76b1b82e91b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala83b57cdd6be5e0a881eb76b1b82e91b)): ?>
<?php $component = $__componentOriginala83b57cdd6be5e0a881eb76b1b82e91b; ?>
<?php unset($__componentOriginala83b57cdd6be5e0a881eb76b1b82e91b); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal9f18c7d06c6ea73c5ddb250e47a2229a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f18c7d06c6ea73c5ddb250e47a2229a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-profile.block-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-profile.block-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f18c7d06c6ea73c5ddb250e47a2229a)): ?>
<?php $attributes = $__attributesOriginal9f18c7d06c6ea73c5ddb250e47a2229a; ?>
<?php unset($__attributesOriginal9f18c7d06c6ea73c5ddb250e47a2229a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f18c7d06c6ea73c5ddb250e47a2229a)): ?>
<?php $component = $__componentOriginal9f18c7d06c6ea73c5ddb250e47a2229a; ?>
<?php unset($__componentOriginal9f18c7d06c6ea73c5ddb250e47a2229a); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\Users\micha\Herd\larastart\resources\views/components/user-profile/actions.blade.php ENDPATH**/ ?>