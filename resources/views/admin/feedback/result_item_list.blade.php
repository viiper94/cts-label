<tr data-result-id="{{ $result->id }}">
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
