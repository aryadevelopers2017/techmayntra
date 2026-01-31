<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TechMayntra Service PVT LTD</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src=" {{ asset('asset/css/jquery.min.js') }}"></script>
    <!-- Styles -->
    <!-- <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff"> -->
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">
    <!-- Styles -->
    <link href="{{ asset('asset/css/lib/data-table/buttons.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset/css/lib/calendar2/pignose.calendar.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('asset/css/lib/chartist/chartist.min.css') }}" rel="stylesheet" type="text/css"> -->
    <!-- <link href="{{ asset('asset/css/lib/font-awesome.min.css') }}" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('asset/plugins/summernote/summernote-bs4.min.css') }}">
    <link href="{{ asset('asset/css/lib/themify-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/lib/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" / />
    <link href="{{ asset('asset/css/lib/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css" / />
    <link href="{{ asset('asset/css/lib/weather-icons.css') }}" rel="stylesheet" type="text/css" / />
    <link href="{{ asset('asset/css/lib/menubar/sidebar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/lib/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/lib/helper.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('asset/css/lib/sweetalert/sweetalert.css') }}" />
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style>
        .form-inline
        {
            display: block!important;
        }

        .dataTables_length
        {
            margin-right: 70px !important;
        }
        .pace-done
        {
            padding-right: 0px !important;
        }

        /*.paginate_button
        {
            margin-right: 10px !important;
            margin-left: 10px !important;
        }*/
    </style>
</head>
<body>
    <div id="app">
        <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                    <ul>
                        <div class="logo">
                            <a href="{{ url('/home') }}">
                                <img style="height:50px;width:100px;" src="{{ asset('asset/images/logo_1646956465.png') }}" alt="" />
                            </a>
                        </div>
                        <li>
                            <a href="{{ url('/home') }}"><i class="ti-home"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ url('/lead_list') }}"><i class="ti-layers"></i>Lead Master</a>
                        </li>
                        <li>
                            <a href="{{ url('/customer') }}"><i class="ti-user"></i>Client Master</a>
                        </li>
                        <!-- <li>
                            <a href="{{ url('/company_module') }}"><i class="ti-notepad"></i>Company Module</a>
                        </li> -->
                        <!-- <li>
                            <a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Company Module <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{ url('/company_module') }}"><i class="ti-notepad"></i>Company</a></li>
                                <li><a href="{{ url('/company_address_list') }}"><i class="ti-notepad"></i>Company Address</a></li>
                            </ul>
                        </li> -->
                        <!-- <li>
                            <a href="{{ url('/client_list') }}"><i class="ti-user"></i>Client Master</a>
                        </li> -->

                        <li>
                            <a href="{{ url('/item') }}"><i class="ti-layers"></i>Item Master</a>
                        </li>
                        <li>
                            <a href="{{ url('/quotation/0') }}"><i class="ti-comment-alt"></i>Quotation</a>
                        </li>
                        <li>
                            <a href="{{ url('/proforma_invoice') }}"><i class="ti-comment-alt"></i> Invoice</a>
                        </li>
                        <li>
                            <a href="{{ url('/invoice_list/0') }}"><i class="ti-comment-alt"></i>Invoice</a>
                        </li>
                        @php
                            $sub_admin=Auth::user()->sub_admin;
                            if($sub_admin==0)
                            {
                                @endphp
                                <li>
                                    <a href="{{ url('/staff_list/') }}"><i class="ti-comment-alt"></i>User</a>
                                </li>
                                @php
                            }
                        @endphp
                        <li>
                            <a href="{{ url('/project_list') }}"><i class="ti-comment-alt"></i>Project</a>
                        </li>
                        <li>
                            <a href="{{ url('/purchase_order_list') }}"><i class="ti-comment-alt"></i>Vendor Receipt</a>
                        </li>
                        <li>
                            <a href="{{ url('/vendor_list') }}"><i class="ti-comment-alt"></i>Vendor</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="float-left">
                            <div class="hamburger sidebar-toggle">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        </div>
                        <div class="float-right">
                            <div class="dropdown dib">
                                <div class="header-icon" data-toggle="dropdown">
                                    <span class="user-avatar">{{ Auth::user()->name }}
                                        <i class="ti-angle-down f-s-10"></i>
                                    </span>
                                    <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-content-body">
                                            <ul>
                                                <!-- <li>
                                                    <a href="#">
                                                        <i class="ti-user"></i>
                                                        <span>Profile</span>
                                                    </a>
                                                </li> -->
                                                <li>
                                                    <a href="{{ url('/company_module') }}" onClick="redirecturl_fun('/company_module');" target="_blank">
                                                        <i class="ti-notepad"></i>
                                                        Company Master
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/user_add') }}" onClick="redirecturl_fun('/staff_add');" target="_blank">
                                                        <i class="ti-user"></i>
                                                        Add Users
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/changepassword') }}" onClick="redirecturl_fun('/changepassword');" target="_blank">
                                                        <i class="ti-user"></i>
                                                        Change Password
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();"><i class="ti-power-off"></i> {{ __('Logout') }} </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
        @include('layouts.Admin.footer')
    </div>
</body>
</html>
