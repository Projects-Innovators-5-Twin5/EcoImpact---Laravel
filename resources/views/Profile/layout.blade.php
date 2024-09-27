<!DOCTYPE html>
<html lang="en">

<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Primary Meta Tags -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="Volt - Free Bootstrap 5 Dashboard">
<meta name="author" content="Themesberg">
<meta name="description" content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
<meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, themesberg, themesberg dashboard, themesberg admin dashboard" />
<link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-premium-bootstrap-5-dashboard">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://demo.themesberg.com/volt-pro">
<meta property="og:title" content="Volt - Free Bootstrap 5 Dashboard">
<meta property="og:description" content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
<meta property="og:image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/volt-pro-bootstrap-5-dashboard/volt-pro-preview.jpg">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://demo.themesberg.com/volt-pro">
<meta property="twitter:title" content="Volt - Free Bootstrap 5 Dashboard">
<meta property="twitter:description" content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
<meta property="twitter:image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/volt-pro-bootstrap-5-dashboard/volt-pro-preview.jpg">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="120x120" href="../../assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="../../assets/img/favicon/site.webmanifest">
<link rel="mask-icon" href="../../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<!-- Sweet Alert -->
@vite('public/documentation/assets/vendor/sweetalert2/dist/sweetalert2.min.css')

<!-- Notyf -->
@vite('public/documentation/assets/vendor/notyf/notyf.min.css')

<!-- Volt CSS -->
@vite('resources/css/volt.css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">


<!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

</head>

<body>


      <!-- Include the navbar -->
      @include('layouts.landingtopbar')

      <div class="content-profile">
        <div class="row">
            @include('layouts.profilenav')
            @yield('content')
        </div>
      </div>

     <!-- Include the footer -->
      @include('layouts.landingfooter')



<!-- Core -->
@vite('public/documentation/assets/vendor/@popperjs/core/dist/umd/popper.min.js')
@vite('public/documentation/assets/vendor/bootstrap/dist/js/bootstrap.min.js')

<!-- Vendor JS -->
@vite('public/documentation/assets/vendor/onscreen/dist/on-screen.umd.min.js')

<!-- Slider -->
@vite('public/documentation/assets/vendor/nouislider/distribute/nouislider.min.js')

<!-- Smooth scroll -->
@vite('public/documentation/assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js')

<!-- Charts -->
@vite('public/documentation/assets/vendor/chartist/dist/chartist.min.js')
@vite('public/documentation/assets/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js')

<!-- Datepicker -->
@vite('public/documentation/assets/vendor/vanillajs-datepicker/dist/js/datepicker.min.js')

<!-- Sweet Alerts 2 -->
@vite('public/documentation/assets/vendor/sweetalert2/dist/sweetalert2.all.min.js')

<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

<!-- Vanilla JS Datepicker (Duplicate, remove the duplicate if necessary) -->
@vite('public/documentation/assets/vendor/vanillajs-datepicker/dist/js/datepicker.min.js')

<!-- Notyf -->
@vite('public/documentation/assets/vendor/notyf/notyf.min.js')

<!-- Simplebar -->
@vite('public/documentation/assets/vendor/simplebar/dist/simplebar.min.js')

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Volt JS -->
@vite('resources/assets/js/volt.js')


    
</body>

</html>
