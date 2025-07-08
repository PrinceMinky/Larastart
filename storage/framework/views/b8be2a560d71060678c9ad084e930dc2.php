<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'handle' =>null, 
    'group' => null, 
    'key' => null, 
    'permissions' => []
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
    'handle' =>null, 
    'group' => null, 
    'key' => null, 
    'permissions' => []
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $canSort = empty($permissions) || auth()->user()?->canAny($permissions);
?>

<div 
    <?php echo e($attributes); ?>

    
    <?php if($canSort): ?>
        <?php if($group): ?>
            x-sort:group="<?php echo e($group); ?>"
        <?php endif; ?>

        <?php if($key !== null): ?>
            x-sort="<?php echo e('$wire.' . $handle . '($item, $position, ' . json_encode($key) . ')'); ?>"
        <?php else: ?>
            x-sort="<?php echo e('$wire.' . $handle . '($item, $position)'); ?>"
        <?php endif; ?>
    <?php endif; ?>
>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\Users\micha\Herd\larastart\resources\views\components\sort\index.blade.php ENDPATH**/ ?>