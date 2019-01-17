<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('extra-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/algolia.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumbs'); ?>
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Orders</span>
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

    <div class="products-section my-orders container">
        <div class="sidebar">

            <ul>
              <li><a href="<?php echo e(route('users.edit')); ?>">My Profile</a></li>
              <li class="active"><a href="<?php echo e(route('orders.index')); ?>">My Orders</a></li>
            </ul>
        </div> <!-- end sidebar -->
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">My Orders</h1>
            </div>

            <div>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="order-container">
                    <div class="order-header">
                        <div class="order-header-items">
                            <div>
                                <div class="uppercase font-bold">Order Placed</div>
                                <div><?php echo e(presentDate($order->created_at)); ?></div>
                            </div>
                            <div>
                                <div class="uppercase font-bold">Order ID</div>
                                <div><?php echo e($order->id); ?></div>
                            </div><div>
                                <div class="uppercase font-bold">Total</div>
                                <div><?php echo e(presentPrice($order->billing_total)); ?></div>
                            </div>
                        </div>
                        <div>
                            <div class="order-header-items">
                                <div><a href="<?php echo e(route('orders.show', $order->id)); ?>">Order Details</a></div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="order-products">
                        <?php $__currentLoopData = $order->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="order-product-item">
                                <div><img src="storage/Userfiles/<?php echo e($product->pivot->imgF); ?>" alt="Product Image">
                                <?php if($product->pivot->side == '4/4' ): ?>
                                <img src="storage/Userfiles/<?php echo e($product->pivot->imgB); ?>" alt="Product Image">
                                <?php endif; ?>
                            </div>
                                <div>
                                    <div>
                                        <a href="<?php echo e(route('shop.show', $product->slug)); ?>"><?php echo e($product->name); ?></a>
                                    </div>
                                    <div><?php echo e($product->pivot->product_decription); ?></div>
                                    <div>Quantity: <?php echo e($product->pivot->quantity); ?></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div> <!-- end order-container -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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