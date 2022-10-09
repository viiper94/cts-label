@extends('admin.layout.layout')

@section('admin-content')

    <div class="container">
        <form method="post" action="{{ $contact->id ? route('contacts.update', $contact->id) : route('contacts.store') }}">
            @csrf
            @if($contact->id)
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Имя*</label><br>
                        <input type="text" class="form-control form-control__dark" id="name" name="name" value="{{ old('name') ?? $contact->name }}" required>
                        @if($errors->has('name'))
                            <p class="help-block">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="full_name">Полное имя</label><br>
                        <input type="text" class="form-control form-control__dark" id="full_name" name="full_name" value="{{ old('full_name') ?? $contact->full_name }}">
                        @if($errors->has('full_name'))
                            <p class="help-block">{{ $errors->first('full_name') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">E-Mail*</label><br>
                <input type="email" class="form-control form-control__dark" id="email" name="email" value="{{ old('email') ?? $contact->email }}" required>
                @if($errors->has('email'))
                    <p class="help-block">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="company">Компания</label><br>
                    <input type="text" class="form-control form-control__dark" id="company" name="company" value="{{ old('company') ?? $contact->company }}">
                    @if($errors->has('company'))
                        <p class="help-block">{{ $errors->first('company') }}</p>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="company_foa">Сфера деятельности компании</label><br>
                    <input type="text" class="form-control form-control__dark" id="company_foa" name="company_foa" value="{{ old('company_foa') ?? $contact->company_foa }}">
                    @if($errors->has('company_foa'))
                        <p class="help-block">{{ $errors->first('company_foa') }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="position">Должность</label><br>
                <input type="text" class="form-control form-control__dark" id="position" name="position" value="{{ old('position') ?? $contact->position }}">
                @if($errors->has('position'))
                    <p class="help-block">{{ $errors->first('position') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="website">Сайт</label><br>
                <input type="url" class="form-control form-control__dark" id="website" name="website" value="{{ old('website') ?? $contact->website }}">
                @if($errors->has('website'))
                    <p class="help-block">{{ $errors->first('website') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона</label><br>
                <input type="text" class="form-control form-control__dark" id="phone" name="phone" value="{{ old('phone') ?? $contact->phone }}">
                @if($errors->has('phone'))
                    <p class="help-block">{{ $errors->first('phone') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="country">Страна</label><br>
                <input type="text" class="form-control form-control__dark" id="country" name="country" value="{{ old('country') ?? $contact->country }}">
                @if($errors->has('country'))
                    <p class="help-block">{{ $errors->first('country') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="additional">Дополнительная информация</label><br>
                <textarea name="additional" id="additional" rows="3" class="form-control form-control__dark">{{ old('additional') ?? $contact->additional }}</textarea>
                @if($errors->has('additional'))
                    <p class="help-block">{{ $errors->first('additional') }}</p>
                @endif
            </div>
            <h4>Каналы рассылки</h4>
            @foreach($channels as $channel)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="channels[]" value="{{ $channel->id }}"
                            @checked(
                                (old() && is_array(old('channels')) && in_array($channel->id, old('channels')))
                                || (!old() && $contact->channels->contains($channel->id))
                            )>
                        {{ $channel->title }}
                    </label>
                </div>
            @endforeach
            <button type='submit' class='btn btn-primary'>
                <span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                Сохранить
            </button>
        </form>
        @if($contact->id)
            <form action="{{ route('contacts.destroy', $contact->id) }}" method="post" style="margin-top: 10px">
                @csrf
                @method('DELETE')
                <button class='btn btn-danger' type='submit' onclick='return confirm("Удалить подписчика?")'>
                    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Удалить подписчика
                </button>
            </form>
        @endif
    </div>

@endsection
