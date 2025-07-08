<section>
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Left Pane (profile picture, name etc) -->
        <?php if (isset($component)) { $__componentOriginal820370cd440ccfdbc9e56689938ffa40 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal820370cd440ccfdbc9e56689938ffa40 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-profile.user-information','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-profile.user-information'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal820370cd440ccfdbc9e56689938ffa40)): ?>
<?php $attributes = $__attributesOriginal820370cd440ccfdbc9e56689938ffa40; ?>
<?php unset($__attributesOriginal820370cd440ccfdbc9e56689938ffa40); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal820370cd440ccfdbc9e56689938ffa40)): ?>
<?php $component = $__componentOriginal820370cd440ccfdbc9e56689938ffa40; ?>
<?php unset($__componentOriginal820370cd440ccfdbc9e56689938ffa40); ?>
<?php endif; ?>

        <!-- Right Pane (posts etc) -->
        <div class="w-full md:w-3/4">
            <?php if(Auth::user()->hasAccessToUser($this->user) && $this->isBlocked === false): ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('user-post', ['userId' => $user->id]);

$__html = app('livewire')->mount($__name, $__params, 'lw-66908125-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif(Auth::user()->hasAccessToUser($this->user) && $this->isBlocked === true): ?>
                <?php if (isset($component)) { $__componentOriginale42bb3b2fa6677ca35fe243b74094c7d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale42bb3b2fa6677ca35fe243b74094c7d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-profile.blocked','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-profile.blocked'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale42bb3b2fa6677ca35fe243b74094c7d)): ?>
<?php $attributes = $__attributesOriginale42bb3b2fa6677ca35fe243b74094c7d; ?>
<?php unset($__attributesOriginale42bb3b2fa6677ca35fe243b74094c7d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale42bb3b2fa6677ca35fe243b74094c7d)): ?>
<?php $component = $__componentOriginale42bb3b2fa6677ca35fe243b74094c7d; ?>
<?php unset($__componentOriginale42bb3b2fa6677ca35fe243b74094c7d); ?>
<?php endif; ?>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal00ebbd91ce8537898aa962db3e8ab776 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal00ebbd91ce8537898aa962db3e8ab776 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-profile.private','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-profile.private'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal00ebbd91ce8537898aa962db3e8ab776)): ?>
<?php $attributes = $__attributesOriginal00ebbd91ce8537898aa962db3e8ab776; ?>
<?php unset($__attributesOriginal00ebbd91ce8537898aa962db3e8ab776); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal00ebbd91ce8537898aa962db3e8ab776)): ?>
<?php $component = $__componentOriginal00ebbd91ce8537898aa962db3e8ab776; ?>
<?php unset($__componentOriginal00ebbd91ce8537898aa962db3e8ab776); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\livewire\user-profile\index.blade.php ENDPATH**/ ?>