@php
    $userInfo = session('userInfo');
@endphp

<div class="nav_menu">
    <nav>
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="javascript:void()" class="user-profile dropdown-toggle" data-toggle="dropdown"
                   aria-expanded="false">
                    {{ $userInfo['email'] }}
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{route('auth.logout')}}"><i class="fa fa-sign-out pull-right"></i>Thoát</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>