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
  <div class="col-md-12">
    <h1 class="titleProductint"><strong>{{ $product->name }}</strong></h1>
  </div>
  <div class="col-md-12">
  <ul class="producdetailsul">
    @foreach (json_decode($product->details, true) as $detail)
    <li  class="liDetails"><i class="fas fa-check"></i> {{ $detail }} </li>
    @endforeach
  </ul>
  </div>
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
      <!-- Tabs -->
      <div class="container tabs-products">
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <a class="nav-link link-products active" data-toggle="pill" href="#home">DETAILS  <strong>/</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link link-products " data-toggle="pill" href="#menu4">TEMPLATES </a>
          </li>
        </ul>
        <div class="tab-content tab-content-MP">
          <div id="home" class="container tab-pane active"><br>
            {!!$product->description!!}
          </div>
          <div id="menu1" class="container tab-pane fade"><br>
            {{$product->coatings}}
          </div>
          <div id="menu4" class="container tab-pane fade"><br>

            <div class="col-md-12">
              <h5>EPS</h5>
              <ul class="ulTabTemplete">
                @foreach (productsTempleteEps($product->templates) as $archivo)
                <li>
                  <a href="{{ '../'.$product->templates .'eps/'. $archivo }}" download><i class="fas fa-download"></i>{{$archivo}}</a>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="col-md-12" style="margin-top: 5%;">
              @if( (typeFile($product->templates)) == 'jpg' )
              <h5>JPG</h5>
              @else
              <h5>PSD</h5>
              @endif
              <ul class="ulTabTemplete">
                @foreach ( productsTempleteJpg($product->templates) as $archivo  )
                <li>
                  <a href="{{ '../'.$product->templates .'jpg/'. $archivo }}" download><i class="fas fa-download"></i>{{$archivo}}</a>
                </li>
                @endforeach
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div  class="container containerProductsint" ng-controller="shopcontroller">
        <script>
        var prtd = '{!!$product !!}'
        var apiID = '{!!$product->apiID !!}'
        var prtdname = '{!!$product->name !!}'
        var prtdStock = '{!!$product->coatings !!}'
        var prtdCoatings = '{!!$product->specs !!}'
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
                      <select name="stock" id="stock" ng-disabled="@{{stockarry.length==1}}">
                        <option value="@{{op.value}}" ng-repeat="op in stockarry  | unique: 'option'">@{{stockname(op.option)}}   </option>
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
                      <strong> Coating: @{{prdselect3}}</strong>
                    </div> <!-- end filter_name -->
                    <div class="col-md-7 filter_select">

                      <select name="coating" id="coating" ng-disabled="@{{Coatingarraylist.length==1}}">
                        <option value="@{{op.product_code}}" ng-repeat="op in Coatingarraylist  | filter:{product_code:'!16PT-4VBCUV-2X3.5'} | orderBy:'-option'">@{{CoatingsName(op.option,op.product_code)}}</option>
                      </select>

                    </div> <!-- end filter-select -->
                  </div>
                </div> <!-- end jt_filters -->
              </fieldset>
            </form>
            <div>
              <div class="jt_filters prtd@{{op.product_option_group_uuid}}" ng-repeat="op in arrayproductprices | filter:{product_option_group_uuid:'!ed16daf6-77e4-4133-8d65-3947d5d19f52'} | filter:{product_option_group_uuid:'!38d33954-5a42-4112-a905-215eb827e62c'} | filter:{product_option_group_uuid:'!87e09691-ef33-4cf4-8f17-48af06ce84f4'} | filter:{product_option_group_uuid:'!f80e8179-b264-42ce-9f80-bb258a09a1fe'}">
                <div class="row ">
                  <div class="col-md-5 filter_name">
                    <strong>@{{changeoptioname(op.product_option_group_name)}}:</strong>
                  </div>
                  <div class="col-md-7">
                    <select   name="" id="@{{op.product_option_group_uuid}}" ng-disabled="@{{op.options.length==1}}">
                      <option id="@{{op2.option_uuid}}" name="@{{op2.option_name}}" value="@{{op2.option_uuid}}" ng-repeat="op2 in op.options | filter:{option_uuid:'!2fd6ad29-756c-4927-a66f-b0c0116e31f9'} | unique: 'option_name'" >@{{changeoptioname(op2.option_name)}}</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="jt_filters prtd@{{op.product_option_group_uuid}}" >
                <div class="row ">
                  <div class="col-md-5 filter_name">
                    <strong>Printed Side:</strong>
                  </div>
                  <div class="col-md-7">
                    <select   name="PrintedSide" id="38d33954-5a42-4112-a905-215eb827e62c" >
                      <option id="@{{op.colorspec_uuid}}" name="@{{op.colorspec}}" value="@{{op.colorspec_uuid}}" ng-repeat="op in arrayProductprice  | unique: 'colorspec' | filter:{colorspec:'!4/1'}" >@{{changeoptioname(op.colorspec)}}</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="jt_filters prtd@{{op.product_option_group_uuid}}" >
                <div class="row ">
                  <div class="col-md-5 filter_name">
                    <strong>Quantity:</strong>
                  </div>
                  <div class="col-md-7">
                    <select   name="Quantity" id="87e09691-ef33-4cf4-8f17-48af06ce84f4">
                    <option id="@{{op.runsize_uuid}}" name="@{{op.runsize}}" value="@{{op.runsize_uuid}}" ng-repeat="op in arrayProductprice  | unique: 'runsize' " >@{{changeoptioname(op.runsize)}}</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="jt_filters prtd@{{op.product_option_group_uuid}}" >
                <div class="row ">
                  <div class="col-md-5 filter_name">
                    <strong>Printing Time:</strong>
                  </div>
                  <div class="col-md-7">
                    <select   name="PrintingTime" id="f80e8179-b264-42ce-9f80-bb258a09a1fe">
                    <option id="@{{op.option_uuid}}" name="@{{op.option_name}}" value="@{{op.option_uuid}}" ng-repeat="op in arrayProductprice | filter:{runsize_uuid:Runsize} | filter:{colorspec_uuid:Colorspec} | unique: 'option_uuid' " >@{{changeoptioname(op.option_name)}}</option>
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
                <img src="{{ asset('img/settings/gif-load-13.gif') }}" alt="" ng-hide="priceshow" >
                <input id="product-section-price" value="@{{finalprice}}" ng-show="priceshow" readonly disabled>
                <p style="text-align: right;" ng-show="priceshow">( Only $@{{priceperpiece}} each )</p>
              </div>
            </div>
          </div>
          @if ($product->quantity > 0)
          <form action="{{route('cart.cartstep',$product)}}" id="fromBtn" name="fromBtn" class="center" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input hidden type="text" name="prddesc" value="@{{productdesc}}" readonly>
            <input hidden type="text" name="prdtcode" value="@{{productcode}}" readonly>
            <input hidden type="text" name="prdtID" value="@{{productuuid}}" readonly>
            <input hidden type="text" name="prdtprice" value="@{{buildprice}}" readonly>
            <input hidden type="text" name="prdRunsize" value="@{{quantyti}}" readonly>
            <input hidden type="text" name="prdRunsizeid" value="@{{Runsize}}" readonly>
            <input hidden type="text" name="prdside" value="@{{side}}" readonly>
            <input hidden type="text" name="prdTurnAroundTime" value="@{{TurnAroundval}}" readonly>
            <input hidden type="text" name="option_uuid" value="@{{option_uuid}}" readonly>
            <input hidden type="text" name="colorspec_uuid" value="@{{Colorspec}}" readonly>
            <input hidden type="text" name="runsize_uuid" value="@{{runsize_uuid}}" readonly>
            <input hidden type="text" name="optionstring" value="@{{optionstring}}" readonly>
            <input hidden type="text" name="sendbtn" value="@{{optsend}}" readonly>
            <div class="col-md-12">
              <button type="button" class="btn_formProduct btn_op1" ng-click="actionoptsend('op1')" ng-disabled="btndisigned">UPLOAD YOUR FILE & ORDER NOW</button>
            </div>
            <button  type="button" hidden   class="btn_formProduct btn_op2" ng-click="actionoptsend('op2')" ng-disabled="btndisigned">CREATE YOUR DESIGN ONLINE</button>
            <div class="col-md-12">
              <button type="button" class="btn_formProduct btn_op3" ng-click="actionoptsend('op3')" ng-disabled="btndisigned">WE DESIGN IT FOR YOU</button>
            </div>
          </form>
          @endif
        </div>
         <div ng-repeat="op in Coatingarraylist">{"Name":"@{{op.option}}","value":"@{{op.option}}"},</div>
         <!-- <button ng-click="categorias()">categotias</button>
        <input type="text" ng-model="busca" >
        <ul>
           <li ng-repeat="cat in categoriaslist |filter:busca"><b>@{{cat.category_name}}</li><br>
        </ul>  -->
      </div> <!-- end product-section -->
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

</script>
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->

<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
<script src="{{ asset('js/shop.js') }}"></script>

@endsection
