<?php $__env->startSection('title', 'Shopping Cart'); ?>

<?php $__env->startSection('extra-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/algolia.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumbs'); ?>
<a href="#">Home</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>Shopping Cart</span>
<?php echo $__env->renderComponent(); ?>

<div class="container">
  <div>
    <?php if(session()->has('success_message')): ?>
    <div class="alert alert-success containerAlerts">
      <?php echo e(session()->get('success_message')); ?>

    </div>
    <?php endif; ?>
    <?php if(count($errors) > 0): ?>
    <div class="alert alert-danger containerAlerts">
      <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <?php endif; ?>



    <!--  carro real-->


    <?php if(Cart::count() > 0): ?>

    <h2><?php echo e(Cart::count()); ?> item(s) in Shopping Cart</h2>
    <div class="col-md-12">
      <?php $__currentLoopData = Cart::content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="row productRow">
        <div class="col-md-4">
          <?php if($item->options->side=='4/4'): ?>
          <div class="row">
            <div class="col-6 col-sm-6 col-md-6">
              <?php if((extensioImg($item->options->imgF) =='jpg')||(extensioImg($item->options->imgF) =='png')): ?>
              <label for="">Front</label>
              <img src="storage/Userfiles/<?php echo e($item->options->imgF); ?>" alt="item" class="cart-table-img">
              <?php else: ?>
              <label for="">Front</label>
              <embed src="storage/Userfiles/<?php echo e($item->options->imgF); ?>" type="application/pdf"   height="100%" width="100%">
                <?php endif; ?>
              </div>
              <div class="col-6 col-sm-6 col-md-6">
                <?php if((extensioImg($item->options->imgB) =='jpg')||(extensioImg($item->options->imgB) =='png')): ?>
                <label for="">Back</label>
                <img src="storage/Userfiles/<?php echo e($item->options->imgB); ?>" alt="item" class="cart-table-img">
                <?php else: ?>
                <label for="">Back</label>
                <embed src="storage/Userfiles/<?php echo e($item->options->imgB); ?>" type="application/pdf"   height="100%" width="100%">
                  <?php endif; ?>
                </div>
              </div>
              <?php else: ?>
              <div class="col-md-12">
                <?php if((extensioImg($item->options->imgF) =='jpg')||(extensioImg($item->options->imgF) =='png')): ?>
                <label for="">Front</label>
                <img src="storage/Userfiles/<?php echo e($item->options->imgF); ?>" alt="item" class="cart-table-img">
                <?php else: ?>
                <label for="">Front</label>
                <embed src="storage/Userfiles/<?php echo e($item->options->imgF); ?>" type="application/pdf"   height="100%" width="100%">
                  <?php endif; ?>
                </div>
                <?php endif; ?>
              </div>
              <div class="col-sm-3 col-md-3">
                <div class="cart-table-item"><a href=""><strong><?php echo e($item->name); ?></strong></a></div>
                <div class="cart-table-description"><?php echo e($item->options->decription); ?></div>
              </div>
              <div class="col-sm-5 col-md-5 row">
                <div class="col-8 col-sm-8 col-md-8 cart-table-actions">
                  <div class="checkout-table-row-right">
                    <div class="checkout-table-quantity"> <strong>Quantity:</strong> <?php echo e($item->options->quantity); ?></div>
                    <div class="checkout-table-quantity"> <strong>Printed Side:</strong> <?php echo e(getPrintingsides($item->options->side)); ?></div>
                    <div class="checkout-table-quantity"> <strong>Turnaround:</strong> <?php echo e(getPrintingTime($item->options->tat)); ?></div>
                    <?php if($item->options->ProofingOption=='N/A'): ?>
                    <?php else: ?>
                    <div class="checkout-table-quantity"> <strong>Proofing:</strong> <?php echo e($item->options->ProofingOption); ?></div>
                    <?php endif; ?>
                  </div>
                  <!-- <form action="<?php echo e(route('cart.switchToSaveForLater', $item->rowId)); ?>" method="POST">
                  <?php echo e(csrf_field()); ?>

                  <button type="submit" class="cart-options">Save for Later</button>
                </form> -->
              </div>
              <div class="col-4 col-sm-4 col-md-4">
                <div class="productotalbold"><?php echo e(presentPrice($item->subtotal)); ?></div>
                <form action="<?php echo e(route('cart.destroy', $item->rowId)); ?>" method="POST">
                  <?php echo e(csrf_field()); ?>

                  <?php echo e(method_field('DELETE')); ?>

                  <button type="submit" class="btnDeleProduct">Remove</button>
                </form>
              </div>
            </div>
          </div> <!-- end cart-table-row -->
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div> <!-- end cart-table -->

        <?php if(! session()->has('coupon')): ?>

        <div class="containerCodeCart">
          <h3><strong>Have a Code?</strong></h3>
          <div class="have-code-container">
            <form action="<?php echo e(route('coupon.store')); ?>" method="POST">
              <?php echo e(csrf_field()); ?>

              <input type="text" name="coupon_code" id="coupon_code">
              <button type="submit" class="btn_CodeApply">Apply</button>
            </form>
          </div> <!-- end have-code-container -->
        </div>

        <?php endif; ?>


        <div class="containerPriceCart">


          <div class="col-md-12 row">

            <div class="col-md-2">
              <strong>Subtotal</strong> <br>
              <?php if(session()->has('coupon')): ?>
              Code (<?php echo e(session()->get('coupon')['name']); ?>)
              <form action="<?php echo e(route('coupon.destroy')); ?>" method="POST" style="display:block">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('delete')); ?>

                <button type="submit" style="font-size:14px;" >Remove</button>
              </form>
              <hr>
              New Subtotal <br>
              <?php endif; ?>
              <span class="cart-totals-total"><strong>Total</strong></span>
            </div>
            <div class="col-md-2">
              <?php echo e(presentPrice(Cart::subtotal())); ?> <br>
              <?php if(session()->has('coupon')): ?>
              -<?php echo e(presentPrice($discount)); ?> <br>&nbsp;<br>
              <hr>
              <?php echo e(presentPrice($newSubtotal)); ?> <br>
              <?php endif; ?>

              <span class="cart-totals-total totalbold"><?php echo e(presentPrice($newTotal)); ?></span>
            </div>
          </div>

          <div class="col-md-12 btnsShopping">
            <a href="<?php echo e(route('shop.index')); ?>" class="btn_Cshopping">Continue Shopping</a>
            <a href="<?php echo e(route('checkout.index')); ?>" class="btn_Pcheckout">Proceed to Checkout</a>
          </div>

        </div>



        <?php else: ?>
        <h3>No items in Cart!</h3>
        <div class="spacer"></div>
        <a href="<?php echo e(route('shop.index')); ?>" class="button">Continue Shopping</a>
        <div class="spacer"></div>

        <?php endif; ?>

        <?php if(Cart::instance('saveForLater')->count() > 0): ?>

        <h2><?php echo e(Cart::instance('saveForLater')->count()); ?> item(s) Saved For Later</h2>

        <div class="saved-for-later cart-table">
          <?php $__currentLoopData = Cart::instance('saveForLater')->content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="cart-table-row">
            <div class="cart-table-row-left">
              <a href="<?php echo e(route('shop.show', $item->model->slug)); ?>"><img src="<?php echo e(asset('img/products/'.$item->model->slug.'.jpg')); ?>" alt="item" class="cart-table-img"></a>
              <div class="cart-item-details">
                <div class="cart-table-item"><a href="<?php echo e(route('shop.show', $item->model->slug)); ?>"><?php echo e($item->model->name); ?></a></div>
                <div class="cart-table-description"><?php echo e($item->model->details); ?></div>
              </div>
            </div>
            <div class="cart-table-row-right">
              <div class="cart-table-actions">
                <form action="<?php echo e(route('saveForLater.destroy', $item->rowId)); ?>" method="POST">
                  <?php echo e(csrf_field()); ?>

                  <?php echo e(method_field('DELETE')); ?>


                  <button type="submit" class="cart-options">Remove</button>
                </form>

                <form action="<?php echo e(route('saveForLater.switchToCart', $item->rowId)); ?>" method="POST">
                  <?php echo e(csrf_field()); ?>


                  <button type="submit" class="cart-options">Move to Cart</button>
                </form>
              </div>

              <div><?php echo e($item->model->presentPrice()); ?></div>
            </div>
          </div> <!-- end cart-table-row -->
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div> <!-- end saved-for-later -->

        <?php else: ?>

        <!-- <h3>You have no items Saved for Later.</h3> -->

        <?php endif; ?>

      </div>

    </div> <!-- end cart-section -->

    <?php echo $__env->make('partials.might-like', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('extra-js'); ?>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
   <script src="<?php echo e(asset('js/cart.js')); ?>"></script>

    <script>
    (function(){
      const classname = document.querySelectorAll('.quantity')

      Array.from(classname).forEach(function(element) {
        element.addEventListener('change', function() {
          const id = element.getAttribute('data-id')
          const productQuantity = element.getAttribute('data-productQuantity')

          axios.patch(`/cart/${id}`, {
            quantity: this.value,
            productQuantity: productQuantity
          })
          .then(function (response) {
            // console.log(response);
            window.location.href = '<?php echo e(route('cart.index')); ?>'
          })
          .catch(function (error) {
            // console.log(error);
            window.location.href = '<?php echo e(route('cart.index')); ?>'
          });
        })
      })
    })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="<?php echo e(asset('js/algolia.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>