<section>
    <!-- Display Heading -->
    <?php if (isset($component)) { $__componentOriginal8026f1991abb42645b4d7cc7ace47942 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8026f1991abb42645b4d7cc7ace47942 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('heading', null, []); ?> <?php echo e(__('Permissions')); ?> <?php $__env->endSlot(); ?>
         <?php $__env->slot('subheading', null, []); ?> <?php echo e(__('Permissions that are assigned to use groups.')); ?> <?php $__env->endSlot(); ?>

         <?php $__env->slot('actions', null, []); ?> 
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create permissions')): ?>
            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['wire:click' => 'showForm','wire:target' => 'showForm','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'showForm','wire:target' => 'showForm','variant' => 'primary']); ?>Add Permission <?php echo $__env->renderComponent(); ?>
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
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8026f1991abb42645b4d7cc7ace47942)): ?>
<?php $attributes = $__attributesOriginal8026f1991abb42645b4d7cc7ace47942; ?>
<?php unset($__attributesOriginal8026f1991abb42645b4d7cc7ace47942); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8026f1991abb42645b4d7cc7ace47942)): ?>
<?php $component = $__componentOriginal8026f1991abb42645b4d7cc7ace47942; ?>
<?php unset($__componentOriginal8026f1991abb42645b4d7cc7ace47942); ?>
<?php endif; ?>

    <!-- Search/Filters and Actions -->
    <div class="flex gap-2">
        <div class="w-2/4">
            <?php if (isset($component)) { $__componentOriginal2a7bc1485821b9ab3a3500d7b186ebe2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a7bc1485821b9ab3a3500d7b186ebe2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.user-management.permissions.search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.user-management.permissions.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a7bc1485821b9ab3a3500d7b186ebe2)): ?>
<?php $attributes = $__attributesOriginal2a7bc1485821b9ab3a3500d7b186ebe2; ?>
<?php unset($__attributesOriginal2a7bc1485821b9ab3a3500d7b186ebe2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a7bc1485821b9ab3a3500d7b186ebe2)): ?>
<?php $component = $__componentOriginal2a7bc1485821b9ab3a3500d7b186ebe2; ?>
<?php unset($__componentOriginal2a7bc1485821b9ab3a3500d7b186ebe2); ?>
<?php endif; ?>
        </div>

        <?php if (isset($component)) { $__componentOriginal4a4f7aa062a095c651c2f80bb685a42a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4a4f7aa062a095c651c2f80bb685a42a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::spacer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::spacer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4a4f7aa062a095c651c2f80bb685a42a)): ?>
<?php $attributes = $__attributesOriginal4a4f7aa062a095c651c2f80bb685a42a; ?>
<?php unset($__attributesOriginal4a4f7aa062a095c651c2f80bb685a42a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4a4f7aa062a095c651c2f80bb685a42a)): ?>
<?php $component = $__componentOriginal4a4f7aa062a095c651c2f80bb685a42a; ?>
<?php unset($__componentOriginal4a4f7aa062a095c651c2f80bb685a42a); ?>
<?php endif; ?>
        
        <div class="flex gap-2">
            <?php if (isset($component)) { $__componentOriginal6893be50e1bda36745e66e27df623c4d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6893be50e1bda36745e66e27df623c4d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.user-management.permissions.multiple-actions','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.user-management.permissions.multiple-actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6893be50e1bda36745e66e27df623c4d)): ?>
