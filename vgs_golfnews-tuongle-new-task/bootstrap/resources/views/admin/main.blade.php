@php 
    $user = session('userInfo');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.elements.head')
</head>
<body class="nav-sm">
<div class="container body">
    <div class="main_container">
        @if(in_array($user['level'], [1,2]))
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    @include('admin.elements.sidebar_title')
                    @include('admin.elements.sidebar_menu')
                </div>
            </div>
        @endif
        <div class="top_nav" @if(!in_array($user['level'], [1,2])) style="margin-left: 0" @endif>
            @include('admin.elements.top_nav')
        </div>
        <div class="right_col" role="main" @if(!in_array($user['level'], [1,2])) style="margin-left: 0" @endif>
            @yield('content')
        </div>
        @include('admin.elements.footer')
    </div>
</div>
@include('admin.elements.script')
</body>
</html>