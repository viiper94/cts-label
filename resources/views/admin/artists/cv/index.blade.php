@extends('admin.layout.layout')

@section('title')
    @lang('artists.cv.title') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions my-3">
            <a href="{{ route('artists.public.info.create') }}" target="_blank" class="btn btn-outline">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>@lang('artists.cv.artists_cv_page')
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-dark">
                <tbody class="text-nowrap">
                <tr>
                    <th>@lang('artists.cv.contact_name')</th>
                    <th>@lang('artists.cv.phone')</th>
                    <th>@lang('user.email')</th>
                    <th>@lang('artists.cv.artists')</th>
                    <th>@lang('cv.status')</th>
                    <th>@lang('cv.created_at')</th>
                    <th>@lang('cv.doc')</th>
                    <th></th>
                </tr>
                @foreach($cv_list as $cv)
                    <tr>
                        <td>{{ $cv->main_contact_name }}</td>
                        <td>{{ $cv->main_contact_phone }}</td>
                        <td>{{ $cv->main_contact_email }}</td>
                        <td>{{ $cv->artists_info_count }}</td>
                        <td><span class="badge {{ $cv->status->badgeClass() }}">{{ $cv->status->name() }}</span></td>
                        <td>{{ $cv->created_at->isoFormat('LLL') }}</td>
                        <td>
                            @if($cv->doc && is_file(public_path('/cv/'.$cv->doc)))
                                <a class="btn btn-sm btn-outline" href="{{ url('/cv/'.$cv->doc) }}" target="_blank">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('artists_cv.show', $cv->id) }}">
                                <i class="fa-solid fa-chevron-right me-2"></i>@lang('cv.full_cv')
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
