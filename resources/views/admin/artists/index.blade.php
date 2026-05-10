@extends('admin.layout.layout')

@section('title')
    @lang('artists.artists') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('search')
    @include('admin.layout.search')
@endsection

@section('admin-content')

    <div class="container-fluid admin-tracks">
        <div class="justify-content-between align-items-center d-flex flex-column-reverse flex-lg-row my-3">
            <div class="releases-actions m-xl-0 m-1">
                <button data-url="{{ route('artists.create') }}" class="btn btn-primary edit-artist">
                    <i class="fa-solid fa-plus me-2"></i>@lang('artists.new_artist')
                </button>
            </div>
            {{ $artists->appends(Request::input())->links('admin.layout.pagination') }}
        </div>

        <div class="table-responsive artists-table" data-fl-scrolls>
            <table class="table table-hover table-dark">
                <thead>
                <tr>
                    <th></th>
                    <th class="fw-bold">@lang('artists.name')</th>
                    <th class="fw-bold">@lang('artists.link')</th>
                    <th class="fw-bold">
                        <i class="fa-brands fa-spotify"></i>
                        @lang('artists.spotify_id')
                    </th>
                    <th class="fw-bold">
                        <i class="bi bi-apple-music"></i>
                        @lang('artists.apple_music_id')
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="sortable" data-action="{{ route('studio.resort') }}">
                    @foreach($artists as $artist)
                    <tr data-id="{{ $artist->id }}" class="artist-row">
                        <td class="p-0">
                            <img src="/images/artists/{{ $artist->image ?? 'default.png' }}" class="img-fluid" style="height: 47px">
                        </td>
                        <td><b>{{ $artist->name }}</b></td>
                        <td>
                            @if($artist->link)
                                <a href="{{ $artist->link }}" target="_blank">{{ $artist->link }}</a>
                            @endif
                        </td>
                        <td>
                            @if($artist->spotify_id)
                                <a href="{{ $artist->getSpotifyLink() }}" target="_blank">{{ $artist->spotify_id }}</a>
                            @endif
                        </td>
                        <td>
                            @if($artist->spotify_id)
                                <a href="{{ $artist->getAppleMusicLink() }}" target="_blank">{{ $artist->apple_music_id }}</a>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary edit-artist"
                                    data-url="{{ route('artists.edit', $artist->id) }}" data-id="{{ $artist->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="justify-content-center d-flex my-3">
            {{ $artists->appends(Request::input())->links('admin.layout.pagination') }}
        </div>

        <div class="modal fade" tabindex="-1" id="editArtistModal">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('artists.edit_artist')</h5>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection