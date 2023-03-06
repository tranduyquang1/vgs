@php
    $userInfo = session('userInfo');
    $actionName = strtolower($action);
    $controllerName = strtolower($controller);
@endphp

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
            @php
                $menusAdmin = config('navigation.admin');
            @endphp
            @foreach($menusAdmin as $menu)
                @if(in_array($userInfo['level'], $menu['user_level']))
                    @if(empty($menu['child']))
                        @if(!empty($menu['params']))
                            <li @if(in_array($actionName, ['form', 'view']) && $controllerName == strtolower($menu['link'])) class="current-page" @endif>
                                <a href="{{ route($menu['link']) }}">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    {{$menu['name']}}
                                </a>
                            </li>
                        @else
                            <li @if(in_array($actionName, ['form', 'view']) && $controllerName == strtolower($menu['link'])) class="current-page" @endif>
                                <a href="{{ route($menu['link'], $menu['params']) }}">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    {{$menu['name']}}
                                </a>
                            </li>
                        @endif
                    @else
                        <li @if(in_array($actionName, ['form', 'view']) && in_array($controllerName, $menu['arr_controller'])) class="current-page"@endif>
                            <a><i class="{{ $menu['icon'] }}"></i> {{ $menu['name'] }}
                                <span class="fa fa-chevron-down"></span>
                            </a>
                            <ul class="nav child_menu">
                                @foreach($menu['child'] as $child)
                                    @if(!empty($child['params']))
                                        <li @if((in_array($actionName, ['form', 'view']) && $controllerName == strtolower($child['link'])) || ($controllerName == 'settings' && route($child['link'], $child['params']) == url()->full()))
                                            class="current-page" @endif>
                                            <a href="{{ route($child['link'], $child['params']) }}"> {{$child['name']}} </a>
                                        </li>
                                    @else
                                        <li @if(in_array($actionName, ['form', 'view']) && $controllerName == strtolower($child['link'])) class="current-page" @endif>
                                            <a href="{{ route($child['link']) }}"> {{$child['name']}} </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
    </div>
</div>
