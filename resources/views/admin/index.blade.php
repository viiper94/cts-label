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

        {{-- Feedbacks --}}
        <div class="artists">
            <h4>Последние фидбэки:</h4>
            <a href="{{ route('feedback_admin') }}" class="btn btn-info"><span class='glyphicon glyphicon-list'></span> Все фидбэки</a>
            <a href='{{ route('feedback_admin') }}/add' class='btn btn-success'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                Кастомная страница фидбэка
            </a>
            <div class="items-container">
                @if(count($feedback) > 0)
                    @foreach($feedback as $item)
                        <div class='item-horizontal-list'>
                            <a href='{{ route('artists_admin') }}/edit/{{ $item->id }}'
                               style="background-image: url(/images/{{ $item->release ? 'releases/'.($item->release->image ?? 'default.png') : 'feedback/'.($item->image ?? 'default.png') }})"
                               title="{{ $item->feedback_title }}"></a>
                        </div>
                    @endforeach
                @else
                    <h5>Еще нет фидбэков</h5>
                @endif

            </div>
        </div>

    </div>

@endsection
