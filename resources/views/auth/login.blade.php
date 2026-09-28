@extends('layouts.app')
@section('title', 'Steven Steel Gears - Sign In')
@section('content')
    <div class="container">
        <style>
            .auth-links {
                display: flex;
                justify-content: center;
                gap: 20px;
                margin-top: 10px;
                flex-wrap: wrap;
            }

            .auth-links a {
                color: #000;
                text-decoration: none;
                font-family: 'Arimo', sans-serif;
                font-size: 14px;
                transition: color 0.3s ease;
            }

            .auth-links a:hover {
                color: #555;
                text-decoration: underline;
            }
        </style>
        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">SIGN IN TO YOUR
                ACCOUNT</h4>
            <p class="text-center mt-4" style="font-family: Arimo, sans-serif">Please enter your email and password below to
                access your account</p>
            <div class="col-md-8 col-lg-5 mt-2 col-12 col-sm-11 col-xl-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="" class="my-2">Your Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" placeholder="Enter Your Email"
                                class="custom-input-field @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-lg-12">
                            <label for="" class="my-2">Password <span class="text-danger">*</span></label>
                            <input id="password" type="password" placeholder="Enter Password"
                                class="custom-input-field @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">

                            <label class="custom-checkbox">
                                <input type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <span class="box"></span>

                                Remember Me
                            </label>

                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="custom-outline-btn mt-2">
                                SIGN IN
                                <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                            </button>
                            <div class="auth-links">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                <a href="{{ route('register') }}">
                                    {{ __("Don't Have An Account?") }}
                                </a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>




        </div>
    </div>
@endsection
