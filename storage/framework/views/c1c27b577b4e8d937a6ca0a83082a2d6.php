
<?php
$classes = Flux::classes()
    ->add('shrink-0 size-[1.125rem] rounded-[.3rem] flex justify-center items-center')
    ->add('text-sm text-zinc-700 dark:text-zinc-800')
    ->add('[ui-option[disabled]_&]:opacity-75 [ui-option[data-selected][disabled]_&]:opacity-50 ')
    ->add('[ui-option[data-selected]_&>svg:first-child]:block')
    ->add([
        'border',
        'border-zinc-300 dark:border-white/10',
        '[ui-option[disabled]_&]:border-zinc-200 dark:[ui-option[disabled]_&]:border-white/5',
        '[ui-option[data-selected]_&]:border-transparent',
        '[ui-option[disabled][data-selected]_&]::border-transparent',
    ])
    ->add([
        'bg-white dark:bg-white/10',
        '[ui-option[data-selected]_&]:bg-[var(--color-accent)]',
        'hover:[ui-option[data-selected]_&]:bg-(--color-accent)',
        'focus:[ui-option[data-selected]_&]:bg-(--color-accent)',
    ])
    ;
?>

<div <?php echo e($attributes->class($classes)); ?>>
    <?php if (isset($component)) { $__componentOriginal9c2dfd6cb98f4df18e26d1694500af11 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9c2dfd6cb98f4df18e26d1694500af11 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.check','data' => ['variant' => 'micro','class' => 'hidden text-[var(--color-accent-foreground)]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'micro','class' => 'hidden text-[var(--color-accent-foreground)]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9c2dfd6cb98f4df18e26d1694500af11)): ?>
<?php $attributes = $__attributesOriginal9c2dfd6cb98f4df18e26d1694500af11; ?>
<?php unset($__attributesOriginal9c2dfd6cb98f4df18e26d1694500af11); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9c2dfd6cb98f4df18e26d1694500af11)): ?>
<?php $component = $__componentOriginal9c2dfd6cb98f4df18e26d1694500af11; ?>
<?php unset($__componentOriginal9c2dfd6cb98f4df18e26d1694500af11); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.minus','data' => ['variant' => 'micro','class' => 'hidden text-[var(--color-accent-foreground)]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.minus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'micro','class' => 'hidden text-[var(--color-accent-foreground)]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50)): ?>
<?php $attributes = $__attributesOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50; ?>
<?php unset($__attributesOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50)): ?>
<?php $component = $__componentOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50; ?>
<?php unset($__componentOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\select\indicator\variants\checkbox.blade.php ENDPATH**/ ?>