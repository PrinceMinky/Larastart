<?php
$classes = Flux::classes()
    ->add('data-hidden:hidden block items-center px-2 py-1.5 w-full')
    ->add('rounded-md')
    ->add('text-start text-sm font-medium')
    ->add('text-zinc-500 data-active:bg-zinc-100 dark:text-zinc-300 dark:data-active:bg-zinc-600')
    ;
?>

<ui-empty <?php echo e($attributes->class($classes)); ?>>
    <?php echo e($slot); ?>

</ui-empty>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux-pro\src/../stubs/resources/views/flux/select/empty.blade.php ENDPATH**/ ?>