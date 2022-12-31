<div align="center">

    <table style="text-align: center; width: 695px; background-color: #fff; font-family: Arial, Sans-Serif">
        <tbody>
        <tr>
            <td>
                <table style="margin: auto">
                    <tbody>
                    <tr>
                        <td>
                            <a href="{{ route('school') }}" target="_blank">
                                <img src="{{ url('/') }}/images/email/ctschool.png" alt="CTSchool" height="122">
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('home') }}" target="_blank">
                                <img src="{{ url('/') }}/images/email/cts.png" alt="CTS" height="122">
                            </a>
                        </td>
                        <td>
                            <a href="https://sergiomega.com/" target="_blank">
                                <img src="{{ url('/') }}/images/email/sergio-mega.png" alt="Sergio Mega" height="122">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h2>Dear {{ $name }}!</h2>
                <h1>We need your feedback!</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <p style="color: blue;font-size: 13px;"><b>DOWNLOAD TRACKS FOR FREE AND SEND US YOUR REACTIONS FOR USING ON SEVERAL WEBSITES</b></p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h1>{{ $mail->feedback->feedback_title }}</h1>
                @if($mail->feedback->release?->genre)
                    <h3>Genre: {{ $mail->feedback->release->genre }}</h3>
                @endif
                <div style="font-size: 16px;">
                    {!! $mail->feedback->release->description_en !!}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <a href="{{ route('feedback', $mail->feedback->slug) }}" target="_blank">
                    @if(!$mail->feedback->release)
                        <img src="{{ url('/') }}/images/feedback/{{ $mail->feedback->image ?? 'default.png' }}" alt="{{ $mail->feedback->feedback_title }}" width="250">
                    @else
                        <img src="{{ url('/') }}/images/releases/{{ $mail->feedback->release->image ?? 'default.png' }}" alt="{{ $mail->feedback->feedback_title }}" width="250">
                    @endif
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <h3><a href="{{ route('feedback', $mail->feedback->slug) }}" target="_blank" style="color: blue;font-size: 19px;">Download & feedback</a></h3>
            </td>
        </tr>
        @if(count($mail->feedback->related) > 0)
            <tr>
                <td style="font-size: 12px">
                    <p>Also available:</p>
                    <p>
                        @foreach($mail->feedback->related as $item)
                            <a href="{{ route('feedback', $item->slug) }}" target="_blank" style="color: red;"><b>{{ $item->feedback_title }}</b></a>
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
            <td>
                <span style="font-size: 11px">Follow us</span>
            </td>
        </tr>
        <tr>
            <td>
                <table style="text-align: center; margin: auto">
                    <tbody>
                    <tr>
                        <td>
                            <a href="https://beatport.com/label/cts-creative-technologies-studio/4470" target="_blank">
                                <img src="{{ url('/') }}/images/email/socials-beatport.png" alt="Follow us on Beatport" width="40">
                            </a>
                        </td>
                        <td>
                            <a href="https://facebook.com/CTS.Records/" target="_blank">
                                <img src="{{ url('/') }}/images/email/socials-facebook.png" alt="Follow us on Facebook" width="40">
                            </a>
                        </td>
                        <td>
                            <a href="https://youtube.com/channel/UCudx-EMGd8zRddRAFWl7YHA" target="_blank">
                                <img src="{{ url('/') }}/images/email/socials-youtube.png" alt="Follow us on YouTube" width="40">
                            </a>
                        </td>
                        <td>
                            <a href="https://ra.co/labels/2317" target="_blank">
                                <img src="{{ url('/') }}/images/email/socials-ra.png" alt="Follow us on Resident Advisor" width="40">
                            </a>
                        </td>
                        <td>
                            <a href="https://soundcloud.com/cts-records" target="_blank">
                                <img src="{{ url('/') }}/images/email/socials-soundcloud.png" alt="Follow us on Soundcloud" width="40">
                            </a>
                        </td>
                        <td>
                            <a href="https://twitter.com/CTS_RECORDS" target="_blank">
                                <img src="{{ url('/') }}/images/email/socials-twitter.png" alt="Follow us on Twitter" width="40">
                            </a>
                        </td>
                        <td>
                            <a href="https://discogs.com/label/74862-CTS-records" target="_blank">
                                <img src="{{ url('/') }}/images/email/socials-discogs.png" alt="Follow us on Discogs" width="40">
                            </a>
                        </td>
                        <td>
                            <a href="https://open.spotify.com/user/892tia21rho36ip7xqygpqxpq" target="_blank">
                                <img src="{{ url('/') }}/images/email/socials-spotify.png" alt="Follow us on Spotify" width="40">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        @if($hash)
            <tr>
                <td>
                    <p style="font-size: 12px; font-style: italic">You get this e-mail because you are a part of international music industry.
                        <br>
                        We respect you and your inbox! If you feel disturbed by our newsletter,<br>
                        push <a href="{{ route('unsubscribe', $hash) }}" target="_blank">unsubscribe</a> and you will immediately be...</p>
                </td>
            </tr>
        @endif
        </tbody>
    </table>

</div>
