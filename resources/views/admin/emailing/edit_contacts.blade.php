@extends('admin.layout.layout')

@section('title')
    {{ $contact->name ?? 'Новый контакт рассылки' }} | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid">
        <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit-contact-form">
            <i class="fa-solid fa-floppy-disk me-2"></i>Сохранить
        </button>
        @if($contact->id)
            <form action="{{ route('emailing.contacts.destroy', $contact->id) }}" method="post" class="d-inline my-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('Удалить контакт?')">
                    <i class="fa-solid fa-trash me-2"></i>Удалить
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
                        <label for="name" class="form-label">Имя*</label>
                        <input type="text" class="form-control form-dark" id="name" name="name"
                               value="{{ old('name') ?? $contact->name }}" required>
                        @error('name')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">Полное имя</label>
                        <input type="text" class="form-control form-dark" id="full_name" name="full_name"
                               value="{{ old('full_name') ?? $contact->full_name }}">
                        @error('full_name')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">E-Mail*</label>
                <input type="email" class="form-control form-dark" id="email" name="email"
                       value="{{ old('email') ?? $contact->email }}" required>
                @error('email')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="row">
                <div class="form-group col-sm-6 mb-3" class="form-label">
                    <label for="company" class="form-label">Компания</label>
                    <input type="text" class="form-control form-dark" id="company" name="company"
                           value="{{ old('company') ?? $contact->company }}">
                    @error('company')
                        <p class="help-block">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-sm-6 mb-3">
                    <label for="company_foa" class="form-label">Сфера деятельности компании</label>
                    <input type="text" class="form-control form-dark" id="company_foa" name="company_foa"
                           value="{{ old('company_foa') ?? $contact->company_foa }}">
                    @error('company_foa')
                        <p class="help-block">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="position" class="form-label">Должность</label>
                <input type="text" class="form-control form-dark" id="position" name="position"
                       value="{{ old('position') ?? $contact->position }}">
                @error('position')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="website" class="form-label">Сайт</label>
                <input type="url" class="form-control form-dark" id="website" name="website"
                       value="{{ old('website') ?? $contact->website }}">
                @error('website')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="phone" class="form-label">Номер телефона</label>
                <input type="text" class="form-control form-dark" id="phone" name="phone"
                       value="{{ old('phone') ?? $contact->phone }}">
                @error('phone')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="country" class="form-label">Страна</label>
                <input type="text" class="form-control form-dark" id="country" name="country"
                       value="{{ old('country') ?? $contact->country }}">
                @error('country')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="additional" class="form-label">Дополнительная информация</label>
                <textarea name="additional" id="additional" rows="3" class="form-control form-dark">{{ old('additional') ?? $contact->additional }}</textarea>
                @error('additional')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="card text-bg-dark" style="width: 18rem;">
                <div class="card-header">
                    <h4 class="card-title">Каналы рассылки</h4>
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
        </form>
    </div>

@endsection
