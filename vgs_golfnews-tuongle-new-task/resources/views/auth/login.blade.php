<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <title>Đăng nhập quản trị viên</title>
    <link rel="stylesheet" type="text/css" href="{{asset('auth/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('auth/css/my-login.min.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper px-3 my-auto">
                @yield('content')
            </div>
        </div>
    </div>
</section>

<script src="{{asset('auth/js/jquery.min.js')}}"></script>
<script src="{{asset('auth/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('auth/js/my-login.min.js')}}"></script>
</body>
</html>