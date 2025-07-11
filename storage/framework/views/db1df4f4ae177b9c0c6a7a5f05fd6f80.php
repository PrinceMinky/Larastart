<?php if (isset($component)) { $__componentOriginal8538230192bdc6213dcd99f7b3693ed1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8538230192bdc6213dcd99f7b3693ed1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort.item','data' => ['key' => $column['id']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column['id'])]); ?>
    <div class="rounded-lg w-80 max-w-80 bg-zinc-400/5 dark:bg-zinc-900">
        <div class="px-4 py-4 flex justify-between items-start">
            <div>
                <?php if (isset($component)) { $__componentOriginale0fd5b6a0986beffac17a0a103dfd7b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0fd5b6a0986beffac17a0a103dfd7b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::heading','data' => ['class' => 'flex gap-2 items-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex gap-2 items-center']); ?>
                    <?php if (isset($component)) { $__componentOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort.handle','data' => ['permissions' => ['edit kanban boards']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort.handle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permissions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['edit kanban boards'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42)): ?>
<?php $attributes = $__attributesOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42; ?>
<?php unset($__attributesOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42)): ?>
<?php $component = $__componentOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42; ?>
<?php unset($__componentOriginalc7ab7a1bb0e0b6b0202a77169cd5eb42); ?>
<?php endif; ?>
                    <?php echo e($column['title']); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0fd5b6a0986beffac17a0a103dfd7b9)): ?>
<?php $attributes = $__attributesOriginale0fd5b6a0986beffac17a0a103dfd7b9; ?>
<?php unset($__attributesOriginale0fd5b6a0986beffac17a0a103dfd7b9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0fd5b6a0986beffac17a0a103dfd7b9)): ?>
<?php $component = $__componentOriginale0fd5b6a0986beffac17a0a103dfd7b9; ?>
<?php unset($__componentOriginale0fd5b6a0986beffac17a0a103dfd7b9); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal43e8c568bbb8b06b9124aad3ccf4ec97 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e8c568bbb8b06b9124aad3ccf4ec97 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::subheading','data' => ['class' => 'mb-0!']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::subheading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-0!']); ?><?php echo e(count($column['cards'])); ?> tasks <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43e8c568bbb8b06b9124aad3ccf4ec97)): ?>
<?php $attributes = $__attributesOriginal43e8c568bbb8b06b9124aad3ccf4ec97; ?>
<?php unset($__attributesOriginal43e8c568bbb8b06b9124aad3ccf4ec97); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43e8c568bbb8b06b9124aad3ccf4ec97)): ?>
<?php $component = $__componentOriginal43e8c568bbb8b06b9124aad3ccf4ec97; ?>
<?php unset($__componentOriginal43e8c568bbb8b06b9124aad3ccf4ec97); ?>
<?php endif; ?>
            </div>

            <?php if (isset($component)) { $__componentOriginal7fe345ac6d0eda9f483f4987968b8d53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7fe345ac6d0eda9f483f4987968b8d53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.kanban-board.column-actions','data' => ['column' => $column]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.kanban-board.column-actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7fe345ac6d0eda9f483f4987968b8d53)): ?>
<?php $attributes = $__attributesOriginal7fe345ac6d0eda9f483f4987968b8d53; ?>
<?php unset($__attributesOriginal7fe345ac6d0eda9f483f4987968b8d53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7fe345ac6d0eda9f483f4987968b8d53)): ?>
<?php $component = $__componentOriginal7fe345ac6d0eda9f483f4987968b8d53; ?>
<?php unset($__componentOriginal7fe345ac6d0eda9f483f4987968b8d53); ?>
<?php endif; ?>
        </div>

        <!-- CARD SORTING -->
        <?php if (isset($component)) { $__componentOriginal6a44cb87e86b7d587c0ef29d28e1a20e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a44cb87e86b7d587c0ef29d28e1a20e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sort.index','data' => ['class' => 'relative flex flex-col gap-2 px-2','group' => 'cards','handle' => 'updateCardPosition','permissions' => 'edit kanban cards','key' => $column['id']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sort'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'relative flex flex-col gap-2 px-2','group' => 'cards','handle' => 'updateCardPosition','permissions' => 'edit kanban cards','key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column['id'])]); ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $column['cards']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginale5a334b68148055e9396f48e4f28ffd4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5a334b68148055e9396f48e4f28ffd4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.kanban-board.card','data' => ['sortable' => true,'actions' => true,'card' => $card]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.kanban-board.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['sortable' => true,'actions' => true,'card' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($card)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5a334b68148055e9396f48e4f28ffd4)): ?>
<?php $attributes = $__attributesOriginale5a334b68148055e9396f48e4f28ffd4; ?>
<?php unset($__attributesOriginale5a334b68148055e9396f48e4f28ffd4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5a334b68148055e9396f48e4f28ffd4)): ?>
<?php $component = $__componentOriginale5a334b68148055e9396f48e4f28ffd4; ?>
<?php unset($__componentOriginale5a334b68148055e9396f48e4f28ffd4); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a44cb87e86b7d587c0ef29d28e1a20e)): ?>
<?php $attributes = $__attributesOriginal6a44cb87e86b7d587c0ef29d28e1a20e; ?>
<?php unset($__attributesOriginal6a44cb87e86b7d587c0ef29d28e1a20e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a44cb87e86b7d587c0ef29d28e1a20e)): ?>
<?php $component = $__componentOriginal6a44cb87e86b7d587c0ef29d28e1a20e; ?>
<?php unset($__componentOriginal6a44cb87e86b7d587c0ef29d28e1a20e); ?>
<?php endif; ?>

        <div class="px-2 py-2">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create kanban cards')): ?>
            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['wire:click' => 'showCreateCardForm('.e($column['id']).')','variant' => 'subtle','icon' => 'plus','size' => 'sm','class' => 'w-full justify-start! mt-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'showCreateCardForm('.e($column['id']).')','variant' => 'subtle','icon' => 'plus','size' => 'sm','class' => 'w-full justify-start! mt-1']); ?>
                Add Task
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
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8538230192bdc6213dcd99f7b3693ed1)): ?>
<?php $attributes = $__attributesOriginal8538230192bdc6213dcd99f7b3693ed1; ?>
<?php unset($__attributesOriginal8538230192bdc6213dcd99f7b3693ed1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8538230192bdc6213dcd99f7b3693ed1)): ?>
<?php $component = $__componentOriginal8538230192bdc6213dcd99f7b3693ed1; ?>
<?php unset($__componentOriginal8538230192bdc6213dcd99f7b3693ed1); ?>
<?php endif; ?><?php /**PATH C:\Users\micha\Herd\larastart\resources\views/components/admin/kanban-board/column.blade.php ENDPATH**/ ?>