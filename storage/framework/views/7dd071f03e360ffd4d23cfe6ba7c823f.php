<?php
$classes = Flux::classes()
    ->add('p-[.3125rem]')
    ->add('overflow-y-auto')
    ->add('bg-white dark:bg-zinc-700')
    ;
?>

<ui-options <?php echo e($attributes->class($classes)); ?> data-flux-command-items>
    <?php echo e($slot); ?>


    <?php if (isset($component)) { $__componentOriginal4be45da1ae1eab5d71599be2e88c4c3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4be45da1ae1eab5d71599be2e88c4c3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::command.empty','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::command.empty'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo __('No results found'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4be45da1ae1eab5d71599be2e88c4c3d)): ?>
<?php $attributes = $__attributesOriginal4be45da1ae1eab5d71599be2e88c4c3d; ?>
<?php unset($__attributesOriginal4be45da1ae1eab5d71599be2e88c4c3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4be45da1ae1eab5d71599be2e88c4c3d)): ?>
<?php $component = $__componentOriginal4be45da1ae1eab5d71599be2e88c4c3d; ?>
<?php unset($__componentOriginal4be45da1ae1eab5d71599be2e88c4c3d); ?>
<?php endif; ?>
</ui-options>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\command\items.blade.php ENDPATH**/ ?>