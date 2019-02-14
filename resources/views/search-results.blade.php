@extends('layout')

@section('title', 'Search Results')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Search</span>
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

    <div class="search-results-container container">
        <h1>Search Results</h1>
        <p class="search-results-count">{{ $products->total() }} result(s) for '{{ request()->input('query') }}'</p>

        @if ($products->total() > 0)
        <div class="productSection-Index center" >
        <div>
          <div class="container row">
            @forelse ($products as $product)
            <div class="col-md-4 col-sm-4 col-12" >
              <div class="btnHoverI"  style="border-top: 1px #e4e4e4 solid;border-right: 1px #e4e4e4 solid;border-left: 1px #e4e4e4 solid;width: 100%;height: 175px;background-size: cover;background-image: url('{{ productImage($product->image) }}');" >
                <div class="btn_info">
                  <a class="a_Shop" href="{{ route('shop.show', $product->slug) }}">SHOP NOW</a>
                </div>
              </div>
              <a href="{{ route('shop.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
              <div class="product-price">from {{ $product->presentPrice() }}</div>
            </div>
            @empty
            <div style="text-align: left">No items found</div>
            @endforelse
          </div> <!-- end products -->
          <div class="spacer"></div>
          {{ $products->appends(request()->input())->links() }}
        </div>
      </div>
        @endif
    </div> <!-- end search-results-container -->

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <!-- <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script> -->
@endsection
