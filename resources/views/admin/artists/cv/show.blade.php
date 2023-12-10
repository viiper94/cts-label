@extends('admin.layout.layout')

@section('title')
    {{ $cv->main_contact_name }} | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid admin-cv">
        @if(is_file(public_path('cv/'.$cv->doc)))
            <a href="{{ url('/'). '/cv/'.$cv->doc }}" class="btn btn-primary my-3" target="_blank">
                <i class="fa-solid fa-file-pdf me-2"></i>@lang('cv.download_cv')
            </a>
        @else
        @endif
        <a href="{{ route('artists_cv.document', $cv->id) }}" class="btn btn-primary">
            <i class="fa-solid fa-gears me-2"></i>@lang('cv.generate_doc')
        </a>
        <form action="{{ route('artists_cv.destroy', $cv->id) }}" method="POST" class="d-inline my-3">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit" onclick='return confirm("@lang('cv.delete_cv')?")'>
                <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
            </button>
        </form>
        <div class="card text-bg-dark cv-data mb-3">
            <div class="card-header text-uppercase">Main contact</div>
            <div class="card-body row g-0">
                <div class="col-xs-12 col-md-4 my-3 px-3">
                    <p class="text-muted mb-0"><i>@lang('artists.cv.contact_name')</i></p>
                    <p class="mb-0 fs-5"><b>{{ $cv->main_contact_name }}</b></p>
                </div>
                <div class="col-xs-12 col-md-4 my-3 px-3">
                    <p class="text-muted mb-0"><i>@lang('user.email')</i></p>
                    <p class="mb-0 fs-5"><b>{{ $cv->main_contact_email }}</b></p>
                </div>
                <div class="col-xs-12 col-md-4 my-3 px-3">
                    <p class="text-muted mb-0"><i>@lang('artists.cv.phone')</i></p>
                    <p class="mb-0 fs-5"><b>{{ $cv->main_contact_phone }}</b></p>
                </div>
            </div>
            @if($cv->tracks_to_sign)
                <div class="card-header text-uppercase">tRACKS TO SIGN</div>
                <div class="card-body">
                    @foreach($cv->tracks_to_sign as $track)
                        <div class="col-xs-12 col-md-4 px-3">
                            <p class="mb-0"><b>{{ $track['name'] }} ({{ $track['mix'] }})</b></p>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($cv->artists_info)
                <div class="card-footer text-uppercase">Artists Info</div>
                <div class="accordion" id="accordion">
                    @foreach($cv->artists_info as $info)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button text-bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#artist-{{ $info->id }}" aria-expanded="true" aria-controls="artist-{{ $info->id }}">
                                    <span>{{ $loop->iteration }}.</span>
                                    <b class="mx-2">{{ $info->artist_name }}</b>
                                    <span>({{ $info->first_name }} {{ $info->surname }})</span>
                                </button>
                            </h2>
                            <div id="artist-{{ $info->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                <div class="accordion-body text-bg-dark">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.first_name')</i></p>
                                            <p class="mb-0"><b>{{ $info->first_name }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.surname')</i></p>
                                            <p class="mb-0"><b>{{ $info->surname }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.artist_name')</i></p>
                                            <p class="mb-0"><b>{{ $info->artist_name }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.publisher')</i></p>
                                            <p class="mb-0"><b>{{ $info->publisher }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.pro')</i></p>
                                            <p class="mb-0"><b>{{ $info->pro }}</b></p>
                                        </div>
                                        @if($info->date_of_birth)
                                            <div class="col-xs-12 col-md-6 mb-3">
                                                <p class="text-muted mb-0"><i>@lang('artists.cv.date_of_birth')</i></p>
                                                <p class="mb-0"><b>{{ $info->date_of_birth->isoFormat('LL') }}</b></p>
                                            </div>
                                        @endif
                                        <div class="col-xs-12 col-md-12 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.address')</i></p>
                                            <p class="mb-0"><b>{{ $info->address }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.city')</i></p>
                                            <p class="mb-0"><b>{{ $info->city }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.state')</i></p>
                                            <p class="mb-0"><b>{{ $info->state }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.zip')</i></p>
                                            <p class="mb-0"><b>{{ $info->zip }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.country')</i></p>
                                            <p class="mb-0"><b>{{ $info->country }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.bank')</i></p>
                                            <p class="mb-0"><b>{{ $info->bank }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.place_of_bank')</i></p>
                                            <p class="mb-0"><b>{{ $info->place_of_bank }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.account_holder')</i></p>
                                            <p class="mb-0"><b>{{ $info->account_holder }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6 mb-3">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.account_number')</i></p>
                                            <p class="mb-0"><b>{{ $info->account_number }}</b></p>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <p class="text-muted mb-0"><i>@lang('artists.cv.passport_number')</i></p>
                                            <p class="mb-0"><b>{{ $info->passport_number }}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="card-footer">
                <p class="text-muted mt-3 mb-0"><i>@lang('cv.created_at')</i></p>
                <p class="mb-3"><b>{{ $cv->created_at->isoFormat('LLL') }}</b></p>
            </div>
        </div>
    </div>

@endsection
