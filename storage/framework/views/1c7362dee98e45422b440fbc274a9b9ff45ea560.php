<?php $__env->startSection('title', $product->name); ?>
<?php $__env->startSection('extra-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/algolia.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/shop.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumbs'); ?>
<span><a href="<?php echo e(route('shop.index')); ?>">Shop</a></span>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span><?php echo e($product->name); ?></span>
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

<div class="container containerProducts">
  <div class="col-md-12">
    <h1 class="titleProductint"><strong><?php echo e($product->name); ?></strong></h1>
  </div>
  <div class="col-md-12">
    <ul class="producdetailsul">
      <?php $__currentLoopData = json_decode($product->details, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li  class="liDetails"><i class="fas fa-check"></i> <?php echo e($detail); ?> </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="product-section-image">
        <img src="<?php echo e(productImage($product->image)); ?>" alt="product" class="active" id="currentImage">
      </div>
      <div class="product-section-images">
        <div class="product-section-thumbnail selected">
          <img src="<?php echo e(productImage($product->image)); ?>" alt="product">
        </div>
        <?php if($product->images): ?>
        <?php $__currentLoopData = json_decode($product->images, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="product-section-thumbnail">
          <img src="<?php echo e(productImage($image)); ?>" alt="product">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
      </div>

      <!-- Tabs -->
      <div class="container tabs-products">
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <a class="nav-link link-products active" data-toggle="pill" href="#home">DETAILS  <strong>/</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link link-products " data-toggle="pill" href="#menu1">COATINGS <strong>/</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link link-products " data-toggle="pill" href="#menu4">TEMPLATES </a>
          </li>
        </ul>
        <div class="tab-content tab-content-MP">
          <div id="home" class="container tab-pane active"><br>
            <?php echo $product->description; ?>

          </div>
          <div id="menu1" class="container tab-pane fade"><br>
            <?php echo e($product->coatings); ?>

          </div>
          <div id="menu4" class="container tab-pane fade"><br>

            <div class="col-md-12">
              <h5>EPS</h5>
              <ul class="ulTabTemplete">
                <?php $__currentLoopData = productsTempleteEps($product->templates); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <a href="<?php echo e('../'.$product->templates .'eps/'. $archivo); ?>" download><i class="fas fa-download"></i><?php echo e($archivo); ?></a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>

            <div class="col-md-12" style="margin-top: 5%;">
              <?php if( (typeFile($product->templates)) == 'jpg' ): ?>
              <h5>JPG</h5>
              <?php else: ?>
              <h5>PSD</h5>
              <?php endif; ?>
              <ul class="ulTabTemplete">
                <?php $__currentLoopData = productsTempleteJpg($product->templates); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <a href="<?php echo e('../'.$product->templates .'jpg/'. $archivo); ?>" download><i class="fas fa-download"></i><?php echo e($archivo); ?></a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div  class="container containerProductsint" ng-controller="shopcontroller">
        <script>
        var prtd = '<?php echo $product; ?>'
        var apiID = '<?php echo $product->apiID; ?>'
        var prtdname = '<?php echo $product->name; ?>'
        </script>
        <div class="product-section-information" Style="position:relative">
          <div id="preloader">
            <div class="flexloader">
              <div class="loader">
                <i class="fa fa-cog fa-4x yellow">
                </i>
                <i class="fa fa-cog fa-4x black">
                </i>
              </div>
            </div>
            <p style="text-align: center;padding-top: 70px;">Loading Options...  This may take a few seconds.</p>
          </div>
          <div ng-hide="moreoptions">
            <form id="list_view_filter" name="list_view_filter">
              <input type="hidden" id="id_category" name="id_category" value="1">
              <fieldset>
                <div class="jt_filters">
                  <div class="row">
                    <div class="col-md-5 filter_name">
                      <strong>
                        Dimensions:
                      </strong>
                    </div> <!-- end filter_name -->
                    <div class="col-md-7 filter_select">
                      <?php echo $product->dinamicoption; ?>

                    </div> <!-- end filter-select -->
                  </div>
                </div> <!-- end jt_filters -->
                <div class="jt_filters">
                  <div class="row">
                    <div class="col-md-5 filter_name">
                      <strong>
                        Stock:
                      </strong>
                    </div> <!-- end filter_name -->
                    <!-- <div ng-repeat="op in stockarry  | unique: 'option'">{{op.option}}</div>  -->
                    <div class="col-md-7 filter_select">
                      <select name="stock" id="stock">
                        <option value="{{op.value}}" ng-repeat="op in stockarry  | unique: 'option'">{{stockname(op.option)}}   </option>
                      </select>
                    </div> <!-- end filter-select -->
                  </div>
                </div> <!-- end jt_filters -->
                <div class="jt_filters" ng-hide="showcorners">
                  <div class="row">
                    <div class="col-md-5 filter_name">
                      <strong>    Corners:</strong>
                    </div> <!-- end filter_name -->
                    <div class="col-md-7 filter_select" >
                      <select name="roundcorners" id="roundcorners" >
                        <option id="idStandard" value="Standard">Standard Corners</option>
                        <option id="idRound" value="Round">Round Corners</option>
                      </select>
                    </div> <!-- end filter-select -->
                  </div>
                </div> <!-- end jt_filters -->
                <div class="jt_filters">
                  <div class="row">
                    <div class="col-md-5 filter_name">
                      <strong> Coating: {{prdselect3}}</strong>
                    </div> <!-- end filter_name -->
                    <div class="col-md-7 filter_select">
                      <select name="coating" id="coating">
                        <option value="{{op.product_code}}" ng-repeat="op in Coatingarraylist">{{op.option}}</option>
                      </select>
                    </div> <!-- end filter-select -->
                  </div>
                </div> <!-- end jt_filters -->
              </fieldset>
            </form>
            <div>
              <div class="jt_filters prtd{{op.product_option_group_uuid}}" ng-repeat="op in arrayproductprices | filter:{product_option_group_uuid:'!ed16daf6-77e4-4133-8d65-3947d5d19f52'}">
                <div class="row ">
                  <div class="col-md-5 filter_name">
                    <strong>{{changeoptioname(op.product_option_group_name)}}:</strong>
                  </div>
                  <div class="col-md-7">
                    <select   name="" id="{{op.product_option_group_uuid}}" ng-click="optionschange()">
                      <option id="{{op2.option_uuid}}" name="{{op2.option_name}}" value="{{op2.option_uuid}}" ng-repeat="op2 in op.options | unique: 'option_name'">{{changeoptioname(op2.option_name)}}</option>

                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="productSectionPrice row">

              <div class="col-md-6">
                <strong>
                  <label for="product-section-price">Printing Cost:</label>
                </strong>
              </div>

              <div class="col-md-6">
                <img src="<?php echo e(asset('img/settings/gif-load-13.gif')); ?>" alt="" ng-hide="priceshow" >
                <input id="product-section-price" value="{{priceformat(buildprice)}}" ng-show="priceshow" readonly disabled>
                <p style="text-align: right;" ng-show="priceshow">( Only ${{priceperpiece}} each )</p>
              </div>



            </div>
          </div>

          <?php if($product->quantity > 0): ?>
          <form action="<?php echo e(route('cart.cartstep',$product)); ?>" id="fromBtn" name="fromBtn" class="center" method="POST" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <?php echo e(csrf_field()); ?>

            <input hidden type="text" name="prddesc" value="{{productdesc}}" readonly>
            <input hidden type="text" name="prdtcode" value="{{productcode}}" readonly>
            <input hidden type="text" name="prdtID" value="{{productuuid}}" readonly>
            <input hidden type="text" name="prdtprice" value="{{buildprice}}" readonly>
            <input hidden type="text" name="prdRunsize" value="{{quantyti}}" readonly>
            <input hidden type="text" name="prdRunsizeid" value="{{Runsize}}" readonly>
            <input hidden type="text" name="prdside" value="{{side}}" readonly>
            <input hidden type="text" name="prdTurnAroundTime" value="{{TurnAroundval}}" readonly>
            <input hidden type="text" name="option_uuid" value="{{option_uuid}}" readonly>
            <input hidden type="text" name="colorspec_uuid" value="{{Colorspec}}" readonly>
            <input hidden type="text" name="runsize_uuid" value="{{runsize_uuid}}" readonly>
            <input hidden type="text" name="optionstring" value="{{optionstring}}" readonly>
            <input hidden type="text" name="sendbtn" value="{{optsend}}" readonly>
            <div class="col-md-12">
              <button type="button" class="btn_formProduct btn_op1" ng-click="actionoptsend('op1')" ng-disabled="btndisigned">UPLOAD YOUR FILE & ORDER NOW</button>
            </div>
            <button  type="button" hidden   class="btn_formProduct btn_op2" ng-click="actionoptsend('op2')" ng-disabled="btndisigned">CREATE YOUR DESIGN ONLINE</button>
            <div class="col-md-12">
              <button type="button" class="btn_formProduct btn_op3" ng-click="actionoptsend('op3')" ng-disabled="btndisigned">WE DESIGN IT FOR YOU</button>
            </div>
          </form>
          <?php endif; ?>
        </div>




        <!-- <button ng-click="categorias()">categotias</button>
        <input type="text" ng-model="busca" >
        <ul>
        <li ng-repeat="cat in categoriaslist |filter:busca"><b>{{cat.category_name}}</li><br>
      </ul>  -->
    </div> <!-- end product-section -->



  </div>
</div>








</div>


<!-- productos sugeridos -->
<?php echo $__env->make('partials.might-like', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('extra-js'); ?>
<script>
(function(){
  const currentImage = document.querySelector('#currentImage');
  const images = document.querySelectorAll('.product-section-thumbnail');
  images.forEach((element) => element.addEventListener('click', thumbnailClick));
  function thumbnailClick(e) {
    currentImage.classList.remove('active');
    currentImage.addEventListener('transitionend', () => {
      currentImage.src = this.querySelector('img').src;
      currentImage.classList.add('active');
    })
    images.forEach((element) => element.classList.remove('selected'));
    this.classList.add('selected');
  }
})();

</script>
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->

<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="<?php echo e(asset('js/algolia.js')); ?>"></script>
<script src="<?php echo e(asset('js/shop.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>