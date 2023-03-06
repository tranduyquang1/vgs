@php
    $menus = \App\Models\Menu::withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();
    $settingMain = \App\Helpers\Fetch::get(public_path('cache/setting-main.json'), true);

    if ($agent->isMobile()) {
        $bannerModel = new \App\Models\Banner();
        $bannerTop = $bannerModel->select('id', 'name', 'thumb', 'last_viewed_at', 'position', 'url')->active()->topBanner()->mobile();

        switch ($controllerName) {
            case 'index':
                $bannerTop = $bannerTop->home();
                break;
            case 'category':
                $bannerTop = $bannerTop->category();
                break;
            case 'post':
                $bannerTop = $bannerTop->post();
                break;
        }

        $bannerTop = $bannerTop->get();

        $keyCenter = $bannerTop->search(function ($item) {
            return $item->last_viewed_at != null;
        });
        $keyCenter = ($keyCenter === false || !@$bannerTop[$keyCenter + 1]) ? 0 : ++$keyCenter;

        if (@$bannerTop[$keyCenter]) {
            $bannerModel->home()->mobile()->where('type', 'top_banner')->update(['last_viewed_at' => null]);
            $item = $bannerTop[$keyCenter];
            $item->last_viewed_at = now();
            $item->viewed_count += 1;
            $item->save();
            $bannerTopItem = $item;
        }
    }


@endphp
@if($agent->isMobile() && @$bannerTopItem)
    <div>
        @include('frontend.pages.index.elements.ads-item-horizontal', ['item' => @$bannerTopItem])
    </div>
@endif

<header id="header" class="header-size-sm">
    <div class="container">
        <div class="header-row">

            <!-- Logo
            ============================================= -->
            <div id="logo" class="mx-auto py-3">
                <a href="{{ route('index.index') }}" class="standard-logo"
                   data-dark-logo="{{ asset($settingMain['logo']) }}"><img
                            src="{{ asset($settingMain['logo']) }}" alt="Logo" style="height: 80px"></a>
                <a href="{{ route('index.index') }}" class="retina-logo"
                   data-dark-logo="{{ asset($settingMain['logo']) }}"><img
                            src="{{ asset($settingMain['logo']) }}" alt="Logo"></a>
            </div><!-- #logo end -->

        </div>
    </div>

    <div id="header-wrap" class="">
        <div class="container-fluid">
            <div class="header-row justify-content-between flex-row-reverse flex-lg-row">

                <div class="d-none d-lg-block order-4 col-lg-2 text-end">
                    <a href="tel:0336405077" class="standard-logo d-inline-block"><img
                                src="{{ asset('frontend/images/icon_call.png') }}" style="height: 45px" alt=""></a>
                </div>
                <div class="header-misc order-0 col-lg-2">

                    <form id="widget-subscribe-form" action="{{ route('index.search') }}" method="get" class="mb-0">
                        <div class="input-group mx-auto">
                            <input type="text" name="q"
                                   class="form-control border-0 border-bottom" placeholder="Search">
                            <div class="input-group-text bg-transparent border-0 border-bottom"><i
                                        class="icon-line-search"></i></div>
                        </div>
                    </form>
                </div>

                <div id="primary-menu-trigger">
                    <svg class="svg-trigger" viewBox="0 0 100 100">
                        <path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path>
                        <path d="m 30,50 h 40"></path>
                        <path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path>
                    </svg>
                </div>

                <nav class="primary-menu mx-auto">

                    <ul class="menu-container">
                        @foreach($menus as $menu)
                            @include('frontend.elements.menu-item', ['menu' => $menu])
                        @endforeach
                    </ul>

                </nav>

            </div>

        </div>
    </div>
    <div class="header-wrap-clone"></div>
</header><!-- #header end -->