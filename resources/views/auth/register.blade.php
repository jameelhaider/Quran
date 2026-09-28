@extends('layouts.app')
@section('title', 'Steven Steel Gears - Create Account')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">CREATE ACCOUNT</h4>
            <p class="text-center mt-3" style="font-family: Arimo, sans-serif">Please register below to create an account
            </p>
            <div class="col-md-8 col-lg-5 col-12 col-sm-11 col-xl-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-1">
                        <div class="col-lg-12">
                            <label for="" class="my-2">Your Name <span class="text-danger">*</span></label>
                            <input id="name" type="text" placeholder="Enter Your Name"
                                class="custom-input-field @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-lg-12">
                            <label for="" class="my-2">Your Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" placeholder="Enter Your Email"
                                class="custom-input-field @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-lg-12">
                            <label for="" class="my-2">Password <span class="text-danger">*</span></label>
                            <input id="password" type="password" placeholder="Enter Password"
                                class="custom-input-field @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <label for="" class="my-2">Confirm Password <span class="text-danger">*</span></label>
                            <input id="password-confirm" placeholder="Confirm Password" type="password"
                                class="custom-input-field" name="password_confirmation" required
                                autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-lg-12">

                            <div class="d-none d-lg-block d-mb-block d-sm-block">
                                <button type="submit" class="custom-btn mt-2">
                                    CREATE AN ACCOUNT
                                    <i class="fa-solid fa-user-plus ms-2"></i>
                                </button>
                            </div>


                            <div class="d-md-none d-lg-none d-sm-none">
                                <button type="submit" class="custom-sm-btn mt-2">
                                    CREATE AN ACCOUNT
                                    <i class="fa-solid fa-user-plus ms-2"></i>
                                </button>
                            </div>


                            <div class="text-center mt-2">
                                <a href="{{ route('login') }}" class="text-dark">Already Have An Account?</a>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
