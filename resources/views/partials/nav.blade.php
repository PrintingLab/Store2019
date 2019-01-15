<header>

  <div class="barsignage">
    <img src="/img/signage.svg" alt="">
    <span>ARE YOU LOOKING FOR SIGNAGE, VEHICLE GRAPHICS OR TRADE SHOWS? <a target="_blank" href="http://signslab.com/">CLICK HERE</a>
    </span>
    <img src="/img/signage.svg" alt="">
  </div>
  <div class="haderPc">
    <div class="container">
      <div class="row" id="menuPrincipal">
        <div class="col-md-2 paddingCero">
          <a href="/">
            <img class="logo" src="/img/logo-printing-lab-new-york.svg" alt="">
          </a>
        </div>
        <div class="col-md-1">
          <div class="dropdown displayNone" id="btn_HambDisplayPc">
            <button class="dropdown-toggle btn_hamburguesa" type="button" id="dropdownMenuButton2" data-toggle="dropdown">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="dropdown-menu  menu_H_allPP "  aria-labelledby="dropdownMenuButton2">
              <div class="row">
                <div class="col-md-6">
                  <h6><strong>MARKETINGPRODUCTS</strong></h6>
                  <div class="row">
                    <div class="col-md-8">
                      <ul class="list_dropdown list_dropdown-brake">
                      @foreach (getAllProducts() as $produc)
                       <li style="display: -webkit-inline-box;"><a href="{{ route('shop.show', $produc->slug) }}">{{$produc->name}}</a></li>
                      @endforeach                     
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <h6><strong>CUSTOM APPAREL</strong></h6>
                      <ul class="list_dropdown">
                        <li><a href="#">Short Sleeve T-shirts</a></li>
                        <li><a href="#">Long Sleeve T-shirts</a></li>
                        <li><a href="#">Women</a></li>
                        <li><a href="#">Hoodies</a></li>
                        <li><a href="#">Sweatshirts</a></li>
                        <li><a href="#">Activewear</a></li>
                        <li><a href="#">Polos</a></li>
                        <li><a href="#">Jackets</a></li>
                      </ul>
                      <h6 style="margin-top: 5%;"><strong>LARGE FORMAT</strong></h6>
                      <ul class="list_dropdown">
                        <li><a href="#">Banners</a></li>
                        <li><a href="#">Vinyl Graphics</a></li>
                      </ul>
                    </div>
                    <div class="col-md-6 img_MenuDrop">
                      <img  src="/img/bcards1.jpg" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 search">
        <form action="{{ route('search') }}" method="GET" class="search-form">
    <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="Search for product" required>
    <span class="fa fa-search"></span>
