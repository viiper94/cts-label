@extends('admin.layout.layout')

@section('title')
    @lang('feedback.feedbacks') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid admin-releases">

        <div class="justify-content-between align-items-center d-flex flex-column-reverse flex-lg-row my-3">
            <div class="releases-actions text-center">
                <button type="button" class="btn btn-primary m-xl-0 m-1" data-bs-toggle="modal" data-bs-target="#newFeedbackModal">
                    <i class="fa-solid fa-plus me-2"></i>@lang('feedback.new_feedback')
                </button>
            </div>
            {{ $feedback_list->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <div class="row">
            @foreach($feedback_list as $feedback)
                <div class="col-xxl-3 col-xl-4 col-md-12 col-sm-6 col-xs-12">
                    <div class="card text-bg-dark mb-3">
                        <div class="row g-0">
                            <div class="card-header d-flex flex-nowrap align-items-center">
                                <h5 class="card-title text-nowrap mb-0 text-truncate flex-grow-1" title="{{ $feedback->feedback_title }}">{{ $feedback->feedback_title }}</h5>
                                @if(!$feedback->release)
                                    <i class="fa-solid fa-wand-magic-sparkles ms-2" title="@lang('feedback.custom_feedback')"></i>
                                @endif
                            </div>
                            <div class="col-12 d-flex g-0">
                                <div class="card-img col-auto">
                                    @if($feedback->release)
                                        <img src="/images/releases/{{ $feedback->release->image ?? 'default.png' }}" class="img-fluid" alt="{{ $feedback->feedback_title }}">
                                    @else
                                        <img src="/images/feedback/{{ $feedback->image ?? 'default.png' }}" class="img-fluid" alt="{{ $feedback->feedback_title }}">
                                    @endif
                                </div>
                                <div class="card-info d-flex flex-column col">
                                    <div class="d-flex flex-grow-1">
                                        <div class="card-body">
                                            <small class="text-muted">@lang('feedback.tracks')</small>
                                            <h4 class="card-text">{{ $feedback->ftracks_count }}</h4>
                                            <small class="text-muted">@lang('feedback.replies.replies')</small>
                                            <h4 class="card-text">{{ $feedback->results_count }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a class="btn btn-sm btn-primary" href="{{ route('feedback.edit', $feedback->id) }}">
                                    <i class="fa-solid fa-pen me-2"></i>@lang('shared.admin.edit')
                                </a>
                                <a class="btn btn-sm btn-outline" href="{{ route('feedback', $feedback->slug) }}" target="_blank">
                                    @lang('feedback.frontend')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="justify-content-center d-flex my-3">
            {{ $feedback_list->appends(['q' => Request::input('q')])->links('admin.layout.pagination') }}
        </div>

    </div>

    <div class="modal fade" id="newFeedbackModal">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('feedback.pick_release')</h5>
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body row g-0">
                    @foreach($releases_without_feedback as $release)
                        <div class="col-xs-6 col-md-3 p-3">
                            <a href="{{ route('feedback.create', $release->id) }}" class="d-block" title="{{ $release->title }}">
                                <img src="/images/releases/{{ $release->image }}" alt="{{ $release->image }}" class="img-fluid">
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <a href="{{ route('feedback.create') }}" class="btn btn-outline">
                        <i class="fa-solid fa-wand-magic-sparkles me-2"></i>@lang('feedback.create_custom')
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
