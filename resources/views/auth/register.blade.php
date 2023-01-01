@extends('layout.layout')

@section('content')
    <div class="container auth py-5">
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="card text-bg-dark m-auto">
                <div class="card-header">
                    @lang('user.register_header')
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">@lang('user.name')</label>
                        <input type="text" class="form-control form-dark" name="name" id="name" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
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
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">@lang('user.password_confirmation')</label>
                        <input type="password" class="form-control form-dark" name="password_confirmation" id="password_confirmation" required>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>@lang('user.register')</button>
                    <a href="{{ route('login') }}" class="d-inline-block py-2">@lang('user.already_have_account')</a>
                </div>
            </div>
        </form>
    </div>
@endsection
