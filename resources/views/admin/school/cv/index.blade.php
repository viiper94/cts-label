@extends('admin.layout.layout')

@section('title')
    @lang('school.ctschool_courses') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions my-3">
            <a href="{{ route('school.cv') }}" target="_blank" class="btn btn-outline">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>@lang('cv.cv_page')
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-dark">
                <tbody class="text-nowrap">
                    <tr>
                        <th>@lang('cv.name')</th>
                        <th>@lang('user.email')</th>
                        <th>@lang('cv.status')</th>
                        <th>@lang('cv.created_at')</th>
                        <th>@lang('cv.doc')</th>
                        <th></th>
                    </tr>
                    @foreach($cv_list as $cv)
                        <tr>
                            <td>{{ $cv->name }}</td>
                            <td>{{ $cv->email }}</td>
                            <td><span class="badge {{ $cv->status->badgeClass() }}">{{ $cv->status->name() }}</span></td>
                            <td>{{ $cv->created_at->isoFormat('LLL') }}</td>
                            <td>
                                @if($cv->document && is_file(public_path('/cv/'.$cv->document)))
                                    <a class="btn btn-sm btn-outline" href="{{ url('/cv/'.$cv->document) }}" target="_blank">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('school.cv.destroy', $cv->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <a class="btn btn-sm btn-primary" href="{{ route('school.cv.show', $cv->id) }}">
                                        <i class="fa-solid fa-chevron-right me-2"></i>@lang('cv.full_cv')
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" type="submit" onclick='return confirm("{{ trans('cv.delete_cv') }}?")'>
                                        <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
