@extends('layout')

@section('title', 'About Us')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
<script type="text/javascript" src="{!! asset('js/jquery-3.3.1.min.js') !!}"></script>
@endsection
@section('content')
<div class="container containerProducts">
  <div class="col-md-12">
    <h1 class="titlecontact">About Us</h1>
  </div>
  <div class="col-md-12">
    <h2>Our History</h2>
    <p>The company's success is a real testament to its focus, and its value to customers. It built itself up from a small company located in Union City, NJ to become one of the leading printing companies in the Tri-State area. Printing Lab has always been committed to social responsibility and eco-friendly printing initiatives. The company has further evolved from a simple point-of-purchase printing and display manufacturing company into a regional force and is now flourishing in the E-commerce arena with the addition of Printinglab.com.</p>
  </div>
  <div class="col-md-12">
    <h2>Our Mission</h2>
    <p>To help each and every client find the best, cost effective printing solutions, with the most appealing design and display, that will promote their personal or business vision aimed at achieving growth and success!</p>
  </div>
  <div class="col-md-12">
    <h2>Our Vision</h2>
    <p>Printinglab.com strives to design and create products that surpass customer expectations and create the highest quality products for every individual client we serve.</p>
  </div>
</div>
@endsection
