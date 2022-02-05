@extends('admin.layout.layout')

@section('admin-content')

    <div class="container">
        @include('admin.layout.alert')
        @csrf
        <a href="{{ route('cv') }}" target="_blank" class="btn btn-primary">Анкета</a>
        <div class="table-responsive">
            <table class="items-table table table-hover table__dark">
                <tbody>
                    <tr>
                        <th>Имя</th>
                        <th>E-Mail</th>
                        <th>Статус</th>
                        <th>Создано</th>
                        <th>Действия</th>
                    </tr>
                    @foreach($cv_list as $cv)
                        <tr>
                            <td>{{ $cv->name }}</td>
                            <td>{{ $cv->email }}</td>
                            <td><span class="label {{ $cv->getStatus()['labelClass'] }}">{{ $cv->getStatus()['name'] }}</span></td>
                            <td>{{ $cv->created_at->format('j M Y, H:i') }}</td>
                            <td>
                                <a class='btn btn-success' href='{{ route('cv_admin') }}/edit/{{ $cv->id }}/student'>
                                    <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> Смотреть анкету
                                    <span class="hidden-xs hidden-sm hidden-lg">Смотреть анкету</span>
                                </a>
                                <a class='btn btn-danger' href='{{ route('cv_admin') }}/delete/{{ $cv->id }}' onclick='return confirm("Удалить анкету?")'>
                                    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm hidden-lg">Удалить</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
