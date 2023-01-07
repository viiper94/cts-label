<tr data-track-id="{{ $track->id }}">
    <td>
        <input type="hidden" name="tracks[]" value="{{ $track->id }}">
    </td>
    <td>{{ implode(', ', $track->artists) }}</td>
    <td>{{ $track->name }}</td>
    <td><small>{{ $track->mix_name }}</small></td>
    <td><small>{{ $track->isrc }}</small></td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline add-track" data-url="{{ route('tracks.edit', $track->id) }}" data-bs-toggle="modal" data-bs-target="#trackModal">
            <i class="fa-solid fa-pen"></i>
        </button>
        <button type="button" class="btn btn-sm btn-outline-danger remove-track">
            <i class="fa-solid fa-minus"></i>
        </button>
    </td>
    <td class="sort-handle text-muted"><i class="fa-solid fa-grip-vertical me-2"></i></td>
</tr>
