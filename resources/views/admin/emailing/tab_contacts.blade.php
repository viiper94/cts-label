{{ $contacts->appends(Request::input())->links('admin.layout.pagination') }}
<div class="table-responsive">
    <table class="items-table table table-hover table__dark">
        <tbody>
        <tr>
            @php $headers = [
                'name' => 'Имя',
                'email' => 'E-Mail',
                'company' => 'Компания',
                'company_foa' => 'Сфера',
                'position' => 'Должность',
                'website' => 'Сайт',
                'phone' => 'Телефон',
                'additional' => 'Доп. информация',
                'created' => 'Добавлен',
            ];
            @endphp
            @foreach($headers as $key => $item)
                <th>
                    <a href="{{ route('contacts.index', [
                            'sort' => $key,
                            'dir' => ($dir === 'up' ? 'down' : 'up'),
                            'channel' => Request::input('channel'),
                            'q' => Request::input('q'),
                        ]) }}">
                        {{ $item }}
                    </a>
                    @if($sort === $key)
                        <span @class([
                            'glyphicon text-warning',
                            'glyphicon-sort-by-alphabet' => ($dir === 'up'),
                            'glyphicon-sort-by-alphabet-alt' => ($dir === 'down'),
                        ])></span>
                    @endif
                </th>
            @endforeach
            <th style="overflow: visible">
                <div class="dropdown dropdown__dark">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        @if(Request::input('channel')){{ $selected_channel }}@elseКаналы@endif
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        @foreach($channels as $item)
                            <li><a href="{{ route('contacts.index', ['channel' => $item->id]) }}">{{ $item->title }}</a></li>
                        @endforeach
                        <li><a href="{{ route('contacts.index') }}">Все каналы</a></li>
                    </ul>
                </div>
            </th>
            <th>
                <a class='btn btn-info btm-sm' href='{{ route('contacts.create') }}'>
                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                </a>
            </th>
        </tr>
        @foreach($contacts as $contact)
            <tr>
                <td><b @if($contact->full_name) title="{{ $contact->full_name }}" @endif>{{ $contact->name }}</b></td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->company }}</td>
                <td>{{ $contact->company_foa }}</td>
                <td>{{ $contact->position }}</td>
                <td>@if($contact->website)<a href="{{ $contact->website }}" target="_blank">{{ $contact->website }}</a>@endif</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->additional }}</td>
                <td>{{ $contact->created_at->format('d/m/y H:i') }}</td>
                <td class="text-center">{{ implode(', ', \Illuminate\Support\Arr::pluck($contact->channels->toArray(), 'title')) }}</td>
                <td>
                    <a class='btn btn-warning' href='{{ route('contacts.edit', $contact->id) }}'>
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{ $contacts->appends(Request::input())->links('admin.layout.pagination') }}
