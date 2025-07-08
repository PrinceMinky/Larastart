<?php
$classes = Flux::classes()
    ->add('data-hidden:hidden flex items-center px-2 py-1.5 w-full focus:outline-hidden rounded-md')
    ->add('text-start text-sm font-medium')
    ->add('text-zinc-800 data-active:bg-zinc-100 dark:text-white dark:data-active:bg-zinc-600')
    ->add('scroll-my-[.3125rem]') // This is here so that when a user scrolls to the top or bottom of the list, the padding is included...
    ;
?>

<ui-option <?php echo e($attributes->class($classes)); ?> data-flux-autocomplete-item>
    <?php echo e($slot); ?>

</ui-option>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\src/../stubs/resources/views/flux/autocomplete/item.blade.php ENDPATH**/ ?>