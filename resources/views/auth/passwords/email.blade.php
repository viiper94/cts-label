@extends('layout.layout')

@section('content')
    <div class="container">
        <form action="{{ route('password.email') }}" method="post" class="col-md-offset-3 col-md-6 col-xs-12">
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
                @csrf
                <button type="submit" class="btn btn-default">@lang('auth.submit')</button>
            </div>
        </form>
    </div>
@endsection