<?php $attributes = $__attributesOriginal6893be50e1bda36745e66e27df623c4d; ?>
<?php unset($__attributesOriginal6893be50e1bda36745e66e27df623c4d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6893be50e1bda36745e66e27df623c4d)): ?>
<?php $component = $__componentOriginal6893be50e1bda36745e66e27df623c4d; ?>
<?php unset($__componentOriginal6893be50e1bda36745e66e27df623c4d); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginala2064dd5457041afc2933386037ba160 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2064dd5457041afc2933386037ba160 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.user-management.permissions.export-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.user-management.permissions.export-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2064dd5457041afc2933386037ba160)): ?>
<?php $attributes = $__attributesOriginala2064dd5457041afc2933386037ba160; ?>
<?php unset($__attributesOriginala2064dd5457041afc2933386037ba160); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2064dd5457041afc2933386037ba160)): ?>
<?php $component = $__componentOriginala2064dd5457041afc2933386037ba160; ?>
<?php unset($__componentOriginala2064dd5457041afc2933386037ba160); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Show Permissions Table -->
    <div class="relative">
        <?php if (isset($component)) { $__componentOriginal3969065b33d8f849854f52e7f2dcea0a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3969065b33d8f849854f52e7f2dcea0a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::checkbox.group.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::checkbox.group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php if (isset($component)) { $__componentOriginal0a72bb2009468dece2d4608a050e87ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a72bb2009468dece2d4608a050e87ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.index','data' => ['paginate' => $this->permissions,'class' => 'mt-3','wire:loading.class' => 'opacity-50','wire:target' => 'create,update,delete,deleteSelected,search,sort']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->permissions),'class' => 'mt-3','wire:loading.class' => 'opacity-50','wire:target' => 'create,update,delete,deleteSelected,search,sort']); ?>
            <?php if (isset($component)) { $__componentOriginal3f77032fa33cb52b5796e07e933bec29 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f77032fa33cb52b5796e07e933bec29 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.columns','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.columns'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete permissions')): ?>
                <?php if (isset($component)) { $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.column','data' => ['class' => 'w-0 overflow-hidden p-0 m-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-0 overflow-hidden p-0 m-0']); ?>
                    <?php if($this->permissions->count() != 0): ?>
                        <?php if (isset($component)) { $__componentOriginal56d1ee5891d66f2938e3231b69d1ee2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56d1ee5891d66f2938e3231b69d1ee2c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::checkbox.all','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::checkbox.all'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56d1ee5891d66f2938e3231b69d1ee2c)): ?>
<?php $attributes = $__attributesOriginal56d1ee5891d66f2938e3231b69d1ee2c; ?>
<?php unset($__attributesOriginal56d1ee5891d66f2938e3231b69d1ee2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56d1ee5891d66f2938e3231b69d1ee2c)): ?>
<?php $component = $__componentOriginal56d1ee5891d66f2938e3231b69d1ee2c; ?>
<?php unset($__componentOriginal56d1ee5891d66f2938e3231b69d1ee2c); ?>
<?php endif; ?>
                    <?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $attributes = $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $component = $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
                <?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.column','data' => ['sortable' => true,'sorted' => $sortBy === 'name','direction' => $sortDirection,'wire:click' => 'sort(\'name\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['sortable' => true,'sorted' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sortBy === 'name'),'direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sortDirection),'wire:click' => 'sort(\'name\')']); ?>Name <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $attributes = $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $component = $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.column','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $attributes = $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $component = $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f77032fa33cb52b5796e07e933bec29)): ?>
<?php $attributes = $__attributesOriginal3f77032fa33cb52b5796e07e933bec29; ?>
<?php unset($__attributesOriginal3f77032fa33cb52b5796e07e933bec29); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f77032fa33cb52b5796e07e933bec29)): ?>
<?php $component = $__componentOriginal3f77032fa33cb52b5796e07e933bec29; ?>
<?php unset($__componentOriginal3f77032fa33cb52b5796e07e933bec29); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal85e16a75e372f4e3a67a9194622e1c8c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal85e16a75e372f4e3a67a9194622e1c8c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.rows','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.rows'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <?php $__empty_1 = true; $__currentLoopData = $this->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginal86eadb0706b70e528f7e6a1e76ec4ac7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86eadb0706b70e528f7e6a1e76ec4ac7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.user-management.permissions.row','data' => ['permission' => $permission]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.user-management.permissions.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($permission)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal86eadb0706b70e528f7e6a1e76ec4ac7)): ?>
<?php $attributes = $__attributesOriginal86eadb0706b70e528f7e6a1e76ec4ac7; ?>
<?php unset($__attributesOriginal86eadb0706b70e528f7e6a1e76ec4ac7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal86eadb0706b70e528f7e6a1e76ec4ac7)): ?>
<?php $component = $__componentOriginal86eadb0706b70e528f7e6a1e76ec4ac7; ?>
<?php unset($__componentOriginal86eadb0706b70e528f7e6a1e76ec4ac7); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if (isset($component)) { $__componentOriginal2133c30832e0f094522523cf64171420 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2133c30832e0f094522523cf64171420 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.row','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginal57d943fde8fc41daddcb4b24245801cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57d943fde8fc41daddcb4b24245801cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.cell','data' => ['colspan' => '3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => '3']); ?>No permissions added. <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $attributes = $__attributesOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $component = $__componentOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__componentOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2133c30832e0f094522523cf64171420)): ?>
<?php $attributes = $__attributesOriginal2133c30832e0f094522523cf64171420; ?>
<?php unset($__attributesOriginal2133c30832e0f094522523cf64171420); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2133c30832e0f094522523cf64171420)): ?>
<?php $component = $__componentOriginal2133c30832e0f094522523cf64171420; ?>
<?php unset($__componentOriginal2133c30832e0f094522523cf64171420); ?>
<?php endif; ?>
                <?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal85e16a75e372f4e3a67a9194622e1c8c)): ?>
