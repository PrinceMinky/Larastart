<?php foreach ((['axis' => 'x', 'position' => null]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php if($axis === 'x'): ?>
    <template name="tick-mark">
        <g>
            <line <?php echo e($attributes->merge([
                'class' => 'stroke-zinc-300',
                'orientation' => $position === 'top' ? 'top' : 'bottom',
                'stroke' => 'currentColor',
                'stroke-width' => '1',
                'fill' => 'none',
                'y1' => '0',
                'y2' => '6',
            ])); ?>></line>
        </g>
    </template>
<?php else: ?>
    <template name="tick-mark">
        <g>
            <line <?php echo e($attributes->merge([
                'class' => 'stroke-zinc-300',
                'orientation' => $position === 'right' ? 'right' : 'left',
                'stroke' => 'currentColor',
                'stroke-width' => '1',
                'fill' => 'none',
                'x1' => $position === 'right' ? '0' : '-6',
                'x2' => $position === 'right' ? '6' : '0',
            ])); ?>></line>
        </g>
    </template>
<?php endif; ?><?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\axis\mark.blade.php ENDPATH**/ ?>