@extends('layout.layout')

@section('content')
    <div class="container">
        <form action="{{ route('password.request') }}" method="post" class="col-md-offset-3 col-md-6 col-xs-12">
            @if (session('status'))
                <h6 class="center">{{ session('status') }}</h6>
            @endif
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
                <label for="password_confirmation">@lang('user.password_confirmation')</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
            <div class="form-group">
                @csrf
                <button type="submit" class="btn btn-default">@lang('auth.submit')</button>
            </div>
        </form>
    </div>
@endsection
