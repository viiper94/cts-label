<tr data-track-id="{{ $track->id }}">
    <td>
        <input type="hidden" name="tracks[]" value="{{ $track->id }}">
    </td>
    <td><span class="to-clipboard">{{ $track->artists }}</span></td>
    <td><span class="to-clipboard">{{ $track->name }}</span></td>
    <td><small class="to-clipboard">{{ $track->mix_name }}</small></td>
    <td><small class="to-clipboard">{{ $track->length }}</small></td>
    <td><small class="to-clipboard">{{ $track->isrc }}</small></td>
    <td>
        @if($track->youtube)
            <a href="{{ $track->youtube }}" target="_blank" class="btn btn-sm btn-outline"><i class="fa-brands fa-youtube"></i></a>
        @endif
        @if($track->beatport_sample)
            <a href="{{ $track->beatport_sample }}" target="_blank" class="btn btn-sm btn-outline"><i class="fa-solid fa-play"></i></a>
        @endif
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline-primary add-track"
                data-url="{{ route('tracks.edit', $track->id) }}" data-id="{{ $track->id }}">
            <i class="fa-solid fa-pen"></i>
        </button>
        <button type="button" class="btn btn-sm btn-outline-danger remove-track" data-alert="@lang('tracks.delete_track')?">
            <i class="fa-solid fa-minus"></i>
        </button>
    </td>
    <td class="sort-handle text-muted"><i class="fa-solid fa-grip-vertical me-2"></i></td>
</tr>
