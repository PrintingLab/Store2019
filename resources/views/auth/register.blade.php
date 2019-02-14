@extends('layout')

@section('title', 'Sign Up for an Account')

@section('content')
<div class="container">
    <div class="auth-pages">
        <div>
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
            <h2>Create Account</h2>
            <div class="spacer"></div>

            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>

                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>

                <input id="password" type="password" class="form-control" name="password" placeholder="Password" placeholder="Password" required>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"
                    required>
                    <div class="form-group">
                        <input placeholder="Address" type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                    </div>

                    <div class="half-form"> 
                        <div class="form-group">
                            <input placeholder="City" type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" ng-model="city"  required>
                        </div>
                        <div class="form-group">
                            <input placeholder="Province" type="text" class="form-control" id="province" name="province" value="{{ old('province') }}"   required>
                        </div>
                    </div> 
                    <div class="half-form">
                        <div class="form-group">
                            <input maxlength="5" placeholder="Postal Code" type="text" class="form-control" id="postalcode" name="postalcode" value="{{ old('postalcode') }}"  required>
                        </div>
                        <div class="form-group">
                            <input placeholder="Phone" type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" required>
                        </div>

                        </div>
                <div class="login-container">
                    <button type="submit" class="auth-button">Create Account</button>
                    <div class="already-have-container">
                        <p><strong>Already have an account?</strong></p>
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>

            </form>
        </div>
<script>
$("input[name='phone']").keyup(function() {
    $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "$1-$2-$3"));
});
</script>
        <div class="auth-right">
            <h2>New Customer</h2>
            <div class="spacer"></div>
            <p><strong>Save time now.</strong></p>
            <p>Creating an account will allow you to checkout faster in the future, have easy access to order history and customize your experience to suit your preferences.</p>

            
        </div>
    </div> <!-- end auth-pages -->
</div>
@endsection
