@extends('admin.layout.layout')

@section('title')
    {{ $contact->name ?? trans('emailing.contacts.new_emailing_contact') }} | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid">
        <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit-contact-form">
            <i class="fa-solid fa-floppy-disk me-2"></i>@lang('shared.admin.save')
        </button>
        @if($contact->id)
            <form action="{{ route('emailing.contacts.destroy', $contact->id) }}" method="post" class="d-inline my-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('@lang('emailing.contacts.delete_contact')?')">
                    <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
                </button>
            </form>
        @endif
        <form method="post" id="edit-contact-form"
              action="{{ $contact->id ? route('emailing.contacts.update', $contact->id) : route('emailing.contacts.store') }}">
            @csrf
            @if($contact->id)
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">@lang('emailing.contacts.name')*</label>
                        <input type="text" class="form-control form-dark" id="name" name="name"
                               value="{{ old('name') ?? $contact->name }}" required>
                        @error('name')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">@lang('emailing.contacts.full_name')</label>
                        <input type="text" class="form-control form-dark" id="full_name" name="full_name"
                               value="{{ old('full_name') ?? $contact->full_name }}">
                        @error('full_name')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">@lang('emailing.contacts.email')*</label>
                <input type="email" class="form-control form-dark" id="email" name="email"
                       value="{{ old('email') ?? $contact->email }}" required>
                @error('email')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="row">
                <div class="form-group col-sm-6 mb-3" class="form-label">
                    <label for="company" class="form-label">@lang('emailing.contacts.company')</label>
                    <input type="text" class="form-control form-dark" id="company" name="company"
                           value="{{ old('company') ?? $contact->company }}">
                    @error('company')
                        <p class="help-block">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-sm-6 mb-3">
                    <label for="company_foa" class="form-label">@lang('emailing.contacts.company_foa')</label>
                    <input type="text" class="form-control form-dark" id="company_foa" name="company_foa"
                           value="{{ old('company_foa') ?? $contact->company_foa }}">
                    @error('company_foa')
                        <p class="help-block">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="position" class="form-label">@lang('emailing.contacts.position')</label>
                <input type="text" class="form-control form-dark" id="position" name="position"
                       value="{{ old('position') ?? $contact->position }}">
                @error('position')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="website" class="form-label">@lang('emailing.contacts.website')</label>
                <input type="url" class="form-control form-dark" id="website" name="website"
                       value="{{ old('website') ?? $contact->website }}">
                @error('website')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="phone" class="form-label">@lang('emailing.contacts.phone')</label>
                <input type="text" class="form-control form-dark" id="phone" name="phone"
                       value="{{ old('phone') ?? $contact->phone }}">
                @error('phone')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="country" class="form-label">@lang('emailing.contacts.country')</label>
                <input type="text" class="form-control form-dark" id="country" name="country"
                       value="{{ old('country') ?? $contact->country }}">
                @error('country')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="additional" class="form-label">@lang('emailing.contacts.additional')</label>
                <textarea name="additional" id="additional" rows="3" class="form-control form-dark">{{ old('additional') ?? $contact->additional }}</textarea>
                @error('additional')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="card text-bg-dark mb-3" style="width: 22rem;">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('emailing.channels.emailing_channels')</h4>
                </div>
                <div class="card-body">
                    @foreach($channels as $key => $channel)
                        <x-checkbox name="channels[]"
                                    :id="$channel->id"
                                    :value="$channel->id"
                                    :checked="(old() && is_array(old('channels')) && in_array($channel->id, old('channels')))
                                       || (!old() && $contact->channels->contains($channel->id))">
                            {{ $channel->title }}
                        </x-checkbox>
                    @endforeach
                </div>
            </div>
            @if($contact->error_log)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">@lang('emailing.contacts.error_log')</h5>
                </div>
                <div class="accordion mb-3" id="accordion">
                    @foreach($contact->error_log as $key => $log)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{ $key }}">
                                <button class="accordion-button text-bg-dark" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_{{ $key }}" aria-expanded="true" aria-controls="collapse_{{ $key }}">
                                    <i class="fa-solid fa-exclamation-triangle text-danger me-2"></i>
                                    <b class="text-danger me-2">{{ $log['code'] }}</b>
                                    <span class="text-muted">{{ $log['date'] }}</span>
                                </button>
                            </h2>
                            <div id="collapse_{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $key }}" data-bs-parent="#accordion">
                                <div class="accordion-body text-bg-dark">
                                    <p>{{ $log['message'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </form>
    </div>

@endsection
