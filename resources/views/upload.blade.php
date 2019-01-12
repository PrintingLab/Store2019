@extends('layout')

@section('title', 'Thank You')

@section('extra-css')
<link rel="stylesheet" href="css/loading-bar.css">
@endsection

@section('body-class', 'sticky-footer')

@section('content')

<div class="container textoscontainer">
<div class="row col-md-12">
    <h2><strong>{{$productDESCRIPTION}}</strong></h2> 
  </div>
  <div class="divfile">
@if ($productSIDE == '4/4')
    <form action="{{ route('cart.store', $produto) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      {{csrf_field()}}
      <input hidden type="text" name="prddesc" value="{{$productDESCRIPTION}}" readonly>
  <input hidden type="text" name="prdtprice" value="{{$productPRICE}}" readonly>
   <input hidden type="text" name="prdtcode" value="{{$productCODE}}" readonly>
   <input hidden type="text" name="prdtID" value="{{$productID}}" readonly>
    <input hidden type="text" name="prdRunsize" value="{{$productRUNSIZE}}" readonly>
    <input hidden type="text" name="prdside" value="{{$productSIDE}}" readonly>
    <input hidden type="text" name="prdTurnAroundTime" value="{{$productTATIME}}" readonly>
    <input hidden type="text" name="option_uuid" value="{{$optionuuid}}" readonly>
    <input hidden type="text" name="colorspec_uuid" value="{{$colorspecuuid}}" readonly>
    <input hidden type="text" name="runsize_uuid" value="{{$runsizeuuid}}" readonly>
    <input type="hidden" name="typedesigned" value="1">
    <input hidden type="text" name="comentario" value="N/A" readonly>
    <input hidden type="text" name="optionstring" value="{{$optionstring}}" readonly>
<div class="row">
  <div class="col-md-6">
    <h5><strong>UPLOAD AN EXANPLE OF WHAT YOU WANT:</strong></h5>
    <p><i>Only JPG,PNG,PDF,DOC,PPT</i></p>
    <p>Remember, select only two files at the same time.</p>
  </div>
  <div class="col-md-6">
            <div class="filex">
              <div class="outputx">
                <p></p>
              </div>
              <p>UPLOAD YOUR FILE - FRONT</p>
              <input type="file" id="archivox" name="file21"  required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="filey">
              <div class="outputy">
                <p></p>
              </div>
              <p>UPLOAD YOUR FILE- BACK</p>
              <input type="file" id="archivoy" name="file22" required>
            </div>
          </div>
          </div>
<div class="info-UP">
  <h3><strong>Select a Proofing Option</strong></h3>
  <p>
    Every print-ready file gets a 30 point automated and human review to ensure technical quality. Please choose one of the following:
  </p>
  <div class="form-check">
    <input type="radio" name="selectRadios" value="Print ASAP" required><strong>Print ASAP</strong>
    <p>If your file passes review, we will print it ASAP. If we find a problem we can't fix, we'll contact you.</p>
  </div>
  <div class="form-check">
    <input type="radio" name="selectRadios" value="Wait - I want to receive and approve a free PDF proof" required><strong>Wait - I want to receive and approve a free PDF proof. </strong>
    <p>We will email you a link to a PDF proof within 6 hours. Don't worry, we won't print your file until you check the PDF and approve it online. Be aware this could delay your order by a day or more.</p>
  </div>
</div>
<div class="col-md-12 align-right">
  <input type="submit" value="CONTINUE TO CHECKOUT" class="botoEupload">
