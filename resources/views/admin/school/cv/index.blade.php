@extends('admin.layout.layout')

@section('title')
    CTSchool - Анкеты | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions my-3">
            <a href="{{ route('school.cv') }}" target="_blank" class="btn btn-outline">
                <i class="fa-solid fa-list me-2"></i>Анкета
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-dark">
                <tbody class="text-nowrap">
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
                            <td>{{ $cv->created_at->isoFormat('LLL') }}</td>
                            <td>
                                <form action="{{ route('school.cv.destroy', $cv->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <a class="btn btn-sm btn-primary" href="{{ route('school.cv.show', $cv->id) }}">
                                        <i class="fa-solid fa-chevron-right me-2"></i>Смотреть анкету
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" type="submit" onclick='return confirm("Удалить анкету?")'>
                                        <i class="fa-solid fa-trash me-2"></i>Удалить
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
