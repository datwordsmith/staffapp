@extends('layouts.auth')

@section('content')


<div class="container-fluid h-100">
    <div class="row full-height">
        <div class="col-md-6 col-lg-6 d-none d-md-block">
            <div class="col-12 h-100 d-flex align-items-center justify-content-center">
                {{-- <img src="{{ asset('admin/assets/images/staff.png') }}"  class= "img-fluid w-50" alt="Splash Image"> --}}
            </div>
        </div>


        <div class="col-md-6 col-lg-6 bg-sm-danger">
            <div class="row mt-5 pt-3">
                <div class="col-12 mt-5 text-center">
                    <img src="{{ asset('admin/assets/images/fulafia_logo_black.png') }}"  class= "img-fluid w-25" alt="Splash Image">
                    <h5 class="mt-2">Staff Portal</h5>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="card shadow rounded-5">
                        <div class="card-body">

                            <form method="POST" action="{{ route('login') }}" class="w-md-50">
                                @csrf

                                <div class="form-floating mb-3">
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email@address.com">
                                    <label for="email">{{ __('Email Address') }}</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                    <label for="password">{{ __('Password') }}</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                <div class="d-grid gap-2 col-12 mx-auto">
                                    <button type="submit" class="btn btn-primary d-block">
                                        {{ __('Login') }}
                                    </button>
                                </div>

                                <div class="">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
