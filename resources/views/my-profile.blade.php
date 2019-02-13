@extends('layout')

@section('title', 'My Profile')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

@component('components.breadcrumbs')
<a href="/">Home</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>My Profile</span>
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

<div class="products-section container">
    <div class="sidebar">
        <ul>
            <li class="active"><a href="{{ route('users.edit') }}">My Profile</a></li>
            <li><a href="{{ route('orders.index') }}">My Orders</a></li>
        </ul>
    </div> <!-- end sidebar -->
    <div class="my-profile">
        <div class="products-header">
            <h1 class="stylish-heading">My Profile</h1>
        </div>
        <div>
            <form action="{{ route('users.update') }}" method="POST">
                @method('patch')
                @csrf
                <div class="half-form">
                    <div class="form-group">
                        <span>Name:</span>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Name"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <span>Email:</span>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                            placeholder="Email" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <span>Password:</span>
                    <input id="password" type="password" name="password" placeholder="Password (Leave password blank to keep current password)"
                        class="form-control">
                </div>
                <div class="form-group">
                    <span>Password Confirm:</span>
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password"
                        class="form-control">
                </div>
                <div class="form-group">
                    <span>Address:</span>
                    <input placeholder="Address" value="{{ old('Address', $user->Address) }}" type="text" class="form-control"
                        id="address" name="Address" value="{{ old('address') }}">
                </div>
                <div class="half-form">
                    <div class="form-group">
                        <span>City:</span>
                        <input placeholder="City" value="{{ old('City', $user->City) }}" type="text" class="form-control"
                            id="city" name="City" value="{{ old('city') }}">
                    </div>
                    <div class="form-group">
                        <span>Province:</span>
                        <input placeholder="Province" value="{{ old('Province', $user->Province) }}" type="text" class="form-control"
                            id="province" name="Province" value="{{ old('province') }}">
                    </div>
                </div>
                <div class="half-form">
                    <div class="form-group">
                        <span>Postal Code:</span>
                        <input maxlength="5" value="{{ old('PostalCode', $user->PostalCode) }}" placeholder="Postal Code"
                            type="text" class="form-control" id="postalcode" name="PostalCode" value="{{ old('postalcode') }}">
                    </div>
                    <div class="form-group">
                        <span>phone Number:</span>
                        <input placeholder="Phone" value="{{ old('Phone', $user->Phone) }}" type="text" class="form-control"
                            id="phone" name="Phone" value="{{ old('phone') }}" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                            maxlength="12">
                    </div>

                </div>
                <div>
                    <button type="submit" class="my-profile-button">Update Profile</button>
                </div>
            </form>
        </div>

        <div class="spacer"></div>
    </div>
</div>

@endsection

@section('extra-js')
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
@endsection