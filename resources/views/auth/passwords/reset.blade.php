@extends('layout.layout')

@section('content')

    <div class="container auth py-5">
        <form action="{{ route('password.request') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="card text-bg-dark m-auto">
                <div class="card-header">
                    @lang('user.password_reset_header')
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <h6 class="text-warning">{{ session('status') }}</h6>
                    @endif
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">@lang('user.password')</label>
                        <input type="password" class="form-control form-dark" name="password" id="password" required>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">@lang('user.password_confirmation')</label>
                        <input type="password" class="form-control form-dark" name="password_confirmation" id="password_confirmation" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>@lang('user.submit')</button>
                </div>
            </div>
        </form>
    </div>

@endsection
