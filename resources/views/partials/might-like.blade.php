
<div class="might-like-section">
    <div class="container">
        <h2>You might also like...</h2>
        <div class="might-like-grid productSection-Index center">
            @foreach ($mightAlsoLike as $product)
            <div class="col-md-12 col-sm-12 col-12" >
              <div class="btnHoverI"  style="border-top: 1px #e4e4e4 solid;border-right: 1px #e4e4e4 solid;border-left: 1px #e4e4e4 solid;width: 100%;height: 175px;background-size: cover;background-image: url('{{ productImage($product->image) }}');" >
                <div class="btn_info">
                  <a class="a_Shop" href="{{ route('shop.show', $product->slug) }}">SHOP NOW</a>
                </div>
              </div>
              <a href="{{ route('shop.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
              <div class="product-price">from {{ $product->presentPrice() }}</div>
            </div>
            @endforeach

        </div>
    </div>
</div>

