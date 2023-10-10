@extends('admin.layout.layout')

@section('title')
    @lang('emailing.contacts.emailing_contacts') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid emailing">
        <div class="justify-content-between align-items-center d-flex flex-column-reverse flex-lg-row my-3">
            <div class="releases-actions d-flex gap-2">
                <a href="{{ route('emailing.contacts.create') }}" class="btn btn-primary m-xl-0 m-1">
                    <i class="fa-solid fa-plus me-2"></i>@lang('emailing.contacts.new_emailing_contact')
                </a>
                <div class="dropdown text-center">
                    <button class="btn btn-outline dropdown-toggle" type="button" id="dropdownMenu1" data-bs-toggle="dropdown">
                        @if(Request::input('channel')){{ $selected_channel }}@else @lang('emailing.contacts.filter_by_channel') @endif
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        @foreach($channels as $item)
                            <li>
                                <a href="{{ route('emailing.contacts.index', ['channel' => $item->id]) }}" class="dropdown-item">
                                    {{ $item->title }}
                                </a>
                            </li>
                        @endforeach
                        <li><a href="{{ route('emailing.contacts.index') }}" class="dropdown-item">@lang('emailing.contacts.all_channels')</a></li>
                    </ul>
                </div>
            </div>
            {{ $contacts->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <div class="table-responsive" data-fl-scrolls>
            <table class="table table-hover table-dark">
                <thead>
                <tr>
                    @php $headers = [
                        'name',
                        'email',
                        'company',
                        'company_foa',
                        'position',
                        'website',
                        'phone',
                        'additional',
                        'created_at',
                    ];
                    @endphp
                    <th></th>
                    @foreach($headers as $item)
                        <th class="text-nowrap">
                            @if($sort === $item)
                                <i @class([
                                    'fa-solid text-warning',
                                    'fa-arrow-down-a-z' => ($dir === 'up'),
                                    'fa-arrow-down-z-a' => ($dir === 'down'),
                                ])></i>
                            @endif
                            <a href="{{ route('emailing.contacts.index', [
                                    'sort' => $item,
                                    'dir' => ($dir === 'up' ? 'down' : 'up'),
                                    'channel' => Request::input('channel'),
                                    'q' => Request::input('q'),
                                ]) }}" class="text-light text-nowrap">
                                @lang('emailing.contacts.'.$item)
                            </a>
                        </th>
                    @endforeach
                    <th class="text-center">@lang('emailing.contacts.channels')</th>
                </tr>
                </thead>
                <tbody class="text-nowrap">
                @foreach($contacts as $contact)
                    <tr>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('emailing.contacts.edit', $contact->id) }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </td>
                        <td><b @if($contact->full_name) title="{{ $contact->full_name }}" @endif>{{ $contact->name }}</b></td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->company }}</td>
                        <td>{{ $contact->company_foa }}</td>
                        <td>{{ $contact->position }}</td>
                        <td>
                            @if($contact->website)
                                <a href="{{ $contact->website }}" target="_blank" class="btn btn-sm btn-outline">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            @endif
                        </td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->additional }}</td>
                        <td>{{ $contact->created_at->format('d/m/y H:i') }}</td>
                        <td class="text-center">{{ implode(', ', \Illuminate\Support\Arr::pluck($contact->channels->toArray(), 'title')) }}</td>
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

