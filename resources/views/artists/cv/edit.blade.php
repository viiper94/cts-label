<div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title fs-5" id="artistInfoModalLabel">{{ $info->id ? trans('artists.cv.edit_info') : trans('artists.cv.new_info') }}</h3>
        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="first_name" class="form-label">@lang('artists.cv.first_name')*</label>
            <input type="text" class="form-control form-dark" id="first_name" name="first_name" value="{{ $info->first_name }}" required>
            <small class="text-danger text-required" style="display: none">@lang('shared.admin.required')</small>
            @error('first_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="surname" class="form-label">@lang('artists.cv.surname')*</label>
            <input type="text" class="form-control form-dark" id="surname" name="surname" value="{{ $info->surname }}" required>
            @error('surname')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="artist_name" class="form-label">@lang('artists.cv.artist_name')*</label>
            <input type="text" class="form-control form-dark" id="artist_name" name="artist_name" value="{{ $info->artist_name }}" required>
            <small class="text-danger text-required" style="display: none">@lang('shared.admin.required')</small>
            @error('artist_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="publisher" class="form-label">@lang('artists.cv.publisher')</label>
            <input type="text" class="form-control form-dark" id="publisher" name="publisher" value="{{ $info->publisher }}">
            @error('publisher')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="pro" class="form-label">@lang('artists.cv.pro')</label>
            <input type="text" class="form-control form-dark" id="pro" name="pro" value="{{ $info->pro }}">
            @error('pro')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="date_of_birth" class="form-label d-block">@lang('artists.cv.date_of_birth')</label>
            <input type="hidden" class="form-control form-dark" id="date_of_birth" name="date_of_birth" value="{{ $info->date_of_birth }}" readonly>
            @error('date_of_birth')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="address" class="form-label">@lang('artists.cv.address')</label>
            <input type="text" class="form-control form-dark" id="address" name="address" value="{{ $info->address }}">
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="city" class="form-label">@lang('artists.cv.city')</label>
            <input type="text" class="form-control form-dark" id="city" name="city" value="{{ $info->city }}">
            @error('city')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="state" class="form-label">@lang('artists.cv.state')</label>
            <input type="text" class="form-control form-dark" id="state" name="state" value="{{ $info->state }}">
            @error('state')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="zip" class="form-label">@lang('artists.cv.zip')</label>
            <input type="text" class="form-control form-dark" id="zip" name="zip" value="{{ $info->zip }}">
            @error('zip')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="country" class="form-label">@lang('artists.cv.country')</label>
            <input type="text" class="form-control form-dark" id="country" name="country" value="{{ $info->country }}">
            @error('country')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="phone" class="form-label">@lang('artists.cv.phone')</label>
            <input type="text" class="form-control form-dark" id="phone" name="phone" value="{{ $info->phone }}">
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="email" class="form-label">@lang('user.email')</label>
            <input type="email" class="form-control form-dark" id="email" name="email" value="{{ $info->email }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="bank" class="form-label">@lang('artists.cv.bank')</label>
            <input type="text" class="form-control form-dark" id="bank" name="bank" value="{{ $info->bank }}">
            @error('bank')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="place_of_bank" class="form-label">@lang('artists.cv.place_of_bank')</label>
            <input type="text" class="form-control form-dark" id="place_of_bank" name="place_of_bank" value="{{ $info->place_of_bank }}">
            @error('place_of_bank')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="account_holder" class="form-label">@lang('artists.cv.account_holder')</label>
            <input type="text" class="form-control form-dark" id="account_holder" name="account_holder" value="{{ $info->account_holder }}">
            @error('account_holder')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="account_number" class="form-label">@lang('artists.cv.account_number')</label>
            <input type="text" class="form-control form-dark" id="account_number" name="account_number" value="{{ $info->account_number }}">
            @error('account_number')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="passport_number" class="form-label">@lang('artists.cv.passport_number')</label>
            <input type="text" class="form-control form-dark" id="passport_number" name="passport_number" value="{{ $info->passport_number }}">
            @error('passport_number')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary save-artist-info-btn" data-method="{{ $info->id ? 'PUT' : 'POST' }}"
                data-url="{{ $info->id ? route('artists.public.contact.update', $info->id) : route('artists.public.contact.store') }}" @if($info->id) data-id="{{ $info->id }}"@endif>
            <i class="fa-solid fa-check me-2"></i>@lang('shared.admin.save')
        </button>
    </div>
</div>
