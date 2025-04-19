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
    'suffix' => null,
    'size' => null,
    'max' => null,
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
    'suffix' => null,
    'size' => null,
    'max' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
// Clearable is not supported on xs size...
if ($size === 'xs') $clearable = null;

$classes = Flux::classes()
    ->add('group/select-button cursor-default py-2')
    ->add('overflow-hidden') // Overflow hidden is here to prevent the button from growing when selected text is too long.
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

<button type="button" <?php echo e($attributes->class($classes)); ?> <?php if($invalid): ?> data-invalid <?php endif; ?> data-flux-group-target data-flux-select-button>
    <?php if ($slot->isNotEmpty()): ?>
        <?php echo e($slot); ?>

    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginalc8efb579379bd45f09a36f016c32b705 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8efb579379bd45f09a36f016c32b705 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.selected','data' => ['placeholder' => $placeholder,'max' => $max,'suffix' => $suffix]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.selected'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($placeholder),'max' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($max),'suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffix)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8efb579379bd45f09a36f016c32b705)): ?>
<?php $attributes = $__attributesOriginalc8efb579379bd45f09a36f016c32b705; ?>
<?php unset($__attributesOriginalc8efb579379bd45f09a36f016c32b705); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8efb579379bd45f09a36f016c32b705)): ?>
<?php $component = $__componentOriginalc8efb579379bd45f09a36f016c32b705; ?>
<?php unset($__componentOriginalc8efb579379bd45f09a36f016c32b705); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if ($clearable): ?>
        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['as' => 'div','class' => 'cursor-pointer ms-2 -me-2 [[data-flux-select-button]:has([data-flux-select-placeholder])_&]:hidden [[data-flux-select]:has([disabled][data-selected])_&]:hidden','variant' => 'subtle','size' => $size === 'sm' ? 'xs' : 'sm','square' => true,'tabindex' => '-1','ariaLabel' => 'Clear selected','xOn:click.prevent.stop' => 'let select = $el.closest(\'ui-select\'); select.value = select.hasAttribute(\'multiple\') ? [] : null; select.dispatchEvent(new Event(\'change\', { bubbles: false })); select.dispatchEvent(new Event(\'input\', { bubbles: false }))']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['as' => 'div','class' => 'cursor-pointer ms-2 -me-2 [[data-flux-select-button]:has([data-flux-select-placeholder])_&]:hidden [[data-flux-select]:has([disabled][data-selected])_&]:hidden','variant' => 'subtle','size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($size === 'sm' ? 'xs' : 'sm'),'square' => true,'tabindex' => '-1','aria-label' => 'Clear selected','x-on:click.prevent.stop' => 'let select = $el.closest(\'ui-select\'); select.value = select.hasAttribute(\'multiple\') ? [] : null; select.dispatchEvent(new Event(\'change\', { bubbles: false })); select.dispatchEvent(new Event(\'input\', { bubbles: false }))']); ?>
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

    <?php if (isset($component)) { $__componentOriginal298ff21bbc41cebb188cbb18c6c11bc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal298ff21bbc41cebb188cbb18c6c11bc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.chevron-down','data' => ['variant' => 'mini','class' => 'ms-2 -me-1 text-zinc-300 [[data-flux-select-button]:hover_&]:text-zinc-800 [[disabled]_&]:text-zinc-200! dark:text-white/60 dark:[[data-flux-select-button]:hover_&]:text-white dark:[[disabled]_&]:text-white/40!']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.chevron-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'mini','class' => 'ms-2 -me-1 text-zinc-300 [[data-flux-select-button]:hover_&]:text-zinc-800 [[disabled]_&]:text-zinc-200! dark:text-white/60 dark:[[data-flux-select-button]:hover_&]:text-white dark:[[disabled]_&]:text-white/40!']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal298ff21bbc41cebb188cbb18c6c11bc0)): ?>
<?php $attributes = $__attributesOriginal298ff21bbc41cebb188cbb18c6c11bc0; ?>
<?php unset($__attributesOriginal298ff21bbc41cebb188cbb18c6c11bc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal298ff21bbc41cebb188cbb18c6c11bc0)): ?>
<?php $component = $__componentOriginal298ff21bbc41cebb188cbb18c6c11bc0; ?>
<?php unset($__componentOriginal298ff21bbc41cebb188cbb18c6c11bc0); ?>
<?php endif; ?>
</button>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\src/../stubs/resources/views/flux/select/button.blade.php ENDPATH**/ ?>