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
                @if(!$mail->feedback->release)
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
                <td style="font-size: 12px">
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
        <tr>
            <td style="font-size: 12px">
                <p>CTS Records | Baseyna 3, of. 49 | 01004 | Ukraine, Kyiv <br>
                Phone / Fax +38 044 496 09 02 | <a href="mailto:records@cts-studio.com" target="_blank">records@cts-studio.com</a> | <a href="{{ route('home') }}" target="_blank">www.cts-label.com</a> <br>
                Booking contact: Lilia Lazareva | <a href="mailto:lilia@cts-studio.com" target="_blank">lilia@cts-studio.com</a> | Cell +38 067 466 75 13</p>
            </td>
        </tr>
        <tr>
            <p style="font-size: 11px">Follow us</p>
            <table style="text-align: center">
                <tbody>
                <tr>
                    <td>
                        <a href="https://beatport.com/label/cts-creative-technologies-studio/4470" target="_blank">
                            <img src="{{ url('/') }}/images/email/social-beatport.png" alt="Follow us on Beatport">
                        </a>
                    </td>
                    <td>
                        <a href="https://facebook.com/CTS.Records/" target="_blank">
                            <img src="{{ url('/') }}/images/email/social-facebook.png" alt="Follow us on Facebook">
                        </a>
                    </td>
                    <td>
                        <a href="https://youtube.com/channel/UCudx-EMGd8zRddRAFWl7YHA" target="_blank">
                            <img src="{{ url('/') }}/images/email/social-youtube.png" alt="Follow us on YouTube">
                        </a>
                    </td>
                    <td>
                        <a href="https://ra.co/labels/2317" target="_blank">
                            <img src="{{ url('/') }}/images/email/social-ra.png" alt="Follow us on Resident Advisor">
                        </a>
                    </td>
                    <td>
                        <a href="https://soundcloud.com/cts-records" target="_blank">
                            <img src="{{ url('/') }}/images/email/social-soundcloud.png" alt="Follow us on Soundcloud">
                        </a>
                    </td>
                    <td>
                        <a href="https://twitter.com/CTS_RECORDS" target="_blank">
                            <img src="{{ url('/') }}/images/email/social-twitter.png" alt="Follow us on Twitter">
                        </a>
                    </td>
                    <td>
                        <a href="https://discogs.com/label/74862-CTS-records" target="_blank">
                            <img src="{{ url('/') }}/images/email/social-discogs.png" alt="Follow us on Discogs">
                        </a>
                    </td>
                    <td>
                        <a href="https://open.spotify.com/user/892tia21rho36ip7xqygpqxpq" target="_blank">
                            <img src="{{ url('/') }}/images/email/social-spotify.png" alt="Follow us on Spotify">
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </tr>
        @if($hash)
            <tr>
                <p style="font-size: 12px; font-style: italic">You get this e-mail because you are a part of international music industry.
                    We respect you and your inbox! If you feel disturbed by our newsletter,
                    push <a href="{{ route('unsubscribe', $hash) }}" target="_blank">unsubscribe</a> and you will immediately be...</p>
            </tr>
        @endif
        </tbody>
    </table>

</div>
