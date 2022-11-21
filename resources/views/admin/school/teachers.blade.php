@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions sticky-top my-3">
            <button data-action="{{ route('school.courses.store') }}" class="btn btn-primary add-service">
                <i class="fa-solid fa-plus me-2"></i>Новая услуга
            </button>
        </div>
        @foreach($service_list as $services)
            <div class="card text-bg-dark service-lang mb-5">
                <h4 class="card-header">({{ $services[0]->lang }}) {{ \Illuminate\Support\Facades\Lang::choice('school.services', 8, locale: $services[0]->lang) }}</h4>
                <div class="card-body sortable">
                    @foreach($services as $service)
                        <img src="/images/school/services/{{ $service->image }}" alt="{{ $service->service_alt }}" class="service-img p-3"
                             data-id="{{ $service->id }}" data-lang="{{ $service->lang }}" data-name="{{ $service->name }}"
                             data-visible="{{ $service->visible }}" data-action="{{ route('school.courses.update', $service->id) }}">
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

@endsection
