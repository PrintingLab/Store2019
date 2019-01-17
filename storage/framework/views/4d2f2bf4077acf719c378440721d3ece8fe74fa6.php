<ul>
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($menu_item->title === 'Follows:'): ?>
            <li><?php echo e($menu_item->title); ?></li>
        <?php endif; ?>
        <li><a href="<?php echo e($menu_item->link()); ?>"><i class="fa <?php echo e($menu_item->title); ?>"></i></a></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
