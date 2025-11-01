<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{$title}}</title>
    <!-- Vendor CSS Files -->
    <link href="{{asset('backend_assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!--  Main CSS File -->
    <link href="{{asset('backend_assets/css/style.css')}}" rel="stylesheet">
</head>
<body>
    @yield('content')
	
<script src="{{asset('backend_assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend_assets/jquery/jquery.js')}}"></script>

@yield('script');
</body>

</html>