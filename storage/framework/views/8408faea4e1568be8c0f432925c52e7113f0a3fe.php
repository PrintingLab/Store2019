<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title>Printinglab.com | <?php echo $__env->yieldContent('title', ''); ?></title>

  <link href="/img/favicon-printing-lab.png" rel="SHORTCUT ICON" />

  <!-- Fonts -->
  <script src="<?php echo e(asset('js/jquery-3.3.1.min.js')); ?>"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

  <!-- Styles -->
  <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/page.css')); ?>">

  <?php echo $__env->yieldContent('extra-css'); ?>


</head>


<body class="<?php echo $__env->yieldContent('body-class', ''); ?>" ng-app="shop-v1">
  <?php echo $__env->make('partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <div class="content">
    <div class="index_container">
    </div>
    <?php echo $__env->yieldContent('content'); ?>
  </div>

  <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>


  <!-- Js-->
  <script src="<?php echo e(asset('js/angular.min.js')); ?>"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="<?php echo e(asset('js/angularapp.js')); ?>"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script src="<?php echo e(asset('js/propio.js')); ?>"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <?php echo $__env->yieldContent('extra-js'); ?>



</body>
</html>
