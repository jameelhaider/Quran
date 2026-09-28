<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('newdash/assets/images/favicon.png') }}">
    <title>@yield('admin_title')</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="{{ asset('newdash/assets/extra-libs/c3/c3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('newdash/assets/libs/chartist/dist/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('newdash/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}">
    <link rel="stylesheet" href="{{ asset('newdash/dist/css/style.min.css') }}">
    <link href="{{ asset('newdash/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('newdash/assets/extra-libs/prism/prism.css') }}">

    {!! ToastMagic::styles() !!}

</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <div class="navbar-brand">
                        <a href="/admin">
                            <b class="logo-icon">
                                <img src="{{ asset('newdash/assets/images/logo-icon.png') }}" alt="homepage"
                                    class="dark-logo" />
                                <img src="{{ asset('newdash/assets/images/logo-icon.png') }}" alt="homepage"
                                    class="light-logo" />
                            </b>
                            <span class="logo-text">
                                <img src="{{ asset('newdash/assets/images/logo-text.png') }}" alt="homepage"
                                    class="dark-logo" />
                                <img src="{{ asset('newdash/assets/images/logo-light-text.png') }}" class="light-logo"
                                    alt="homepage" />
                            </span>
                        </a>
                    </div>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                    </ul>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('newdash/assets/images/users/profile-pic.jpg') }}" alt="user"
                                    class="rounded-circle" width="40">
                                <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                        class="text-dark">{{ auth()->user()->name }}</span> <i
                                        data-feather="chevron-down" class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/admin/logout') }}"><i data-feather="power"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Logout</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/admin"
                                aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="list-divider"></li>
                        {{-- <li class="nav-small-cap"><span class="hide-menu">Products</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('admin.product.index') }}"
                                aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                    class="hide-menu">Products
                                </span></a>
                        </li> --}}

                        {{-- <li class="list-divider"></li> --}}
                        <li class="nav-small-cap"><span class="hide-menu">Products</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                                    class="hide-menu">Products </span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item"><a href="{{ url('admin/products') }}"
                                        class="sidebar-link"><span class="hide-menu"> Inventory
                                        </span></a>
                                </li>
                                <li class="sidebar-item"><a href="{{ route('admin.product.create') }}"
                                        class="sidebar-link"><span class="hide-menu"> Add Product
                                        </span></a>
                                </li>
                            </ul>
                        </li>




                        <li class="list-divider"></li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('admin/logout') }}"
                                aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span
                                    class="hide-menu">Logout</span></a></li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-wrapper">
            @yield('content')
            <footer class="footer text-center text-muted">
                © Steven Steel Gears
                <script>
                    document.write(new Date().getFullYear());
                </script>, Designed and Developed by <a href="https://wa.link/ehud9w"
                    target="_BLANK">JH DEVELOPERS</a>.
            </footer>
        </div>
    </div>


    {!! ToastMagic::scripts() !!}
    <script src="{{ asset('newdash/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('newdash/dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('newdash/dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('newdash/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('newdash/dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('newdash/dist/js/pages/dashboards/dashboard1.min.js') }}"></script>
    <script src="{{ asset('newdash/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('newdash/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('newdash/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/prism/prism.js') }}"></script>
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init-menusidebar.js') }}"></script>
</body>

</html>
