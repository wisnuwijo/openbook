<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    
    <!--====== Title ======-->
    <title>{{ env('APP_NAME') }} - Documentation tool</title>
    
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--====== Favicon Icon ======-->
    <link rel="icon" href="{{ url('/tabler/dist/img/document.png') }}" type="image/x-icon"/>
        
    <!--====== Magnific Popup CSS ======-->
    <link rel="stylesheet" href="{{ asset('smash/css/magnific-popup.css') }}">
        
    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="{{ asset('smash/css/slick.css') }}">
        
    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="{{ asset('smash/css/LineIcons.css') }}">
        
    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="{{ asset('smash/css/bootstrap.min.css') }}">
    
    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="{{ asset('smash/css/default.css') }}">
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="{{ asset('smash/css/style.css') }}">
    
</head>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
   
    <!--====== PRELOADER PART START ======-->

    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="services" class="features-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div class="section-title pb-10">
                        <h3 class="title">Welcome to {{ env('APP_NAME') }}</h3>
                        <p class="text">Documentation tool that allows you to write documentation with ease. Here are available documentation you can choose to start of your journey. Have a great time!</p>
                    </div> <!-- row -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                @yield('topic-list')
            </div> <!-- row -->
        </div> <!-- container -->
        <br>
        <br>
        <br>
        <br>
    </section>

    <!--====== FEATRES TWO PART ENDS ======-->
    <!--====== Jquery js ======-->
    <script src="{{ asset('smash/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('smash/js/vendor/modernizr-3.7.1.min.js') }}"></script>
    
    <!--====== Bootstrap js ======-->
    <script src="{{ asset('smash/js/popper.min.js') }}"></script>
    <script src="{{ asset('smash/js/bootstrap.min.js') }}"></script>
    
    <!--====== Slick js ======-->
    <script src="{{ asset('smash/js/slick.min.js') }}"></script>
    
    <!--====== Magnific Popup js ======-->
    <script src="{{ asset('smash/js/jquery.magnific-popup.min.js') }}"></script>
    
    <!--====== Ajax Contact js ======-->
    <script src="{{ asset('smash/js/ajax-contact.js') }}"></script>
    
    <!--====== Isotope js ======-->
    <script src="{{ asset('smash/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('smash/js/isotope.pkgd.min.js') }}"></script>
    
    <!--====== Scrolling Nav js ======-->
    <script src="{{ asset('smash/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('smash/js/scrolling-nav.js') }}"></script>
    
    <!--====== Main js ======-->
    <script src="{{ asset('smash/js/main.js') }}"></script>
    
</body>

</html>
