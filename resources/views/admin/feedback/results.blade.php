@extends('admin.layout.layout')

@section('title')
    @lang('feedback.replies.replies') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid admin-tracks">
        <div class="justify-content-between align-items-center d-flex flex-column-reverse flex-lg-row my-3">
            <div class="releases-actions text-center">
                <a href="{{ route('feedback.index') }}" class="btn btn-outline m-xl-0 m-1">
                    <i class="fa-solid fa-comments me-2"></i>@lang('shared.admin.sidebar.feedbacks')
                </a>
            </div>
            {{ $results->appends(Request::input())->links('admin.layout.pagination') }}
        </div>

        <div class="table-responsive" data-fl-scrolls>
            <table class="table table-hover table-dark">
                <thead>
                <tr>
                    <th class="fw-bold">@lang('feedback.feedbacks')</th>
                    <x-table-sorting-header :headers="['name', 'best_track', 'comment']"
                                            :route_name="'feedback.results.index'" trans="feedback"></x-table-sorting-header>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                        <tr>
                            <td>
                                <a href="{{ route('feedback.edit', $result->feedback->id) }}" target="_blank" title="{{ $result->feedback->feedback_title }}">
                                    @if($result->feedback->release)
                                        <img src="/images/releases/{{ $result->feedback->release->image ?? 'default.png' }}" class="img-fluid" alt="{{ $result->feedback->feedback_title }}" style="height: 30px">
                                    @else
                                        <img src="/images/feedback/{{ $result->feedback->image ?? 'default.png' }}" class="img-fluid" alt="{{ $result->feedback->feedback_title }}" style="height: 30px">
                                    @endif
                                </a>
                            </td>
                            <td title="{{ $result->email }}">{{ $result->name }}</td>
                            <td>{{ $result->best_track ?? $result->feedback->ftracks[0]->name }}</td>
                            <td><i>{{ $result->comment }}</i></td>
                            <td>
                                <button type="button" style="width: 34px;"
                                        @class(['btn', 'btn-sm', 'process-review-btn',
                                            'btn-outline-primary' => $result->status === \App\Enums\FeedbackResultStatus::NEW,
                                            'btn-outline' => $result->status != \App\Enums\FeedbackResultStatus::NEW,
                                        ])
                                        data-url="{{ route('feedback.results.add', $result->id) }}">
                                    <i @class(['fa-solid',
                                                'fa-circle-check text-success' => $result->status === \App\Enums\FeedbackResultStatus::ACCEPTED,
                                                'fa-xmark text-danger' => $result->status === \App\Enums\FeedbackResultStatus::REJECTED,
                                                'fa-star' => $result->status === \App\Enums\FeedbackResultStatus::NEW,
                                            ])
                                    ></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">@lang('feedback.replies.no_replies_yet')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>

@endsection
