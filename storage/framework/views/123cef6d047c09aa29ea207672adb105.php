<?php foreach ((['axis' => 'x']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php if($axis === 'x'): ?>
    <template name="grid-line">
        <line <?php echo e($attributes->merge([
            'type' => 'horizontal',
            'class' => 'text-zinc-200/50 dark:text-white/15',
            'stroke' => 'currentColor',
            'stroke-width' => '1',
        ])); ?>></line>
    </template>
<?php else: ?>
    <template name="grid-line">
        <line <?php echo e($attributes->merge([
            'type' => 'vertical',
            'class' => 'text-zinc-200/50 dark:text-white/15',
            'stroke' => 'currentColor',
            'stroke-width' => '1',
        ])); ?>></line>
    </template>
<?php endif; ?>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\axis\grid.blade.php ENDPATH**/ ?>