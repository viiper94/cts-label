@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">
        @include('admin.layout.alert')
        @csrf
        <div class="table-responsive">
            <table class="items-table table table-hover table__dark">
                <tbody>
                    <tr>
                        <th></th>
                        <th>Имя</th>
                        <th>E-Mail</th>
                        <th>Статус</th>
                        <th>Зарегестрирован</th>
                        <th>Действия</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td><img src="/images/users/{{ $user->image ?? 'default.png' }}"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="label {{ $user->getStatus()['labelClass'] }}">{{ $user->getStatus()['name'] }}</span></td>
                            <td>{{ $user->created_at->format('j M Y, H:i') }}</td>
                            <td>
                                @if(!$user->is_admin)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <a class='btn btn-success' href='{{ route('users.index') }}/set/{{ $user->id }}/student'>
                                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                        <span class="hidden-xs hidden-sm hidden-lg">Назначить студентом</span>
                                    </a>
                                    <button class='btn btn-danger' onclick='return confirm("Удалить пользователя и все его данные?")'>
                                        <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                        <span class="hidden-xs hidden-sm hidden-lg">Удалить</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
