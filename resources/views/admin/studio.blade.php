@extends('admin.layout.layout')

@section('assets')
    <link rel="stylesheet" href="/assets/css/jquery.ui.sortable.min.css">
@endsection

@section('scripts')
    <script src="/assets/js/jquery.ui.sortable.min.js"></script>
@endsection

@section('admin-content')

    <div class="container">
        @include('admin.layout.alert')
        <div class="releases-actions">
            <button class='btn btn-success add-service' data-action="{{ route('studio.store') }}">
                <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                Новая услуга
            </button>
        </div>
        @foreach($service_list as $services)
            <h4>({{ $services[0]->lang }}) {{ \Illuminate\Support\Facades\Lang::choice('studio.services', 8, locale: $services[0]->lang) }}</h4>
            <section class="panel panel__dark service-lang">
                <div class="panel-body sortable">
                    @foreach($services as $service)
                        <img src="/images/studio/services/{{ $service->image }}" alt="{{ $service->service_alt }}" class="service-img"
                             data-id="{{ $service->id }}" data-lang="{{ $service->lang }}" data-name="{{ $service->name }}"
                             data-visible="{{ $service->visible }}" data-action="{{ route('studio.update', $service->id) }}">
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="modal fade" id="serviceModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modal-content__dark">
                    <form action="{{ route('studio.store') }}" enctype="multipart/form-data" method="post" id="modal-form">
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <img src="/images/studio/services/default.png" id="preview">
                                    <input type="file" name="image" id="uploader" accept="image/jpeg, image/png">
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Язык</label><br>
                                        <select class="form-control form-control__dark" name="lang" id="lang" required>
                                            <option value="en">English</option>
                                            <option value="ru">Русский</option>
                                            <option value="ua">Українська</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Название услуги</label><br>
                                        <input type="text" class="form-control form-control__dark" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Ключевые слова</label><br>
                                        <textarea name="service_alt" id="service_alt" rows="3" class="form-control form-control__dark"></textarea>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" name="visible" value="0">
                                            <input type="checkbox" name="visible" id="visible"> Опубликовано
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <form method="post" id="delete-form" style="display:none;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" form="delete-form" onclick='return confirm("Удалить?")'><i class="fa-solid fa-trash"></i> Удалить</button>
                        </form>
                        <button type="submit" class="btn btn-primary" form="modal-form"><i class="fa-solid fa-check"></i> Сохранить</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

@endsection