</form>    
        </div>
        <div class="col-md-5 row btn_3top">
          <div class="col-md-5 paddingCero">
              <img src="/img/call-icon.png" alt="">
              <a href="tel:201-305-0404">201-305-0404</a>
          </div>
          @include('partials.menus.main-right')
        </div>
      </div>
    </div>
  </div>


  <div class="headerMb">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="col-sm-12 col-12 row">
          <div class=" col-sm-1 col-2 paddingCero">
            <button type="button" class=" collapsed btn_hamburguesaMB" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            </button>
          </div>
          <div class=" col-sm-4 col-8 center paddingCero">
            <img class="imgLogoH" src="/img/logo-printing-lab-new-york.svg" alt="">
          </div>
          <div class=" col-sm-7 col-6 row btn_3topMovil">




            <div class="col-sm-4 paddingCero">
                <a href="tel:201-305-0404">
                  <img src="/img/call-icon.png" alt="">
                  201-305-0404
                </a>
            </div>



              @guest
              <div class="Btn_Account col-sm-6 paddingCero">
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
              <div class="Btn_Account col-sm-5 row">

                <div class="col-sm-2 paddingCero">
                  <img class="imgUserbtn" src="/img/user-login-printing-lab.png" alt="">
                </div>

                <div class="col-sm-10">
                  <p class="text_Userp">{{ Auth::user()->name }}</p>
                  <button type="button" id="userName" class="btn-myAccount dropdown-toggle" data-toggle="dropdown">
                  Your Account
                  </button>

                  <div class="dropdown-menu center">
                    <li><a href="{{ route('users.edit') }}">Dashboard</a></li>
                    <li>
                      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout</a>
                      </li>
                    </div>
                  </div>


                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
                @endguest






                <div class=" col-sm-3">
                  <a href="{{ route('cart.index') }}">
                    <img src="/img/shopping-bag-printing-lab.png" alt="">
                    @if (Cart::instance('default')->count() > 0)
                    <span class="cart-countMovil">
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
                      <span class="cart-countMovil"><span>{{ Cart::instance('default')->count() }}</span></span>
                      @endif
                      @endif
                    </a>
                  </li>
                  @endforeach --}}









          </div>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <form class="navbar-form navbar-left">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
          </form>
          <ul class="nav navbar-nav">
            <li class="dropdown center">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">MARKETING PRODUCTS<span class="caret"></span></a>
              <ul class="dropdown-menu">
                 @foreach (getAllProducts() as $produc)
                       <li><a href="{{ route('shop.show', $produc->slug) }}">{{$produc->name}}</a></li>
                      @endforeach
              </ul>
            </li>
            <li class="dropdown center">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">CUSTOM APPAREL<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Short Sleeve T-shirts</a></li>
                <li><a href="#">Long Sleeve T-shirts</a></li>
                <li><a href="#">Women</a></li>
                <li><a href="#">Hoodies</a></li>
                <li><a href="#">Sweatshirts</a></li>
                <li><a href="#">Activewear</a></li>
                <li><a href="#">Polos</a></li>
                <li><a href="#">Jackets</a></li>
              </ul>
            </li>
            <li class="dropdown center">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">LARGE FORMAT<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Banners</a></li>
                <li><a href="#">Vinyl Graphics</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>

<div class="border_Mplegable haderPc">
  <div class="container center">
    <div class="col-md-10">
      <ul class="menuPlegable">
        <li>
          <div class="dropdown">
            <button class="dropdown-toggle btn_allPP" type="button" id="dropdownMenuButton3" data-toggle="dropdown">
              ALL PRINT PRODUCTS
            </button>
            <div class="dropdown-menu menu_drop_allPP"  aria-labelledby="dropdownMenuButton2">
              <div class="row">
              <div class="col-md-6">
                  <h6><strong>MARKETINGPRODUCTS</strong></h6>
                  <div class="row">
                    <div class="col-md-8">
                      <ul class="list_dropdown list_dropdown-brake">
                      @foreach (getAllProducts() as $produc)
                       <li style="display: -webkit-inline-box;"><a href="{{ route('shop.show', $produc->slug) }}">{{$produc->name}}</a></li>
                      @endforeach                     
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <h6><strong>CUSTOM APPAREL</strong></h6>
                      <ul class="list_dropdown">
                        <li><a href="#">Short Sleeve T-shirts</a></li>
                        <li><a href="#">Long Sleeve T-shirts</a></li>
                        <li><a href="#">Women</a></li>
                        <li><a href="#">Hoodies</a></li>
                        <li><a href="#">Sweatshirts</a></li>
                        <li><a href="#">Activewear</a></li>
                        <li><a href="#">Polos</a></li>
                        <li><a href="#">Jackets</a></li>
                      </ul>
                      <h6 style="margin-top: 5%;"><strong>LARGE FORMAT</strong></h6>
                      <ul class="list_dropdown">
                        <li><a href="#">Banners</a></li>
                        <li><a href="#">Vinyl Graphics</a></li>
                      </ul>
                    </div>
                    <div class="col-md-6 img_MenuDrop">
                      <img  src="/img/bcards1.jpg" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li>
        <a href="{{ route('shop.index', ['category' => 'LARGE FORMAT']) }}">
            LARGE FORMAT
          </a>
        </li>
        <li>
        <a href="{{ route('shop.index', ['category' => 'CUSTOM APPAREL']) }}">
            CUSTOM APPAREL
          </a>
        </li>
        <li>
          <a href="{{ route('shop.index', ['category' => 'MARKETING PRODUCTS']) }}">
            MARKETING PRODUCTS
          </a>
        </li>
        <li>
          <a href="#">
            CONTACT US
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
