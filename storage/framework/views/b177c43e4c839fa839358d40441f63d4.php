
<?php
$classes = Flux::classes()
    ->add('flex isolate')
    ->add('*:not-first:-ml-2 **:ring-white **:dark:ring-zinc-900')
    ->add('**:data-[slot=avatar]:ring-4 **:data-[slot=avatar]:data-[size=sm]:ring-2 **:data-[slot=avatar]:data-[size=xs]:ring-2')
    ;
?>

<div <?php echo e($attributes->class($classes)); ?>>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\Users\micha\Herd\larastart\vendor\livewire\flux\src/../stubs/resources/views/flux/avatar/group.blade.php ENDPATH**/ ?>