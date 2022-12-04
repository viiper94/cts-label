@extends('admin.layout.layout')

@section('assets')
    <link rel="stylesheet" href="/assets/css/jquery.ui.sortable.min.css">
@endsection

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions sticky-top my-3">
            <button data-action="{{ route('studio.store') }}" class="btn btn-primary add-service">
                <i class="fa-solid fa-plus me-2"></i>Новая услуга
            </button>
        </div>
        @foreach($service_list as $services)
            <div class="card text-bg-dark service-lang mb-5">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">({{ $services[0]->lang }}) {{ \Illuminate\Support\Facades\Lang::choice('studio.services', 8, locale: $services[0]->lang) }}</h4>
                    <b class="msg text-primary"></b>
                </div>
                <div class="card-body sortable" data-action="{{ route('studio.resort') }}">
                    @foreach($services as $service)
                        <img src="/images/studio/services/{{ $service->image }}" alt="{{ $service->service_alt }}" class="service-img m-3"
                             data-id="{{ $service->id }}" data-lang="{{ $service->lang }}" data-name="{{ $service->name }}"
                             data-visible="{{ $service->visible }}" data-action="{{ route('studio.update', $service->id) }}">
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="modal fade" id="serviceModal">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body py-3">
                        <form action="{{ route('studio.store') }}" enctype="multipart/form-data" method="post" id="modal-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <img src="/images/studio/services/default.png" id="preview" class="img-fluid">
                                    <input type="file" name="image" id="uploader" class="form-control form-dark" accept="image/jpeg, image/png">
                                </div>
                                <div class="col-md-7">
                                    <div class="form-check mb-3">
                                        <input type="hidden" name="visible" value="0">
                                        <input type="checkbox" name="visible" id="visible" class="form-check-input">
                                        <label for="visible" class="form-check-label">Опубликовано</label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label form-dark">Название услуги</label>
                                        <input type="text" class="form-control form-dark" name="name" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Язык</label>
                                        <select class="form-select form-dark" name="lang" id="lang" required size="3">
                                            <option value="en">English</option>
                                            <option value="ru">Русский</option>
                                            <option value="ua">Українська</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Описание</label>
                                        <textarea name="service_alt" id="service_alt" rows="3" class="form-control form-dark"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <form method="post" id="delete-form" style="display:none;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" form="delete-form" onclick='return confirm("Удалить?")'><i class="fa-solid fa-trash"></i> Удалить</button>
                        </form>
                        <button type="submit" class="btn btn-primary" form="modal-form"><i class="fa-solid fa-floppy-disk"></i> Сохранить</button>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
        </div>

@endsection
