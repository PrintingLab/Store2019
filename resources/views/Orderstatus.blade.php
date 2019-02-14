@extends('layout')

@section('title', 'Oreder Status')

@section('content')
<div class="container">
    <div class="auth-pages">
        <div class="auth-left">
            @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
            @endif @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h2>Search For You Order</h2>
            <div class="spacer"></div>
            <form action="{{ route('Order-search') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" id="order" name="order" value="{{ old('order') }}" placeholder="Order No." required autofocus>
                <div class="login-container">
                    <button type="submit" class="auth-button">Search</button>
                </div>
                <div class="spacer"></div>
            </form>
        </div>

        <div class="auth-right">
            <h2>New Customer</h2>
            <div class="spacer"></div>
            <p><strong>Save time later.</strong></p>
            <p>Create an account for fast checkout and easy access to order history.</p>
            <div class="spacer"></div>
            <a href="{{ route('register') }}" class="auth-button-hollow">Create Account</a>
            <div class="spacer"></div>
            &nbsp;
            <div class="spacer"></div>
            <p>Already have an account?</p>
            <div class="spacer"></div>
            <a href="{{ route('login') }}" class="auth-button-hollow">Login</a>
        </div>
    </div>
</div>
@endsection
