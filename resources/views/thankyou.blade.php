@extends('layout')

@section('title', 'Thank You')

@section('extra-css')

@endsection

@section('body-class', 'sticky-footer')

@section('content')

   <div class="thank-you-section">
       <p style="color: #227522;font-size: 60px;"><i class="fas fa-check-circle"></i></p>
       <h1>Thank you for <br> Your Order!</h1>
       <p>Your order has been placed and is being processed. You will recived an email with the order details.</p>
       <div class="spacer"></div>
       <div>
           <a href="{{ url('/') }}" style="text-decoration: underline;"><i class="fas fa-home"></i> Back to HomePage</a>
           <div class="spacer"></div>
           <div class="spacer"></div>
           <div class="spacer"></div>
           <form action="{{ route('Order-search') }}" method="POST">
                {{ csrf_field() }}
                <input hidden value="{{$successID}}" type="text" id="order" name="order" value="{{ old('order') }}" placeholder="Order No." required autofocus>
                <div class="login-container">
                    To print your order <button type="submit" class="auth-button">Click Here</button>
                </div>
                <div class="spacer"></div>
            </form>
       </div>
   </div>




@endsection
