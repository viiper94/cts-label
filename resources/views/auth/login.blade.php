@extends('layout.layout')

@section('content')
    <div class="container">
        <form action="{{ route('login') }}" method="post" class="col-md-7 col-xs-12">
            <div class="form-group">
                <label for="email">@lang('user.email')</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <p class="help-block">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="password">@lang('user.password')</label>
                <input type="password" name="password" id="password" class="form-control">
                @if($errors->has('password'))
                    <p class="help-block">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('auth.remember_me')
                    </label>
                </div>
            </div>
            <div class="form-group">
                @csrf
                <button type="submit" class="btn btn-default">@lang('auth.submit')</button>
                <a class="col s12 center" href="{{ route('password.request') }}">@lang('user.forgot_password')</a>
                <p class="center col s12">@lang('user.dont_have_account')
                    <a href="{{ route('register') }}">@lang('user.register')</a>
                </p>
            </div>
        </form>
        <div class="social-login col-xs-12 col-md-5">
            @include('auth.social')
        </div>
    </div>
@endsection
