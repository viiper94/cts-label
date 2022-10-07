@extends('admin.layout.layout')

@section('admin-content')

    <div class="container">
        @include('admin.layout.alert')
        @csrf
        <a href="{{ route('cv.public') }}" target="_blank" class="btn btn-primary">Анкета</a>
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
                                <form action="{{ route('cv.destroy', $cv->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <a class='btn btn-success' href='{{ route('cv.show', $cv->id) }}'>
                                        <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> Смотреть анкету
                                        <span class="hidden-xs hidden-sm hidden-lg">Смотреть анкету</span>
                                    </a>
                                    <button class='btn btn-danger' type="submit" onclick='return confirm("Удалить анкету?")'>
                                        <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                        <span class="hidden-xs hidden-sm hidden-lg">Удалить</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