</div>
</form>
@endif
@if ($productSIDE == '4/0')
  <form action="{{ route('cart.store', $produto) }}"  method="post" accept-charset="utf-8" onsubmit="return validatevacio();" enctype="multipart/form-data" >
  {{csrf_field()}}
  <input hidden type="text" name="prddesc" value="{{$productDESCRIPTION}}" readonly>
  <input hidden type="text" name="prdtprice" value="{{$productPRICE}}" readonly>
   <input hidden type="text" name="prdtcode" value="{{$productCODE}}" readonly>
   <input hidden type="text" name="prdtID" value="{{$productID}}" readonly>
    <input hidden type="text" name="prdRunsize" value="{{$productRUNSIZE}}" readonly>
    <input hidden type="text" name="prdside" value="{{$productSIDE}}" readonly>
    <input hidden type="text" name="prdTurnAroundTime" value="{{$productTATIME}}" readonly>
    <input hidden type="text" name="option_uuid" value="{{$optionuuid}}" readonly>
    <input hidden type="text" name="colorspec_uuid" value="{{$colorspecuuid}}" readonly>
    <input hidden type="text" name="runsize_uuid" value="{{$runsizeuuid}}" readonly>
    <input hidden type="text" name="comentario" value="N/A" readonly>
    <input type="hidden" name="typedesigned" value="1">
    <input hidden type="text" name="optionstring" value="{{$optionstring}}" readonly>
  <div class="row">
    <div class="col-md-6">
      <h5><strong>UPLOAD AN EXANPLE OF WHAT YOU WANT:</strong></h5>
      <p><i>Only JPG,PNG,PDF,DOC,PPT</i></p>
    </div>
    <div class="col-md-6">
      <div class="file">
        <div class="output">
          <p></p>
        </div>
        <p>UPLOAD FILE</p>
        <input type="file" id="archivounouno" name="archivo" required>
      </div>
    </div>
  </div>
  <div class="info-UP">
    <h3><strong>Select a Proofing Option</strong></h3>
    <p>
      Every print-ready file gets a 30 point automated and human review to ensure technical quality. Please choose one of the following:
    </p>
    <div class="form-check">
      <input type="radio" name="selectRadios" value="Print ASAP" required><strong>Print ASAP</strong>
      <p>If your file passes review, we will print it ASAP. If we find a problem we can't fix, we'll contact you.</p>
    </div>
    <div class="form-check">
      <input type="radio" name="selectRadios" value="Wait - I want to receive and approve a free PDF proof" required><strong>Wait - I want to receive and approve a free PDF proof. </strong>
      <p>We will email you a link to a PDF proof within 6 hours. Don't worry, we won't print your file until you check the PDF and approve it online. Be aware this could delay your order by a day or more.</p>
    </div>
  </div>
  <div class="col-md-12 align-right">
    <input type="submit" value="CONTINUE TO CHECKOUT" class="botoEupload">
  </div>
</form>
    @endif

  
    



<!-- ///////////////////////////////////////////////////// -->

</div>
</div>


@endsection
@section('extra-js')
<script>

$("#archivoM").on('change',function(e){
  //input
  var result= document.getElementById('archivoM')
  var count=result.files.length;
  if (count>2) {
    var list = document.getElementById('fileList');
    while (list.hasChildNodes()){
      list.removeChild(list.firstChild);
    }
    $("#archivoM").val('')
    $.confirm({
      title: 'Alert!',
      content: 'The limit of allowed files is two',
      draggable: false,
      buttons: {
        confirm: function () {
        },
      }
    })
  }else{
    var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf|.zip|.ZIP|.PSD|.PNG|.AI|.PDF|.jpeg)$/i;
    var clicked = e.target
    var files1= clicked.files[0]['size']
    if (files1>20000000) {
      $("#archivoM").val('')
      $.confirm({
        title: 'Alert!',
        content: 'The first file can not exceed 20Mb',
        draggable: false,
        buttons: {
          confirm: function () {
          },
        }
      })
    }else{
      var filename1=clicked.files[0]['name']
      if (!allowedExtensions.exec(filename1)) {
        $("#archivoM").val('')
        $.confirm({
          title: 'Alert!',
          content: 'The extension of the first file is not allowed',
          draggable: false,
          buttons: {
            confirm: function () {
            },
          }
        })
      }
    }
    if (clicked.files[1]!=undefined) {
      var files2= clicked.files[1]['size']
      if (files2>20000000) {
        $("#archivoM").val('')
        $.confirm({
          title: 'Alert!',
          content: 'The second file can not exceed 20Mb',
          draggable: false,
          buttons: {
            confirm: function () {
            },
          }
        })
      }else{
        var filename2=clicked.files[1]['name']
        if (!allowedExtensions.exec(filename2)) {
          $("#archivoM").val('')
          $.confirm({
            title: 'Alert!',
            content: 'The extension of the second file is not allowed',
            draggable: false,
            buttons: {
              confirm: function () {
              },
            }
          })
        }
      }
    }
    //ul
    var list = document.getElementById('fileList');
    // lista vacía por ahora ...
    while (list.hasChildNodes()) {
      list.removeChild(list.firstChild);
    }
    for (var x = 0; x < result.files.length; x++) {
      //add to list
      var li = document.createElement('li');
      li.innerHTML = 'File ' + (x + 1) + ':  ' + result.files[x].name;
      list.append(li);
    }
    $('.filex > p').addClass('change');
  }
})

$('#archivounouno').on('change', function(e)
{
  //validación peso del archivo en by
  var input = document.getElementById('archivounouno');
  var clicked = e.target;
  var file = clicked.files[0];
  if (file.size>20000000 )
  {
    $('.output p').text('');
    $("#archivounouno").val('');
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
    var filePath = 	document.getElementById('archivounouno').value;
    var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf|.zip|.ZIP|.PSD|.PNG|.AI|.PDF|.jpeg)$/i;
    //validacion extension
    if (!allowedExtensions.exec(filePath)) {
      $('.output p').text('');
      $("#archivounouno").val('');
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
  if (file.size>200000 ) {
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
    var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf)$/i;
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
  if (file.size>200000 ) {
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
    var allowedExtensions = /(.jpg|.psd|.png|.ai|.pdf)$/i;
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
@endsection
