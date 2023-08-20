@extends('admin.layout.layout')

@section('title')
    {{ $release->title ?? trans('release.new_release') }} | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')
    <div class="container-fluid">
        <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit_release">
            <i class="fa-solid fa-floppy-disk me-2"></i>@lang('shared.admin.save')
        </button>
        @if($release->id)
            <form action="{{ route('releases.destroy', $release->id) }}" method="post" class="d-inline my-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('Удалить релиз?')">
                    <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
                </button>
            </form>
            <a href="{{ route('release', $release->id) }}" class="btn btn-outline" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>@lang('releases.release_on_site')
            </a>
        @endif
        <form enctype="multipart/form-data" method="post" id="edit_release"
              action="{{ $release->id ? route('releases.update', $release->id) : route('releases.store') }}">
            @csrf
            @if($release->id)
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-auto col-xs-12 mb-3">
                    <img src="/images/releases/{{ $release->image ?? 'default.png' }}" id="preview" class="release-cover img-fluid">
                    <input type="file" name="image" class="form-control form-dark" id="uploader" accept="image/jpeg, image/png">
                    @error('image')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                    <div class="row d-none d-md-flex pt-5">
                        <div class="col-6 text-end">
                            @if($next)
                                <p class="mb-0">@lang('releases.next_release')</p>
                                <a href="{{ route('releases.edit', $next->id) }}">
                                    <img src="/images/releases/{{ $next->image }}" title="{{ $next->title }}" class="img-fluid" style="width: 100px;">
                                </a>
                            @endif
                        </div>
                        <div class="col-6">
                            @if($prev)
                                <p class="mb-0">@lang('releases.prev_release')</p>
                                <a href="{{ route('releases.edit', $prev->id) }}">
                                    <img src="/images/releases/{{ $prev->image }}" title="{{ $prev->title }}" class="img-fluid" style="width: 100px;">
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md col-xs-12 mb-3">
                    <x-checkbox class="mb-3" name="visible" :checked="$release->visible">@lang('releases.visible')</x-checkbox>
                    <div class="form-group mb-3">
                        <label class="form-label">@lang('releases.title')</label><br>
                        <input type="text" class="form-control form-dark" name="title" value="{{ old('title') ?? $release->title }}" required>
                        @error('title')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">@lang('releases.genre')</label><br>
                        <input type="text" class="form-control form-dark" name="genre" value="{{ old('genre') ?? $release->genre }}">
                        @error('genre')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">@lang('releases.release_number')</label><br>
                        <div class="input-group">
                            <input type="text" class="form-control form-dark" name="release_number" value="{{ old('release_number') ?? $release->release_number }}">
                            @if(!$release->id)
                                <button class="btn btn-outline" type="button" id="cat-generate" data-url="{{ route('releases.getCat') }}">
                                    @lang('releases.generate')
                                </button>
                            @endif
                        </div>
                        @error('release_number')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-auto">
                            <label class="form-label">@lang('releases.beatport_release_date')</label><br>
                            <input type="hidden" name="release_date" id="release_date"
                                   value="{{ old('release_date') ?? $release->release_date?->format('d F Y') }}">
                            @error('release_date')
                                <p class="help-block text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-12 col-xxl">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="exclusive_period">@lang('releases.exclusive_period')</label><br>
                                        <select class="form-select form-dark form-select mb-3" name="exclusive_period" id="exclusive_period">
                                            <option @selected(!$release->exclusive_period)>@lang('releases.without_exclusive_period')</option>
                                            <option value="2" @selected($release->exclusive_period === '2')>@lang('releases.2_weeks')</option>
                                            <option value="4" @selected($release->exclusive_period === '4')>@lang('releases.4_weeks')</option>
                                        </select>
                                        @error('exclusive_period')
                                        <p class="help-block text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">@lang('releases.link_to_store')</label><br>
                        <div class="input-group">
                            <input type="url" class="form-control form-dark" name="beatport" value="{{ old('beatport') ?? $release->beatport }}">
                            @if($release->beatport)
                                <a class="btn btn-outline border-0" href="{{ $release->beatport }}" target="_blank">
                                    <i @class([
                                        'icon-beatport' => $release->getStore() === 'beatport',
                                        'icon-discogs' => $release->getStore() === 'discogs',
                                        'fa-brands fa-spotify' => $release->getStore() === 'spotify',
                                    ])></i>
                                </a>
                            @endif
                        </div>
                        @error('beatport')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">@lang('releases.link_to_youtube')</label><br>
                        <div class="input-group">
                            <input type="url" class="form-control form-dark" name="youtube" value="{{ old('youtube') ?? $release->youtube }}">
                            @if($release->youtube)
                                <a class="btn btn-outline border-0" href="{{ $release->youtube }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                            @endif
                        </div>
                        @error('youtube')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-12">
                    <div class="tracks mb-5" id="tracklist">
                        <h6>@lang('releases.tracklist')</h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-dark">
                                <thead>
                                <tr>
                                    <th>@lang('releases.track.number')</th>
                                    <th>@lang('releases.track.artists')</th>
                                    <th>@lang('releases.track.title')</th>
                                    <th>@lang('releases.track.mix_name')</th>
                                    <th>@lang('releases.track.length')</th>
                                    <th>@lang('releases.track.isrc')</th>
                                    <th></th>
                                    <th class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline search-track" data-bs-toggle="modal" data-bs-target="#trackSearchModal">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-track" data-url="{{ route('tracks.create') }}">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="text-nowrap sortable">
                                @forelse($release->tracks as $track)
                                    @include('admin.tracks.release_tracklist_item', compact('track'))
                                @empty
                                    <tr>
                                        <td></td>
                                        <td colspan="8" class="text-center">
                                            @lang('releases.track.no_tracks')
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="inline-params">
                            <h6>@lang('releases.tracklist_displaying_params')</h6>
                            <x-checkbox class="form-check-inline" name="tracklist_show_artist" :checked="$release->tracklist_show_artist">@lang('releases.display_artists')</x-checkbox>
                            <x-checkbox class="form-check-inline" name="tracklist_show_title" :checked="$release->tracklist_show_title">@lang('releases.display_title')</x-checkbox>
                            <x-checkbox class="form-check-inline" name="tracklist_show_mix" :checked="$release->tracklist_show_mix">@lang('releases.display_mix_name')</x-checkbox>
                            <x-checkbox class="form-check-inline" name="tracklist_show_custom" id="show_custom" :checked="$release->tracklist_show_custom">@lang('releases.display_custom_text')</x-checkbox>
                        </div>
                        <div class="description form-group my-3" id="tracklist_text" style="display: @if($release->tracklist_show_custom) block @else none @endif">
                            <label class="en">@lang('releases.tracklist_custom_text')</label>
                            <textarea name="tracklist" id="tracklist_textarea">{!! old('tracklist') ?? $release->tracklist !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="description form-group mb-3">
                        <label class="en">@lang('releases.description_en')</label>
                        <textarea name="description_en" id="description_en">{!! old('description_en') ?? $release->description_en !!}</textarea>
                    </div>
                    <div class="description form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="en">@lang('releases.description_ru')</label>
                            <a class="btn btn-sm btn-outline translate_description" data-to-lang="ru">
                                <i class="bi bi-translate me-2"></i>@lang('releases.translate_to_ru')
                            </a>
                        </div>
                        <textarea name="description_ru" id="description_ru">{!! old('description_ru') ?? $release->description_ru !!}</textarea>
                    </div>
                    <div class="description form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="en">@lang('releases.description_ua')</label>
                            <a class="btn btn-sm btn-outline translate_description" data-to-lang="uk">
                                <i class="bi bi-translate me-2"></i>@lang('releases.translate_to_ua')
                            </a>
                        </div>
                        <textarea name="description_ua" id="description_uk">{!! old('description_ua') ?? $release->description_ua !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="card text-bg-dark mb-5">
                <button class="card-header p-3 accordion-button collapsed justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRelated" aria-expanded="false" aria-controls="collapseRelated">
                    <span class="badge text-bg-primary me-2">{{ count($release->related) }}</span>@lang('releases.related_releases')
                </button>
                <div id="collapseRelated" class="collapse">
                    <div class="card-body row g-0 flex-column-reverse flex-md-row">
                        <div class="col-md-6 col-xs-12 related-all-releases">
                            <button class="btn btn-sm btn-outline-danger deselect-btn"><i class="fa-solid fa-square-xmark me-2"></i>@lang('shared.admin.deselect_all')</button>
                            @foreach($release_list as $item)
                                <div class="related d-flex mb-1 form-check-inline">
                                    <a class="me-4" href="{{ route('release', $item->id) }}" target="_blank">@lang('releases.release_on_site')</a>
                                    <input type="checkbox" name="related[]" class="form-check-input me-2" value="{{ $item->id }}" id="related-{{ $item->id }}"
                                        @checked(
                                             (old() && is_array(old('related')) && in_array($item->id, old('related'))) ||
                                             (!old() && $release->related->contains($item)))/>
                                    <label for="related-{{ $item->id }}" class="form-check-label">{{ $item->title }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6 col-xs-12 related-release-search mb-3">
                            <div class="row">
                                <input type="text" class="search-form form-control form-dark col" id='search-related' placeholder="@lang('releases.search_releases')" data-release-id="{{ $release->id }}">
                                <div class="radios col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="search-by" value="title" id="search-by-title" checked>
                                        <label class="form-check-label" for="search-by-title">@lang('releases.by_title')</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="search-by" value="tracklist" id="search-by-tracklist">
                                        <label class="form-check-label" for="search-by-tracklist">@lang('releases.by_tracklist')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="checked-releases mt-3"></div>
                            <div class="item-list mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-bg-dark mb-5">
                <button class="card-header p-3 accordion-button collapsed justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFlow" aria-expanded="false" aria-controls="collapseFlow">
                    <span @class(['badge text-bg-success me-2', 'text-bg-danger' => $release->hasUnfinishedUploads(true)])>
                        {{ count($release->hasUnfinishedUploads()) ?? '0' }}
                    </span>
                    @lang('releases.uploads'):
                </button>
                <div class="collapse" id="collapseFlow">
                    <div class="card-body row">
                        <div class="col-12 col-lg-6">
                            @php $check = $release->hasUnfinishedUploads(); @endphp
                            <x-checkbox class="mt-2" name="uploaded_on_beatport" :checked="$release->uploaded_on_beatport">
                                @lang('releases.uploaded_on_beatport')
                            </x-checkbox>
                            <x-checkbox class="mt-2" name="uploaded_on_believe" :checked="$release->uploaded_on_believe">
                                @lang('releases.uploaded_on') <a href='https://www.believebackstage.com/' target='_blank'>Believe Digital</a>
                            </x-checkbox>
                            @isset($check['uploaded_on_believe'])
                                <small class="text-danger">{{ $check['uploaded_on_believe'] }}</small>
                            @endisset
                            <x-checkbox class="mt-2" name="uploaded_on_juno" :checked="$release->uploaded_on_juno">
                                @lang('releases.uploaded_on') <a href='https://lms.junodownload.com/lms/release/' target='_blank'>Juno</a>
                            </x-checkbox>
                            @isset($check['uploaded_on_juno'])
                                <small class="text-danger">{{ $check['uploaded_on_juno'] }}</small>
                            @endisset
                            <x-checkbox class="mt-2" name="uploaded_on_google_drive" :checked="$release->uploaded_on_google_drive">
                                @lang('releases.uploaded_on_google_drive')
                            </x-checkbox>
                            @isset($check['uploaded_on_google_drive'])
                                <small class="text-danger">{{ $check['uploaded_on_google_drive'] }}</small>
                            @endisset
                            <x-checkbox class="mt-2" name="label_copy_uploaded" :checked="$release->label_copy_uploaded">
                                @lang('releases.label_copy_uploaded')
                            </x-checkbox>
                            @isset($check['label_copy_uploaded'])
                                <small class="text-danger">{{ $check['label_copy_uploaded'] }}</small>
                            @endisset
                        </div>
                        <div class="col-12 col-lg-6">
                            <x-checkbox class="mt-2 mb-4" name="promo_upload" :checked="$release->promo_upload">
                                @lang('releases.promo_upload')
                            </x-checkbox>
                            <x-checkbox class="mt-2" name="uploaded_on_zip_dj" :checked="$release->uploaded_on_zip_dj">
                                @lang('releases.uploaded_on') <a href='https://www.zipdj.com/' target='_blank'>Zip DJ</a>
                            </x-checkbox>
                            @isset($check['uploaded_on_zip_dj'])
                                <small class="text-danger">{{ $check['uploaded_on_zip_dj'] }}</small>
                            @endisset
                            <x-checkbox class="mt-2" name="uploaded_on_music_worx" :checked="$release->uploaded_on_music_worx">
                                @lang('releases.uploaded_on') <a href='https://pro.music-worx.com/en/user/addrelease' target='_blank'>Music Worx</a>
                            </x-checkbox>
                            @isset($check['uploaded_on_music_worx'])
                                <small class="text-danger">{{ $check['uploaded_on_music_worx'] }}</small>
                            @endisset
                            <x-checkbox class="mt-2" name="uploaded_on_release_promo" :checked="$release->uploaded_on_release_promo">
                                @lang('releases.uploaded_on') <a href='http://releasepromo.com/' target='_blank'>Release Promo</a>
                            </x-checkbox>
                            @isset($check['uploaded_on_release_promo'])
                                <small class="text-danger">{{ $check['uploaded_on_release_promo'] }}</small>
                            @endisset
                            <x-checkbox class="mt-2" name="is_emailing_done" :checked="$release->is_emailing_done">
                                @lang('releases.is_emailing_done')
                            </x-checkbox>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if($release->id)
            <div class="d-flex my-5">
                <form action="{{ route('releases.labelCopy', $release->id) }}" method="post">
                    @csrf
                    <div class="btn-group">
                        <button type="submit" class="btn btn-outline">
                            <i class="fa-solid fa-file-pdf me-2"></i>@lang('releases.export_label_copy')
                        </button>
                        @if(is_file(public_path($release->label_copy_zip)))
                            <a href="{{ $release->label_copy_zip }}" class="btn btn-outline">
                                <i class="fa-solid fa-download me-2"></i>
                                @lang('releases.save_label_copy')
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        @endif
    </div>

    <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="trackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            @include('admin.tracks.edit', ['track' => new \App\Track()])
        </div>
    </div>

    <div class="modal fade" id="trackSearchModal" tabindex="-1" aria-labelledby="trackSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="text" name="search" class="form-control form-dark" placeholder="@lang('releases.search_track')" data-url="{{ route('tracks.search') }}">
                    <button type="button" class="btn btn-outline ms-3" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="search-items" style="min-height: 150px;">
                        <div class="table-responsive" data-fl-scrolls>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const picker = new Litepicker({
            element: document.getElementById('release_date'),
            inlineMode: true,
            lang: 'ru-RU',
            dropdowns: {
                "minYear": 2000,
                "maxYear": null,
                "months": true,
                "years": true
            }
        });
        ClassicEditor
            .create(document.querySelector('#description_en'))
            .then(newEditor => {
                enEditor = newEditor;
            });
        ClassicEditor.create(document.querySelector('#description_ru'))
            .then(newEditor => {
                ruEditor = newEditor;
            });
        ClassicEditor.create(document.querySelector('#description_uk'))
            .then(newEditor => {
                uaEditor = newEditor;
            });
        ClassicEditor.create(document.querySelector('#tracklist_textarea'));
    </script>

@endsection

@section('assets')
    <script src="/js/ckeditor.js"></script>
    <link rel="stylesheet" href="/css/ckeditor.css">
@endsection
