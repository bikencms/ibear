@extends('layouts.app')
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                    <img src="assets/images/logo_white.png" alt="logo" /> ibear.vn
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="fw-light">Sign up to continue.</h6>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input">
                        Keep me signed in
                        </label>
                    </div>
                    <a href="#" class="auth-link text-black">Forgot password?</a>
                    </div>
                    <div class="mb-2">
                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                        <i class="ti-facebook me-2"></i>Connect using facebook
                    </button>
                    </div>
                    <div class="text-center mt-4 fw-light">
                    Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <main class="py-4">
        <div class="container container-left inline-block c-background">
        <h2>CHÀO BẠN!</h2>
        <p>Nếu bạn đã có tài khoản rồi, hãy</p>
        <a class="button-login" href="{{ route('login') }}">ĐĂNG NHẬP</a>
        </div><div class="container container-right inline-block container-padding text-center">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('ĐĂNG KÝ') }}</div>
                        <div class="social-register">
                            <img src="{{ url('assets/images/facebook-logo.svg') }}" alt="Logo Facebook">
                            <img src="{{ url('assets/images/google-plus-logo.svg') }}" alt="Logo Google Plus">
                            <img src="{{ url('assets/images/linkedin-logo.svg') }}" alt="Logo Linkedin">
                            <p>Hay dùng email của bạn</p>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input id="name" type="text" placeholder="Tên shop" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input id="password" type="password" placeholder="Mật khẩu" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" placeholder="Nhập lại mật khẩu" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary register">
                                            {{ __('LƯU') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </main>
@endsection
