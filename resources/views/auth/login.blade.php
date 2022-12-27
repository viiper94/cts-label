@extends('layout.layout')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center flex-column">
            <form action="{{ route('login') }}" method="post" class="m-5 p-5 w-50">
                @csrf
                <div class="card text-bg-dark">
                    <div class="card-header">
                        @lang('auth.login_header')
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
                            <label for="remember" class="form-check-label">@lang('auth.remember_me')</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>@lang('auth.submit')</button>
                        <a href="{{ route('register') }}" class="btn btn-outline"><i class="fa-solid fa-user-plus me-2"></i>@lang('user.register')</a>
                        <a href="{{ route('password.request') }}" class="ms-3">@lang('user.forgot_password')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
