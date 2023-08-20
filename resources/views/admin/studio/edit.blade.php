<div class="modal-header">
    <h5 class="modal-title">{{ $service->id ? trans('studio.edit_service') : trans('studio.new_service') }}</h5>
    <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<div class="modal-body">
    <form action="{{ $service->id ? route('studio.update', $service->id) : route('studio.store') }}" id="edit_form"
          enctype="multipart/form-data" method="post">
        @csrf
        @if($service->id)
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-5">
                <img src="/images/studio/services/{{ $service->image ?? 'default.png' }}" id="preview" class="img-fluid" alt="{{ $service->service_alt }}">
                <input type="file" name="image" id="uploader" class="form-control form-dark" accept="image/jpeg, image/png">
            </div>
            <div class="col-md-7">
                <x-checkbox class="mb-3" name="visible" :checked="$service->visible">@lang('studio.visible')</x-checkbox>
                <label class="form-label mb-0">@lang('studio.lang')</label><br>
                <div class="form-check form-check-inline mb-3">
                    <input type="radio" name="lang" id="lang-en" class="form-check-input" value="en"
                           required @checked($service->lang === 'en')>
                    <label for="lang-en" class="form-check-label">English</label>
                </div>
                <div class="form-check form-check-inline mb-3">
                    <input type="radio" name="lang" id="lang-ua" class="form-check-input" value="ua"
                           required @checked($service->lang === 'ua')>
                    <label for="lang-ua" class="form-check-label">Українська</label>
                </div>
                <div class="form-check form-check-inline mb-3">
                    <input type="radio" name="lang" id="lang-ru" class="form-check-input" value="ru"
                           required @checked($service->lang === 'ru')>
                    <label for="lang-ru" class="form-check-label">Русский</label>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label form-dark" for="name">@lang('studio.service_name')</label>
                    <input type="text" class="form-control form-dark" name="name" id="name" value="{{ $service->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="service_alt">@lang('studio.keywords')</label>
                    <textarea name="service_alt" id="service_alt" rows="3" class="form-control form-dark">{{ $service->service_alt }}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    @if($service->id)
        <form action="{{ route('studio.destroy', $service->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger" onclick="return confirm('Удалить курс?')">
                <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
            </button>
        </form>
    @endif
    <button class="btn btn-primary" form="edit_form" type="submit">
        <i class="fa-solid fa-check me-2"></i>@lang('shared.admin.save')
    </button>
</div>
