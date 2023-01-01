@extends('layout.layout')

@section('content')

    <div class="container auth py-5">
        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="card text-bg-dark m-auto">
                <div class="card-header">
                    @lang('user.password_request_header')
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <h6 class="text-warning">{{ session('status') }}</h6>
                    @endif
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">@lang('user.email')</label>
                        <input type="email" class="form-control form-dark" name="email" id="email" value="{{ old('email') }}" required>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>@lang('user.submit')</button>
                </div>
            </div>
        </form>
    </div>

@endsection
