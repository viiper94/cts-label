@extends('admin.layout.layout')

@section('title')
    Вебинар | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid emailing">
        <div class="justify-content-between align-items-center d-flex flex-column-reverse flex-lg-row my-3">
            <div class="releases-actions d-flex gap-2">
                <a href="{{ route('event') }}" class="btn btn-primary m-xl-0 m-1" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Страница вебинара
                </a>
            </div>
            {{ $contacts->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <p class="text-muted mb-0">Всего зарегестрировалось: {{ $total }}</p>
        <div class="table-responsive" data-fl-scrolls>
            <table class="table table-hover table-dark">
                <thead>
                <tr>
                    @php $headers = [
                        'name' => 'Имя',
                        'email' => 'E-Mail',
                        'tel' => 'Телефон',
                        'type' => 'Сфера',
                        'additional' => 'Доп. инфо',
                        'created_at' => 'Добавлен',
                    ];
                    @endphp
                    @foreach($headers as $key => $item)
                        <th>
                            <a href="{{ route('event.index', [
                                    'sort' => $key,
                                    'dir' => ($dir === 'up' ? 'down' : 'up'),
                                    'q' => Request::input('q'),
                                ]) }}" class="text-light text-nowrap">
                                {{ $item }}
                            </a>
                            @if($sort === $key)
                                <i @class([
                                    'fa-solid text-warning',
                                    'fa-arrow-down-a-z' => ($dir === 'up'),
                                    'fa-arrow-down-z-a' => ($dir === 'down'),
                                ])></i>
                            @endif
                        </th>
                    @endforeach
                    <th></th>
                </tr>
                </thead>
                <tbody class="text-nowrap">
                @foreach($contacts as $contact)
                    <tr>
                        <td><b>{{ $contact->name }}</b></td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->tel }}</td>
                        <td>{{ $contact->type }}</td>
                        <td>{{ $contact->additional }}</td>
                        <td>{{ $contact->created_at->format('d/m/y H:i') }}</td>
                        <td>
                            <form action="{{ route('event.destroy', $contact->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить контакт?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="justify-content-end d-flex mb-3">
            {{ $contacts->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
    </div>

@endsection

