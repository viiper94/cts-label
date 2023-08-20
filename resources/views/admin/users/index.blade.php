@extends('admin.layout.layout')

@section('title')
    @lang('user.users') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid users">
        @include('admin.layout.alert')
        <div class="table-responsive my-3" data-fl-scrolls>
            <table class="items-table table table-hover table-dark">
                <thead>
                <tr>
                    <th></th>
                    <th>@lang('user.name')</th>
                    <th>@lang('user.email')</th>
                    <th>@lang('user.status')</th>
                    <th>@lang('user.registered_at')</th>
                </tr>
                </thead>
                <tbody class="text-nowrap">
                    @foreach($users as $user)
                        <tr>
                            <td><img src="/images/users/{{ $user->image ?? 'default.png' }}" class="img-fluid" style="height: 30px"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge {{ $user->status->badgeClass() }}">{{ $user->status->name() }}</span></td>
                            <td>{{ $user->created_at->format('j M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
