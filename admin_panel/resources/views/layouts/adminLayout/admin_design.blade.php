<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matrix Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('css/backend_css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/backend_css/bootstrap-responsive.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/backend_css/fullcalendar.css')}}" />
    <link rel="stylesheet" href="{{asset('css/backend_css/matrix-style.css')}}" />
    <link rel="stylesheet" href="{{asset('css/backend_css/matrix-media.css')}}" />
    <link rel="stylesheet" href="{{asset('css/backend_css/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('css/backend_css/uniform.css')}}" />
    <link href="{{asset('font/backend_font/css/font-awesome.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/backend_css/jquery.gritter.css')}}" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
    
    <!-- css table -->
    <link rel="stylesheet" href="{{asset('css/backend_css/select2.css')}}" />
</head>
<body>
    <!-- include header -->
    @include('layouts.adminLayout.admin_header')
    
    <!-- include sidebar -->
    @include('layouts.adminLayout.admin_sidebar')
   
    <!-- include dashboard -->
    @yield('content')
    
    <!-- include footer -->
    @include('layouts.adminLayout.admin_footer')

    <script src="{{asset('js/backend_js/jquery.min.js')}}"></script> 
    <script src="{{asset('js/backend_js/jquery.ui.custom.js')}}"></script> 
    <script src="{{asset('js/backend_js/bootstrap.min.js')}}"></script> 
    <script src="{{asset('js/backend_js/jquery.uniform.js')}}"></script> 
    <script src="{{asset('js/backend_js/select2.min.js')}}"></script> 
    <script src="{{asset('js/backend_js/jquery.validate.js')}}"></script> 
    <script src="{{asset('js/backend_js/matrix.js')}}"></script> 
    <script src="{{asset('js/backend_js/matrix.form_validation.js')}}"></script>
    <!-- js table-->
    <script src="{{asset('js/backend_js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/backend_js/matrix.tables.js')}}"></script>
    <script src="{{asset('js/backend_js/matrix.popover.js')}}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</body>
</html>
