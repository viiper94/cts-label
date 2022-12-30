<div align="center">

    <table style="text-align: center; width: 695px; background-color: #fff; font-family: Arial, Sans-Serif">
        <tbody>
        <tr>
            <td>
                <img src="https://www.cts-label.com/images/email/logo_rassilka2.jpg" alt="CTS Sites" style="width: 700px; height: 122px;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h3>Dear {{ $name }}!</h3>
                <h1>We need your feedback!</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h6 style="color: blue">DOWNLOAD TRACKS FOR FREE AND SEND US YOUR REACTIONS FOR USING ON SEVERAL WEBSITES</h6>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h1>{{ $mail->feedback->feedback_title }}</h1>
                @if($mail->feedback->release?->genre)
                    <h3>Genre: {{ $mail->feedback->release->genre }}</h3>
                @endif
                {!! $mail->feedback->release->description_en !!}
            </td>
        </tr>
        <tr>
            <td>
                @if(!$feedback->release)
                    <img src="{{ url('/') }}/images/feedback/{{ $mail->feedback->image ?? 'default.png' }}" alt="{{ $mail->feedback->feedback_title }}">
                @else
                    <img src="{{ url('/') }}/images/releases/{{ $mail->feedback->release->image ?? 'default.png' }}" alt="{{ $mail->feedback->feedback_title }}">
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <h3><a href="{{ route('feedback', $mail->feedback->slug) }}" target="_blank" style="color: blue;">Download & feedback</a></h3>
            </td>
        </tr>
        @if(count($mail->feedback->related) > 0)
            <tr>
                <td>
                    <p>Also available:</p>
                    <p>
                        @foreach($mail->feedback->related as $item)
                            <a href="{{ route('feedback', $item->slug) }}" target="_blank" style="color: red;">{{ $item->feedback_title }}</a>
                            <br>
                        @endforeach
                    </p>
                </td>
            </tr>
        @endif

        </tbody>
    </table>

</div>
