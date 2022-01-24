<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>Feedback to {{ $feedback->feedback_title }}</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/player.css">
    <link rel="stylesheet" href="/assets/css/feedbackform_style.css">
    <script src="/assets/js/jquery-1.12.2.min.js"></script>
    <script src="/assets/js/wavesurfer.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <!--[if lte IE 9]>
        <h2 align="center" style="color: red">
            Content may display in wrong way in Internet Explorer!
            <a href="https://www.google.com/chrome/browser/desktop/index.html"><h2>Please use another browser!</h2></a>
        </h2>
        <![endif]-->
        <header>
            <div class="header_img">
                <div class="ctschool">
                    <a target="_blank" href="http://www.cts-label.com/ctschool.html" title="CTSchool - школа DJ & саунд продакшн">
                        <img class="header_img-ctschool" src="/assets/img/logo_rassilka2.jpg" alt="CTSchool">
                    </a>
                </div>
                <div class="ctslabel">
                    <a target="_blank" href="http://www.cts-label.com/" title="CTS Records - official label website">
                        <img class="header_img-ctslabel" src="/assets/img/logo_rassilka2.jpg" alt="CTS Label">
                    </a>
                </div>
                <div class="sergiomega">
                    <a target="_blank" href="http://www.sergiomega.com/" title="Sergio Mega - official website">
                        <img class="header_img-sergiomega" src="/assets/img/logo_rassilka2.jpg" alt="Sergio Mega">
                    </a>
                </div>
                <div class="ctstudio">
                    <a target="_blank" href="http://www.cts-studio.com/"  title="CTS Records - official portal">
                        <img class="header_img-ctstudio" src="/assets/img/logo_rassilka2.jpg" alt="CTS Studio">
                    </a>
                </div>
            </div>
        </header>

        @yield('content')

        <footer>
            <div class="top_footer">
                <p>
                    CTS Records | Baseyna 3, of. 49 | 01004 | Ukraine, Kyiv<br>
                    Phone / Fax +38 044 496 09 02 |
                    <a href="mailto:info@cts-studio.com">info@cts-studio.com</a> |
                    <a href="/">www.cts-label.com</a><br>
                    Booking contact: Lilia Lazareva |
                    <a href="mailto:lilia@cts-studio.com">lilia@cts-studio.com</a> | Cell +38 098 685 40 33
                </p>
            </div>
            <div class="bottom_footer">
                <span>Follow CTS Records</span>
                <div class="facebook">
                    <a href="https://www.facebook.com/CTS.Records" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="twitter">
                    <a href="https://twitter.com/cts_records" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="myspace">
                    <a href="https://myspace.com/cts_records" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="youtube">
                    <a href="https://www.youtube.com/user/CTSStudioUA" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="vk">
                    <a href="https://vk.com/club9616527" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="soundcloud">
                    <a href="https://soundcloud.com/cts-records" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="rss">
                    <a href="http://www.cts-label.com/rss.php" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="beatport">
                    <a href="https://pro.beatport.com/label/cts-creative-technologies-studio/4470" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="resident">
                    <a href="http://www.residentadvisor.net/record-label.aspx?id=2317" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
                <div class="subscribe">
                    <a href="http://cts-label.com/subscribe/" target="_blank">
                        <img src="/assets/img/followus_letter_AUG_2011.gif">
                    </a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
