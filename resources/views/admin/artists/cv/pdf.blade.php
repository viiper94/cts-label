<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <style>
        *{
            font-family: 'DejaVu Sans', 'sans-serif';
            font-size: 13px;
        }
        body{
            margin-left: 100px;
        }
        table{
            border-collapse: collapse;
        }
        tr.header-row{
            text-transform: uppercase;
        }
        tr.header-row span{
            padding-top: 40px;
            display: block;
        }
        th, td{
            padding: 0 10px;
        }
        th + td{
            border: 1px solid black;
        }
        th{
            text-align: right;
        }
        img{
            width: 150px;
            margin-right: 50px;
        }
        .red{
            color: red;
        }
        h1{
            font-size: 22px;
        }
        p.subheader{
            margin: 0;
        }
        h1.header{
            margin: 0;
        }
    </style>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body class="wrapper">

<table>
    <tbody>
    <tr>
        <td><img src="{{ public_path('images/cts_studio.jpg') }}" alt="cts_studio"></td>
        <td>
            <h1 class="header">@lang('artists.cv.title')</h1>
            <p class="subheader red">@lang('artists.cv.not_public')</p>
        </td>
    </tr>
    <tr class="header-row">
        <th class="red"><span>@lang('artists.cv.main_contact'):</span></th>
        <th></th>
    </tr>
    <tr>
        <th>@lang('artists.cv.contact_name'):</th>
        <td>{{ $cv->main_contact_name }}</td>
    </tr>
    <tr>
        <th>@lang('artists.cv.phone'):</th>
        <td>{{ $cv->main_contact_phone }}</td>
    </tr>
    <tr>
        <th>@lang('user.email'):</th>
        <td>{{ $cv->main_contact_email }}</td>
    </tr>

    @if($cv->tracks_to_sign)
        <tr class="header-row">
            <th class="red"><span>@lang('artists.cv.tracks_to_sign'):</span></th>
            <th></th>
        </tr>
        @foreach($cv->tracks_to_sign as $track)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $track['name'] }} ({{ $track['mix'] }})</td>
            </tr>
        @endforeach
    @endif

    @foreach($cv->artists_info as $info)
        <tr class="header-row">
            <th class="red"><span>{{ $loop->iteration }}. @lang('artists.cv.artists_info'):</span></th>
            <th></th>
        </tr>
        <tr>
            <th>@lang('artists.cv.surname'):</th>
            <td>{{ $info->surname }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.first_name'):</th>
            <td>{{ $info->first_name }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.artist_name'):</th>
            <td>{{ $info->artist_name }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.publisher'):</th>
            <td>{{ $info->publisher }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.pro'):</th>
            <td>{{ $info->pro }}</td>
        </tr>
        @if($info->date_of_birth)
            <tr>
                <th>@lang('artists.cv.date_of_birth'):</th>
                <td>{{ $info->date_of_birth->isoFormat('LL') }}</td>
            </tr>
        @endif
        <tr>
            <th>@lang('artists.cv.address'):</th>
            <td>{{ $info->address }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.city'):</th>
            <td>{{ $info->city }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.state'):</th>
            <td>{{ $info->state }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.zip'):</th>
            <td>{{ $info->zip }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.country'):</th>
            <td>{{ $info->country }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.phone'):</th>
            <td>{{ $info->phone }}</td>
        </tr>
        <tr>
            <th>@lang('user.email'):</th>
            <td>{{ $info->email }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.bank'):</th>
            <td>{{ $info->bank }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.place_of_bank'):</th>
            <td>{{ $info->place_of_bank }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.account_holder'):</th>
            <td>{{ $info->account_holder }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.account_number'):</th>
            <td>{{ $info->account_number }}</td>
        </tr>
        <tr>
            <th>@lang('artists.cv.passport_number'):</th>
            <td>{{ $info->passport_number }}</td>
        </tr>
    @endforeach

    </tbody>
</table>


</body>
</html>
