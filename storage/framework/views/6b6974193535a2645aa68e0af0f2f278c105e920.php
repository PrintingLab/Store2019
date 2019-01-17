<?php $__env->startSection('title', 'Sign Up for an Account'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="auth-pages">
        <div>
            <?php if(session()->has('success_message')): ?>
            <div class="alert alert-success">
                <?php echo e(session()->get('success_message')); ?>

            </div>
            <?php endif; ?> <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
            <h2>Create Account</h2>
            <div class="spacer"></div>

            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo e(csrf_field()); ?>


                <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" placeholder="Name" required autofocus>

                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email" required>

                <input id="password" type="password" class="form-control" name="password" placeholder="Password" placeholder="Password" required>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"
                    required>
                    <div class="form-group">
                        <input placeholder="Address" type="text" class="form-control" id="address" name="address" value="<?php echo e(old('address')); ?>" required>
                    </div>

                    <div class="half-form"> 
                        <div class="form-group">
                            <input placeholder="City" type="text" class="form-control" id="city" name="city" value="<?php echo e(old('city')); ?>" ng-model="city"  required>
                        </div>
                        <div class="form-group">
                            <input placeholder="Province" type="text" class="form-control" id="province" name="province" value="<?php echo e(old('province')); ?>"   required>
                        </div>
                    </div> 
                    <div class="half-form">
                        <div class="form-group">
                            <input placeholder="Postal Code" type="text" class="form-control" id="postalcode" name="postalcode" value="<?php echo e(old('postalcode')); ?>"  required>
                        </div>
                        <div class="form-group">
                            <input placeholder="Phone" type="text" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" required>
                        </div>

                        </div>
                <div class="login-container">
                    <button type="submit" class="auth-button">Create Account</button>
                    <div class="already-have-container">
                        <p><strong>Already have an account?</strong></p>
                        <a href="<?php echo e(route('login')); ?>">Login</a>
                    </div>
                </div>

            </form>
        </div>

        <div class="auth-right">
            <h2>New Customer</h2>
            <div class="spacer"></div>
            <p><strong>Save time now.</strong></p>
            <p>Creating an account will allow you to checkout faster in the future, have easy access to order history and customize your experience to suit your preferences.</p>

            &nbsp;
            <div class="spacer"></div>
            <p><strong>Loyalty Program</strong></p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt debitis, amet magnam accusamus nisi distinctio eveniet ullam. Facere, cumque architecto.</p>
        </div>
    </div> <!-- end auth-pages -->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>