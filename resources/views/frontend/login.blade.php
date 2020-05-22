@extends('frontend.app')
@section('icerik')
<title>Fashi | Login</title>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>Login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Form Section Begin -->

    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">
                        <h2>{{Lang::get('giris.giris')}}</h2>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="group-input">
                                <label for="username">{{Lang::get('giris.mail')}} *</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="group-input">
                                <label for="pass">{{Lang::get('giris.sifre')}} *</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="group-input gi-check">
                                <div class="gi-more">
                                    <label for="save-pass">
                                        {{Lang::get('giris.yaddaSaxla')}}
                                        <input class="form-check-input" type="checkbox" name="remember" id="save-pass" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a class="forget-pass" href="{{ route('password.request') }}">
                                            {{ __(Lang::get('giris.sifremiUnutdum')) }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="site-btn login-btn">{{Lang::get('giris.giris')}}</button>
                        </form>
                        <div class="switch-login">
                            <a href="/register" class="or-login">{{Lang::get('giris.yeniHesab')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->
@endsection

@section('css')
@endsection

@section('js')
@endsection
