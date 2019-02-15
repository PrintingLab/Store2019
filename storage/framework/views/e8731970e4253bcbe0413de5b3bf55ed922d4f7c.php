<?php if(auth()->guard()->guest()): ?>
<div class="Btn_Account col-md-5 col-sm-5 paddingCero">
  <img src="/img/user-login-printing-lab.png" alt="">
  <button type="button" class="btn-myAccount dropdown-toggle" data-toggle="dropdown">
    My Account
  </button>
  <div class="dropdown-menu center">
    <li><a href="<?php echo e(route('register')); ?>">Sign Up</a></li>
    <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
    <li><a href="<?php echo e(route('order-satatus')); ?>">Order Search</a></li>
  </div>
</div>
<?php else: ?>
<div class="Btn_Account col-md-5 row">

  <div class="col-md-2 paddingCero">
    <img class="imgUserbtn" src="/img/user-login-printing-lab.png" alt="">
  </div>

  <div class="col-md-10 paddingCero">
    <p class="text_Userp"><?php echo e(Auth::user()->name); ?></p>
    <button type="button" id="userName" class="btn-myAccount dropdown-toggle" data-toggle="dropdown">
    Your Account
    </button>

    <div class="dropdown-menu center">
      <li><a href="<?php echo e(route('users.edit')); ?>">Dashboard</a></li>
      <li>
        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout</a>
        </li>
      </div>
    </div>


  </div>

  <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo e(csrf_field()); ?>

  </form>
  <?php endif; ?>
  <div class="col-md-2 col-sm-2">
    <a href="<?php echo e(route('cart.index')); ?>">
      <img src="/img/shopping-bag-printing-lab.png" alt="">
      <?php if(Cart::instance('default')->count() > 0): ?>
      <span class="cart-count">
        <span><?php echo e(Cart::instance('default')->count()); ?></span>
      </span>
      <?php endif; ?>
    </a>
  </div>

  


    <script>
    /*var userName=document.getElementById('userName').text();*/
    /*let userName=$('#userName').text();
    primera=userName.split(' ');
    /*console.log(primera[4]);*/
    /*$('#userName').text(primera[4]);*/
    </script>
