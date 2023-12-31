<!DOCTYPE html>
<html lang="fa">
<head>
    <meta name="_token" content="{{ csrf_token() }}"/>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> خانه بازی شاد</title>

    <link href="{{asset('/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">

    <!-- begin::global styles -->
    <link rel="stylesheet" href="/assets/vendors/bundle.css" type="text/css">
    <!-- end::global styles -->

    <link rel="stylesheet" href="/assets/vendors/swiper/swiper.min.css">

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="/assets/css/app.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/custom.css" type="text/css">
    <!-- end::custom styles -->


    <!-- begin::theme color -->
    <meta name="theme-color" content="#3f51b5"/>
    <!-- end::theme color -->
    @yield('css')

</head>
<body>

<!-- begin::page loader-->
<div class="page-loader text-info">
    <div class="spinner-border"></div>
    <span>در حال بارگذاری ...</span>
</div>
<!-- end::page loader -->

<!-- begin::sidebar -->
<div class="sidebar">
    <ul class="nav nav-pills nav-justified m-b-30" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a  class="nav-link" id="messages-tab" data-toggle="pill" href="/mails/inbox" role="tab"
               aria-controls="messages" aria-selected="true">
                <i class="fa fa-envelope"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="notifications-tab" data-toggle="pill" href="#notifications" role="tab"
               aria-controls="notifications" aria-selected="false">
                <i class="fa fa-bell"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="settings-tab" data-toggle="pill" href="#settings" role="tab"
               aria-controls="settings" aria-selected="false">
                <i class="ti-settings"></i>
            </a>
        </li>
    </ul>
</div>
<!-- end::sidebar -->

<!-- begin::side menu -->
<div class="side-menu">
    <div class="side-menu-body">
        <ul>
            <li><a class="navbar-brand" href="/customer"><i class="icon ti-home"></i> <span>میز کار (داشبورد)</span></a>
            </li>

            <li><a href="/customer/workshops"><i class="fa fa-magic"></i> &nbsp &nbsp <span>کارگاه ها</span>
                </a>


            </li>
            <li><a href="/customer/planes"><i class="fa fa-play"></i> &nbsp &nbsp <span>پلن ها</span>
                </a>
            </li>

            <li><a href="/customer/rollcalls"><i class="fa fa-calendar"></i> &nbsp &nbsp <span>ورود و خروج</span>
                </a>

            </li>
            <li><a href="/customer/absents"><i class="fa fa-calendar-times-o"></i> &nbsp &nbsp <span>غیبت ها</span>
                </a>
            </li>

            <li><a href="/customer/invoices"><i class="fa fa-dollar"></i> &nbsp &nbsp <span> فاکتور ها</span>
                </a>
            </li>
            <li><a href="/customer/user_reports"><i class="fa fa-file"></i> &nbsp &nbsp <span> گزارش ها</span>
                </a>
            </li>
            <li><a href="/customer/reserve"><i class="fa fa-file"></i> &nbsp &nbsp <span> درخواست رزرو</span>
                </a>
            </li>
            <li><a href="/customer/card"><i class="fa fa-file"></i> &nbsp &nbsp <span> کارت عضویت</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- end::side menu -->

<!-- begin::navbar -->
<nav class="navbar">
    <div class="container-fluid">

        <div class="header-logo">
            <a href="/">
                <img src="https://rashasoftware.ir/playhouse/wp-content/uploads/2019/11/fox-color-1.svg" alt="...">
                <span class="logo-text d-none d-lg-block">خانه بازی شاد</span>
            </a>
        </div>
        <div class="header-body">
            <ul class="navbar-nav">
                <li class="nav-item dropdown d-none d-lg-block">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <i class="fa fa-th-large"></i>
                    </a>
{{--                    <div class="dropdown-menu dropdown-menu-nav-grid">--}}
{{--                        <div class="dropdown-menu-title">منوی سریع</div>--}}
{{--                        <div class="dropdown-menu-body">--}}
{{--                            <div class="nav-grid">--}}
{{--                                <div class="nav-grid-row">--}}
{{--                                    <a href="/rollcall" class="nav-grid-item">--}}
{{--                                        <i class="fa fa-calendar-times-o"></i>--}}
{{--                                        <span>ورود و خروج</span>--}}
{{--                                    </a>--}}
{{--                                    <a href="#" class="nav-grid-item">--}}
{{--                                        <i class="fa fa-envelope-o"></i>--}}
{{--                                        <span>اسکنر</span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                                <div class="nav-grid-row">--}}
{{--                                    <a href="/invoice/create" class="nav-grid-item">--}}
{{--                                        <i class="fa fa-dollar"></i>--}}
{{--                                        <span>ثبت فاکتور</span>--}}
{{--                                    </a>--}}
{{--                                    <a href="/products" class="nav-grid-item">--}}
{{--                                        <i class="fa fa-cutlery"></i>--}}
{{--                                        <span>بوفه</span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </li>
            </ul>
            <form class="search">
                <div class="input-group">
                    <input type="text" class="form-control" aria-label="Recipient's username"
                           aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn" type="button" id="button-addon2">
                            <i class="fa fa-star"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="d-lg-none d-sm-block nav-link search-panel-open">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/mails/inbox" class="nav-link nav-link-notify " data-sidebar-target="">
                        <i class="fa fa-envelope"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-notify sidebar-open" data-sidebar-target="#notifications">
                        <i class="fa fa-bell"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown">
                        <figure class="avatar avatar-sm avatar-state-success">
                            <img class="rounded-circle" src="/login_image/happy-children-go-to-school-free-vector.jpg"
                                 alt="...">
                        </figure>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="/customer" class="dropdown-item">پروفایل</a>
                        <a href="#" data-sidebar-target="#settings" class="sidebar-open dropdown-item">تنظیمات</a>
                        <div class="dropdown-divider"></div>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="text-danger dropdown-item">خروج</button>
                        </form>
                    </div>
                </li>
                <li class="nav-item d-lg-none d-sm-block">
                    <a href="#" class="nav-link side-menu-open">
                        <i class="ti-menu"></i>
                    </a>

                </li>
            </ul>
        </div>


    </div>
</nav>
<!-- end::navbar -->

<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">

        <!-- begin::page header -->
    @yield('header')

    <!-- end::page header -->

        @yield('content')


    </div>

</main>
<!-- end::main content -->

<!-- begin::global scripts -->


<script src="/assets/vendors/bundle.js"></script>
<!-- end::global scripts -->

<!-- begin::custom scripts -->
<script src="/assets/js/custom.js"></script>
<script src="/assets/js/app.js"></script>
<!-- begin::favicon -->
<link rel="shortcut icon" href="/assets/media/image/favicon.png">
<!-- end::favicon -->
<!-- end::custom scripts -->


@yield('script')

</body>
</html>

