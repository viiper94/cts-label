@extends('admin.layout.layout')

@section('title')
    @lang('feedback.replies.replies') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid admin-tracks admin-results">
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
                    <th class="text-nowrap">
                        @if($feedback_results_count > 0)
                            <a href="{{ route('feedback.results.index', [
                                'sort' => 'status',
                                'dir' => (Request::input('dir') === 'up' ? 'down' : 'up'),
                                'q' => Request::input('q'),
                            ]) }}">
                                <span class="badge badge-sm bg-danger">{{ $feedback_results_count }}</span>
                            </a>
                            @if(Request::input('sort') === 'status')
                                <i @class([
                                    'fa-solid text-warning',
                                    'fa-arrow-down-a-z' => (Request::input('dir') === 'up'),
                                    'fa-arrow-down-z-a' => (Request::input('dir') === 'down'),
                                ])></i>
                            @endif
                        @endif
                    </th>
                </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                        @include('admin.feedback.result_item_list', compact('result'))
                    @empty
                        <tr><td colspan="6">@lang('feedback.replies.no_replies_yet')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true" data-target="list">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>

@endsection
