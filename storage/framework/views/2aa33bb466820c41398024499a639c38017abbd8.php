<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('extra-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/algolia.css')); ?>">
<script type="text/javascript" src="<?php echo asset('js/jquery-3.3.1.min.js'); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


<div class="container ">
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


<div class="container containerGeneral" >
  <div class="row">
    <div class="col-md-3 haderPc">
      <div class="Div_allproduct">
        <span><strong>BROWSE PRODUCT</strong></span>
      </div>
      <div class="Div_allproduct2">
        <ul class="list_dropdown">
          <li><strong>MARKETING PRODUCTS</strong></li>
          <li><a href="<?php echo e(route('shop.index', ['category' => 'Business Cards'])); ?>">Business Cards</a></li>
          <?php $__currentLoopData = $Allproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><a href="<?php echo e(route('shop.show', $produc->slug)); ?>"><?php echo e($produc->name); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </ul>
        <ul class="list_dropdown">
          <li><strong>CUSTOM APPAREL</strong></li>
          <li><a href="contact-us">Coming soon...</a></li>
          <!-- <li><a href="#">Short Sleeve T-shirts</a></li>
          <li><a href="#">Long Sleeve T-shirts</a></li>
          <li><a href="#">Women</a></li>
          <li><a href="#">Hoodies</a></li>
          <li><a href="#">Sweatshirts</a></li>
          <li><a href="#">Activewear</a></li>
          <li><a href="#">Polos</a></li>
          <li><a href="#">Jackets</a></li> -->
        </ul>
        <ul class="list_dropdown">
          <li><strong>LARGE FORMAT</strong></li>
          <li><a href="contact-us">Coming soon...</a></li>
          <!-- <li><a href="#">Banners</a></li>
          <li><a href="#">Vinyl Graphics</a></li> -->
        </ul>
      </div>
    </div>
    <div class="col-md-9 col-sm-12">
      <?php if($categoryName=='BUSINESS CARDS'): ?>
      <?php else: ?>
      <div id="carouselExampleIndicators" class="carousel slide haderPc" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active">
            <a href="<?php echo e(route('shop.show', 'BusinesCards')); ?>">
              <img src="/img/Printinglab-banner-home.jpg">
            </a>
          </div>
          <div class="carousel-item">
            <a href="<?php echo e(route('shop.show', 'Hang Tags')); ?>">
              <img src="/img/Printinglab-banner-home2.jpg">
            </a>
          </div>
          <div class="carousel-item">
            <a href="<?php echo e(route('shop.show', 'Notepads')); ?>">
              <img src="/img/Printinglab-banner-home3.jpg">
            </a>
          </div>
          <div class="carousel-item">
            <a href="https://signslab.com/">
              <img src="/img/Printinglab-banner-home4.jpg">
            </a>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>
      <?php endif; ?>

      <div class="container-fluid headerMb">
        <div id="carouselExampleIndicatorsMb" class="carousel slide " data-ride="carousel">
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <a href="<?php echo e(route('shop.show', 'BusinesCards')); ?>">
                <img src="/img/mobile-slider-index-printing-lab-1.jpg">
              </a>
            </div>
            <div class="carousel-item">
              <a href="<?php echo e(route('shop.show', 'Hang Tags')); ?>">
                <img src="/img/mobile-slider-index-printing-lab-2.jpg">
              </a>
            </div>
            <div class="carousel-item">
              <a href="<?php echo e(route('shop.show', 'Notepads')); ?>">
                <img src="/img/mobile-slider-index-printing-lab-3.jpg">
              </a>
            </div>
            <div class="carousel-item">
              <a href="https://signslab.com/">
                <img src="/img/mobile-slider-index-printing-lab-4.jpg">
              </a>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicatorsMb" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicatorsMb" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>
        </div>
      </div>
      <div class="h_featured">
        <h4 class="h4Feature">
          <?php echo e($categoryName); ?>

        </h4>
      </div>
      <div class="productSection-Index center" >
        <div>
          <div class="container row">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 col-sm-4 col-12" >
              <div class="btnHoverI"  style="border-top: 1px #e4e4e4 solid;border-right: 1px #e4e4e4 solid;border-left: 1px #e4e4e4 solid;width: 100%;height: 175px;background-size: cover;background-image: url('<?php echo e(productImage($product->image)); ?>');" >
                <div class="btn_info">
                  <a class="a_Shop" href="<?php echo e(route('shop.show', $product->slug)); ?>">SHOP NOW</a>
                </div>
              </div>
              <a href="<?php echo e(route('shop.show', $product->slug)); ?>"><div class="product-name"><?php echo e($product->name); ?></div></a>
              <div class="product-price">from <?php echo e($product->presentPrice()); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="text-align: left">No items found</div>
            <?php endif; ?>
          </div> <!-- end products -->
          <div class="spacer"></div>
          <?php echo e($products->appends(request()->input())->links()); ?>

        </div>
      </div>
      <!--fin de productos -->
    </div>
  </div>
