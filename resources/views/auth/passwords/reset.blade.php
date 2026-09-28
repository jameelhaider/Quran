
@extends('layouts.app')
@section('title', 'Steven Steel Gears - Reset Password')
@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">SET YOUR NEW PASSWORD
            </h4>
            <p class="text-center mt-4" style="font-family: Arimo, sans-serif">Enter your new password and confirm it to
                change your password</p>

            <div class="col-md-8 col-lg-5 mt-2 col-12 col-sm-11 col-xl-5">

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row mb-2">

                        <div class="col-lg-12">
                            <label for="" class="my-2">Your Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" class="custom-input-field @error('email') is-invalid @enderror"
                                name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-1">

                        <div class="col-lg-12">
                            <label for="" class="my-2">New Password <span
                                    class="text-danger">*</span></label>
                            <input id="password" placeholder="Enter New Password" type="password"
                                class="custom-input-field @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-lg-12">
                            <label for="" class="my-2">Confirm New Password <span
                                    class="text-danger">*</span></label>
                            <input id="password-confirm" type="password" placeholder="Confirm Password" class="custom-input-field" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-lg-12">
                            <button type="submit" class="custom-btn w-100">
                                Reset Password
                                <i class="fa-solid fa-check ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
