@extends('layout.layout')

@section('title', 'CTS Records - New Electronic Music')

@section('content')
    <div class="container pt-3">
        <div class="row">
            <section class="col">
                <div class="d-flex justify-content-between flex-wrap">
                    @foreach($releases as $release)
                        <div class="release-brief mb-4">
                            <a href="{{ route('release', $release->id) }}" class="d-block">
                                <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" class="img-fluid">
                                <div class="item-overlay d-flex justify-content-center align-items-center p-3 text-center">
                                    <span class="">{{ $release->title }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{ $releases->links('layout.pagination') }}
            </section>
            @include('layout.aside')
        </div>
    </div>
@endsection
