@php
    $settingSeo = \App\Helpers\Fetch::get(public_path('cache/setting-seo.json'), true);
@endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(in_array(request()->route()->getName(), ['blog/detail']))
        <title>@yield('title')</title>
        <meta property="og:title" content="@yield('title')">
        <meta name="keywords" content="@yield('keyword')">
        <meta name="description" content="@yield('description')">
        <meta property="og:description" content="@yield('description')">
        <meta property="twitter:description" content="@yield('description')">
    @else
        <title>{{$settingSeo['meta_title']}} @yield('title')</title>
        <meta property="og:title" content="{{$settingSeo['meta_title']}}  @yield('title')">
        <meta name="keywords" content="{{$settingSeo['meta_keyword']}}">
        <meta name="description" content="@yield('description'){{$settingSeo['meta_description']}}">
        <meta property="og:description" content="@yield('description'){{$settingSeo['meta_description']}}">
        <meta property="twitter:description" content="@yield('description'){{$settingSeo['meta_description']}}">
    @endif

    @if(in_array(request()->route()->getName(), ['blog/detail']))
        <meta property="og:image" content="@yield('thumbnail')">
        <meta property="twitter:image" content="@yield('thumbnail')">
    @else
        <meta property="og:image" content="{{ asset('frontend/assets/images/thumb.png') }}">
        <meta property="twitter:image" content="{{ asset('frontend/assets/images/thumb.png') }}">
    @endif

    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">

    <!-- ================================================================
        ***Favicon***
    ================================================================= -->
    <link href="{{ asset('frontend/assets/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon"
          type="image/x-icon"/>
    <link href="{{ asset('frontend/assets/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon"/>

    <!-- ================================================================
        ***CSS Files***
    ================================================================= -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/combine-all-assets.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/myStyle.css?v='.time())}}">

</head>