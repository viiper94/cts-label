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
        img{
            width: 100%;
        }
        h2{
            text-align: center;
            margin: 0;
        }
        ul{
            text-align: center;
            list-style-type: disc;
            margin: 0;
        }
        ul li{
            display: inline-block;
            margin-right: 15px;
        }
        td{
            vertical-align: top;
            padding-bottom: 15px;
        }
        .small{
            font-size: 11px;
        }
    </style>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body class="wrapper">

    <img src="{{ resource_path('img/cv_document_header.jpg') }}">

    <h2 class="mb-0">CTSchool</h2><br>
    <ul>
        <li>@lang('cv.sound_engineer')</li>
        <li>@lang('cv.arranger')</li>
        <li>@lang('cv.dj')</li>
        <li>@lang('cv.sound_producer')</li>
    </ul>

    <table>

        <tr>
            <td><b>1.</b></td>
            <td>
                <b>@lang('cv.name')</b><br>
                <i>{{ $cv->name ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>2.</b></td>
            <td>
                <b>@lang('cv.birth_date')</b><br>
                <i>{{ $cv->birth_date->isoFormat('LL') ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>3.</b></td>
            <td>
                <b>@lang('cv.dj_name')</b><br>
                <i>{{ $cv->dj_name ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>4.</b></td>
            <td>
                <b>@lang('cv.social')</b><br>
                @foreach(['instagram', 'facebook', 'soundcloud', 'other_social'] as $social)
                    @if(isset($cv->$social))
                        {{ $cv->$social }} <br>
                    @endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td><b>5.</b></td>
            <td>
                <b>@lang('user.email')</b><br>
                <i>{{ $cv->email ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>6.</b></td>
            <td>
                <b>@lang('cv.phone_number')</b><br>
                <i>{{ $cv->phone_number ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>7.</b></td>
            <td>
                <b>@lang('cv.address')</b><br>
                <i>{{ $cv->address ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>8.</b></td>
            <td>
                <b>@lang('cv.education')</b><br>
                <i>{{ $cv->education ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>9.</b></td>
            <td>
                <b>@lang('cv.job')</b><br>
                <i>{{ $cv->job ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>10.</b></td>
            <td>
                <b>@lang('cv.sound_engineer_skills')</b><br>
                <i>{{ $cv->sound_engineer_skills ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>11.</b></td>
            <td>
                <b>@lang('cv.sound_producer_skills')</b><br>
                <i>{{ $cv->sound_producer_skills ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>12.</b></td>
            <td>
                <b>@lang('cv.dj_skills')</b><br>
                <i>{{ $cv->dj_skills ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>13.</b></td>
            <td>
                <b>@lang('cv.music_genres')</b><br>
                <i>{{ $cv->music_genres ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>14.</b></td>
            <td>
                <b>@lang('cv.os')</b><br>
                <i>{{ $cv->os ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>15.</b></td>
            <td>
                <b>@lang('cv.equipment')</b><br>
                <i>{{ $cv->equipment ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>16.</b></td>
            <td>
                <b>@lang('cv.additional_info')</b><br>
                <i>{{ $cv->additional_info ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>17.</b></td>
            <td>
                <b>@lang('cv.learned_about_ctschool')</b><br>
                <i>{{ $cv->learned_about_ctschool ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>18.</b></td>
            <td>
                <b>@lang('cv.course')</b><br>
                <i>{{ $cv->course ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>19.</b></td>
            <td>
                <b>@lang('cv.what_to_learn')</b><br>
                <i>{{ $cv->what_to_learn ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>20.</b></td>
            <td>
                <b>@lang('cv.purpose_of_learning')</b><br>
                <i>{{ $cv->purpose_of_learning ?? '-' }}</i>
            </td>
        </tr>

        <tr>
            <td><b>21.</b></td>
            <td>
                <b>@lang('cv.created_at')</b><br>
                <i>{{ $cv->created_at->isoFormat('LL') ?? '-' }}</i>
            </td>
        </tr>

    </table>

    <p class="small">CTSchool contact: E-mail: <a class="small" href="mailto:info@cts-label.com">info@cts-label.com</a>; cell: +38 098 685 40 33 </p>

</body>
</html>
