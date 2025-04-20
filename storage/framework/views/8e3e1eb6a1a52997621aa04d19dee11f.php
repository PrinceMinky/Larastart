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
            <?php if (isset($component)) { $__componentOriginal4dcea768e73c6796883ebe70654d79e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4dcea768e73c6796883ebe70654d79e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-profile.status-form','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-profile.status-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4dcea768e73c6796883ebe70654d79e1)): ?>
<?php $attributes = $__attributesOriginal4dcea768e73c6796883ebe70654d79e1; ?>
<?php unset($__attributesOriginal4dcea768e73c6796883ebe70654d79e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4dcea768e73c6796883ebe70654d79e1)): ?>
<?php $component = $__componentOriginal4dcea768e73c6796883ebe70654d79e1; ?>
<?php unset($__componentOriginal4dcea768e73c6796883ebe70654d79e1); ?>
<?php endif; ?>

            <!-- Show Posts -->
            <!--[if BLOCK]><![endif]--><?php if(auth()->user()->hasAccessToUser($this->user, 'view users')): ?>
            <div class="flex flex-col gap-2">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $this->posts(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginala13bf1da599e542c00963de35b9209a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala13bf1da599e542c00963de35b9209a4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-profile.post','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-profile.post'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala13bf1da599e542c00963de35b9209a4)): ?>
<?php $attributes = $__attributesOriginala13bf1da599e542c00963de35b9209a4; ?>
<?php unset($__attributesOriginala13bf1da599e542c00963de35b9209a4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala13bf1da599e542c00963de35b9209a4)): ?>
<?php $component = $__componentOriginala13bf1da599e542c00963de35b9209a4; ?>
<?php unset($__componentOriginala13bf1da599e542c00963de35b9209a4); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if(auth()->user()->id === $this->user->id): ?>
                        <?php if (isset($component)) { $__componentOriginal0638ebfbd490c7a414275d493e14cb4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0638ebfbd490c7a414275d493e14cb4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::text','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>You have not posted before. Post something! <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0638ebfbd490c7a414275d493e14cb4e)): ?>
<?php $attributes = $__attributesOriginal0638ebfbd490c7a414275d493e14cb4e; ?>
<?php unset($__attributesOriginal0638ebfbd490c7a414275d493e14cb4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0638ebfbd490c7a414275d493e14cb4e)): ?>
<?php $component = $__componentOriginal0638ebfbd490c7a414275d493e14cb4e; ?>
<?php unset($__componentOriginal0638ebfbd490c7a414275d493e14cb4e); ?>
<?php endif; ?>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginal0638ebfbd490c7a414275d493e14cb4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0638ebfbd490c7a414275d493e14cb4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::text','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>User has not posted before. <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0638ebfbd490c7a414275d493e14cb4e)): ?>
<?php $attributes = $__attributesOriginal0638ebfbd490c7a414275d493e14cb4e; ?>
<?php unset($__attributesOriginal0638ebfbd490c7a414275d493e14cb4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0638ebfbd490c7a414275d493e14cb4e)): ?>
<?php $component = $__componentOriginal0638ebfbd490c7a414275d493e14cb4e; ?>
<?php unset($__componentOriginal0638ebfbd490c7a414275d493e14cb4e); ?>
<?php endif; ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
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
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</section><?php /**PATH C:\Users\micha\Herd\larastart\resources\views/livewire/user-profile/index.blade.php ENDPATH**/ ?>