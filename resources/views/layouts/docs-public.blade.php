<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free bootstrap documentation template">
    <title>@yield('title')</title>
    <!-- using online links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- using local links -->
    <!-- <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css"> -->
    <link rel="stylesheet" href="{{ url('/docs/css/main.css') }}">
    <link rel="stylesheet" href="{{ url('/docs/css/sidebar-themes.css') }}">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png" /> 
    <link rel="icon" href="{{ url('/tabler/dist/img/document.png') }}" type="image/x-icon"/>
    @yield('head')
    <style>
        .header-line {
            width: 100%;
            height: 5px;
            position: fixed;
            top: 0px;
            z-index:1000;
            background-color: #17a2b8;
        }

        /* .sidebar-submenu > ul > li {
            margin-left: 30px;
            border-left: 1px solid #DAD7E0;
        } */

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a {
            margin-left: 30px;
            border-left: 1px solid #DAD7E0;
        }
    </style>
</head>
<body>
    <div class="header-line"></div>
    <div class="page-wrapper toggled light-theme">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <!-- sidebar-brand  -->
                <div class="sidebar-item sidebar-brand font-weight-bold" style="background-color:#F9F9F9;margin-top: 20px;margin-left: 13px;font-size:20pt;">
                    @yield('topic-name')
                </div>
                <!-- sidebar-header  -->
                <!-- sidebar-menu  -->
                <div class=" sidebar-item sidebar-menu" style="padding-top:40px">
                    <ul class="docs-sidebar">
                       {{--  <li class="sidebar-dropdown">
                            <a href="#"><span class="menu-text">Getting Started</span></a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li> <a href="#">Setup home page layout

                                        </a> </li>
                                    <li> <a href="#">How do i add knowledgebase post</a> </li>
                                    <li> <a href="#">How do i change header navigation style globally</a> </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#"> <span class="menu-text">Basic Usage</span> </a>
                        </li>
                        <li>
                            <a href="#"> <span class="menu-text">Customizing</span> </a>
                        </li>
                        <li>
                            <a href="#"> <span class="menu-text">Troubleshooting</span> </a>
                        </li>  --}}
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
        </nav>
        <!-- page-content  -->
        <main class="page-content">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid">
                <div class="row d-flex align-items-center p-3 border-bottom">
                    <div class="col-md-1">
                        <a id="toggle-sidebar" class="btn rounded-0 p-3" href="#"> <i class="fas fa-bars"></i> </a>
                    </div>
                    <div class="col-md-8"></div>
                    <div class="col-md-3 text-left">
                        <table>
                            <tr>
                                <td width="50px">Version</td>
                                <td>
                                    <select class="form-control version" style="border:none">
                                        @for($i = 0;$i < count($version_list); $i++)
                                            @if ($version_list[$i]->id == $latest_version)
                                                <option value="{{ $version_list[$i]->id }}" selected>{{ $version_list[$i]->name }}</option>
                                            @else
                                                <option value="{{ $version_list[$i]->id }}">{{ $version_list[$i]->name }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row p-lg-4">
                    <article class="main-content col-md-9 pr-lg-5">
                        @yield('content')
                    </article>
                    <aside class="col-md-3 d-none d-md-block border-left">
                        @yield('aside-right')
                    </aside>
                </div>
            </div>
        </main>
        <!-- page-conten -->
    </div>
    <!-- page-wrapper -->
    <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="{{ url('docs/js/prism.min.js') }}"></script>
    <!-- using local scripts -->
    <!-- <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script> -->
    <script src="{{ url('docs/js/main.js') }}"></script>
    @yield('js')
</body>
</html>