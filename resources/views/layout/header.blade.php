<header>
    <div class = "container">
        <div class = "col-xs-12 logo-container">
            <div class = "row">
                <a href = "/"><img src = "/assets/img/logo.png" class = "logo" alt = "Creative technology Studio"/></a>
            </div>
        </div>
    </div>
    <div class = "black" id = "main_nav">
        <div class = "container">
            <div class = "col-xs-12">
                <div class = "row">
                    <nav class="navbar navbar-default" id = "nav">
                        <div class="container-fluid">
                            <div class = "navbar-brand">
                                <a href = "/"><img src = "/assets/img/logo-small.png" alt = "Creative technology Studio" class = "sticky-logo"/></a>
                            </div>
                            <div class="navbar-header navbar-left">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse navbar-left" id="main-menu-collapse">
                                <ul class="nav navbar-nav">

                                    <li {% if section == 'home' %}class = "active"{% endif %}><a href="/">HOME</a></li>
                                    <li {% if section == 'about' %}class = "active"{% endif %} id = "about-menu"><a href="/about.html">{{ languages[language|trim].about }}</a></li>
                                    <li {% if section == 'artists' %}class = "active"{% endif %}><a href="/artists/">{{ languages[language|trim].artists}}</a></li>
                                    <li {% if section == 'studio' %}class = "active"{% endif %}><a href="/studio.html">{{ languages[language|trim].studio}}</a></li>
                                    <li {% if section == 'ctschool' %}class = "active"{% endif %}><a href="/ctschool.html">{{ languages[language|trim].ctschool}}</a></li>
                                    <li {% if section == 'reviews' %}class = "active"{% endif %}><a href="/reviews/">{{ languages[language|trim].reviews}}</a></li>
                                    <li id = "demo-menu"><a href="/about.html#demo">{{ languages[language|trim].demo}}</a></li>
                                    <li id = "contacts-menu"><a href="/about.html#contacts">{{ languages[language|trim].contact }}</a></li>
                                </ul>
                            </div>

                            <div class = "navbar-right  search" >
                                <div class = "row" >
                                    <form class="navbar-form" role="search" action = "/search/" enctype="application/x-www-form-urlencoded">
                                        <div class="form-group">
                                            <input type="text" id = "search" class="form-control" placeholder="Search here ..." name = "q" {% if q is not empty %} value = "{{ q|escape }}"{% endif %}/>
                                            <button type="submit" class="search-btn"></button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
