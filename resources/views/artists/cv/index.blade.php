@extends('layout.layout')

@section('content')

    <div class="event-header py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between py-3">
            <div class="text-center text-md-start">
                <h1 class="text-light mb-0">@lang('artists.cv.title')</h1>
                <h6 class="text-danger mb-5 mb-md-0">@lang('artists.cv.not_public')</h6>
            </div>
            <div class="lang-switch align-items-center justify-content-center justify-content-md-end">
                <div class="btn-group">
                    <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en' || !isset($_COOKIE['lang'])])
                       data-lang="en" href="{{ route('artists.public.info.create') }}">
                        @lang('shared.en')
                    </a>
                    <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ru'])
                       data-lang="ru" href="{{ route('artists.public.info.create') }}">
                        @lang('shared.ru')
                    </a>
                    <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua'])
                       data-lang="ua" href="{{ route('artists.public.info.create') }}">
                        @lang('shared.ua')
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container anketa">
        @include('admin.layout.alert')

        <form method="post" action="{{ route('artists.public.info.store') }}">
            @csrf
            <div class="row mt-3">
                <h6 class="text-uppercase">@lang('artists.cv.main_contact')</h6>
                <div class="form-group mb-3">
                    <label class="form-label" for="main_contact_name">@lang('artists.cv.contact_name')</label>
                    <input type="text" class="form-control form-dark" id="main_contact_name" name="main_contact_name" value="{{ old('main_contact_name') }}" maxlength="190">
                    @if($errors->has('main_contact_name'))
                        <small class="text-danger">{{ $errors->first('main_contact_name') }}</small>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="main_contact_email">@lang('user.email')</label>
                    <input type="email" class="form-control form-dark" id="main_contact_email" name="main_contact_email" value="{{ old('main_contact_email') }}" maxlength="190">
                    @if($errors->has('main_contact_email'))
                        <small class="text-danger">{{ $errors->first('main_contact_email') }}</small>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="main_contact_phone">@lang('artists.cv.phone')</label>
                    <input type="text" class="form-control form-dark" id="main_contact_phone" name="main_contact_phone" value="{{ old('main_contact_phone') }}" maxlength="190">
                    @if($errors->has('main_contact_phone'))
                        <small class="text-danger">{{ $errors->first('main_contact_phone') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group my-4">
                <label class="form-label">@lang('artists.cv.tracks_to_sign')</label>
                <button type="button" class="btn btn-sm btn-outline add-track-to-sign-btn border-0" data-url="{{ route('artists.public.info.track') }}">
                    <i class="fa-solid fa-plus"></i>
                </button>
                @include('artists.cv.track_to_sign_item', ['tracks' => old('tracks_to_sign') ?? [['name' => '', 'mix' => '']], 'index' => 0])
                @if($errors->has('tracks_to_sign'))
                    <small class="text-danger">{{ $errors->first('tracks_to_sign') }}</small>
                @endif
            </div>
            <div class="row py-3">
                <h6 class="text-uppercase">@lang('artists.cv.artists_info')</h6>
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                         <tr>
                             <th>@lang('artists.cv.artist_name')</th>
                             <th>@lang('artists.cv.first_name')</th>
                             <th>@lang('artists.cv.surname')</th>
                             <th>@lang('artists.cv.country')</th>
                             <th></th>
                             <th>
                                 <i class="fa-solid fa-sort" data-bs-toggle="tooltip" data-bs-title="@lang('shared.admin.sort')"></i>
                             </th>
                         </tr>
                        </thead>
                        <tbody class="text-nowrap sortable">
                        @if(old('info'))
                            @php $contacts = \App\ArtistContact::getFromOld(old('info')) @endphp
                            @foreach($contacts as $contact)
                                @include('artists.cv.artist_contact_item', ['info' => $contact])
                            @endforeach
                        @else
                            <tr class="no-artists">
                                <td colspan="6">@lang('artists.cv.no_artist_yet')</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-md-between justify-content-center gap-3">
                <button type="button" class="btn btn-outline-secondary add-artist-info-btn text-nowrap" data-url="{{ route('artists.public.contact.create') }}">
                    <i class="fa-solid fa-plus"></i>
                    @lang('artists.cv.add_artists_info')
                </button>
                <button type="submit" class="btn btn-primary text-nowrap" onclick="return confirm('@lang('artists.cv.submit')?')">
                    <i class="fa-solid fa-check"></i>
                    @lang('cv.submit')
                </button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="artistInfoModal" tabindex="-1" aria-labelledby="artistInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"></div>
    </div>

@endsection
