<?php foreach ((['axis' => 'x']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php if($axis === 'x'): ?>
    <template name="axis-line">
        <line <?php echo e($attributes->merge([
            'class' => '[:where(&)]:text-zinc-300 dark:[:where(&)]:text-white/40',
            'orientation' => 'bottom',
            'stroke-width' => '1',
            'stroke' => 'currentColor',
            'fill' => 'none',
        ])); ?>></line>
    </template>
<?php else: ?>
    <template name="axis-line">
        <line <?php echo e($attributes->merge([
            'class' => '[:where(&)]:text-zinc-300 dark:[:where(&)]:text-white/40',
            'orientation' => 'left',
            'stroke-width' => '1',
            'stroke' => 'currentColor',
            'fill' => 'none',
        ])); ?>></line>
    </template>
<?php endif; ?><?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\axis\line.blade.php ENDPATH**/ ?>