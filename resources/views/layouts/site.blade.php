<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ahelos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ahelos">
    <meta name="keywords" content="Ahelos, IT">
    <meta name="author" content="Antonio Pauletich">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=m2drEWAMa3">
    <link rel="icon" type="image/png" href="/favicon-32x32.png?v=m2drEWAMa3" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png?v=m2drEWAMa3" sizes="16x16">
    <link rel="manifest" href="/manifest.json?v=m2drEWAMa3">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=m2drEWAMa3">
    <link rel="shortcut icon" href="/favicon.ico?v=m2drEWAMa3">
    <meta name="apple-mobile-web-app-title" content="Ahelos">
    <meta name="application-name" content="Ahelos">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png?v=m2drEWAMa3">
    <meta name="theme-color" content="#ffffff">
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/animate.css" type="text/css">
    <link rel="stylesheet" href="/assets/rs-plugin/css/settings.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/flexslider.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/rev-settings.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/parallax.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/supersized.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/plugin.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/color-orange.css" type="text/css">
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.css" type="text/css">
    @yield('styles')
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/jquery.isotope.min.js"></script>
    <script src="/assets/js/jquery.prettyPhoto.js"></script>
    <script src="/assets/js/easing.js"></script>
    <script src="/assets/js/jquery.ui.totop.js"></script>
    <script src="/assets/js/ender.js"></script>
    <script src="/assets/js/jquery.flexslider-min.js"></script>
    <script src="/assets/js/jquery.scrollto.js"></script>
    <script src="/assets/js/supersized.3.2.7.min.js"></script>
    <script src="/assets/js/designesia.js"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            $.supersized({
                {{-- Functionality --}}
                slide_interval: 2500,		{{-- Length between transitions --}}
                transition: 1, 			{{-- 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left --}}
                transition_speed: 700,		{{-- Speed of transition --}}
                {{-- Components --}}
                slide_links: 'blank',	{{-- Individual links for each slide (Options: false, 'num', 'name', 'blank')--}}
                slides: [			{{-- Slideshow Images --}}
                    {image: '/assets/images-slider/slider-1.jpg', url: '' },
                    { image: '/assets/images-slider/slider-2.jpg', url: '' },
                    { image: '/assets/images-slider/slider-3.jpg', url: '' },
                    { image: '/assets/images-slider/slider-4.jpg', url: '' }
                ]
            });
        });
    </script>
    <script type="text/javascript" src="/assets/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="/assets/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    @yield('scripts')
</head>

<body id="homepage" class="dark">
    <div class="loader"></div>
    <div id="wrapper">
        <header>
            <div class="container">
                <span id="menu-btn"></span>
                <div id="logo">
                    <div class="inner">
                        <a href="{{ url('/') }}"><img src="/assets/images/logo.png" alt="logo"></a>
                    </div>
                </div>
                <nav>
                    <ul id="mainmenu">
                        <li><a href="#home">Početna</a></li>
                        <li><a href="#contact">Kontakt</a></li>
                        <li><a href="{{ url('/login') }}">Narudžba tonera/tinti</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="fullwidthbanner-container">
            <div id="home">
                <ul>
                    <li data-transition="fade" data-slotamount="10" data-masterspeed="200">
                        <img src="/assets/images/blank.png" alt="blank">
                        <div class="tp-caption ultra-big-white customin customout start"
                             data-x="center"
                             data-y="center"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                             data-speed="400"
                             data-start="400"
                             data-easing="easeInOutExpo"
                             data-endspeed="300">
                            <span class="id-color">Ahelos</span>IT
                        </div>
                        <div class="tp-caption sfr teaser"
                             data-x="center"
                             data-y="336"
                             data-speed="400"
                             data-start="800"
                             data-easing="easeInOutExpo">
                            Dobrodošli u Ahelos. Najbolja IT rješenja.
                        </div>
                        <div class="tp-caption lfb text-center"
                             data-x="center"
                             data-y="390"
                             data-speed="400"
                             data-start="1200"
                             data-easing="easeInOutExpo">
                            <a href="{{ url('/login') }}" class="btn-slider solid">Narudžba tonera/tinti</a>
                        </div>
                    </li>
                    <li data-transition="fade" data-slotamount="10" data-masterspeed="200">
                        <img src="/assets/images/blank.png" alt="blank">
                        <div class="tp-caption ultra-big-white customin customout start"
                             data-x="center"
                             data-y="center"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                             data-speed="400"
                             data-start="400"
                             data-easing="easeInOutExpo"
                             data-endspeed="300">
                            Sve u <span class="id-color">jednom</span>
                        </div>
                        <div class="tp-caption sfr teaser"
                             data-x="center"
                             data-y="336"
                             data-speed="400"
                             data-start="800"
                             data-easing="easeInOutExpo">
                            Podrška - Prodaja - Održavanje
                        </div>
                        <div class="tp-caption lfb text-center"
                             data-x="center"
                             data-y="390"
                             data-speed="400"
                             data-start="1200"
                             data-easing="easeInOutExpo">
                            <a href="{{ url('/login') }}" class="btn-slider solid">Narudžba tonera/tinti</a>
                        </div>
                    </li>
                    <li data-transition="fade" data-slotamount="10" data-masterspeed="200">
                        <img src="/assets/images/blank.png" alt="blank">
                        <div class="tp-caption ultra-big-white customin customout start"
                             data-x="center"
                             data-y="center"
                             data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                             data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                             data-speed="400"
                             data-start="400"
                             data-easing="easeInOutExpo"
                             data-endspeed="300">
                            <span class="id-color">Top</span> Podrška
                        </div>
                        <div class="tp-caption sfr teaser"
                             data-x="center"
                             data-y="336"
                             data-speed="400"
                             data-start="800"
                             data-easing="easeInOutExpo">
                            Naš stručni tim na raspolaganju Vam je 24/7. Kontaktirajte nas odmah!
                        </div>
                        <div class="tp-caption lfb text-center"
                             data-x="center"
                             data-y="390"
                             data-speed="400"
                             data-start="1200"
                             data-easing="easeInOutExpo">
                            <a href="{{ url('/login') }}" class="btn-slider solid">Narudžba tonera/tinti</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        @yield('content')
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="social-icons">
                            <a href="{{ url('https://www.facebook.com/Informati%C4%8Dki-SOS-i-online-servis-ra%C4%8Dunala-Ahelos-doo-168798383146138') }}" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
                        </div>
                        <div class="spacer-single"></div>
                        Ahelos © {{ date('Y') }}
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
