<?php foreach ((['axis' => 'x', 'position' => null ]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'format' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'format' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
$format = is_array($format) ? \Illuminate\Support\Js::encode($format) : $format;
?>

<?php if($axis === 'x'): ?>
    <template name="tick-label" <?php if($format): ?> format="<?php echo e($format); ?>" <?php endif; ?>>
        <g>
            <text <?php echo e($attributes->merge([
                'class' => '[:where(&)]:text-xs [:where(&)]:text-zinc-400 [:where(&)]:font-medium [:where(&)]:dark:text-zinc-300',
                'text-anchor' => 'middle',
                'fill' => 'currentColor',
                'dominant-baseline' => $position === 'top' ? 'text-after-edge' : 'text-before-edge',
                'dy' => $position === 'top' ? '-1em' : '1em',
            ])); ?>><slot></slot></text>
        </g>
    </template>
<?php else: ?>
    <template name="tick-label" <?php if($format): ?> format="<?php echo e($format); ?>" <?php endif; ?>>
        <g>
            <text <?php echo e($attributes->merge([
                'class' => '[:where(&)]:text-xs [:where(&)]:text-zinc-400 [:where(&)]:dark:text-zinc-300',
                'dominant-baseline' => 'central',
                'fill' => 'currentColor',
                'text-anchor' => $position === 'right' ? 'start' : 'end',
                'dx' => $position === 'right' ? '1em' : '-1em',
            ])); ?>><slot></slot></text>
        </g>
    </template>
<?php endif; ?><?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\chart\axis\tick.blade.php ENDPATH**/ ?>