<?php $attributes = $__attributesOriginal85e16a75e372f4e3a67a9194622e1c8c; ?>
<?php unset($__attributesOriginal85e16a75e372f4e3a67a9194622e1c8c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal85e16a75e372f4e3a67a9194622e1c8c)): ?>
<?php $component = $__componentOriginal85e16a75e372f4e3a67a9194622e1c8c; ?>
<?php unset($__componentOriginal85e16a75e372f4e3a67a9194622e1c8c); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0a72bb2009468dece2d4608a050e87ba)): ?>
<?php $attributes = $__attributesOriginal0a72bb2009468dece2d4608a050e87ba; ?>
<?php unset($__attributesOriginal0a72bb2009468dece2d4608a050e87ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0a72bb2009468dece2d4608a050e87ba)): ?>
<?php $component = $__componentOriginal0a72bb2009468dece2d4608a050e87ba; ?>
<?php unset($__componentOriginal0a72bb2009468dece2d4608a050e87ba); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3969065b33d8f849854f52e7f2dcea0a)): ?>
<?php $attributes = $__attributesOriginal3969065b33d8f849854f52e7f2dcea0a; ?>
<?php unset($__attributesOriginal3969065b33d8f849854f52e7f2dcea0a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3969065b33d8f849854f52e7f2dcea0a)): ?>
<?php $component = $__componentOriginal3969065b33d8f849854f52e7f2dcea0a; ?>
<?php unset($__componentOriginal3969065b33d8f849854f52e7f2dcea0a); ?>
<?php endif; ?>
        
        <div class="absolute inset-0 flex" wire:loading wire:target="create,update,delete,deleteSelected,search,sort">
            <?php if (isset($component)) { $__componentOriginalb06f0c5905a9427a630c5e299af7ce46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb06f0c5905a9427a630c5e299af7ce46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.loading','data' => ['class' => 'size-12 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-12 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb06f0c5905a9427a630c5e299af7ce46)): ?>
<?php $attributes = $__attributesOriginalb06f0c5905a9427a630c5e299af7ce46; ?>
<?php unset($__attributesOriginalb06f0c5905a9427a630c5e299af7ce46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb06f0c5905a9427a630c5e299af7ce46)): ?>
<?php $component = $__componentOriginalb06f0c5905a9427a630c5e299af7ce46; ?>
<?php unset($__componentOriginalb06f0c5905a9427a630c5e299af7ce46); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Add/Edit Permission Form -->
    <?php if (isset($component)) { $__componentOriginale1e6f9e324cad6c37ea7367355c71bc5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale1e6f9e324cad6c37ea7367355c71bc5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.user-management.permissions.form-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.user-management.permissions.form-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale1e6f9e324cad6c37ea7367355c71bc5)): ?>
<?php $attributes = $__attributesOriginale1e6f9e324cad6c37ea7367355c71bc5; ?>
<?php unset($__attributesOriginale1e6f9e324cad6c37ea7367355c71bc5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale1e6f9e324cad6c37ea7367355c71bc5)): ?>
<?php $component = $__componentOriginale1e6f9e324cad6c37ea7367355c71bc5; ?>
<?php unset($__componentOriginale1e6f9e324cad6c37ea7367355c71bc5); ?>
<?php endif; ?>

    <!-- Delete Permission Modal -->
    <?php if (isset($component)) { $__componentOriginal14f3aebe2b288d8fb257d0c087ca5a38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal14f3aebe2b288d8fb257d0c087ca5a38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.user-management.permissions.delete-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.user-management.permissions.delete-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal14f3aebe2b288d8fb257d0c087ca5a38)): ?>
<?php $attributes = $__attributesOriginal14f3aebe2b288d8fb257d0c087ca5a38; ?>
<?php unset($__attributesOriginal14f3aebe2b288d8fb257d0c087ca5a38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal14f3aebe2b288d8fb257d0c087ca5a38)): ?>
<?php $component = $__componentOriginal14f3aebe2b288d8fb257d0c087ca5a38; ?>
<?php unset($__componentOriginal14f3aebe2b288d8fb257d0c087ca5a38); ?>
<?php endif; ?>
</section><?php /**PATH C:\Users\micha\Herd\larastart\resources\views\livewire\admin\user-management\permissions.blade.php ENDPATH**/ ?>