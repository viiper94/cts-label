@extends('admin.layout.layout')

@section('title')
    @lang('artists.docs.title') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid artists-docs">
        <div class="releases-actions my-3">
            <button data-url="{{ route('artists.docs.create') }}" target="_blank" class="btn btn-primary edit-doc">
                <i class="fa-solid fa-plus me-2"></i>@lang('artists.docs.create')
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-dark">
                <tbody class="text-nowrap">
                <tr>
                    <th>@lang('artists.docs.track')</th>
                    <th>@lang('artists.docs.artist')</th>
                    <th></th>
                </tr>
                @foreach($docs as $doc)
                    <tr>
                        <td>{{ $doc->tracks->pluck('name')->join(', ') }}</td>
                        <td>{{ $doc->artist->name }}</td>
                        <td>
                            @if(is_file(public_path('/docs/'.$doc->file_name)))
                                <a class="btn btn-sm btn-outline" href="{{ url('/docs/'.$doc->file_name) }}" target="_blank">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="editArtistDocsModal">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                </div>
            </div>
        </div>

    </div>

@endsection
