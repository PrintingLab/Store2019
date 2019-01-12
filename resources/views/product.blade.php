@extends('layout')
@section('title', $product->name)
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
<link rel="stylesheet" href="{{ asset('css/shop.css') }}">
@endsection

@section('content')

@component('components.breadcrumbs')
<span><a href="{{ route('shop.index') }}">Shop</a></span>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>{{ $product->name }}</span>
@endcomponent



<div class="container">
  @if (session()->has('success_message'))
  <div class="alert alert-success">
    {{ session()->get('success_message') }}
  </div>
  @endif

  @if(count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
</div>

<div class="container containerProducts">
  <div class="row">
    <div class="col-md-6">
      <div class="product-section-image">
        <img src="{{ productImage($product->image) }}" alt="product" class="active" id="currentImage">
      </div>
      <div class="product-section-images">
        <div class="product-section-thumbnail selected">
          <img src="{{ productImage($product->image) }}" alt="product">
        </div>
        @if ($product->images)
        @foreach (json_decode($product->images, true) as $image)
        <div class="product-section-thumbnail">
          <img src="{{ productImage($image) }}" alt="product">
        </div>
        @endforeach
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="col-md-12">
        <h1 class="titleProductint"><strong>{{ $product->name }}</strong></h1>
      </div>
      <ul>
        @foreach (json_decode($product->details, true) as $detail)
        <li class="liDetails"><i class="fas fa-check"></i> {{ $detail }} </li>
        @endforeach
      </ul>
      <div  class="container containerProductsint" ng-controller="shopcontroller">
        <script>
        var prtd = '{!!$product !!}'
        var apiID = '{!!$product->apiID !!}'
        var prtdname = '{!!$product->name  !!}'
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
                      {!! $product->dinamicoption !!}
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
                    <!-- <div ng-repeat="op in stockarry  | unique: 'option'">@{{op.option}}</div>  -->
                    <div class="col-md-7 filter_select">
                      <select name="stock" id="stock">
                        <option value="@{{op.value}}" ng-repeat="op in stockarry  | unique: 'option'">@{{stockname(op.option)}}</option>
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
                        <option value="">Standard Corners</option>
                        <option value="Round">Round Corners</option>
                      </select>
                    </div> <!-- end filter-select -->
                  </div>
                </div> <!-- end jt_filters -->
                <div class="jt_filters">
                  <div class="row">
                    <div class="col-md-5 filter_name">
                      <strong> Coating: @{{prdselect3}}</strong>
                    </div> <!-- end filter_name -->
                    <div class="col-md-7 filter_select">
                      <select name="coating" id="coating">
                        <option value="@{{op.product_code}}" ng-repeat="op in Coatingarray | filter:{product_description:roundcorners}| filter:{product_description:roundcorners} | unique: 'option'">@{{op.option}}</option>
                      </select>
                    </div> <!-- end filter-select -->
                  </div>
                </div> <!-- end jt_filters -->
              </fieldset>
            </form>
            <div class="jt_filters">
              <div class="row">
                <div class="col-md-5 filter_name">
                  <strong>
                    Printed Side:
                  </strong>
                </div>
                <div class="col-md-7">
                  <select  name="" id="side">
                    <option value="@{{op.capi_description.slice(0,3)}}" ng-repeat="op in productside">@{{stockname(op.capi_name)}}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="jt_filters">
              <div class="row">
                <div class="col-md-5 filter_name">
                  <strong>
                    Quantity:
                  </strong>
                </div>
                <div class="col-md-7">
                  <select  name="" id="quantyti">
                    <option value="@{{qty.option_description}}" ng-repeat="qty in productprices">
                      @{{qty.option_name}}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="jt_filters">
              <div class="row">
                <div class="col-md-5 filter_name">
                  <strong>
                    Printing Time:
                  </strong>
                </div>
                <div class="col-md-7">
                  <select  name="" id="TurnAroundTime">
                    <option value="@{{qty.option_name}}" ng-repeat="qty in productTurnAroundTime | filter:quantyti | filter:side | unique: 'option_description'">
                      @{{qty.option_description}}
                    </option>
                  </select>
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
                <img src="{{ asset('img/settings/gif-load-13.gif') }}" alt="" ng-hide="priceshow" >
                <input id="product-section-price" value="@{{priceformat(buildprice)}}" ng-show="priceshow" readonly disabled>
              </div>



            </div>
          </div>

          <input type="hidden"  id="ruta" name="" value="{{route('cart.cartstep',$product)}}">

          @if ($product->quantity > 0)
          <form action="{{route('cart.cartstep',$product)}}" id="fromBtn" class="center" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input hidden type="text" name="prddesc" value="@{{productdesc}}" readonly>
            <input hidden type="text" name="prdtcode" value="@{{productcode}}" readonly>
            <input hidden type="text" name="prdtID" value="@{{productuuid}}" readonly>
            <input hidden type="text" name="prdtprice" value="@{{pricetosend(buildprice)}}" readonly>
            <input hidden type="text" name="prdRunsize" value="@{{quantyti}}" readonly>
            <input hidden type="text" name="prdside" value="@{{side}}" readonly>
            <input hidden type="text" name="prdTurnAroundTime" value="@{{TurnAroundTime}}" readonly>
            <input hidden type="text" name="option_uuid" value="@{{option_uuid}}" readonly>
            <input hidden type="text" name="colorspec_uuid" value="@{{colorspec_uuid}}" readonly>
            <input hidden type="text" name="runsize_uuid" value="@{{runsize_uuid}}" readonly>
            <div class="col-md-12">
              <button  name="sendbtn" value="op1" class="btn_formProduct btn_op1" ng-disabled="btndisigned">UPLOAD YOUR FILE & ORDER NOW</button>
            </div>
            <button hidden  name="sendbtn" value="op2" class="btn_formProduct btn_op2" ng-disabled="btndisigned">CREATE YOUR DESIGN ONLINE</button>
            <div class="col-md-12">
              <button  name="sendbtn" value="op3" class="btn_formProduct btn_op3" ng-disabled="btndisigned">WE DESIGN IT FOR YOU</button>
            </div>
          </form>
          @endif


        </div>

      </div> <!-- end product-section -->



    </div>
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
        <a class="nav-link link-products " data-toggle="pill" href="#menu2">PAPER <strong>/</strong></a>
      </li>
      <li class="nav-item">
        <a class="nav-link link-products " data-toggle="pill" href="#menu3">SPECS <strong>/</strong></a>
      </li>
      <li class="nav-item">
        <a class="nav-link link-products " data-toggle="pill" href="#menu4">TEMPLATES </a>
      </li>
    </ul>
    <div class="tab-content tab-content-MP">
      <div id="home" class="container tab-pane active"><br>
        <p>
          Set the Right Tone for Your Client Relationships.
        </p>
        <p>
          Business cards may be small but they have a big impact on how your brand is perceived. Business cards at their core represent your business. If your brand is important, then business card printing should be taken seriously. Our high quality custom business cards are thick, durable, and are professionally printed.
        </p>
        <p>
          Business cards may be small but they have a big impact on how your brand is perceived. Business cards at their core represent your business. If your brand is important, then business card printing should be taken seriously. Our high quality custom business cards are thick, durable, and are professionally printed.
        </p>
      </div>
      <div id="menu1" class="container tab-pane fade"><br>
        <p>
          <strong>MATTE/DULL FINISH</strong><br>
          Thick cardstock with a non-reflective matte finish for a classic and elegant look
          Aqueous (water-based) coating adds scratch and scuff resistance
          Paper from sustainable sources
          Non-glossy surface provides better writability but testing is recommended.
          Ballpoint pens (oil-based ink) and permanent markers work best.
          Great choice for business cards, postcards, hang tags and pocket folders
          Note: we do not guarantee writability or printability of coated paper
        </p>
        <p>
          <strong>GLOSS COVER</strong><br>
          Thick cardstock with a gloss finish for sheen and vibrant colors
          Aqueous (water-based) coating adds scratch and scuff resistance
          Paper from sustainable sources
          May be written on but testing is recommended. Ballpoint pens (oil-based ink) and permanent markers work best.
          Most popular choice for business cards, postcards, hang tags and pocket folders
        </p>
        <p>
          <strong>AKUAFOIL</strong><br>
          With Akuafoil, you can turn a wide range of CMYK colors into multi-colored foils. Akuafoil uses a special processed foil system that is applied under a 4/c process to create an array of foil colors. It's simple, affordable, and makes your prints stand out from the crowd.
          For an Akuafoil job, you must include an Akuafoil mask file along with your CMYK file. The mask file indicates where the Akuafoil will be applied. The file setup is the same as Spot UV. Use 100% K where Akuafoil needs to be applied and white where the Akuafoil is not applied.
          As shown above, the file on the left is the normal CMYK print file. If you want the logo to be Akuafoil, then your Akuafoil mask file should look like the file on the right. The white indicates no Akuafoil and black 100% K indicates where the Akuafoil will be applied. When uploading, please remember to upload separate files.
          Here are some more things to keep in mind when creating your Akuafoil artwork:
          Make sure the mask and CMYK print file are aligned. They should match exactly in size and position.
          1.	Akuafoil works best on lighter colors. The darker the CMYK color, the less vibrant the Akuafoil effect.
          2.	Do not use very thin or small text and artwork with Akuafoil. Use San Serif fonts above 12 point for best results.
          a.	If you have Akuafoil applied to a white area, it will have a plain silver Akuafoil look.
          b.	For better quality we recommend creating mask files in vector based programs such as Illustrator or CorelDRAW.
          If you would like plain silver Akuafoil to print, make sure to have at least 15% K in the CMYK print file area in order to obtain the highest quality silver Akuafoil effect.
        </p>
      </div>
      <div id="menu2" class="container tab-pane fade"><br>
        <p>
          14pt Metallic Pearl <br>
          Our 14pt Metallic Pearl paper is a unique stock that shimmers in light when viewed from different angles. The stock itself is embedded with Pearl fibers that give the paper an overall smooth, metallic look. Printing on this stock will give your CMYK colors a subtle shimmer, however heavy ink densities or coverage may diminish the effect.
        </p>
        <p>
          32pt EDGE <br>
          EDGE Cards are made of three premium quality stocks adhered together creating an ultra thick, 32pt triple layered card with a colored core.
          Face Stock: 9pt Bright White Premium uncoated with a Smooth finish
          Insert Stock: 14pt Premium Opaque Black
        </p>
      </div>
      <div id="menu3" class="container tab-pane fade"><br>
        <p>
          RESOLUTION <br>
          Low resolution files may be printed as is or will be placed on hold until we receive new files, slowing your turn-around.
        </p>
        <p>
          <strong>THESE ARE 72 DPI LOW RES IMAGES</strong> <br>
          <img src="images/resolution-72.jpg">
        </p>
        <p>
          <strong>THESE ARE THE SAME IMAGES BUT AT 300 DPI</strong><br>
          <img src="images/resolution-300.jpg">
        </p>
        <p>
          PREPAIR A TRANSPARENT FILE <br>
          Al diseñar las tarjetas de plástico, es importante recordar que el plástico esmerilado(frosted) y el plástico transparente (clear),es transparente. Las tarjetas de plástico son producidas con esquinas redondeadas sin ningún costo adicional.
        </p>
        <p>
          Como puede ver en el ejemplo, la diferencia en la transparencia de cada tarjeta es representada en esta imagen. La tarjeta transparente(clear)a la derecha, son completamente tranparentes.Las tarjetas esmeriladas(frosted ) en el centro, son semi-transparentes, sus diseños no pueden ser vistos en el reverso de este material. Las tarjetas blancas (opaque white) en la izquierda son de plástico blanco sólido y no son transparentes. Por favor tome esto en cuenta al diseñar sus tarjetas. El tipo de material tendrá un efecto en el resultado final.
        </p>
        <p>
          Al no haber tinta blanca en el proceso de CMYK, es importante recordar que la opción de transparente y de esmerilado, tendrá un efecto transparente en su pieza. Los tres diseños en el ejemplo son igual al primer ejemplo. El área blanca(en blanco) en la imagen no incluye tinta y demostrara el material transparente o blanco dependiendo en su selección de material, en este caso, estas áreas en blanco serán producidas sin impresión en estas áreas, todo color en las tarjetas trasparentes o esmeriladas será transparente.
        </p>
        <p>
          Las tarjetas transparentes probablemente incluirán un pequeño porcentaje de tarjetas rayadas, por ser el plástico trasparente. Esto es relacionado con la fabricación de este tipo de material y al transportar el material, para asistir con este resultado corremos una cantidad adicional en su orden para completar la cantidad deseada de su orden.
        </p>
        <p>
          Tarjetas de plástico transparentes son enviadas con una capa protectiva fácil de despegar. Esta protección es para prevenir rayones y daños al empaquetar y proteger el producto en el proceso de envío.
        </p>
        <p>
          PROOF OR SAMPLE FILE <br>
          Al enviar los archivos, no envíe pruebas o muestras. Puede ser que se imprima el archivo incorrecto. Envíe solamente los archivos que usted necesita que se impriman.
        </p>
        <p>
          No somos responsables si este tipo de archivos sean impresos. Solo en la ocasión que uno de nuestros empleados lo pida, no envíe archivos que no sean necesarios.
        </p>
        <p>
          BLEED <br>
          Bleed must extend past the cut-line and will be trimmed from the product during the final cutting phase. When the image is required to extend all the way to the edge, bleed is needed to preserve the finished look and the quality of the final product.
        </p>
        <p>
          Please keep all text at least 0.125" inside the cut-line. <br>
          - The bleed for Standard Products is 0.125". <br>
          - The bleed for Booklets and Presentation Folders is 0.25". <br>
          - For Grand4mat Products, please see the G4Mat FAQs for individual substrate guides. <br>
          We recommend using our templates at all times.
        </p>
        <p>
          TRANSPARENCY ISSUES <br>
          Any transparency issue can be resolved before saving your file.
          What a transparency problem looks like on screen...	After a transparency problem is printed...
        </p>
        <p>
          To prevent this, never use shadows, glows, or any other transparency (image or otherwise) on top of a spot color. Always convert your spot color to CMYK and flatten before sending.
        </p>
        <p>
          SHADOWS, GLOWS, TRANSPARENCY,
          All of these effects will cause transparency problems.
        </p>
        <p>
          FRONT AND BACK <br>
          No. We are now specifically set up to process one side at a time, and this requires that each side of a job must be on a separate file.
          2 FILES – 1FR, 1BK
          1 FILE – FR&BK
        </p>
        <p>
          Not separating files will cause delays and you might have to send the files again. Remember to separate the pages of your .pdf files as well.
        </p>
        <p>
          SPOT UV FILES <br>
          When creating a Spot UV job, you must include a Spot UV template file along with the regular print file. The Spot UV template file is used to show where the UV coating needs to be applied.
        </p>
        <p>
          For better quality we recommend creating mask files in vector based programs such as Illustrator or CorelDRAW.
          Please only use solid 100% K to indicate where you would like the UV. Do not use shadows, glows or grayscale images. White will indicate no UV.
          Remember, if it's white, you can write!
        </p>
      </div>
      <div id="menu4" class="container tab-pane fade"><br>

      </div>
    </div>
  </div>


</div>


<!-- productos sugeridos -->
@include('partials.might-like')
@endsection
@section('extra-js')
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


//validaciones
/*

$(".btn_op1").click(function(){
  var ruta=$('#ruta').val();
  console.log(ruta);
  $('#fromBtn').attr('action', ruta);
  $('#fromBtn').submit();
});

$(".btn_op3").click(function(){
  $.confirm({
    title: 'We design it for you.',
    content: 'If you take this service will cost $50 additional.',
    draggable: false,
    buttons: {
      confirm: function () {
        var ruta=$('#ruta').val();
        $('#fromBtn').attr('action', ruta);
        $('#fromBtn').submit();
      },
      cancel: function () {
      },
    }
  })
});

*/

</script>
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->

<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
<script src="{{ asset('js/shop.js') }}"></script>

@endsection
