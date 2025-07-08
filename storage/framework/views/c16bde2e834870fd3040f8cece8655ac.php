<?php foreach (([ 'placeholder' ]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'placeholder' => null,
    'clearable' => null,
    'invalid' => false,
    'size' => null,
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
    'placeholder' => null,
    'clearable' => null,
    'invalid' => false,
    'size' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php

$classes = Flux::classes()
    ->add('group/select-button cursor-default py-2')
    ->add('overflow-hidden') // Overflow hidden is here to prevent the button from growing if the selected date text is too long.
    ->add('flex items-center')
    ->add('shadow-xs')
    ->add('bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]')
    // Make the placeholder match the text color of standard input placeholders...
    ->add('disabled:shadow-none')
    ->add(match ($size) {
        default => 'h-10 text-base sm:text-sm rounded-lg px-3 block w-full',
        'sm' => 'h-8 text-sm rounded-md ps-3 pe-2 block w-full',
        'xs' => 'h-6 text-xs rounded-md ps-3 pe-2 block w-full',
    })
    ->add($invalid
        ? 'border border-red-500'
        : 'border border-zinc-200 border-b-zinc-300/80 dark:border-white/10'
    )
    ;
?>

<button type="button" <?php echo e($attributes->class($classes)); ?> <?php if($invalid): ?> data-invalid <?php endif; ?> data-flux-group-target data-flux-date-picker-button>
    <?php if (isset($component)) { $__componentOriginalf48bb55ce6fd23a8de595ceefa5f14db = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf48bb55ce6fd23a8de595ceefa5f14db = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.calendar','data' => ['variant' => 'mini','class' => 'me-2 text-zinc-300 [[data-flux-date-picker-button]:hover_&]:text-zinc-800 [[disabled]_&]:text-zinc-200! dark:text-white/60 dark:[[data-flux-date-picker-button]:hover_&]:text-white dark:[[disabled]_&]:text-white/40! [[data-flux-date-picker-button][data-open]_&]:text-zinc-800 dark:[[data-flux-date-picker-button][data-open]_&]:text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'mini','class' => 'me-2 text-zinc-300 [[data-flux-date-picker-button]:hover_&]:text-zinc-800 [[disabled]_&]:text-zinc-200! dark:text-white/60 dark:[[data-flux-date-picker-button]:hover_&]:text-white dark:[[disabled]_&]:text-white/40! [[data-flux-date-picker-button][data-open]_&]:text-zinc-800 dark:[[data-flux-date-picker-button][data-open]_&]:text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf48bb55ce6fd23a8de595ceefa5f14db)): ?>
<?php $attributes = $__attributesOriginalf48bb55ce6fd23a8de595ceefa5f14db; ?>
<?php unset($__attributesOriginalf48bb55ce6fd23a8de595ceefa5f14db); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf48bb55ce6fd23a8de595ceefa5f14db)): ?>
<?php $component = $__componentOriginalf48bb55ce6fd23a8de595ceefa5f14db; ?>
<?php unset($__componentOriginalf48bb55ce6fd23a8de595ceefa5f14db); ?>
<?php endif; ?>

    <?php if ($slot->isNotEmpty()): ?>
        <?php echo e($slot); ?>

    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginalc4cbb44c3699301a9343503f04dd41ea = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc4cbb44c3699301a9343503f04dd41ea = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::date-picker.selected','data' => ['placeholder' => $placeholder]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::date-picker.selected'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($placeholder)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc4cbb44c3699301a9343503f04dd41ea)): ?>
<?php $attributes = $__attributesOriginalc4cbb44c3699301a9343503f04dd41ea; ?>
<?php unset($__attributesOriginalc4cbb44c3699301a9343503f04dd41ea); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc4cbb44c3699301a9343503f04dd41ea)): ?>
<?php $component = $__componentOriginalc4cbb44c3699301a9343503f04dd41ea; ?>
<?php unset($__componentOriginalc4cbb44c3699301a9343503f04dd41ea); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if ($clearable): ?>
        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['as' => 'div','class' => 'cursor-pointer ms-2 '.e($size === 'sm' || $size === 'xs' ? '-me-1' : '-me-2').' [[data-flux-date-picker-button]:has([data-flux-date-picker-placeholder])_&]:hidden [[data-flux-select]:has([disabled])_&]:hidden','variant' => 'subtle','size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','square' => true,'tabindex' => '-1','ariaLabel' => 'Clear date','xOn:click.prevent.stop' => 'let datePicker = $el.closest(\'ui-date-picker\'); datePicker.clear();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['as' => 'div','class' => 'cursor-pointer ms-2 '.e($size === 'sm' || $size === 'xs' ? '-me-1' : '-me-2').' [[data-flux-date-picker-button]:has([data-flux-date-picker-placeholder])_&]:hidden [[data-flux-select]:has([disabled])_&]:hidden','variant' => 'subtle','size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($size === 'sm' || $size === 'xs' ? 'xs' : 'sm'),'square' => true,'tabindex' => '-1','aria-label' => 'Clear date','x-on:click.prevent.stop' => 'let datePicker = $el.closest(\'ui-date-picker\'); datePicker.clear();']); ?>
            <?php if (isset($component)) { $__componentOriginal155e76c41fe51242bc25d269fabf82f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal155e76c41fe51242bc25d269fabf82f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.x-mark','data' => ['variant' => 'micro']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.x-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'micro']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal155e76c41fe51242bc25d269fabf82f5)): ?>
<?php $attributes = $__attributesOriginal155e76c41fe51242bc25d269fabf82f5; ?>
<?php unset($__attributesOriginal155e76c41fe51242bc25d269fabf82f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal155e76c41fe51242bc25d269fabf82f5)): ?>
<?php $component = $__componentOriginal155e76c41fe51242bc25d269fabf82f5; ?>
<?php unset($__componentOriginal155e76c41fe51242bc25d269fabf82f5); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
    <?php endif; ?>
</button>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\stubs\resources\views\flux\date-picker\button.blade.php ENDPATH**/ ?>