<?php $__env->startSection('title', 'We Design It For You'); ?>

<?php $__env->startSection('extra-css'); ?>
<link rel="stylesheet" href="css/loading-bar.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body-class', 'sticky-footer'); ?>

<?php $__env->startSection('content'); ?>
<div class="container containerProducts">

  <div class="row col-md-12 title-wedesign">
    <h2><strong>We Design It For You</strong></h2>
  </div>


  <form  action="<?php echo e(route('cart.store',$produto)); ?>" name="formdata"  method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <?php echo e(csrf_field()); ?>

    <input hidden type="text" name="prddesc" value="<?php echo e($productDESCRIPTION); ?>" readonly>
  <input hidden type="text" name="prdtprice" value="<?php echo e($productPRICE); ?>" readonly>
   <input hidden type="text" name="prdtcode" value="<?php echo e($productCODE); ?>" readonly>
   <input hidden type="text" name="prdtID" value="<?php echo e($productID); ?>" readonly>
    <input hidden type="text" name="prdRunsize" value="<?php echo e($productRUNSIZE); ?>" readonly>
    <input hidden type="text" name="prdside" value="<?php echo e($productSIDE); ?>" readonly>
    <input hidden type="text" name="prdTurnAroundTime" value="<?php echo e($productTATIME); ?>" readonly>
    <input hidden type="text" name="option_uuid" value="<?php echo e($optionuuid); ?>" readonly>
    <input hidden type="text" name="colorspec_uuid" value="<?php echo e($colorspecuuid); ?>" readonly>
    <input hidden type="text" name="runsize_uuid" value="<?php echo e($runsizeuuid); ?>" readonly>
    <input hidden type="text" name="typedesigned" value="3">
    <input hidden type="text" name="selectRadios" value="N/A">
    <input hidden type="text" name="op" value="op3">
    <input hidden type="text" name="optionstring" value="<?php echo e($optionstring); ?>" readonly>
    <div class="row">

      <div class="col-md-6">
        <h5><strong>UPLOAD AN EXANPLE OF WHAT YOU WANT:</strong></h5>
        <p><i>Only JPG,PNG,PDF,DOC,PPT</i></p>
      </div>

      <div class="col-md-6">

        <div class="row" style="text-align: -webkit-center;">
        <?php if($productSIDE == '4/4'): ?>
          <div class="col-md-6">
            <div class="filex">
              <div class="outputx">
                <p></p>
              </div>
              <p>UPLOAD YOUR FILE - FRONT</p>
              <input type="file" id="archivox" name="file21" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="filey">
              <div class="outputy">
                <p></p>
              </div>
              <p>UPLOAD YOUR FILE- BACK</p>
              <input type="file" id="archivoy" name="file22">
            </div>
          </div>
          <?php else: ?>
          <div class="col-md-12">
            <div class="file">
              <div class="output">
                <p></p>
              </div>
              <p>UPLOAD YOUR FILE</p>
              <input type="file" id="archivounouno" name="archivo">
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="row containerProducts">
      <div class="col-md-12">
        <h5><strong>DETAILS ABOUT YOUR PRODUCT:</strong></h5>
      </div>
      <div class="col-md-12">
        <p><i>How do you want your  </i></p>
      </div>
    </div>
    <div class="col-md-12">
      <textarea class="form-control-designed" id="text" rows="5" name="comentario" required></textarea>
    </div>
    <div class="col-md-12" style="text-align: -webkit-right;">
      <button type="submit" class="btnsubmitWeDesigned" value="Submit">
        CONTINUE TO CHECKOUT
      </button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('extra-js'); ?>
<script>
$('.btnsubmitWeDesigned').click(function(){
  if ($.trim($('#text').val()).length < 1) {
    $.confirm({
      title: 'Alert!',
      content: 'The field is empty, please fill it.',
      draggable: false,
      buttons: {
        confirm: function () {
        },
      }
    })
    return false;
  }  else{
    return true;
  }
});

$("#archivounouno").on('change', function(e){
  var input = document.getElementById('archivounouno');
  var clicked = e.target;
  var file = clicked.files[0];
  if (file.size>20000000 ) {
    $('.output p').text('');
    $("#archivounouno").val('');
    $.confirm({
      title: 'Alert!',
      content: 'The file can not exceed 3MB',
      draggable: false,
      buttons: {
        confirm: function () {
        },
      }
    })
  }else {

    var filePath = 	document.getElementById('archivounouno').value;
    var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf|.zip|.ZIP|.PSD|.PNG|.AI|.PDF|.jpeg)$/i;
    if (!allowedExtensions.exec(filePath)) {

      $('.output p').text('');
      $("#archivounouno").val('');
      $.confirm({
        content: 'The extension of the file is not allowed',
        draggable: false,
        buttons: {
          confirm: function () {
          },
        }
      })
    }else{
      var ruta = $(this).val();
      var substr = ruta.replace('C:\\fakepath\\', '');
      $('.output p').text(substr);
      $('.output').css({
        "opacity": 1,
        "transform": "translateY(0px)"
      });
      $('.file > p').addClass('change');
    }
  }
});

$('#archivox').on('change', function(e){
  //validación peso del archivo en by
  var input = document.getElementById('archivox');
  var clicked = e.target;
  var file = clicked.files[0];
  if (file.size>20000000 ) {
    $('.outputx p').text('');
    $("#archivox").val('');
    $.confirm({
      title: 'Alert!',
      content: 'The file can not exceed 20Mb',
      draggable: false,
      buttons: {
        confirm: function () {
        },
      }
    })
  }else {
    var filePath = 	document.getElementById('archivox').value;
    var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf|.zip|.ZIP|.PSD|.PNG|.AI|.PDF|.jpeg)$/i;
    //validacion extension
    if (!allowedExtensions.exec(filePath)) {
      $('.outputx p').text('');
      $("#archivox").val('');
      $.confirm({
        title: 'Alert!',
        content: 'The extension of the file is not allowed',
        draggable: false,
        buttons: {
          confirm: function () {
          },
        }
      })
    }else{
      var ruta = $(this).val();
      var substr = ruta.replace('C:\\fakepath\\', '');
      $('.outputx p').text(substr);
      $('.outputx').css({
        "opacity": 1,
        "transform": "translateY(0px)"
      });
      $('.filex > p').addClass('change');
    }
  }
});

$('#archivoy').on('change', function(e){
  //validación peso del archivo en by
  var input = document.getElementById('archivoy');
  var clicked = e.target;
  var file = clicked.files[0];
  if (file.size>20000000 ) {
    $('.outputy p').text('');
    $("#archivoy").val('');
    $.confirm({
      title: 'Alert!',
      content: 'The file can not exceed 20Mb',
      draggable: false,
      buttons: {
        confirm: function () {
        },
      }
    })
  }else {
    var filePath = 	document.getElementById('archivoy').value;
    var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf|.zip|.ZIP|.PSD|.PNG|.AI|.PDF|.jpeg)$/i;
    //validacion extension
    if (!allowedExtensions.exec(filePath)) {
      $('.outputy p').text('');
      $("#archivoy").val('');
      $.confirm({
        title: 'Alert!',
        content: 'The extension of the file is not allowed',
        draggable: false,
        buttons: {
          confirm: function () {
          },
        }
      })
    }else{
      var ruta = $(this).val();
      var substr = ruta.replace('C:\\fakepath\\', '');
      $('.outputy p').text(substr);
      $('.outputy').css({
        "opacity": 1,
        "transform": "translateY(0px)"
      });
      $('.filey > p').addClass('change');
    }
  }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>