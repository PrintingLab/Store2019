<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('extra-css'); ?>
<style>
.mt-32 {
  margin-top: 32px;
}
</style>
<link rel="stylesheet" href="<?php echo e(asset('css/checkout.css')); ?>">
<script src="https://js.stripe.com/v3/"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

  <?php if(session()->has('success_message')): ?>
  <div class="spacer"></div>
  <div class="alert alert-success">
    <?php echo e(session()->get('success_message')); ?>

  </div>
  <?php endif; ?>

  <?php if(count($errors) > 0): ?>
  <div class="spacer"></div>
  <div class="alert alert-danger">
    <ul>
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li><?php echo $error; ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>
        <?php endif; ?>

        <h1 class="checkout-heading stylish-heading">Checkout</h1>
        <div class="checkout-section" ng-controller="checkoutcontroller">
            <div class="processingpayment" ng-hide="processingpayment">
            <div class="loadergif"></div>
               <p><i class="fas fa-lock"></i> processing payment...</p>
            </div>
            <div>
                <form action="<?php echo e(route('checkout.Authorize')); ?>" method="POST" id="payment-form" name="checkoutform">
                    <?php echo e(csrf_field()); ?>

                
                    <div ng-show="PaymentDetails">
                    <h2>Billing Details</h2>

                    <div class="form-group">
                        <label for="email">Email Address*</label>
                        <?php if(auth()->user()): ?>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(auth()->user()->email); ?>" readonly>
                        <?php else: ?>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>" ng-model="email" required>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="name">Name*</label>
                        <?php if(auth()->user()): ?>
                        <input type="text" ng-init="name = '<?php echo e(auth()->user()->name); ?>'" class="form-control" id="name" name="name" value="<?php echo e(auth()->user()->name); ?>" ng-model="name" required>
                        <?php else: ?>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" ng-model="name" required>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="address">Address*</label>
                        <?php if(auth()->user()): ?>
                        <input type="text" ng-init="address = '<?php echo e(auth()->user()->Address); ?>'" class="form-control" id="address" name="address" ng-model="address" required>
                        <?php else: ?>
                        <input type="text" ng-init="address = '<?php echo e(old('address')); ?>'" class="form-control" id="address" name="address" value="<?php echo e(old('address')); ?>" ng-model="address" required>
                        <?php endif; ?>
                    </div>
                    <div class="half-form"> 
                        <div class="form-group">
                            <label for="city">City*</label>
                            <?php if(auth()->user()): ?>
                            <input type="text"  ng-init="city = '<?php echo e(auth()->user()->City); ?>'"  class="form-control" id="city" name="city" ng-model="city"   required>
                            <?php else: ?>
                            <input type="text"  ng-init="city = '<?php echo e(old('city')); ?>'" class="form-control" id="city" name="city" value="<?php echo e(old('city')); ?>" ng-model="city"   required>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="province">State*</label>
                            <?php if(auth()->user()): ?>
                            <input type="text"  ng-init="province = '<?php echo e(auth()->user()->Province); ?>'" class="form-control" id="province" name="province"  ng-model="province"   required>
                            <?php else: ?>
                            <input type="text"  ng-init="province = '<?php echo e(old('province')); ?>'" class="form-control" id="province" name="province" value="<?php echo e(old('province')); ?>" ng-model="province"   required>
                            <?php endif; ?>
                        </div>
                    </div> <!-- end half-form -->
                    <div class="half-form">
                        <div class="form-group">
                            <label for="postalcode">Postal Code*</label>
                            <?php if(auth()->user()): ?>
                            <input type="text"  ng-init="postalcode = '<?php echo e(auth()->user()->PostalCode); ?>'" class="form-control" id="postalcode" name="postalcode" ng-model="postalcode" ng-change="computeshipping()" maxlength="5" minlength="5" required>
                            <?php else: ?>
                            <input type="text"  ng-init="postalcode = '<?php echo e(old('postalcode')); ?>'" class="form-control" id="postalcode" name="postalcode" value="<?php echo e(old('postalcode')); ?>" ng-model="postalcode" maxlength="5" ng-change="computeshipping()" required>
                            <?php endif; ?>
                           
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone*</label>
                            <?php if(auth()->user()): ?>
                            <input type="text"  ng-init="phone = '<?php echo e(auth()->user()->Phone); ?>'" class="form-control validate" placeholder="800-000-0000" id="phone" name="phone"  ng-model="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" required>
                            <span ng-show="checkoutform.phone.$touched && checkoutform.phone.$invalid">Please match the requested format.</span>
                            <?php else: ?>
                            <input type="text"  ng-init="phone = '<?php echo e(old('phone')); ?>'" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" ng-model="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" required>
                            <span ng-show="checkoutform.phone.$touched && checkoutform.phone.$invalid">Please match the requested format.</span>
                            <?php endif; ?>
                        </div>
                        <input hidden  type="text" class="form-control validate" id="ShippingMethod" name="Shippingmethod" value="{{ShippingMethod}}" required>
                     </div> <!-- end half-form -->
                     <div class="spacer"></div>
                     <?php if(Cart::count() > 1): ?>
                      <h2>Shipping Method for all items</h2>
                      <?php else: ?>
                      <h2>Shipping Method  </h2>
                      <?php endif; ?>
                      <div id="preloader" ng-hide="preloader">
                   <div class="flexloader">
                       <div class="loader">
                           <i class="fa fa-cog fa-4x yellow">
                           </i>
                           <i class="fa fa-cog fa-4x black">
                           </i>
                        </div>
                    </div>
                    <p class="Calculating "> Calculating Shipping...
