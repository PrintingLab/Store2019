@guest
<div class="Btn_Account col-md-4 paddingCero">
  <img src="/img/user-login-printing-lab.png" alt="">
  <button type="button" class="btn-myAccount dropdown-toggle" data-toggle="dropdown">
  My Account
  </button>
  <div class="dropdown-menu center">
    <li><a href="{{ route('register') }}">Sign Up</a></li>
    <li><a href="{{ route('login') }}">Login</a></li>
  </div>
</div>
@else
<div class="Btn_Account col-md-6 ">

  <img src="/img/user-login-printing-lab.png" alt="">
  <button type="button" id="userName" class="btn-myAccount dropdown-toggle" data-toggle="dropdown">
    {{ Auth::user()->name }}
  </button>
  <div class="dropdown-menu center">
    <li><a href="{{ route('users.edit') }}">Count</a></li>
    <li>
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout</a>
      </li>
    </div>
  </div>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
  </form>
  @endguest
  <div class="col-md-2">
    <a href="{{ route('cart.index') }}">
      <img src="/img/shopping-bag-printing-lab.png" alt="">
      @if (Cart::instance('default')->count() > 0)
      <span class="cart-count">
        <span>{{ Cart::instance('default')->count() }}</span>
      </span>
      @endif
    </a>
  </div>

  {{-- @foreach($items as $menu_item)
    <li>
      <a href="{{ $menu_item->link() }}">
        {{ $menu_item->title }}
        @if ($menu_item->title === 'Cart')
        @if (Cart::instance('default')->count() > 0)
        <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
        @endif
        @endif
      </a>
    </li>
    @endforeach --}}


    <script>
/*var userName=document.getElementById('userName').text();*/
let userName=$('#userName').text();
primera=userName.split(' ');
/*console.log(primera[4]);*/
$('#userName').text(primera[4]);
    </script>
