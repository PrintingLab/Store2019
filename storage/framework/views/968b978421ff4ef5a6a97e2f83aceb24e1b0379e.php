<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('extra-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/algolia.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumbs'); ?>
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Profile</span>
    <?php echo $__env->renderComponent(); ?>

    <div class="container">
        <?php if(session()->has('success_message')): ?>
            <div class="alert alert-success">
                <?php echo e(session()->get('success_message')); ?>

            </div>
        <?php endif; ?>

        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <div class="products-section container">
        <div class="sidebar">

            <ul>
              <li class="active"><a href="<?php echo e(route('users.edit')); ?>">My Profile</a></li>
              <li><a href="<?php echo e(route('orders.index')); ?>">My Orders</a></li>
            </ul>
        </div> <!-- end sidebar -->
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">My Profile</h1>
            </div>

            <div>
                <form action="<?php echo e(route('users.update')); ?>" method="POST">
                    <?php echo method_field('patch'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="formInputProfile">
                        <input id="name" type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" placeholder="Name" required>
                    </div>
                    <div class="formInputProfile">
                        <input id="email" type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" placeholder="Email" required>
                    </div>
                    <div class="formInputProfile">
                        <input id="password" type="password" name="password" placeholder="Password">
                        <div>Leave password blank to keep current password</div>
                    </div>
                    <div class="formInputProfile">
                        <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password">
                    </div>
                    <div>
                        <button type="submit" class="my-profile-button">Update Profile</button>
                    </div>
                </form>
            </div>

            <div class="spacer"></div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="<?php echo e(asset('js/algolia.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>