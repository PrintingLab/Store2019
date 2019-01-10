@extends('layout')

@section('title', $product->name)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
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
<div >
    <div  class="product-section container" ng-controller="shopcontroller">
    <script>
        var prtd = '{!!$product !!}'
    var apiID = '{!!$product->apiID !!}'
    var prtdname = '{!!$product->name  !!}'
    </script>
        <div>
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
            <p>
                {!! $product->description !!}
            </p>
            <!-- @{{prdselect2}}
            @{{prdselect}}
            @{{prdselect3}}
            @{{prdselect1}}
             -->
        </div>
        <div class="product-section-information" Style="position:relative"}>
        
            <h1  class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
            <div id="preloader">
                   <div class="flexloader">
                       <div class="loader">
                           <i class="fa fa-cog fa-4x yellow">
                           </i>
                           <i class="fa fa-cog fa-4x black">
                           </i>
                        </div>
                    </div>
                    <p class="Calculating "> Loading options...
This may take a few seconds.</p>
                </div>
                
                <div ng-hide="moreoptions">
              <form id="list_view_filter" name="list_view_filter">
					<input type="hidden" id="id_category" name="id_category" value="1">
					<fieldset>
						    <div class="jt_filters">
                            <div class="filter_name">
							         Dimensions: 
							    </div> <!-- end filter_name -->
							    <div class="filter_select">
                                {!! $product->dinamicoption !!} 
							    </div> <!-- end filter-select -->
							    <div class="filter_name">
							         Stock: 
                                </div> <!-- end filter_name -->
                                 <!-- <div ng-repeat="op in stockarry  | unique: 'option'">@{{op.option}}</div>  -->
							    <div class="filter_select">
								    <select name="stock" id="stock">
									   <option value="@{{op.value}}" ng-repeat="op in stockarry  | unique: 'option'">@{{stockname(op.option)}}</option>
								    </select>
							    </div> <!-- end filter-select -->
							    <div class="clear"></div>
                            </div> <!-- end jt_filters -->
                            <div class="jt_filters" ng-hide="showcorners">
							    <div class="filter_name">
							         Corners: 
							    </div> <!-- end filter_name -->
							    <div class="filter_select" >
                                <select name="roundcorners" id="roundcorners">
                                        <option id="idStandard" value="Standard">Standard Corners</option>
                                        <option id="idRound" value="Round">Round Corners</option> 
								</select>
							    </div> <!-- end filter-select -->
							    <div class="clear"></div>
						    </div> <!-- end jt_filters -->
						    <div class="jt_filters">
							    <div class="filter_name">
							         Coating: @{{prdselect3}}
							    </div> <!-- end filter_name -->
							    <div class="filter_select">
								    <select name="coating" id="coating">
                                    <option value="@{{op.product_code}}" ng-repeat="op in Coatingarraylist">@{{op.option}}</option>
								    </select>
							    </div> <!-- end filter-select -->
							    <div class="clear"></div>
						    </div> <!-- end jt_filters -->
						    <div class="clear"></div>
						    <div class="jt_filters">
							    
							    <div class="clear"></div>
						    </div> <!-- end jt_filters -->
						    
					</fieldset>
                </form>
               
            
            <div class="filter_name">
            Printed Side: 
			</div>
            <select name="" id="side">
            <option value="@{{op.capi_description.slice(0,3)}}" ng-repeat="op in productside">@{{stockname(op.capi_name)}}</option>
        </select>
          <div class="filter_name">
          Quantity: 
			</div>
          <select name="" id="quantyti">
              <option value="@{{qty.option_description}}" ng-repeat="qty in productprices">
               @{{qty.option_name}}
              </option>
          </select>
          <div class="filter_name">
          Printing Time: 
			</div>
          <select name="" id="TurnAroundTime">
              <option value="@{{qty.option_name}}" ng-repeat="qty in productTurnAroundTime | filter:quantyti | filter:side | unique: 'option_description'">
               @{{qty.option_description}}
              </option>
          </select>
          <div class="product-section-price">
<label for="product-section-price">Printing Cost:</label>
            <img src="{{ asset('img/settings/gif-load-13.gif') }}" alt="" ng-hide="priceshow" >
            <input id="product-section-price" value="@{{priceformat(buildprice)}}" ng-show="priceshow" readonly disabled>
            <div class="price-per-piece" ng-show="priceshow">( Only $@{{priceperpiece}} each )</div>          
</div class="formoptions">
            </div> 
            <p>&nbsp;</p>
            @if ($product->quantity > 0)
            <form action="{{ route('cart.cartstep', $product) }}" method="POST">
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
                    <button type="submit" name="sendbtn" value="op1" class="button button-plain" ng-disabled="btndisigned">UPLOAD YOUR FILE & ORDER NOW</button>
                    <button hidden type="submit" name="sendbtn" value="op2" class="button button-plain" ng-disabled="btndisigned">CREATE YOUR DESIGN ONLINE</button>
                    <button type="submit" name="sendbtn" value="op3" class="button button-plain" ng-disabled="btndisigned">WE DESIGN IT FOR YOU</button>
                </form>
            @endif
       <!--     <p>Estimate Shipping Cost and Delivery Date</p>
         <input id="zip_code" ng-model="zip_code">
        <button id="compute_shipping_btn" ng-click="computeshipping()" >Show options</button>
        <div class="shippingResult" id="div_shipping" ng-repeat="ship in shipping_options">

                        <label class="col-md-12 label-result">
                            <div class="shippingServices clearfix">
                                <input id="ship_FEDEX_GROUND" type="radio" class="shipRadio" style="outline: none;" checked="checked" name="shipping_selected" value="11.21|FEDEX_GROUND|0||4">&nbsp;
                               
                                    <label for="ship_FEDEX_GROUND" class="shipping-cost shipping-rate-wrap" style="float:right">
                                           @{{ship.service_price}}
                                    </label>
                                        <label for="ship_FEDEX_GROUND" class="shipping-detail">@{{ship.service_name}}&nbsp;</label>
                            </div>
                        </label>
                       
            </div>
        </div> -->

        
    </div> <!-- end product-section -->
</div>
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
