@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

@component('components.breadcrumbs')
<a href="#">Home</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>Shopping Cart</span>
@endcomponent

<div class="container">
  <div>
    @if (session()->has('success_message'))
    <div class="alert alert-success containerAlerts">
      {{ session()->get('success_message') }}
    </div>
    @endif
    @if(count($errors) > 0)
    <div class="alert alert-danger containerAlerts">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif



    <!--  carro real-->


    @if (Cart::count() > 0)

    <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>
    <div class="col-md-12">
      @foreach (Cart::content() as $item)
      <div class="row productRow">
        <div class="col-md-4">
          @if ($item->options->side=='4/4')
          <div class="row">
            <div class="col-6 col-sm-6 col-md-6">
              @if ((extensioImg($item->options->imgF) =='jpg')||(extensioImg($item->options->imgF) =='png'))
              <img src="storage/Userfiles/{{$item->options->imgF}}" alt="item" class="cart-table-img">
              @else
              <embed src="storage/Userfiles/{{$item->options->imgF}}" type="application/pdf"   height="120px" width="100%">
                @endif
              </div>
              <div class="col-6 col-sm-6 col-md-6">
                @if ((extensioImg($item->options->imgB) =='jpg')||(extensioImg($item->options->imgB) =='png'))
                <img src="storage/Userfiles/{{$item->options->imgB}}" alt="item" class="cart-table-img">
                @else
                <embed src="storage/Userfiles/{{$item->options->imgB}}" type="application/pdf"   height="120px" width="100%">
                  @endif
                </div>
              </div>
              @else
              <div class="col-md-12">
                @if ((extensioImg($item->options->imgF) =='jpg')||(extensioImg($item->options->imgF) =='png'))
                <img src="storage/Userfiles/{{$item->options->imgF}}" alt="item" class="cart-table-img">
                @else
                <embed src="storage/Userfiles/{{$item->options->imgF}}" type="application/pdf"   height="120px" width="100%">
                  @endif
                </div>
                @endif
              </div>
              <div class="col-sm-3 col-md-3">
                <div class="cart-table-item"><a href=""><strong>{{ $item->name }}</strong></a></div>
                <div class="cart-table-description">{{ $item->options->decription }}</div>
              </div>
              <div class="col-sm-5 col-md-5 row">
                <div class="col-8 col-sm-8 col-md-8 cart-table-actions">
                  <div class="checkout-table-row-right">
                    <div class="checkout-table-quantity"> <strong>Quantity:</strong> {{$item->options->quantity }}</div>
                    <div class="checkout-table-quantity"> <strong>Printed Side:</strong> {{ getPrintingsides($item->options->side) }}</div>
                    <div class="checkout-table-quantity"> <strong>Turnaround:</strong> {{ getPrintingTime($item->options->tat) }}</div>
                  </div>
                  <!-- <form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="POST">
                  {{ csrf_field() }}
                  <button type="submit" class="cart-options">Save for Later</button>
                </form> -->
              </div>
              <div class="col-4 col-sm-4 col-md-4">
                <div class="productotalbold">{{presentPrice($item->subtotal) }}</div>
                <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btnDeleProduct">Remove</button>
                </form>
              </div>
            </div>
          </div> <!-- end cart-table-row -->
          @endforeach
        </div> <!-- end cart-table -->

        @if (! session()->has('coupon'))

        <div class="containerCodeCart">
          <h3><strong>Have a Code?</strong></h3>
          <div class="have-code-container">
            <form action="{{ route('coupon.store') }}" method="POST">
              {{ csrf_field() }}
              <input type="text" name="coupon_code" id="coupon_code">
              <button type="submit" class="btn_CodeApply">Apply</button>
            </form>
          </div> <!-- end have-code-container -->
        </div>

        @endif


        <div class="containerPriceCart">


          <div class="col-md-12 row">

            <div class="col-md-2">
              <strong>Subtotal</strong> <br>
              @if (session()->has('coupon'))
              Code ({{ session()->get('coupon')['name'] }})
              <form action="{{ route('coupon.destroy') }}" method="POST" style="display:block">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <button type="submit" style="font-size:14px;" >Remove</button>
              </form>
              <hr>
              New Subtotal <br>
              @endif
            
              <span class="cart-totals-total"><strong>Total</strong></span>
            </div>

            <div class="col-md-2">
              {{ presentPrice(Cart::subtotal()) }} <br>
              @if (session()->has('coupon'))
              -{{ presentPrice($discount) }} <br>&nbsp;<br>
              <hr>
              {{ presentPrice($newSubtotal) }} <br>
              @endif

              <span class="cart-totals-total totalbold">{{ presentPrice($newTotal) }}</span>
            </div>
          </div>

          <div class="col-md-12 btnsShopping">
            <a href="{{ route('shop.index') }}" class="btn_Cshopping">Continue Shopping</a>
            <a href="{{ route('checkout.index') }}" class="btn_Pcheckout">Proceed to Checkout</a>
          </div>

        </div>



        @else
        <h3>No items in Cart!</h3>
        <div class="spacer"></div>
        <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
        <div class="spacer"></div>

        @endif

        @if (Cart::instance('saveForLater')->count() > 0)

        <h2>{{ Cart::instance('saveForLater')->count() }} item(s) Saved For Later</h2>

        <div class="saved-for-later cart-table">
          @foreach (Cart::instance('saveForLater')->content() as $item)
          <div class="cart-table-row">
            <div class="cart-table-row-left">
              <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{ asset('img/products/'.$item->model->slug.'.jpg') }}" alt="item" class="cart-table-img"></a>
              <div class="cart-item-details">
                <div class="cart-table-item"><a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a></div>
                <div class="cart-table-description">{{ $item->model->details }}</div>
              </div>
            </div>
            <div class="cart-table-row-right">
              <div class="cart-table-actions">
                <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}

                  <button type="submit" class="cart-options">Remove</button>
                </form>

                <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="POST">
                  {{ csrf_field() }}

                  <button type="submit" class="cart-options">Move to Cart</button>
                </form>
              </div>

              <div>{{ $item->model->presentPrice() }}</div>
            </div>
          </div> <!-- end cart-table-row -->
          @endforeach

        </div> <!-- end saved-for-later -->

        @else

        <!-- <h3>You have no items Saved for Later.</h3> -->

        @endif

      </div>

    </div> <!-- end cart-section -->

    @include('partials.might-like')


    @endsection

    @section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
   <script src="{{ asset('js/cart.js') }}"></script>

    <script>
    (function(){
      const classname = document.querySelectorAll('.quantity')

      Array.from(classname).forEach(function(element) {
        element.addEventListener('change', function() {
          const id = element.getAttribute('data-id')
          const productQuantity = element.getAttribute('data-productQuantity')

          axios.patch(`/cart/${id}`, {
            quantity: this.value,
            productQuantity: productQuantity
          })
          .then(function (response) {
            // console.log(response);
            window.location.href = '{{ route('cart.index') }}'
          })
          .catch(function (error) {
            // console.log(error);
            window.location.href = '{{ route('cart.index') }}'
          });
        })
      })
    })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
    @endsection
