@extends('admin.layout.layout')

@section('admin-content')

    <div class="container">
        @include('admin.layout.alert')

        @foreach($service_list as $services)
            <h4>{{ $services[0]->lang }}</h4>
            <section class="row panel panel__dark service-lang">
                <div class="panel-body sortable">
                    @foreach($services as $service)
                        <img src="/images/studio/services/{{ $service->image }}" alt="{{ $service->service_alt }}"
                             class="service-img" data-toggle="modal" data-target="#serviceModal" data-id="{{ $service->id }}">
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="modal fade" tabindex="-1" role="dialog" id="serviceModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content__dark">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span class="text-secondary" aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Редактирование услуги</h4>
                    </div>
                    <div class="modal-body">
                        <form action="" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-5">
                                    <img src="/images/studio/services/default.png" id="preview">
                                    <input type="file" name="image" id="uploader" accept="image/jpeg, image/png">
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Язык</label><br>
                                        <select class="form-control form-control__dark" name="lang" required>
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
                                            <input type="checkbox" name="visible"> Опубликовано
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
