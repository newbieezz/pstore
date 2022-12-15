<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>P-Store</title>
    <meta name="csrf-token" content="{{ csrf_token()}}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('front/first/css/bootstrap.min.css') }}" >
    <!-- Icon -->
    <link rel="stylesheet" href="{{ url('front/first/fonts/line-icons.css') }}">
    <!-- Owl carousel -->
    <link rel="stylesheet" href="{{ url('front/first/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('front/first/css/owl.theme.css') }}">
    
    <link rel="stylesheet" href="{{ url('front/first/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('front/first/css/nivo-lightbox.css') }}">
    <!-- Animate -->
    <link rel="stylesheet" href="{{ url('front/first/css/animate.css') }}">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ url('front/first/css/main.css') }}">
    <!-- Responsive Style -->
    <link rel="stylesheet" href="{{ url('front/first/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ url('front/first/css/listing.css') }}">
  </head>
 
  <body>
    
    @include('front.layout.header')
    @yield('content')
    @include('front.layout.footer')


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('front/first/js/jquery-min.js') }}"></script>
    <script src="{{ url('front/first/js/popper.min.js') }}"></script>
    <script src="{{ url('front/first/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('front/first/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('front/first/js/wow.js') }}"></script>
    <script src="{{ url('front/first/js/jquery.nav.js') }}"></script>
    <script src="{{ url('front/first/js/scrolling-nav.js') }}"></script>
    <script src="{{ url('front/first/js/jquery.easing.min.js') }}"></script>
    <script src="{{ url('front/first/js/jquery.counterup.min.js') }}"></script>      
    <script src="{{ url('front/first/js/waypoints.min.js') }}"></script>   
    <script src="{{ url('front/first/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ url('front/js/custom.js') }}"></script>
    @include('front.layout.scripts')
  </body>
</html>