<table class="table table-sm table-hover table-dark">
    <thead>
    <tr>
        <th></th>
        <th>Артист</th>
        <th>Название</th>
        <th>Микс</th>
        <th>Длина</th>
        <th>ISRC</th>
        <th>Релиз</th>
    </tr>
    </thead>
    <tbody class="text-nowrap" style="font-size: 14px">
    @foreach($tracks as $item)
        <tr>
            <td>
                <button type="button" class="btn btn-sm btn-outline add-to-release me-3" data-track-id="{{ $item->id }}" data-url="{{ route('releases.add_track') }}">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </td>
            <td>{{ $item->artists }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->mix_name }}</td>
            <td>{{ $item->length }}</td>
            <td>{{ $item->isrc }}</td>
            <td>
                @foreach($item->releases as $release)
                    {{ $release->title }} @if(!$loop->last), @endif
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
