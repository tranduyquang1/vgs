@php
    $settingMain = \App\Helpers\Fetch::get(public_path('cache/setting-main.json'), true);
    $cart = !empty(session()->get('cart')) ? session()->get('cart') : [];
    $cartOffline = !empty(session()->get('cart_offline')) ? session()->get('cart_offline') : [];
    $menus = config('menu');
    krsort($menus);
@endphp

<header class="header-nav menu_style_home_five navbar-scrolltofixed stricky main-menu">
    <div class="container-fluid">
        <nav>
            <!-- Menu Toggle btn-->
            <div class="menu-toggle">
                <img class="nav_logo_img img-fluid" src="{{ asset($settingMain['logo1']) }}" alt="logo.png">
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <a href="{{ route('index') }}" class="navbar_brand float-left dn-smd">
                <img class="logo1 img-fluid" src="{{ asset($settingMain['logo1']) }}" alt="logo.png">
            </a>

            <!-- Search box -->
            <div class="ht_left_widget home5 float-custom">
                <ul>
                    <li class="list-inline-item show-1920">
                        <div class="ht_search_widget">
                            <div class="header_search_widget">
                                <form class="form-inline mailchimp_form" action="{{ route('index/search') }}" method="GET">
                                    <input type="text" name="keyword" pattern=".{3,}"  required title="Bạn phải nhập từ khóa hơn 3 ký tự" class="form-control mb-2 mr-sm-2"
                                           id="inlineFormInputMail2" placeholder="Tìm khóa học bạn quan tâm">
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <span class="flaticon-magnifying-glass"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item list_s hidden-1920 m-custom">
                        <div class="search_overlay home5">
                            <a id="search-button-listener" class="mk-search-trigger mk-fullscreen-trigger" href="#">
                                <span id="search-button"><i class="flaticon-magnifying-glass"></i></span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Cart block -->
            <ul class="home5_shop_reg_widget float-right mb0 mt20">
                <li class="list-inline-item">
                    <div class="cart_btn home5">
                        <ul class="cart">
                            <li>
                                <a href="{{ route('courses/cart') }}" class="btn cart_btn flaticon-shopping-bag"><span><sup id="cart-number" data-number="{{ count($cart) + count($cartOffline) }}">{{ count($cart) + count($cartOffline) }}</sup></span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="list-inline-item">
                    <a href="https://training.zendvn.com" target="_blank" class="btn btn-md">
                        <i class="flaticon-user pr5"></i>
                        <span class="dn-lg">Tài khoản <span class="d-xll-none">học viên</span></span>
                    </a>
                </li>
            </ul>

            <!-- List menu -->
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
        </nav>
    </div>
</header>

<!-- Search modal -->
<div class="search_overlay dn-992">
    <div class="mk-fullscreen-search-overlay" id="mk-search-overlay">
        <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button"><i class="fa fa-times"></i></a>
        <div id="mk-fullscreen-search-wrapper">
            <form method="get" id="mk-fullscreen-searchform" action="{{ route('index/search') }}">
                <input type="text" name="keyword" value="{{ request()->keyword }}" pattern=".{3,}"  required title="Bạn phải nhập từ khóa hơn 3 ký tự" placeholder="Tìm khóa học bạn quan tâm" id="mk-fullscreen-search-input">
                <i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit"></i>
            </form>
        </div>
    </div>
</div>

<!-- Main Header Nav For Mobile -->
<div id="page" class="stylehome1 h0">
    <div class="mobile-menu">

        <div class="header stylehome1 home5">
            <div class="main_logo_home2">
                <img class="nav_logo_img img-fluid float-left mt20" src="{{ asset($settingMain['logo1']) }}"
                     alt="logo.png">
            </div>
            <ul class="menu_bar_home2 home5">
                <li class="list-inline-item">
                    <div class="search_overlay">
                        <a id="search-button-listener2" class="mk-search-trigger mk-fullscreen-trigger" href="#">
                            <div id="search-button2">
                                <i class="flaticon-magnifying-glass color-dark"></i>
                            </div>
                        </a>
                        <div class="mk-fullscreen-search-overlay" id="mk-search-overlay2">
                            <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button2">
                                <i class="fa fa-times"></i>
                            </a>
                            <div id="mk-fullscreen-search-wrapper2">
                                <form id="mk-fullscreen-searchform2" action="{{ route('index/search') }}" method="GET">
                                    <input type="text" name="keyword" pattern=".{3,}"  required title="Bạn phải nhập từ khóa hơn 3 ký tự" placeholder="Tìm khóa học bạn quan tâm"
                                           id="mk-fullscreen-search-input2">
                                    <i class="flaticon-magnifying-glass fullscreen-search-icon">
                                        <input value="" type="submit">
                                    </i>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-inline-item"><a href="#menu"><span></span></a></li>
            </ul>
        </div>
    </div>

    <!-- List menu -->
    <nav id="menu" class="stylehome1">

        <ul>
            @foreach(config('menu') as $menu)
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