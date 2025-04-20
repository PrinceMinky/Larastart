<div>
    <!-- Post Form -->
    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->id === $this->user->id): ?>
        <div class="mb-4">
        <?php if (isset($component)) { $__componentOriginal0ee30026125d1a66523211147b00e4dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0ee30026125d1a66523211147b00e4dc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::textarea','data' => ['xData' => '{shiftPressed: false}','@keydown.enter.prevent' => '
                if (shiftPressed) {
                    $event.target.value += \'\n\'; // Allows Shift + Enter to add a new line
                } else {
                    $wire.post();
                }
            ','@keydown.shift' => 'shiftPressed = true','@keyup.shift' => 'shiftPressed = false','wire:model' => 'status','type' => 'text','class' => 'w-full','placeholder' => 'What are you up to?','rows' => 'auto','resize' => 'none','wire:loading.class' => 'opacity-50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-data' => '{shiftPressed: false}','@keydown.enter.prevent' => '
                if (shiftPressed) {
                    $event.target.value += \'\n\'; // Allows Shift + Enter to add a new line
                } else {
                    $wire.post();
                }
            ','@keydown.shift' => 'shiftPressed = true','@keyup.shift' => 'shiftPressed = false','wire:model' => 'status','type' => 'text','class' => 'w-full','placeholder' => 'What are you up to?','rows' => 'auto','resize' => 'none','wire:loading.class' => 'opacity-50']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0ee30026125d1a66523211147b00e4dc)): ?>
<?php $attributes = $__attributesOriginal0ee30026125d1a66523211147b00e4dc; ?>
<?php unset($__attributesOriginal0ee30026125d1a66523211147b00e4dc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0ee30026125d1a66523211147b00e4dc)): ?>
<?php $component = $__componentOriginal0ee30026125d1a66523211147b00e4dc; ?>
<?php unset($__componentOriginal0ee30026125d1a66523211147b00e4dc); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal5730b1630871592dc0d77210545c88c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5730b1630871592dc0d77210545c88c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::error','data' => ['name' => 'status']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'status']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5730b1630871592dc0d77210545c88c1)): ?>
<?php $attributes = $__attributesOriginal5730b1630871592dc0d77210545c88c1; ?>
<?php unset($__attributesOriginal5730b1630871592dc0d77210545c88c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5730b1630871592dc0d77210545c88c1)): ?>
<?php $component = $__componentOriginal5730b1630871592dc0d77210545c88c1; ?>
<?php unset($__componentOriginal5730b1630871592dc0d77210545c88c1); ?>
<?php endif; ?>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\Users\micha\Herd\larastart\resources\views/components/user-profile/status-form.blade.php ENDPATH**/ ?>