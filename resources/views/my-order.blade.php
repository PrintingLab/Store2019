@extends('layout')

@section('title', 'My Order')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
<link rel="stylesheet" href="{{ asset('css/myorder.css') }}">
@endsection

@section('content')

@component('components.breadcrumbs')
<a href="/">Home</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>My Order</span>
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
<div class="products-section my-orders container">
@guest
@else
    <div class="sidebar">
        <ul>
            <li><a href="{{ route('users.edit') }}">My Profile</a></li>
            <li class="active"><a href="{{ route('orders.index') }}">My Orders</a></li>
        </ul>
    </div> <!-- end sidebar -->
    @endguest
    <div class="my-profile" id="my-profile">
        <div class="products-header">
        </div>
        <div>
            <div class="grid-container" id="OrderDetails">
                <div class="details-header">
                    <div class="row">
                        <div class="details-header-title col-12">
                            <h2 class="details-title-text">Order Details <span class="pipe">|</span> </h2>
                            <h3 class="order-number">Order #
                                <span class="order-number-value">{{ $order->id }}</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="order-status-area">
                    <div class="row">
                        <div class="col-12">
                            <div class="printer-friendly text-large">
                                <a onclick="printContent('my-profile');">
                                    <div class="printer-icon"><i class="fas fa-print"></i></div>
                                    Print
                                </a>
                            </div>
                            <div class="order-status-section text-x-large">
                                <div class="order-date">Order Date: {{ presentDate($order->created_at) }}</div>
                                <div class="arrival-date">
                                </div>
                                <div class="order-status">Order Status:
                                    <span class="order-status-text">
                                        <span class="{{OrderStatus($order->shipped) }}">{{OrderStatus($order->shipped)
                                            }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function printContent(el) {
                            var restorepage = $('body').html();
                            var printcontent = $('#' + el).clone();
                            $('body').empty().html(printcontent);
                            window.print();
                            $('body').html(restorepage);
                        }
                    </script>
                </div>
                <div class="row payment-instructions">
                    <div class="col-12">
                    </div>
                </div>
                <div class="row order-summary">
                    <div class="checkout-info col-6 col-xs-12 text-large">
                        <div class="col-6 col-xs-12 clearfix">
                            <div class="row">
                                <div class="shipping-info col-3 col-xs-6">
                                    <div class="address-readonly-template">
                                        <h5 class="section-title">Shipping Address</h5>
                                        <div class="address-data text-large">
                                            <div class="name emphasized-address-field">{{ $order->billing_name}}</div>
                                            <div class="street">{{ $order->billing_address }}</div>
                                            <div class="region">
                                                {{ $order->billing_city }}, {{$order->billing_province }} {{
                                                $order->billing_postalcode }}
                                            </div>
                                            <div class="phoneNumber">{{ $order->billing_phone}}</div>
                                            <div class="company">
                                                {{ $order->billing_email}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="payment-info col-3 col-xs-6">
                                    <h5 class="section-title">Payment Information</h5>
                                    <div class="section-data">
                                        <div>{{ $order->payment_gateway}}</div>
                                        <div>{{ $order->payment_id}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-offset-1 col-xs-12">
                        <h5 class="section-title">Order Total</h5>
                        <div class="cart-external-totals text-large">
                            <hr class="hr-skin-simple">
                            <div class="totals-item text-large">
                                <div class="product-total">
                                    Product Total
                                    <span class="right"><span class="discount-price">{{
                                            presentPrice($order->billing_subtotal) }}</span> </span>
                                </div>
                            </div>
                            <hr class="hr-skin-soft">
                            <div class="totals-item shipping text-large">
                                <span>Shipping &amp; Processing</span>
                                <br>
                                <span class="text-small">
                                    {{ $order->shipping_Type}}
                                </span>
                                <span class="right"><span class="discount-price">{{
                                        presentPrice($order->shipping_Value) }}</span></span>
                            </div>
                            <hr class="hr-skin-soft">
                            <div class="totals-item text-large">
                                Sales Tax
                                <span class="right"><span class="price">{{ presentPrice($order->billing_tax) }}</span></span>
                            </div>
                            <hr class="hr-skin-simple">
                            <div class="grand-total-complete totals-item text-large">
                                <span>You Paid:</span>
                                <h3 class="grand-total right"><span class="total-price">{{
                                        presentPrice($order->billing_total) }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <hr class="col-12">
                <div class="col-12 itemsbuttonsrow">
                    <div class="row">
                        <div class="col-3 pad-right">
                            <h3 class="items">{{count($products)}} Item(s) </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper grid-container">
                <div class="cart-content">
                    <div class="cart">
                        <div id="loading-lightbox">
                            &nbsp;
                        </div>
                        <div>
                            <div class="cart-item-group row">
                                <div class="col-12 items">
                                    @foreach ($products as $product)
                                    <div class="cart-item grid-container row item-5240829809" pfid="CT7">
                                        <div class="preview-info col-3 col-sm-3">
                                            <div class="preview-container">
                                                <a href="#largerPreview-MZKQF-45A54-1H1" class="view-larger"
                                                    data-toggle="modal" data-target="#ex{{$product->pivot->product_id}}">
                                                    <img src="../img/Userfiles/{{$product->pivot->imgF}}" alt="Product Image"
                                                        style="border: 1px #e4e4e4 solid;">
                                                    <div class="overlay-wrapper">
                                                        <div class="overlay" adocid="MZKQF-45A54-1H1">
                                                            <div class="text textbutton textbutton-skin-primary textbutton-super textbutton-with-icon textbutton-with-icon-left">
                                                                <span class="textbutton-copy">Preview</span>
                                                                <span class="textbutton-icon textbutton-icon-search"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="ex{{$product->pivot->product_id}}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ex{{$product->pivot->product_id}}">{{$product->pivot->product_decription}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div id="main-page" class="dialog-content-size">
                                                                    <article class="main-content">
                                                                        <div class="modal-preview clearfix">
                                                                            <div class="tabs tabs-skin-minimal tabs-center-headers">
                                                                                <div class="mx-auto" style="width: 150px;">
                                                                                    <div class="btn-group btn-group-toggle"
                                                                                        data-toggle="buttons">
                                                                                        <label onclick="changueside('previewTabFront')" class="btn btn-Front active">
                                                                                            <input  type="radio" name="options"
                                                                                                id="option1"
                                                                                                autocomplete="off"
                                                                                                checked> Front
                                                                                        </label>
                                                                                        @if ($product->pivot->side ==
                                                                                        '4/4' )
                                                                                        <label onclick="changueside('previewTabBack')" class="btn btn-Back">
                                                                                            <input  type="radio" name="options"
                                                                                                id="option2"
                                                                                                autocomplete="off">
                                                                                            Back
                                                                                        </label>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tabs-contents">
                                                                                    <div id="previewTabFront" class="">
                                                                                        <img src="../img/Userfiles/{{$product->pivot->imgF}}"
                                                                                            alt="Product Image">
                                                                                    </div>
                                                                                    <div id="previewTabBack" class="tab-selected"
                                                                                        >
                                                                                        @if ($product->pivot->side ==
                                                                                        '4/4' )
                                                                                        <img src="../img/Userfiles/{{$product->pivot->imgB}}"
                                                                                            alt="Product Image">
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </article>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info col-8 col-offset-1 col-sm-9 col-sm-offset-0">
                                            <div class="item-name">
                                                <h3 class="docName">
                                                    <a href="{{ route('shop.show', $product->slug) }}"><b>{{$product->name
                                                            }}</b></a>
                                                </h3>
                                            </div>
                                            <div class="product_-brake">
                                                @foreach (json_decode($product->pivot->Optionstring, true) as $key)
                                                @if(isset($key['id']))
                                                <p><b>{{Changeoptioname($key['option'])}}:</b>
                                                    {{Changeoptioname($key['name'])}}</p>
                                                @endif
                                                @endforeach
                                                <div><b>Proofing:</b> {{$product->pivot->Proofing}}</div>
                                                <div><b>Job:</b> {{getdesignemode($product->pivot->jobtype)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="order-container">
                <div class="order-header">
                    <div class="order-header-items">
                        <div>
                            Order Items
                        </div>
                    </div>
                </div>
                <div class="order-products">
                    @foreach ($products as $product)
                    <h4>
                        <a href="{{ route('shop.show', $product->slug) }}"><b>{{ $product->name }}</b></a>
                    </h4>

                    <div class="order-product-item" style="border-bottom: 1px #e4e4e4 solid;">
                        <div><img src="../img/Userfiles/{{$product->pivot->imgF}}" alt="Product Image">
                            @if ($product->pivot->side == '4/4' )
                            <img src="../img/Userfiles/{{$product->pivot->imgB}}" alt="Product Image">
                            @endif
                        </div>
                        <div class="product_-brake">
                            @foreach (json_decode($product->pivot->Optionstring, true) as $key)
                            @if(isset($key['id']))
                            <p><b>{{Changeoptioname($key['option'])}}:</b> {{Changeoptioname($key['name'])}}</p>
                            @endif
                            @endforeach
                            <div><b>Proofing:</b> {{$product->pivot->Proofing}}</div>
                            <div><b>Job:</b> {{getdesignemode($product->pivot->jobtype)}}</div>
                        </div>
                    </div>
                    @endforeach
                    </h1>
                </div> 
            </div> -->
            <div class="spacer"></div>
        </div>
    </div>
    @endsection
    @section('extra-js')
    <script>
        $("#previewTabBack").hide()
        function changueside(side) {
            if (side=="previewTabBack") {
                $("#previewTabBack").show()
                $("#previewTabFront").hide()
            }
            if (side=="previewTabFront") {
                $("#previewTabFront").show()
                $("#previewTabBack").hide()
            }
        }
    </script>
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
    @endsection