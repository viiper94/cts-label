@extends('admin.layout.layout')

@section('title')
    @lang('artists.artists') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid admin-items admin-artists">

        <div class="justify-content-between align-items-center flex-column-reverse flex-lg-row my-3 d-flex">
            <div class="releases-actions m-xl-0 m-1">
                <button data-url="{{ route('artists.create') }}" class="btn btn-primary edit-artist">
                    <i class="fa-solid fa-plus me-2"></i>@lang('artists.new_artist')
                </button>
            </div>
            {{ $artists->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <div class="row">
            @foreach($artists as $artist)
                <div class="col-xxl-2 col-lg-3 col-md-6 col-sm-4 col-xs-12">
                    <div class="card text-bg-dark mb-3 border-0 edit-artist" data-url="{{ route('artists.edit', $artist->id) }}">
                        <img src="/images/artists/{{ $artist->image ?? 'default.png' }}" class="card-img" alt="{{ $artist->name }}">
                        <div class="card-img-overlay">
                            <h5 class="card-title text-nowrap mb-0 text-truncate" title="{{ $artist->name }}">{{ $artist->name }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
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

@section('search')
    @include('admin.layout.search')
@endsection
