<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap Min CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/bootstrap.min.css') }}">
    <!-- Owl Theme Default Min CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/owl.theme.default.min.css') }}">
    <!-- Owl Carousel Min CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/owl.carousel.min.css') }}">
    <!-- scrollCue CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/scrollCue.css') }}">
    <!-- Boxicons Min CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/boxicons.min.css') }}">
    <!-- Magnific Popup Min CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/magnific-popup.min.css') }}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/flaticon.css') }}">
    <!-- Meanmenu Min CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/meanmenu.min.css') }}">
    <!-- Nice Select Min CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/nice-select.min.css') }}">
    <!-- Odometer Min CSS-->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/odometer.min.css') }}">
    <!-- Muli Fonts Min CSS-->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/muli-fonts.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('theme/client/assets/css/responsive.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('theme/admin/assets/logo/logo-2.png') }}">

    <!-- Jquery Min JS -->
    {{-- <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> --}}
    <script src="{{ asset('theme/client/assets/js/jquery.min.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <!-- Title -->
    <title>{{ ucfirst(request()->segment(1) ?? 'Trang chủ') }}</title>
    @livewireStyles
</head>

<body>
    <!-- Start Preloader Area -->
    <div class="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start Header Area -->
    @include('client.layouts.partials.header')
    <!-- End Header Area -->

    <!-- Content -->
    @yield('content')
    <!-- End Content -->

    <!-- Start Footer Area -->
    @include('client.layouts.partials.footer')
    <!-- End Footer Area -->

    <!-- Start Go Top Area -->
    <div class="go-top">
        <i class="bx bx-chevrons-up"></i>
        <i class="bx bx-chevrons-up"></i>
    </div>
    <!-- End Go Top Area -->


    <!-- Jquery Min JS -->
    {{-- <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> --}}
    {{-- <script src="{{ asset('theme/client/assets/js/jquery.min.js') }}"></script> --}}

    <!-- Bootstrap Min JS -->
    <script src="{{ asset('theme/client/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Meanmenu Min JS -->
    <script src="{{ asset('theme/client/assets/js/meanmenu.min.js') }}"></script>
    <!-- scrollCue JS -->
    <script src="{{ asset('theme/client/assets/js/scrollCue.min.js') }}"></script>
    <!-- Owl Carousel Min JS -->
    <script src="{{ asset('theme/client/assets/js/owl.carousel.min.js') }}"></script>
    <!-- Nice Select Min JS -->
    <script src="{{ asset('theme/client/assets/js/nice-select.min.js') }}"></script>
    <!-- Magnific Popup Min JS -->
    <script src="{{ asset('theme/client/assets/js/magnific-popup.min.js') }}"></script>
    <!-- Mixitup Min JS -->
    <script src="{{ asset('theme/client/assets/js/mixitup.min.js') }}"></script>
    <!-- Appear Min JS -->
    <script src="{{ asset('theme/client/assets/js/appear.min.js') }}"></script>
    <!-- Odometer Min JS -->
    <script src="{{ asset('theme/client/assets/js/odometer.min.js') }}"></script>
    <!-- Range Slider Min JS -->
    <script src="{{ asset('theme/client/assets/js/range-slider.min.js') }}"></script>
    <!-- Form Validator Min JS -->
    <script src="{{ asset('theme/client/assets/js/form-validator.min.js') }}"></script>
    <!-- Contact JS -->
    <script src="{{ asset('theme/client/assets/js/contact-form-script.js') }}"></script>
    <!-- Ajaxchimp Min JS -->
    <script src="{{ asset('theme/client/assets/js/ajaxchimp.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('theme/client/assets/js/custom.js') }}"></script>

    @livewireScripts
    @yield('script')
</body>

</html>
