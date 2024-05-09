<div class="accordion-item" data-result-id="{{ $result->id }}">
    <h2 class="accordion-header" id="heading_{{ $key }}">
        <button class="accordion-button text-bg-dark" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse_{{ $key }}" aria-expanded="true" aria-controls="collapse_{{ $key }}">
            <i class="{{ $result->status->getStarClass() }} me-2"></i>
            <b>{{ $result->name }}</b>&nbsp;<i>({{ $result->created_at }})</i>
        </button>
    </h2>
    <div id="collapse_{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $key }}" data-bs-parent="#accordion">
        <div class="accordion-body text-bg-dark">
            <p><i class="fa-solid fa-user me-2"></i>@lang('user.name'): <b>{{ $result->name }}</b></p>
            <p><i class="fa-solid fa-envelope me-2"></i>@lang('user.email'): <b>{{ $result->email }}</b></p>
            <p class="mb-0"><i class="fa-solid fa-star me-2"></i><b>@lang('feedback.replies.scores')</b>:</p>
            <ul style="list-style: none" class="mb-3">
                @foreach($result->rates as $track => $score)
                    <li><b>{{ $score }}</b>: "{{ $track }}"</li>
                @endforeach
            </ul>
            @if($result->best_track)
                <p><i class="fa-solid fa-heart me-2"></i>@lang('feedback.best_track'): <b>{{ $result->best_track }}</b></p>
            @endif
            <p class="mb-0"><i class="fa-solid fa-comment me-2"></i>@lang('feedback.comment'):</p>
            <p><b>{!! nl2br(e($result->comment)) !!}</b></p>
            <form action="{{ route('feedback.results.destroy', $result->id) }}" method="post" class="mt-3">
                @csrf
                @method('DELETE')
                @if($result->status === \App\Enums\FeedbackResultStatus::NEW)
                    <button type="button" class="btn btn-sm btn-outline-success process-review-btn"
                            data-url="{{ route('feedback.results.add', $result->id) }}" data-key="{{ $key }}">
                        <i class="fa-solid fa-star me-2"></i>@lang('feedback.replies.process_review')
                    </button>
                @endif
                <button type="submit" class="delete-feedback-result-btn btn btn-outline-danger btn-sm"
                        onclick="return confirm('@lang('shared.admin.are_you_sure_to_delete')?')">
                    <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
                </button>
            </form>
        </div>
    </div>
</div>
