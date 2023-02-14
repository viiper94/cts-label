@extends('layout.layout')

@section('content')
    <div class="container auth py-5">
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="card text-bg-dark m-auto">
                <div class="card-header">
                    @lang('user.login_header')
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">@lang('user.email')</label>
                        <input type="email" class="form-control form-dark" name="email" id="email" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">@lang('user.password')</label>
                        <input type="password" class="form-control form-dark" name="password" id="password" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember" @checked(old('remember'))>
                        <label for="remember" class="form-check-label">@lang('user.remember_me')</label>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                    <div class="">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>@lang('user.submit')</button>
                        <a href="{{ route('register') }}" class="btn btn-outline"><i class="fa-solid fa-user-plus me-2"></i>@lang('user.register')</a>
                    </div>
                    <a href="{{ route('password.request') }}" class="py-2 d-inline-block">@lang('user.forgot_password')</a>
                </div>
            </div>
{{--            <h5 class="my-4 text-center text-muted">OR</h5>--}}
{{--            <div class="d-flex justify-content-center">--}}
{{--                <a href="{{ route('auth.google') }}" class="btn btn-lg btn-outline">--}}
{{--                    <i class="fa-brands fa-google me-2"></i>Login with Google--}}
{{--                </a>--}}
{{--            </div>--}}
        </form>

    </div>
@endsection
