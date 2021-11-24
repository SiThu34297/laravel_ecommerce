@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="left-auth-container">
                <h1>Returning Customer</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-5">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control @error('email') is-invalid
                            @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required
                            autocomplete="email" autofocus>
                        @error('email')
                        <div class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </div>
                        @enderror
                    </div>
                    {{-- end email --}}
                    <div class="input-group mb-4">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input type="password" class="form-control @error('password') is-invalid
                            @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    {{-- end password --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit">Login</button>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    {{-- end button --}}
                </form>
                <a href="{{ route('password.request') }}">Forget Password?</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="right-auth-container mt-md-0 mt-4">
                <h1>New Customer</h1>
                <span>Save time now.</span>
                <p>You don't neea an account to checkout.</p>

                <a href="{{route('guestCheckout')}}">Continue as Guest</a>

                <span>save time later.</span>
                <p>Create an account for fast checkout, and easy acess to order history.</p>

                <a href="{{route('register')}}">Create Account</a>
            </div>
        </div>
    </div>
</div>
@endsection
