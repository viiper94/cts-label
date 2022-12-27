@extends('layout.layout')

@section('content')

    <div class="container">
        <div class="d-flex align-items-center flex-column">
            <form action="{{ route('password.request') }}" method="post" class="m-5 p-5 w-50">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="card text-bg-dark">
                    <div class="card-header">
                        @lang('auth.password_reset_header')
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
                            <label for="password_confirmation" class="form-label">@lang('auth.password_confirmation')</label>
                            <input type="password" class="form-control form-dark" name="password_confirmation" id="password_confirmation" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>@lang('auth.submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
