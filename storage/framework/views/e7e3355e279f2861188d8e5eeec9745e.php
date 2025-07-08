<?php foreach ((['axis' => 'x']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<template name="zero-line">
    <line <?php echo e($attributes->merge([
        'class' => '[:where(&)]:text-zinc-400',
        'orientation' => 'left',
        'stroke-width' => '1',
        'stroke' => 'currentColor',
        'fill' => 'none',
        'x1' => '0',
        'y1' => '0',
        'x2' => '0',
        'y2' => '6',
    ])); ?>></line>
</template><?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\zero-line.blade.php ENDPATH**/ ?>