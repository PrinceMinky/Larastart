<div>
    <?php if (isset($component)) { $__componentOriginal6fd8f7c79426092ed14c2d021a97657f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6fd8f7c79426092ed14c2d021a97657f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notifications.dropdown.index','data' => ['unreadCount' => $unreadCount,'processedNotifications' => $processedNotifications,'notificationLimit' => $notificationLimit,'showAllNotifications' => $showAllNotifications]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notifications.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['unreadCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadCount),'processedNotifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($processedNotifications),'notificationLimit' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notificationLimit),'showAllNotifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showAllNotifications)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6fd8f7c79426092ed14c2d021a97657f)): ?>
<?php $attributes = $__attributesOriginal6fd8f7c79426092ed14c2d021a97657f; ?>
<?php unset($__attributesOriginal6fd8f7c79426092ed14c2d021a97657f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6fd8f7c79426092ed14c2d021a97657f)): ?>
<?php $component = $__componentOriginal6fd8f7c79426092ed14c2d021a97657f; ?>
<?php unset($__componentOriginal6fd8f7c79426092ed14c2d021a97657f); ?>
<?php endif; ?>
</div><?php /**PATH C:\Users\micha\Herd\larastart\resources\views/livewire/notifications-dropdown.blade.php ENDPATH**/ ?>