<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/admin/img/favicon.ico" type="image/ico"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {!! $controller !!} - {!! $action !!}</title>

    <link href="{{ asset('backend/asset/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/asset/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/asset/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/asset/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/asset/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/asset/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/asset/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/asset/nestable2/jquery.nestable.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/asset/tagify/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/asset/switchery/switchery.min.css') }}">
    <link href="{{ asset('backend/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/myStyle.css?v='.time()) }}" rel="stylesheet">
    @livewireStyles
    <script src="{{ asset('backend/js/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/asset/dropzone/dropzone.min.js') }}"></script>

</head>