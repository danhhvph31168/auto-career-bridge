<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <!-- App favicon -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="shortcut icon" href="{{ asset('theme/admin/assets/logo/logo-2.png') }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('theme/admin/html/master/assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet"
        type=" text/css">

    <!--Swiper slider css-->
    <link href="{{ asset('theme/admin/html/master/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet"
        type="text/css">
    @yield('css')
    <!-- Layout config Js -->
    <script src="{{ asset('theme/admin/html/master/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('theme/admin/html/master/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('theme/admin/html/master/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('theme/admin/html/master/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{ asset('theme/admin/html/master/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('theme/admin/html/master/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('theme/admin/html/master/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet"
        type="text/css">
    <!-- Thêm SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Thêm Lord Icon Library -->
    <script src="https://cdn.lordicon.com/libs/ldo/ldo.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        sessionStorage.setItem('data-preloader', 'enable')
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="{{ asset('assets/index/table.css') }}" rel="stylesheet" type="text/css">
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }

        .left-column {
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Thêm bóng đổ nhẹ cho cột */
        }

        .right-column {
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .custom-margin {
            margin-left: 20px;
        }

        .box-image {
            border-radius: 3px;
            margin-right: 5px;
        }
    </style>
    @livewireStyles
</head>

<body>
    <div id="layout-wrapper">

        @include('admin.layouts.partials.header')



        @include('admin.layouts.partials.sidebar')

        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('content')
            <!-- End Page-content -->

            @include('admin.layouts.partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('theme/admin/html/master/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/admin/html/master/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('theme/admin/html/master/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('theme/admin/html/master/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('theme/admin/html/master/assets/js/app.js') }}"></script>
    <script src="{{ asset('theme/admin/html/master/assets/library/library.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>

    @yield('js')

    <!-- App js -->
    <script src="{{ asset('assets/index/sortAndPerPage.js') }}"></script>
</body>

</html>
