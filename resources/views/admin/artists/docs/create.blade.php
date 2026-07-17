<div class="modal-header">
    <h5 class="modal-title">@lang('artists.docs.files')</h5>
    <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<div class="modal-body">
    <form action="{{ $doc->id ? route('artists.docs.update', $doc->id) : route('artists.docs.store') }}" id="edit_form"
          enctype="multipart/form-data" method="post">
        @csrf
        @if($doc->id)
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-5 col-xs-12 mb-3">
                <input type="file" name="files[]" class="form-control form-dark" multiple required>
            </div>
        </div>
        <div class="row my-3">
            <div class="table-responsive assigned-tracks">
                <table class="table table-sm table-hover table-dark">
                    <thead>
                    <tr>
                        <th></th>
                        <th>@lang('tracks.artists')</th>
                        <th>@lang('tracks.title')</th>
                        <th>@lang('tracks.mix_name')</th>
                        <th>@lang('tracks.length')</th>
                        <th>@lang('tracks.isrc')</th>
                        <th>@lang('tracks.release')</th>
                    </tr>
                    </thead>
                    <tbody class="text-nowrap">
                        @if($doc->id && count($doc->tracks) > 0)
                            @foreach ($doc->tracks as $track)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline remove-from-docs me-3" data-track-id="{{ $track->id }}">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                    </td>
                                    <td>{{ $track->artists }}</td>
                                    <td>{{ $track->name }}</td>
                                    <td>{{ $track->mix_name }}</td>
                                    <td>{{ $track->length }}</td>
                                    <td>{{ $track->isrc }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="no-tracks">
                                <td colspan=7 class="text-center">
                                    @lang('artists.docs.no_assigned_tracks')
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <div id="trackSearchModal" class="mb-3">
        <input type="text" name="search" class="mb-1 form-control form-dark" placeholder="@lang('releases.search_track')" data-url="{{ route('artists.docs.tracks_search') }}">
        <div class="search-items">
            <div class="table-responsive"></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" form="edit_form" type="submit">
        <i class="fa-solid fa-check me-2"></i>@lang('shared.admin.save')
    </button>
</div>
