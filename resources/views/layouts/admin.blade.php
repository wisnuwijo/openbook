<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-alpha.5
* @link https://github.com/tabler/tabler
* Copyright 2018-2019 The Tabler Authors
* Copyright 2018-2019 codecalm.net Paweł Kuna
* Licensed under MIT (https://tabler.io/license)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <meta name="msapplication-TileColor" content="#206bc4"/>
    <meta name="theme-color" content="#206bc4"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="MobileOptimized" content="320"/>
    <meta name="robots" content="noindex,nofollow,noarchive"/>
    <link rel="icon" href="{{ url('/tabler/dist/img/document.png') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ url('/tabler/dist/img/document.png') }}" type="image/x-icon"/>
    <!-- Libs CSS -->
    <link href="{{ url('/tabler/dist/libs/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/libs/selectize/dist/css/selectize.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/libs/fullcalendar/core/main.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/libs/fullcalendar/daygrid/main.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/libs/fullcalendar/timegrid/main.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/libs/fullcalendar/list/main.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/libs/flatpickr/dist/flatpickr.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/libs/nouislider/distribute/nouislider.min.css') }}" rel="stylesheet"/>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.8.0/mapbox-gl.css') }}" rel="stylesheet"/>
    <!-- Tabler Core -->
    <link href="{{ url('/tabler/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <!-- Tabler Plugins -->
    <link href="{{ url('/tabler/dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/css/tabler-buttons.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/tabler/dist/css/demo.min.css') }}" rel="stylesheet"/>
    <style>
      body {
      	display: none;
      }
    </style>
  </head>
  <body class="antialiased">
    <div class="page">
      <header class="navbar navbar-expand-md navbar-light">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a href="." class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3">
            Devdocs
          </a>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
                <span class="avatar" style=""></span>
                <div class="d-none d-xl-block pl-2">
                  <div>{{ Auth::user()->name }}</div>
                  <div class="mt-1 small text-muted">Contributor</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  Log out
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="navbar-expand-md">
        <div class="navbar collapse navbar-collapse navbar-light" id="navbar-menu">
          <div class="container-xl">
            <ul class="navbar-nav">
              {{ menu() }}
            </ul>
            <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last"></div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-xl d-flex flex-column justify-content-center">
          @yield('content')
        </div>
        <footer class="footer footer-transparent">
          <div class="container">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                Copyright © <?php echo date('Y'); ?>
                <a href="." class="link-secondary">Devdocs</a>.
                All rights reserved.
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- Libs JS -->
    <script src="{{ url('/tabler/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('/tabler/dist/libs/jquery/dist/jquery.slim.min.js') }}"></script>
    <!-- Tabler Core -->
    <script src="{{ url('/tabler/dist/js/tabler.min.js') }}"></script>
    <script>
      document.body.style.display = "block"
    </script>
  </body>
</html>