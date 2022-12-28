@extends('layout.layout')

@section('title', 'CTS Records - New Electronic Music')

@section('content')
    <div class="container pt-3">
        <div class="row">
            <section class="col">
                <div class="row g-1">
                    @foreach($releases as $release)
                        <div class="col-md-4 mb-4 g-2">
                            <div class="release-brief">
                                <a href="{{ route('release', $release->id) }}" class="d-block">
                                    <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" class="img-fluid">
                                    <div class="item-overlay d-flex justify-content-center align-items-center p-3 text-center">
                                        <span class="">{{ $release->title }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>

                    @endforeach
                </div>
                {{ $releases->links('layout.pagination') }}
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection
