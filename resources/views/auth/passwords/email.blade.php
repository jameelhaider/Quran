
@extends('layouts.app')
@section('title', 'Steven Steel Gears - Forgot Password')
@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">RESET YOUR PASSWORD
            </h4>
            <p class="text-center mt-3" style="font-family: Arimo, sans-serif">We will send you an email to reset your
                password enter email to get your account back</p>

            <div class="col-md-8 col-lg-5 mt-2 col-12 col-sm-11 col-xl-5">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
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

                    <div class="row mb-0">
                        <div class="col-lg-12">

                            <button type="submit" class="custom-outline-btn w-75 mt-2">
                                Send Password Reset Link
                                <i class="fa-solid fa-paper-plane ms-2"></i>
                            </button>
                                <a class="text-dark ms-3" href="{{ route('login') }}">
                                    {{ __('Cancel') }}
                                </a>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
