@extends('layout.layout')

@section('assets')
    <link href="/assets/css/ctssc2.css" rel="stylesheet" />
    <link  href="/assets/css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="/assets/js/modernizr.js"></script>
@endsection

@section('content')
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "Курсы звукорежиссуры и аранжировки CTSchool",
      "url" : "http://www.cts-label.com/ctschool.html",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Kiev, Ukraine",
        "streetAddress": "Бессарабська площа, 4,"
      },
      "email": "info(at)cts-label.com",

     "telephone": "+38 098 685 40 33"

    }
    </script>
    <div class="col-xs-12 school-page">
        <div class="row">
            <div class="col-xs-12 s-logo">
                <div class="container">
                    <img src="/assets/img/ctschool-y.png" alt="CTSchool" />
                    <div class="col-md-5 col-sm-6 pull-right">
                        <h1>CTSchool - профессиональные курсы звукорежиссеров, аранжировщиков, DJ-ев и саунд продюсеров в
                            Киеве</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="school-menu school-land">
                <div class="container">
                    <ul class="nav-justified list-unstyled s-menu clearfix">
                        <li><a href="#about">О Курсах</a></li>
                        <li><a href="#equipment">Оборудование</a></li>
                        <li><a href="#teachers">Преподаватели</a></li>
                        <li><a href="#prices">Стоимость обучения</a></li>
                        <li><a href="#contacts">Контакты</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="container">
            <h2 class="sh text-center" id="courses">КУРСЫ</h2>
            <div class="сol-xs-12 course-buttons ">
                <div class="course-button l1 hover_one">
                    SOUND PRODUCER
                </div>
                <div class="course-button l2 hover_two">
                    ЗВУКОРЕЖИССЕР
                    АРРАНЖИРОВЩИК
                </div>
                <div class="course-button l2 hover_three">
                    Концертный
                    ЗВУКОРЕЖИССЕР
                </div>
                <div class="course-button l2 hover_four">
                    ОСНОВЫ ТЕОРИИ <span class="lsp">МУЗЫКИ</span>

                </div>
                <div class="course-button l2 hover_five">
                    ВОКАЛЬНОЕ МАСТЕРСТВО

                </div>
                <div class="course-button l1b hover_six">
                    DJ
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="school-images">
                <section class="b-marquee-line">
                    <div class="b-marquee-line__flow">
                        <div class="b-marquee-line__flow-in">
                          <span class="b-marquee-line__flow-block">
                             @for($i = 1; $i <= 7; $i++)
                                <img src="/assets/img/school-{{ $i }}.jpg" class="pull-left" />
                              @endfor
						  </span>
                            <span class="b-marquee-line__flow-block">
                             @for($i = 1; $i <= 7; $i++)
                                <img src="/assets/img/school-{{ $i }}.jpg" class="pull-left" />
                                @endfor
						  </span>
                        </div>
                    </div>
                </section>
                <div class="clearfix"></div>
            </div>
            <h2 class="text-center sh" id="equipment">ОБОРУДОВАНИЕ</h2>
            <div class="col-xs-12">
                <div class="col-md-3 col-md-offset-3 col-sm-4 grey-text hrdw">
                    <div class="row">
                        <div class="bordered">HARDWARE</div>
                        <p>Vinyl Turn Tables:<br />
                            Technics 12 10 MK2</p>

                        <p>CD double: Pioneer</p>

                        <p> CD double: Denon</p>

                        <p>Mixer: Pioner</p>

                        <p>Effector: Pioneer</p>

                        <p>NI TRAKTOR</p>
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-4 grey-text hrdw">
                    <div class="row">
                        <div class="bordered">SOFTWARE</div>
                        <p>Propellerheads REASON</p>


                        <p>Ableton LIVE</p>


                        <p>Digidesign PRO TOOLS</p>


                        <p>Apple LOGIC PRO</p>


                        <p>Presonus STUDIO ONE</p>


                        <p>Steinberg NUENDO</p>
                    </div>
                </div>
                <div class="col-sm-4 col-sm-offset-4 text-center">
                    <p><a href="{{ route('studio') }}#equipment">Смотреть полную комплектацию<br> в разделе "Studio"</a></p>
                </div>
                <div class="clearfix"></div>
                <h2 class="text-center sh" id="teachers">ПРЕПОДАВАТЕЛИ</h2>
                <div class="teachers">
                    <div class="row">
                        <div class="col-md-4 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-1.png" alt="" />
                            <b>ИВАН ШАПОВАЛОВ</b>

                            <div class="binfo"> Звукорежиссура,
                                Сведение, мастеринг<br />
                                STUDIO ONE, CUBASE.<br />
                                Теория, практические занятия<br />
                                Психоакустика - мастер класс

                            </div>
                            <div class="hinfo">звукроежиссер и совладелец продакшн студии, участник группы That Black,
                                опыт работы на сцене, в кино, на ТV
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-2.png" alt="" />
                            <b>SERGIO MEGA</b>

                            <div class="binfo">Аранжировка<br />
                                Сведение, мастеринг<br />
                                LOGIC, PRO TOOLS, Reason<br />
                                Теория, практические занятия
                            </div>
                            <div class="hinfo">
                                DJ, музыкант, продюсер. Преподаватель кафедры звукорежиссуры НАКККиМ. Основатель лейбла
                                и студии звукозаписи CTS Records

                            </div>
                        </div>
                        <div class="clearfix visible-sm"></div>
                        <div class="col-md-4 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-3.png" alt="" />
                            <b>ЛИЛИЯ ЛАЗАРЕВА</b>

                            <div class="binfo">Авторское право<br />
                                в музыкальной сфере<br />
                                Маркетинг и промоушн
                            </div>
                            <div class="hinfo">
                                Директор лейбла CTS Records,специалист в области авторского права и маркетинга
                            </div>
                        </div>
                        <div class="clearfix visible-md visible-lg hidden-sm hidden-xs"></div>
                        <div class="col-md-4  col-md-offset-2 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-5.png" alt="" />
                            <b>MISHUKOFF</b>

                            <div class="binfo"> мастерство ДиДжея<br />
                                Мастер класс Pioneer/Technics
                            </div>
                            <div class="hinfo">
                                DJ, продюсер - один из первых, начавших развивать клубную культуру в Украине

                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-6.png" alt="" />
                            <b>DJ EKSPERT</b>
                            <div class="binfo"> Мастерство ДиДжея<br />
                                Мастер класс по SCRETCH <br>
                                и ABLETON LIVE
                            </div>
                            <div class="hinfo">
                                DJ и продюсер проекта Awesomatic. Опыт работы на сцене в составе групп Green Grey и
                                Gorchitza
                            </div>
                        </div>
                        <div class="col-md-4  col-md-offset-4 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-4.png" alt="" />
                            <b>АЛЕКСАНДРА СЕМЕРГЕЙ</b>
                            <div class="binfo">
                                Теория музыки и гармония<br />
                                Вокальное мастерство
                            </div>
                            <div class="hinfo">
                                солистка хора Киево-Печерской Лавры, большой опыт преподавательской работы в т.ч. вокал
                                и теория музыки в КНУ им.Шевченко
                            </div>
                        </div>
                        <div class="clearfix visible-md visible-sm visible-lg hidden-xs"></div>


                        <div class="col-md-4 col-md-offset-2 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-7.png" alt="" />
                            <b>ВЛАДИМИР ЧЕРНЯ</b>
                            <div class="binfo"> Сценическая Звукорежиссура<br />
                                Звукорежиссура TV<br>практические занятия
                            </div>
                            <div class="hinfo">
                                звукорежиссер театра и TV, технический директор фестиваля DOCUDAYS
                            </div>
                        </div>

                        <div class="col-md-4  col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-8.png" alt="" />
                            <b> МИРОСЛАВ КУВАЛДИН</b>
                            <div class="binfo">Cонграйтинг<br />
                                Мастер класс
                            </div>
                            <div class="hinfo">
                                Музыкант, телеведущий, фронтмен группы The Вйо
                            </div>
                        </div>
                        <div class="clearfix visible-md visible-lg visible-sm hidden-xs"></div>
                        <div class="col-md-4 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-9.png" alt="" />
                            <b>YOSHI</b>
                            <div class="binfo"> Мастерство ДиДжея<br />
                                Мастер класс Pioneer/Technics
                            </div>
                            <div class="hinfo">
                                DJ, один из наиболее авторитетных DJ в украинской танцевальной культуре
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12 col-sm-6 teacher">
                            <img src="/assets/img/t-10.png" alt="" />
                            <b>NIELS VON GEYER</b>
                            <div class="binfo"> Мастерство ДиДжея<br />
                                Mастер класс на DENON DJ
                            </div>
                            <div class="hinfo">
                                DJ и продюсер, TV и радио ведущий. Резидент лейбла Ministry of Sound (Berlin)

                            </div>
                        </div>
                        <div class="clearfix  visible-sm "></div>
                        <div class="col-md-4 col-xs-12 col-sm-6  teacher">
                            <img src="/assets/img/t-12.png" alt="" />
                            <b>РОМАН РЕЗНИЧЕНКО</b>
                            <div class="binfo"> Аранжировка в LOGIC и STUDIUO ONE<br />
                                в стилях Drum-N-Bass, Dubstep, Hip-Hop
                            </div>
                            <div class="hinfo">
                                Владелец продакшн-студии. <br >Саунд-продюсер проектов Bulbajar, Monovakzin, Kalimakosh и WooYko. Опыт работы с мультимедиа на больших площадках.
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="text-center sh" id="about">О КУРСАХ</h2>
                <div class="text">
                    <div class="row">
                        <p class="pull-left text-paragraph">Курсы CTSchool рассчитаны как на пользователей ПК, которые
                            имеют только общее представление о создании музыки и студийной звукорежиссуре, так и на тех,
                            кто желает повысить уровень своей квалификации. Основное внимание в программе CTSchool
                            уделяется звукорежиссуре, а также созданию электронной музыки. В рамках обучения с Вами
                            поделятся своими практическими навыками опытные продюсеры, музыканты, состоявшиеся артисты,
                            звукорежиссеры и ди-джеи.</p>
                        <div class="course-img course-img2 pull-right">
                            <img src="/assets/img/school-9.jpg" class="img-responsive" />
                            <div class="img-overlay">Занятие проводит Sergio Mega</div>
                        </div>
                        <div class="clearfix hidden-md hidden-lg hidden-sm visible-xs"></div>
                        <div class="course-img course-img1 pull-left">
                            <img src="/assets/img/school-7.jpg" class="img-responsive" />
                            <div class="img-overlay">Мастер-класс проводит DJ Ekspert</div>
                        </div>
                        <div class="course-img course-img1 pull-right">
                            <img src="/assets/img/school-8.jpg" class="img-responsive" />
                            <div class="img-overlay">Консультацию проводит Наталья Белявина</div>
                        </div>
                        <div class="course-list">
                            <h5 style="padding-bottom: 15px;">Занятия проходят:</h5>
                            в студии CTS,<br />
                            в клубе CINEMA,<br />
                            в студии Государственной академии руководящих кадров культуры и искусств Украины,<br />
                            в магазине МУЗТОРГ.
                        </div>
                    </div>
                    <div class="row">
                        <p style="margin-bottom: 30px;">Выпускники школы получают сертификат об окончании CTSchool,
                            рекомендацию для поступления в Государственную академию руководящих кадров культуры и
                            искусства Украины на специальности: звукорежиссёр, звукорежиссёр-аранжировщик,
                            звукорежиссёр-диджей; скидку на покупку техники в магазине Музторг, Реал Мюзик и АРТ-Р.
                            Треки лучших выпускников будут изданы на CTS Records. Успешные студенты получат рекомендации
                            для дальнейшего устройства на работу в сфере звукорежиссуры.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4 course-img-block pull-left">
                            <div class="course-img course-img3">
                                <img src="/assets/img/school-10.jpg" class="img-responsive" />
                                <div class="img-overlay">Занятие по звукорежиссуре проводит Иван Шаповалов</div>
                            </div>
                            <div class="course-img course-img3">
                                <img src="/assets/img/school-12.jpg" class="img-responsive" />
                                <div class="img-overlay">Занятие по теории музыки проводит Александра Семергей</div>
                            </div>
                        </div>
                        <div class="col-md-4 course-center-text">
                            <p>* CTSchool работает непосредственно с производителями и поставщиками SOFT & HARDWARE.
                                Все программное обеспечение в вышеуказанном списке - ЛИЦЕНЗИОННОЕ.</p>
                            <p>** Только в CTSchool вы имеете возможность пройти курс обучения
                                работе с электронной танцевальной музыкой в PRO TOOLS HD 3 Accel System на MAC OS.
                                CTSchool тесно сотрудничает с компанией A&T Trade и МУЗ ТОРГ, проводит совместные акции,
                                семинары, мастер классы.</p>
                            <p>*** CTSchool набирает группы до 5 человек что позволяет улучшить качество обучения.</p>
                            <p>**** Цены указаны для групп 5 человек. Стоимость занятий в мини-группах (2-3 человека) зависит от количества человек в группе. Возможна разработка индивидуального курса. Одно занятие – 2 академических часа. </p>
                        </div>
                        <div class="col-md-4 course-img-block pull-right">
                            <div class="course-img course-img3">
                                <img src="/assets/img/school-11.jpg" class="img-responsive" />
                                <div class="img-overlay">Занятие по DJ-ингу в клубе Cinema проводит DJ Yoshi</div>
                            </div>
                            <div class="course-img course-img3">
                                <img src="/assets/img/school-13.jpg" class="img-responsive" />
                                <div class="img-overlay">Занятие по продакшн проводит Sergio Mega</div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="text-center sh" id="prices">СТОИМОСТЬ ОБУЧЕНИЯ</h2>
                <div class="service-images ">
                    @for($i = 1; $i <= 13; $i++)
                    <div class="col-md-3 col-sm-6 text-center  scale{{ $i }} ">
                        <a href="mailto:info@cts-label.com?body=Мое имя:%0AМой телефон:%0A&Subject=Обучение в CTSchool @if(!empty($subject[$i])) - {{ $subject[$i] }}@endif">
                            <img src="/assets/img/prices-{{ $i }}.png"
                                 class="service-image" @if(!empty($prices[$i])) alt="{{ $prices[$i] }}"@endif>
                        </a>
                    </div>
                    @endfor
                    <div class="clearfix"></div>
                </div>
                <h2 class="text-center sh" id="contacts">КОНТАКТЫ</h2>
                <div class="text-center col-xs-12">
                    <p>Вы можете связаться с нами оставив ваше сообщение <a href="http://vk.com/ctschool"
                                                                            target="_blank" class="yellow-link">на
                            стене CTSchool</a>, после чего мы в индивидуальном порядке пригласим вас пройти
                        собеседование.</p><br />

                    <p>ЗАПИСАТЬСЯ НА СОБЕСЕДОВАНИЕ ТАКЖЕ МОЖНО ПО ТЕЛЕФОНУ:</p><br />


                    <div style="font-size: 15px; max-width: 200px; display: inline-block; padding-bottom: 50px">


                        <p>+38 098 685 40 33</p>

                        <p>E-MAIL: <a href="mailto:info@cts-label.com" class="wl"
                                      style="text-transform: lowercase">info@cts-label.com</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection