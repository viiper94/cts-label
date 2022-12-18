@extends('layout.layout')

@section('title', 'CTS Records - New Electronic Music')

@section('content')
    <div class="container pt-3">
        <div class="row flex-nowrap">
            <section class="col content">
                <div class="row">
                    @foreach($releases as $release)
                        <div class="col-sm-4 col-xs-6 release-brief mb-4">
                            <a href="{{ route('release', $release->id) }}">
                                <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" class="img-fluid">
                                <div class="item-overlay">
                                    <div class="item-data">
                                        <div>{{  $release->title  }}</div>
                                    </div>
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
