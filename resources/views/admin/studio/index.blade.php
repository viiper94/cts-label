@extends('admin.layout.layout')

@section('title')
    Услуги CTStudio | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions sticky-top my-3">
            <button data-url="{{ route('studio.create') }}" class="btn btn-primary add-service">
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
                        <img src="/images/studio/services/{{ $service->image ?? 'default.png' }}" alt="{{ $service->service_alt }}" class="service-img m-3"
                             data-id="{{ $service->id }}" data-url="{{ route('studio.edit', $service->id) }}">
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="modal fade" id="editServiceModal">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование услуги</h5>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>

@endsection
