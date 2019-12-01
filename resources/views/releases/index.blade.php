@extends('layout.layout')

@section('title', 'CTS Records - New Electronic Music')

@section('content')
    <div class = "container">
        <div class="col-md-9 col-sm-8 content">
            <div class="row" style="margin-top: -4px;">
            @foreach($releases as $release)
                    <div class="col-sm-4 col-xs-6 release-brief">
                        <a href="{{ route('release', $release->id) }}">
                            <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" class="img-responsive"/>
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
        </div>
        @include('layout.aside')
    </div>
@endsection
