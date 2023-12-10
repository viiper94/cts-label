<tr data-info-id="{{ $info->id }}">
    <input type="hidden" name="info[]" value="{{ $info->id }}">
    <td>{{ $info->artist_name }}</td>
    <td>{{ $info->first_name }}</td>
    <td>{{ $info->surname }}</td>
    <td>{{ $info->country }}</td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline-primary add-artist-info-btn"
                data-bs-toggle="tooltip" data-bs-title="@lang('shared.admin.edit')"
                data-url="{{ route('artists.public.contact.edit', $info->id) }}" data-id="{{ $info->id }}">
            <i class="fa-solid fa-pen"></i>
        </button>
        <button type="button" class="btn btn-sm btn-outline-danger remove-artist-info-btn"
                data-alert="@lang('artists.cv.delete_info')?" data-bs-toggle="tooltip" data-bs-title="@lang('shared.admin.delete')">
            <i class="fa-solid fa-minus"></i>
        </button>
    </td>
    <td class="sort-handle text-muted"><i class="fa-solid fa-grip-vertical me-2"></i></td>
</tr>
