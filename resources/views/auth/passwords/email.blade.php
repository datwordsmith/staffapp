@extends('layouts.auth')

@section('content')

<div class="container-fluid h-100">
    <div class="row full-height">
        <div class="col-md-6 col-lg-6 d-none d-md-block">
            <div class="col-12 h-100 d-flex align-items-center justify-content-center">
                {{-- <img src="{{ asset('admin/assets/images/staff.png') }}"  class= "img-fluid w-50" alt="Splash Image"> --}}
            </div>
        </div>

        <div class="col-md-6 col-lg-6">

            <div class="row mt-5 pt-3">
                <div class="col-12 mt-5 text-center">
                    <img src="{{ asset('admin/assets/images/fulafia_logo_black.png') }}"  class= "img-fluid w-25" alt="Splash Image">
                    <h5 class="mt-2">Staff Portal</h5>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="card shadow rounded-5 mt-3">
                        <div class="card-body">
                            <h5 class="text-center mb-2">{{ __('Reset Password') }}</h5>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}" class="w-md-50">
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

                                <div class="d-grid gap-2 col-12 mx-auto">
                                    <button type="submit" class="btn btn-primary d-block">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>

                                <div class="text-center mb-0 mt-3">
                                    <a class="btn btn-link" href="{{ url('/login')}}">
                                        Return to login
                                    </a>
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
