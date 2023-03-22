@extends('admin.layout.layout')

@section('title')
    Треки | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid admin-tracks">
        <div class="justify-content-end align-items-center d-flex flex-column-reverse flex-lg-row my-3">
            {{ $tracks->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <div class="table-responsive" data-fl-scrolls>
            <table class="table table-hover table-dark">
                <thead>
                @php $headers = [
                        'artists' => 'Артисты',
                        'name' => 'Название',
                        'mix_name' => 'Микс',
                        'isrc' => 'ISRC',
                        'genre' => 'Жанр',
                        'length' => 'Длина'
                    ];
                @endphp
                <tr>
                    <th>Релиз</th>
                    @foreach($headers as $key => $item)
                        <th>
                            <a href="{{ route('tracks.index', [
                                    'sort' => $key,
                                    'dir' => (Request::input('dir') === 'up' ? 'down' : 'up'),
                                    'q' => Request::input('q'),
                                ]) }}" class="text-light text-nowrap">
                                {{ $item }}
                            </a>
                            @if(Request::input('sort') === $key)
                                <i @class([
                                    'fa-solid text-warning',
                                    'fa-arrow-down-a-z' => (Request::input('dir') === 'up'),
                                    'fa-arrow-down-z-a' => (Request::input('dir') === 'down'),
                                ])></i>
                            @endif
                        </th>
                    @endforeach
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tracks as $track)
                    <tr class="text-nowrap">
                        <td>
                            @foreach($track->releases as $release)
                                <a href="{{ route('releases.edit', $release->id) }}" target="_blank" title="{{ $release->title }}">
                                    <img src="/images/releases/{{ $release->image }}" alt="{{ $release->title }}" class="img-fluid" style="height: 30px">
                                </a>
                            @endforeach
                        </td>
                        <td>
                            {{ $track->artists }}
                        </td>
                        <td>
                            <b>{{ $track->name }}</b>
                        </td>
                        <td>
                            {{ $track->mix_name }}
                        </td>
                        <td>
                            {{ $track->isrc }}
                        </td>
                        <td>
                            {{ $track->genre }}
                        </td>
                        <td>
                            {{ $track->length }}
                        </td>
                        <td class="text-end">
                            @if($track->youtube)
                                <a href="{{ $track->youtube }}" target="_blank" class="btn btn-sm btn-outline"><i class="fa-brands fa-youtube"></i></a>
                            @endif
                            @if($track->beatport_sample)
                                <a href="{{ $track->beatport_sample }}" target="_blank" class="btn btn-sm btn-outline"><i class="fa-solid fa-play"></i></a>
                            @endif
                            <button class="btn btn-sm btn-outline show-reviews" title="Ревью" data-url="{{ route('reviews.show', $track->id) }}">
                                <i @class([
                                        'bi',
                                        'bi-star-fill text-primary' => $track->reviews_count > 0 || $track->also_supported_count > 0,
                                        'bi-star' => $track->reviews_count == 0 && $track->also_supported_count == 0
                                        ])></i>
                            </button>
                            @if(count($track->releases) > 0)
                                <a href="{{ route('releases.edit', $track->releases[0]->id) }}#tracklist" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                            @else
                                <form action="{{ route('tracks.destroy', $track->id) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить этот трек?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="justify-content-center d-flex my-3">
            {{ $tracks->appends(Request::input())->links('admin.layout.pagination') }}
        </div>

        <div class="modal fade" tabindex="-1" id="trackReviewsModal">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ревью</h5>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="editReviewModal">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-arrow-left"></i></button>
                        <h5 class="modal-title flex-grow-1 ms-2">Редактирование ревью</h5>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