</div>

<div class="container-fluid Slide_GrandeIndex">
  <div class="container center textSlideMail">
    <h1>
      DONT'T MISS AN OFFER!
    </h1>
    <span><strong>Stay tune with us and get the best savings, don't worry we don't spam </strong></span>
    <div id="mc_embed_signup">
      <form action="https://printinglab.us15.list-manage.com/subscribe/post?u=251b2e0553860ed938039c6f1&amp;id=0e1097874c" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        <div id="mc_embed_signup_scroll">
          <input type="email"  value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter your Email Address" required>
          <div style="position: absolute; left: -5000px;" aria-hidden="true">
            <input type="text" name="b_251b2e0553860ed938039c6f1_0e1097874c" tabindex="-1" value="">
          </div>
          <div class="clear ">
            <input type="submit" value="SEND " name="subscribe" id="mc-embedded-subscribe" class="bnt_senMailchip">
            <i class="far fa-paper-plane">
            </i>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container containerClientes center haderPc">
  <h2 class="box">SOME OF OUR CLIENTS</h2>
  <div class="row">
    <div class="col-md-12">
      <div class="carousel slide" data-ride="carousel" >
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active">
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente2">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente1">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente3">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente4">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente5">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente6">
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente7" >
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente8" >
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente9" >
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente10" >
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente11" >
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente12" >
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente13">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente14">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente15">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente16">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente17">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente18">
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente19">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente20">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente21">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente22">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente23">
              </div>
              <div class="col-md-2 col-sm-2 col-xs-2" id="cliente24">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container  headerMb" >
  <h2 class="center HmobilTxt">SOME OF OUR CLIENTS</h2>
  <div class="row">
    <div class="col-md-12">
      <div class="carousel slide" data-ride="carousel" >
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active">
            <div class="row">
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-1.png" >
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-2.png" >
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-3.png" >
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-4.png" >
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-5.png" >
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-6.png" >
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-7.png" >
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-8.png" >
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-9.png" >
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-10.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-11.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-12.png" alt="">
              </div>
            </div>
          </div>
          <div class=" carousel-item">
            <div class=" row">
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-13.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-14.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-15.png" alt="">
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-16.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-17.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-18.png" alt="">
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-19.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-20.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-21.png" alt="">
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-22.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-23.png" alt="">
              </div>
              <div class="col-sm-4 col-4">
                <img src="/img/clientes/client-printing-lab-24.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <h2 class="center HmobilTxt">REASONS TO TRUST IN US</h2>
  <div class="row reasons">
    <div class="col-md-4 col-sm-4 row">
      <div class="col-md-3 ">
        <img src="/img/high-quality.png" alt="">
      </div>
      <div class="col-md-9">
        <h4>
          <strong>
            High Quality
          </strong>
        </h4>
        <p>
          Don't compromise on quality and see the Printing Lab difference!
          <br>
          We offer superior quality printing all backed by our 100% quality guarantee.
        </p>
      </div>
    </div>
    <div class="col-md-4 col-sm-4 row">
      <div class="col-md-3 ">
        <img src="/img/best-prices.png" alt="">
      </div>
      <div class="col-md-9">
        <h4>Best Prices </h4>
        <p>
          We are proud to offer our high quality printing at the best possible price.
          <br>
          We continually strive to provide our customers with the best instant princing avalible
        </p>
      </div>
    </div>
    <div class="col-md-4 col-sm-4 row">
      <div class="col-md-3 ">
        <img src="/img/customer-service.png" alt="">
      </div>
      <div class="col-md-9">
        <h4>Customer Service</h4>
        <p>
          Have a question or need help placing an order?
          <br>
          Our printing specialists are available Monday-Friday and form 8am-5pm.
        </p>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class=" btn btn-default btn-circle btn-xl" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body">
        <a href="https://signslab.com/" target="_blank">
        <img src="img/mobile-slider-index-printing-lab-4.jpg" alt="">
        </a>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->

<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>

<script src="<?php echo e(asset('js/algolia.js')); ?>"></script>

<script>
modalSignsLab();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>