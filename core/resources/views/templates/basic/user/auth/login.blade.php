@extends($activeTemplate.'layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-5">
            <div class="text-end">
                <a href="{{ route('home') }}" class="fw-bold home-link"> <i class="las la-long-arrow-alt-left"></i> @lang('Go to Home')</a>
            </div>
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Login')</h5>
                </div>

                <div class="card-body">

                    @include($activeTemplate.'partials.social_login')

                    <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">@lang('Username or Email')</label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control form--control" required>
                        </div>

                        <div class="form-group">
                            <div class="d-flex flex-wrap justify-content-between mb-2">
                                <label for="password" class="form-label mb-0">@lang('Password')</label>
                                <a class="fw-bold forgot-pass"
                                    href="{{ route('user.password.request') }}">
                                    @lang('Forgot your password?')
                                </a>
                            </div>
                            <input id="password" type="password" class="form-control form--control" name="password" required>
                        </div>

                        <x-captcha />

                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                @lang('Remember Me')
                           </label>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="recaptcha" class="btn btn--base w-100">
                                @lang('Login')
                            </button>
                        </div>
                        <p class="mb-0">@lang('Don\'t have any account?') <a href="{{ route('user.register') }}">@lang('Register')</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
