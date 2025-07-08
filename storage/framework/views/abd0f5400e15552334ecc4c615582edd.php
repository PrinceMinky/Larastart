<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['hideScrollbar' => true]));

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

foreach (array_filter((['hideScrollbar' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'overflow-x-auto cursor-grab min-h-[400px] sm:min-h-[500px] md:min-h-[600px] lg:min-h-[800px] relative',
        'hide-scrollbar' => $hideScrollbar === true,
    ]); ?>"
    x-data="scrollContainer()" 
    x-init="init()"
    x-on:destroy="destroy()"
>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\Users\micha\Herd\larastart\resources\views\components\drag-scroll-container.blade.php ENDPATH**/ ?>