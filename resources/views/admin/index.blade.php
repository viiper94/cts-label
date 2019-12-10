@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">

        {{-- Releases --}}
        <div class="releases">
            <h4>Последние релизы:</h4>
            <a href="{{ route('releases_admin') }}" class="btn btn-info"><span class='glyphicon glyphicon-list'></span> Все релизы</a>
            <a href="{{ route('releases_admin') }}/add" class="btn btn-success"><span class='glyphicon glyphicon-plus'></span> Новый релиз</a>
            <div class="items-container">
                @foreach($releases as $release)
                    <div class='item-horizontal-list'>
                        <a href='{{ route('releases_admin') }}/edit/{{ $release->id }}'
                           style="background-image: url(/images/releases/{{ $release->image ?? 'default.png' }})"
                           title="{{ $release->title }}"></a>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- Artists --}}
        <div class="artists">
            <h4>Последние артисты:</h4>
            <a href="{{ route('artists_admin') }}" class="btn btn-info"><span class='glyphicon glyphicon-list'></span> Все артисты</a>
            <a href="{{ route('artists_admin') }}/add" class="btn btn-success"><span class='glyphicon glyphicon-plus'></span> Новый артист</a>
            <div class="items-container">
                @foreach($artists as $artist)
                    <div class='item-horizontal-list'>
                        <a href='{{ route('artists_admin') }}/edit/{{ $artist->id }}'
                           style="background-image: url(/images/artists/{{ $artist->image ?? 'default.png' }})"
                           title="{{ $artist->name }}"></a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection
