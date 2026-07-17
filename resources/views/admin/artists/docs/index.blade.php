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
                    <th></th>
                    <th>@lang('artists.docs.filename')</th>
                    <th>@lang('artists.artists')</th>
                    <th>@lang('artists.docs.track')</th>
                    <th>@lang('artists.docs.date_added')</th>
                    <th></th>
                </tr>
                @foreach($docs as $doc)
                    <tr>
                        <td><i class="fa-solid fa-file text-muted"></i></td>
                        <td>
                            @if(is_file(public_path('docs/'.$doc->filename)))
                            <a href="{{ url('/docs/'.$doc->filename) }}" target="_blank">
                                {{ $doc->filename }}
                            </a>
                            @else
                                {{ $doc->filename }}
                            @endif
                        </td>
                        <td>{{ $doc->tracks->pluck('artists')->join(', ') }}</td>
                        <td>{{ $doc->tracks->pluck('name')->join(', ') }}</td>
                        <td>{{ $doc->created_at->isoFormat('LL') }}</td>
                        <td>
                            @if(is_file(public_path('docs/'.$doc->filename)))
                                <form action="{{ route('artists.docs.destroy', $doc->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('@lang('artists.docs.delete_doc')?')">
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

        <div class="modal fade" id="editArtistDocsModal">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                </div>
            </div>
        </div>

    </div>

@endsection
