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
    <link rel="shortcut icon" type="image/png" href="img/favicon.png" /> </head>
    <link rel="icon" href="{{ url('/tabler/dist/img/document.png') }}" type="image/x-icon"/>

<body>
    <div class="page-wrapper toggled light-theme">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <!-- sidebar-brand  -->
                <div class="sidebar-item sidebar-brand font-weight-bold" style="background-color:#F9F9F9">{{ env('APP_NAME') }}</div>
                <!-- sidebar-header  -->
                <!-- sidebar-menu  -->
                <div class=" sidebar-item sidebar-menu" style="padding-top:40px">
                    <ul>
                        <li class="sidebar-dropdown">
                            <a href="#"> <i class="fa fa-shopping-cart"></i> <span class="menu-text">Getting Started</span> <span class="badge badge-pill badge-primary">4</span> </a>
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
                            <a href="#"> <i class="fa fa-book"></i> <span class="menu-text">Basic Usage</span> </a>
                        </li>
                        <li>
                            <a href="#"> <i class="fa fa-calendar"></i> <span class="menu-text">Customizing</span> </a>
                        </li>
                        <li>
                            <a href="#"> <i class="fa fa-folder"></i> <span class="menu-text">Troubleshooting</span> </a>
                        </li>
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
                    <div class="col-md-8">
                        <nav aria-label="breadcrumb" class="align-items-center">
                            <a href="index.html" class="breadcrumb-back" title="Back"></a>
                            <ol class="breadcrumb d-none d-lg-inline-flex m-0">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Layout 2</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-3 text-left">
                        <table>
                            <tr>
                                <td width="50px">Versi</td>
                                <td>
                                    <select class="form-control">
                                        <option value="1">1.0</option>
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
</body>

</html>