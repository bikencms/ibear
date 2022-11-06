@extends('layouts.app')

@section('content')
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
@endsection
