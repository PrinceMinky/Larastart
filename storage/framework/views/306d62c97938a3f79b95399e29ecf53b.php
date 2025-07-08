<?php if (isset($component)) { $__componentOriginal2b4bb2cd4b8f1a3c08bae49ea918b888 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b4bb2cd4b8f1a3c08bae49ea918b888 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::dropdown','data' => ['position' => 'bottom','align' => 'end']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['position' => 'bottom','align' => 'end']); ?>
    <?php if (isset($component)) { $__componentOriginal040a70962ba178fb6fc90ed444105a60 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal040a70962ba178fb6fc90ed444105a60 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notifications.dropdown.button','data' => ['unreadCount' => $unreadCount]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notifications.dropdown.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['unreadCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadCount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal040a70962ba178fb6fc90ed444105a60)): ?>
<?php $attributes = $__attributesOriginal040a70962ba178fb6fc90ed444105a60; ?>
<?php unset($__attributesOriginal040a70962ba178fb6fc90ed444105a60); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal040a70962ba178fb6fc90ed444105a60)): ?>
<?php $component = $__componentOriginal040a70962ba178fb6fc90ed444105a60; ?>
<?php unset($__componentOriginal040a70962ba178fb6fc90ed444105a60); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginale1d9e3b6554d05329551a11b4bf1696e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale1d9e3b6554d05329551a11b4bf1696e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::popover.index','data' => ['class' => 'min-w-[30rem] max-h-[30rem] flex flex-col gap-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::popover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'min-w-[30rem] max-h-[30rem] flex flex-col gap-1']); ?>
        <?php if (isset($component)) { $__componentOriginal23cda51183dd59b75f3cf63672fa5638 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23cda51183dd59b75f3cf63672fa5638 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notifications.dropdown.heading','data' => ['unreadCount' => $unreadCount]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notifications.dropdown.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['unreadCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadCount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23cda51183dd59b75f3cf63672fa5638)): ?>
<?php $attributes = $__attributesOriginal23cda51183dd59b75f3cf63672fa5638; ?>
<?php unset($__attributesOriginal23cda51183dd59b75f3cf63672fa5638); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23cda51183dd59b75f3cf63672fa5638)): ?>
<?php $component = $__componentOriginal23cda51183dd59b75f3cf63672fa5638; ?>
<?php unset($__componentOriginal23cda51183dd59b75f3cf63672fa5638); ?>
<?php endif; ?>
        
        <?php $__empty_1 = true; $__currentLoopData = $processedNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if (isset($component)) { $__componentOriginal9dfb3acdc458c8cb2a4fb8d1e5cc4e3c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9dfb3acdc458c8cb2a4fb8d1e5cc4e3c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notifications.dropdown.row','data' => ['notification' => $notification]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notifications.dropdown.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['notification' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9dfb3acdc458c8cb2a4fb8d1e5cc4e3c)): ?>
<?php $attributes = $__attributesOriginal9dfb3acdc458c8cb2a4fb8d1e5cc4e3c; ?>
<?php unset($__attributesOriginal9dfb3acdc458c8cb2a4fb8d1e5cc4e3c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9dfb3acdc458c8cb2a4fb8d1e5cc4e3c)): ?>
<?php $component = $__componentOriginal9dfb3acdc458c8cb2a4fb8d1e5cc4e3c; ?>
<?php unset($__componentOriginal9dfb3acdc458c8cb2a4fb8d1e5cc4e3c); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php if (isset($component)) { $__componentOriginal1499956abcbe6803ec8fbf1fa7294ce9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1499956abcbe6803ec8fbf1fa7294ce9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notifications.dropdown.empty','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notifications.dropdown.empty'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1499956abcbe6803ec8fbf1fa7294ce9)): ?>
<?php $attributes = $__attributesOriginal1499956abcbe6803ec8fbf1fa7294ce9; ?>
<?php unset($__attributesOriginal1499956abcbe6803ec8fbf1fa7294ce9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1499956abcbe6803ec8fbf1fa7294ce9)): ?>
<?php $component = $__componentOriginal1499956abcbe6803ec8fbf1fa7294ce9; ?>
<?php unset($__componentOriginal1499956abcbe6803ec8fbf1fa7294ce9); ?>
<?php endif; ?>
        <?php endif; ?>
        
        <?php if (isset($component)) { $__componentOriginal3ccdf16fa6dcb0a513e298cc4ac471b7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3ccdf16fa6dcb0a513e298cc4ac471b7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notifications.dropdown.view-all-link','data' => ['processedNotifications' => $processedNotifications,'notificationLimit' => $notificationLimit,'showAllNotifications' => $showAllNotifications]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notifications.dropdown.view-all-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['processedNotifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($processedNotifications),'notificationLimit' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notificationLimit),'showAllNotifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showAllNotifications)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3ccdf16fa6dcb0a513e298cc4ac471b7)): ?>
<?php $attributes = $__attributesOriginal3ccdf16fa6dcb0a513e298cc4ac471b7; ?>
<?php unset($__attributesOriginal3ccdf16fa6dcb0a513e298cc4ac471b7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3ccdf16fa6dcb0a513e298cc4ac471b7)): ?>
<?php $component = $__componentOriginal3ccdf16fa6dcb0a513e298cc4ac471b7; ?>
<?php unset($__componentOriginal3ccdf16fa6dcb0a513e298cc4ac471b7); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale1d9e3b6554d05329551a11b4bf1696e)): ?>
<?php $attributes = $__attributesOriginale1d9e3b6554d05329551a11b4bf1696e; ?>
<?php unset($__attributesOriginale1d9e3b6554d05329551a11b4bf1696e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale1d9e3b6554d05329551a11b4bf1696e)): ?>
<?php $component = $__componentOriginale1d9e3b6554d05329551a11b4bf1696e; ?>
<?php unset($__componentOriginale1d9e3b6554d05329551a11b4bf1696e); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b4bb2cd4b8f1a3c08bae49ea918b888)): ?>
<?php $attributes = $__attributesOriginal2b4bb2cd4b8f1a3c08bae49ea918b888; ?>
<?php unset($__attributesOriginal2b4bb2cd4b8f1a3c08bae49ea918b888); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b4bb2cd4b8f1a3c08bae49ea918b888)): ?>
<?php $component = $__componentOriginal2b4bb2cd4b8f1a3c08bae49ea918b888; ?>
<?php unset($__componentOriginal2b4bb2cd4b8f1a3c08bae49ea918b888); ?>
<?php endif; ?><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\components\notifications\dropdown\index.blade.php ENDPATH**/ ?>