This may take a few moments.</p>
                </div>
                <div class="alert alert-warning" role="alert" ng-hide="dangermesagge">
  {{danger}}
</div>               
            <div class="shippingResult" id="div_shipping" ng-repeat="ship in shipping_options | unique: 'service_name'">
              <label class="col-md-12 label-result">
                <div class="shippingServices clearfix">
                  <input id="ShippingMethodlist" type="radio" class="shipRadio" name="shipping_selected" ng-model="ShippingMethodlist" value="{{ship.service_name}}" ng-click="shipingupdate(ship.service_price,ship.service_name)" >&nbsp;
                  <pre hidden ng-if="$first" ng-init="shipingupdate(ship.service_price,ship.service_name)"></pre>
                  <!--checking of local pickup options-->
                  <label for="ShippingMethodlist" class="shipping-cost shipping-rate-wrap" style="float:right">
                    {{(ship.service_price)}}
                  </label>
                  <label for="ShippingMethodlist" class="shipping-detail">{{ship.service_name}}&nbsp;</label>
                </div>
              </label>
            </div>

            <div class="txtBotCheckout">
              <span ng-show="preloader" >This product will be available from {{addressoptions.city}}, {{addressoptions.state}} <br>
                Estimated Production Completion Date: {{productionestimate}}</span>
                <div class="spacer"></div>
            </div>


            </div>
            <div class="PaymentDetails" ng-hide="PaymentDetails">
              <h2>Payment Details</h2>
              <div class="card-details">
                <img src="<?php echo e(asset('img/settings/payments-checkout.png')); ?>" alt="card allowed" >
                <div class="spacer"></div>
                <div class="row">

                  <div class="form-group col-sm-7">
                    <label for="card_name">Name on Card*</label>
                    <input id="card_name" type="text" class="form-control" placeholder="Name on Card" aria-label="Card Holder" aria-describedby="basic-addon1" name="card_name" required>
                  </div>
                  <div class="form-group col-sm-5">
                    <label for="">Expiration Date*</label>
                    <div class="input-group expiration-date">
                      <input type="text" class="form-control" placeholder="MM" aria-label="MM" aria-describedby="basic-addon1" name="card_expiry_month" id="card_expiry_month" required>
                      <span class="date-separator"></span>
                      <input type="text" class="form-control" placeholder="YYYY" aria-label="YYYY" aria-describedby="basic-addon1" name="card_expiry_year" id="card_expiry_year" required>
                    </div>
                  </div>
                  <div class="form-group col-sm-8">
                    <label for="card-number">Card Number*</label>
                    <input type="text" class="form-control" id="cnumber" name="cnumber" placeholder="Enter Card Number" aria-label="Card Holder" aria-describedby="basic-addon1" required>
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="cvc">CVC*</label>
                    <input type="text" class="form-control"  id="ccode" name="ccode" placeholder="Enter Card Code" aria-label="Card Holder" aria-describedby="basic-addon1" required>
                  </div>
                </div>
              </div>
              <div class="spacer"></div>
              <button type="submit" id="complete-order" class="btnCheckoutContinue" ng-click="processingpayment()">Complete Order</button>

            </div>


          </form>
          <div class="alert alert-warning" role="alert" ng-hide="dangermesagge">
            {{danger}}
          </div>
          <button  id="Continue-order" class="btnCheckoutContinue" ng-click="Continueorder()" ng-hide="Continuehide" ng-disabled="Continuebtn">Continue</button>
          <!-- Modal -->
          <div class="modal fade" id="candidates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Shipping Address Validation</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Sorry! We were not able to verify your shipping address. Please
                  please select one of our suggestions or modify it and try again
                  <div class="suggestions" ng-repeat="adr in addresscandidates " ng-click="setaddres(adr.address,adr.city,adr.state,adr.zipcode)"> {{adr.address}} {{adr.city}},  {{adr.state}} {{adr.zipcode}}</div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit Address</button>
                </div>
              </div>
            </div>
          </div>

          <div class="flex-center position-ref full-height">
            <div class="content">

            </div>
          </div>
          <?php if($paypalToken): ?>
          <div class="mt-32" ng-hide="PaymentDetails">or</div>
          <div class="mt-32" ng-hide="PaymentDetails">
            <h2>Pay with PayPal</h2>
            <form method="post" id="paypal-payment-form" action="<?php echo e(route('checkout.paypal')); ?>">
              <?php echo csrf_field(); ?>
              <section>
                <div class="bt-drop-in-wrapper">
                  <div id="bt-dropin"></div>
                </div>
              </section>
              <input hidden  type="text" class="form-control"  name="address" value="{{address}}" required>
              <input hidden  type="text" class="form-control"  name="city" value="{{city}}" required>
              <input hidden  type="text" class="form-control"  name="province" value="{{province}}" required>
              <input hidden  type="text" class="form-control"  name="postalcode" value="{{postalcode}}" required>
              <input hidden  type="text" class="form-control"  name="phone" value="{{phone}}" required>
              <input hidden type="text" class="form-control" id="ShippingMethod" name="Shippingmethod" value="{{ShippingMethod}}" required>
              <input id="nonce" name="payment_method_nonce" type="hidden" />
              <button class="btnCheckoutContinue" type="submit" ng-click="processingpayment()"><span>Pay with PayPal</span></button>
            </form>
          </div>
          <?php endif; ?>
        </div>
        <div class="checkout-table-container">
          <h2>Your Order</h2>
          <div class="checkout-table">
            <?php $__currentLoopData = Cart::content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="checkout-table-row">
              <div class="checkout-table-row-left">
                <div class="checkout-item-details">
                  <div class="checkout-table-item"><?php echo e($item->name); ?></div>
                  <div class="checkout-table-description"><?php echo e($item->options->decription); ?></div>
                  <div class="checkout-table-item">Quantity</div>
                  <div class="checkout-table-description"><?php echo e($item->options->quantity); ?></div>
                  <div class="checkout-table-item">Printed Side</div>
                  <div class="checkout-table-description"><?php echo e(getPrintingsides($item->options->side)); ?></div>
                  <div class="checkout-table-item">Turnaround</div>
                  <div class="checkout-table-description"><?php echo e(getPrintingTime($item->options->tat)); ?></div>
                </div>
              </div> <!-- end checkout-table -->

              <div class="checkout-table-row-right">

                <div class="checkout-table-quantity"><?php echo e(presentPrice($item->price)); ?></div>
              </div>
            </div> <!-- end checkout-table-row -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          </div> <!-- end checkout-table -->

          <div class="checkout-totals">
            <div class="checkout-totals-left">
              Subtotal <br>
              <?php if(session()->has('coupon')): ?>
              Discount (<?php echo e(session()->get('coupon')['name']); ?>) :
              <br>
              <hr>
              New Subtotal <br>
              <?php endif; ?>
              Tax <br>
              Shipping <br>
              <span class="checkout-totals-total">Total</span>

            </div>

            <div class="checkout-totals-right">
              <?php echo e(presentPrice(Cart::subtotal())); ?> <br>
              <?php if(session()->has('coupon')): ?>
              -<?php echo e(presentPrice($discount)); ?> <br>
              <hr>
              {{presentPrice(NewSubtotal)}} <br>
              <?php endif; ?>
              {{presentPrice(newTax)}} <br>
              {{presentPrice(shiping)}} <br>
              <span class="checkout-totals-total">{{ presentPrice(newTotal) }}</span>

            </div>
          </div> <!-- end checkout-totals -->
        </div>

      </div> <!-- end checkout-section -->
    </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('extra-js'); ?>
    <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>
    <script src="<?php echo e(asset('js/checkout.js')); ?>"></script>
    <script>

    (function(){

      // PayPal Stuff
      var form = document.querySelector('#paypal-payment-form');
      var client_token = "<?php echo e($paypalToken); ?>";

      braintree.dropin.create({
        authorization: client_token,
        selector: '#bt-dropin',
        paypal: {
          flow: 'vault'
        }
      }, function (createErr, instance) {
        if (createErr) {
          console.log('Create Error', createErr);
          return;
        }

        // remove credit card option
        var elem = document.querySelector('.braintree-option__card');
        elem.parentNode.removeChild(elem);

        form.addEventListener('submit', function (event) {
          event.preventDefault();

          instance.requestPaymentMethod(function (err, payload) {
            if (err) {
              console.log('Request Payment Method Error', err);
              return;
            }

            // Add the nonce to the form and submit
            document.querySelector('#nonce').value = payload.nonce;
            form.submit();
          });
        });
      });

    })();
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>