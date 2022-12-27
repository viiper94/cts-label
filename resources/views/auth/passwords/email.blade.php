@extends('layout.layout')

@section('content')

    <div class="container">
        <div class="d-flex align-items-center flex-column">
            <form action="{{ route('password.email') }}" method="post" class="m-5 p-5 w-50">
                @csrf
                <div class="card text-bg-dark">
                    <div class="card-header">
                        @lang('auth.password_request_header')
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
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>@lang('auth.submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
