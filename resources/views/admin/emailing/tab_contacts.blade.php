{{ $contacts->appends([
        'q' => Request::input('q'),
        'sort' => Request::input('sort'),
        'dir' => Request::input('dir'),
        'channel' => Request::input('channel'),
        ])->links('admin.layout.pagination') }}
<div class="table-responsive">
    <table class="items-table table table-hover table__dark">
        <tbody>
        <tr>
            <th>Имя</th>
            <th>E-Mail</th>
            <th>Компания</th>
            <th>Сфера</th>
            <th>Должность</th>
            <th>Сайт</th>
            <th>Телефон</th>
            <th>Каналы</th>
            <th>Доп. информация</th>
            <th>Добавлен</th>
            <th>
                <a class='btn btn-info btm-sm' href='{{ route('emailing_admin') }}/editContact'>
                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                </a>
            </th>
        </tr>
        @foreach($contacts as $contact)
            <tr>
                <td><b>{{ $contact->name }}</b>@if($contact->full_name)({{ $contact->full_name }})@endif</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->company }}</td>
                <td>{{ $contact->company_foa }}</td>
                <td>{{ $contact->position }}</td>
                <td>{{ $contact->website }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ implode(', ', \Illuminate\Support\Arr::pluck($contact->channels->toArray(), 'title')) }}</td>
                <td>{{ $contact->additional }}</td>
                <td>{{ $contact->created_at->isoFormat('LLL') }}</td>
                <td>
                    <a class='btn btn-warning' href='{{ route('emailing_admin') }}/editContact/{{ $contact->id }}'>
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{ $contacts->appends([
        'q' => Request::input('q'),
        'sort' => Request::input('sort'),
        'dir' => Request::input('dir'),
        'channel' => Request::input('channel'),
        ])->links('admin.layout.pagination') }}
