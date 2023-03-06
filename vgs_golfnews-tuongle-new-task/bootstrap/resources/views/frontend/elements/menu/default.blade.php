@php
    $settingMain = \App\Helpers\Fetch::get(public_path('cache/setting-main.json'), true);
    $cart = !empty(session()->get('cart')) ? session()->get('cart') : [];
    $cartOffline = !empty(session()->get('cart_offline')) ? session()->get('cart_offline') : [];
    $menus = config('menu');
@endphp

@include('frontend.elements.gtm')

<header class="header-nav menu_style_home_one navbar-scrolltofixed stricky main-menu">
    <div class="container-fluid">
        <nav>

            <div class="menu-toggle">
                <img class="nav_logo_img img-fluid" src="{{ asset($settingMain['logo2']) }}" alt="logo.png">
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <a href="{{ route('index') }}" class="navbar_brand float-left dn-smd">
                <img class="logo1 img-fluid" src="{{ asset($settingMain['logo2']) }}" alt="logo.png">
                <img class="logo2 img-fluid" src="{{ asset($settingMain['logo2']) }}" alt="logo.png">
            </a>

            <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
                @foreach($menus as $menu)
                    <li>
                        <a href="{{ $menu['link'] }}" @if(isset($menu['target'])) target="{{ $menu['target'] }}" @endif><span class="title">{!! $menu['name'] !!}</span></a>
                        @if(isset($menu['child']) && count($menu['child']) > 0)
                            <ul>
                                @foreach($menu['child'] as $menu1)
                                    <li><a href="{{ $menu1['link'] }}" @if(isset($menu1['target'])) target="{{ $menu1['target'] }}" @endif>{{ $menu1['name'] }}</a>
                                        @if(isset($menu1['child']) && count($menu1['child']) > 0)
                                            <ul>
                                                @foreach($menu1['child'] as $menu2)
                                                    <li>
                                                        <a href="{{ $menu2['link'] }}" @if(isset($menu2['target'])) target="{{ $menu2['target'] }}" @endif>
                                                            {{ $menu2['name'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
            <ul class="sign_up_btn pull-right dn-smd mt20">
                <li class="list-inline-item list_s"><a href="https://training.zendvn.com" target="_blank" class="btn flaticon-user">
                        <span class="dn-lg"><span class="d-xll-none">Tài khoản học viên</span></span>
                    </a></li>
                <li class="list-inline-item list_s">
                    <div class="cart_btn">
                        <ul class="cart">
                            <li>
                                <a href="{{ route('courses/cart') }}" class="btn cart_btn flaticon-shopping-bag"><span id="cart-number" data-number="{{ count($cart) + count($cartOffline) }}">{{ count($cart) + count($cartOffline) }}</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="list-inline-item list_s">
                    <div class="search_overlay">
                        <a id="search-button-listener" class="mk-search-trigger mk-fullscreen-trigger" href="#">
                            <span id="search-button"><i class="flaticon-magnifying-glass"></i></span>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</header>

<!-- Modal Search Button Bacground Overlay -->
<div class="search_overlay dn-992">
    <div class="mk-fullscreen-search-overlay" id="mk-search-overlay">
        <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button"><i class="fa fa-times"></i></a>
        <div id="mk-fullscreen-search-wrapper">
            <form method="get" id="mk-fullscreen-searchform" action="{{ route('index/search') }}">
                <input type="text" name="keyword" pattern=".{3,}"  required title="Bạn phải nhập từ khóa hơn 3 ký tự" value="{{ request()->keyword }}" placeholder="Tìm khóa học bạn quan tâm" id="mk-fullscreen-search-input">
                <i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit"></i>
            </form>
        </div>
    </div>
</div>

<!-- Main Header Nav For Mobile -->
<div id="page" class="stylehome1 h0">
    <div class="mobile-menu">
        <div class="header stylehome1">
            <div class="main_logo_home2">
                <img class="nav_logo_img img-fluid float-left mt20" src="{{ asset($settingMain['logo2']) }}" alt="logo.png" onclick="window.location.href='{{ route('index') }}'">
            </div>
            <ul class="menu_bar_home2">
                <li class="list-inline-item">
                    <div class="search_overlay">
                        <a id="search-button-listener2" class="mk-search-trigger mk-fullscreen-trigger" href="#">
                            <div id="search-button2"><i class="flaticon-magnifying-glass"></i></div>
                        </a>
                        <div class="mk-fullscreen-search-overlay" id="mk-search-overlay2">
                            <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button2"><i class="fa fa-times"></i></a>
                            <div id="mk-fullscreen-search-wrapper2">
                                <form method="get" id="mk-fullscreen-searchform2" action="{{ route('index/search') }}">
                                    <input type="text" name="keyword" pattern=".{3,}"  required title="Bạn phải nhập từ khóa hơn 3 ký tự" value="{{ request()->keyword }}" placeholder="Tìm khóa học bạn quan tâm" id="mk-fullscreen-search-input2">
                                    <i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit"></i>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-inline-item"><a href="#menu"><span></span></a></li>
            </ul>
        </div>
    </div><!-- /.mobile-menu -->
    <nav id="menu" class="stylehome1">
        <ul>
            @foreach($menus as $menu)
                <li>
                    <a href="{{ $menu['link'] }}" @if(isset($menu['target'])) target="{{ $menu['target'] }}" @endif><span class="title">{!! $menu['name'] !!}</span></a>
                    @if(isset($menu['child']) && count($menu['child']) > 0)
                        <ul>
                            @foreach($menu['child'] as $menu1)
                                <li><a href="{{ $menu1['link'] }}" @if(isset($menu1['target'])) target="{{ $menu1['target'] }}" @endif>{{ $menu1['name'] }}</a>
                                    @if(isset($menu1['child']) && count($menu1['child']) > 0)
                                        <ul>
                                            @foreach($menu1['child'] as $menu2)
                                                <li>
                                                    <a href="{{ $menu2['link'] }}" @if(isset($menu2['target'])) target="{{ $menu2['target'] }}" @endif>
                                                        {{ $menu2['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
</div>