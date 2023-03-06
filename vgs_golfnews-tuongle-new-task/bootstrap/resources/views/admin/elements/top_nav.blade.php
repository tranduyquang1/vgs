@php
    $userInfo = Session::get('userInfo');
@endphp

<div class="nav_menu">
    <nav>
        <div class="nav toggle">
            <a @if(in_array($userInfo['level'], [1, 2])) id="menu_toggle" @else href="{{ route('files') }}" @endif ><i class="fa fa-bars"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/user/'.$userInfo['avatar']) }}" alt="" class="d-none">{{$userInfo['username']}}
                        <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{route('user/change-password')}}"><i class="fa fa-config pull-right"></i>Đổi mật khẩu</a></li>
                    <li><a href="{{route('auth/logout')}}"><i class="fa fa-sign-out pull-right"></i>Thoát</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>