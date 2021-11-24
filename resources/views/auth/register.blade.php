@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="left-auth-container">
                <h1>Register Customer Acount</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-group mb-5">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa fa-user"></i>
                        </span>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            placeholder="Name">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
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
                    <div class="input-group mb-5">
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

                    <div class="input-group mb-4">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Retype Password">
                    </div>
                    {{-- end password --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button type="submit">Register</button>
                    </div>
                    {{-- end button --}}
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="right-auth-container mt-md-0 mt-4">
                <h1>Have An Account?</h1>
                <span>Save time now.</span>
                <p>Log In To Your Account.</p>

                <a href="{{route('login')}}">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection



{{-- <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address')
            }}</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password')
            }}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm
            Password') }}</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>
    </div>
</form> --}}
