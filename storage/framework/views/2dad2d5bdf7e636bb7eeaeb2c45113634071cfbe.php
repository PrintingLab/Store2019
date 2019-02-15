
<div class="might-like-section">
    <div class="container">
        <h2>You might also like...</h2>
        <div class="might-like-grid productSection-Index center">
            <?php $__currentLoopData = $mightAlsoLike; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 col-sm-12 col-12" >
              <div class="btnHoverI"  style="border-top: 1px #e4e4e4 solid;border-right: 1px #e4e4e4 solid;border-left: 1px #e4e4e4 solid;width: 100%;height: 175px;background-size: cover;background-image: url('<?php echo e(productImage($product->image)); ?>');" >
                <div class="btn_info">
                  <a class="a_Shop" href="<?php echo e(route('shop.show', $product->slug)); ?>">SHOP NOW</a>
                </div>
              </div>
              <a href="<?php echo e(route('shop.show', $product->slug)); ?>"><div class="product-name"><?php echo e($product->name); ?></div></a>
              <div class="product-price">from <?php echo e($product->presentPrice()); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</div>

