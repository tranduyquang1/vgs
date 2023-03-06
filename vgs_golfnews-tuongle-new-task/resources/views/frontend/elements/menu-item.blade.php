<li class="menu-item">
    <a class="menu-link" @if($menu->link == 'http://golfnewstv.com/') target="_blank" @endif
       href="@if($menu->type == 'link') {{ $menu->link }} @else {{ route('category.detail', ['slug' => \Illuminate\Support\Str::slug($menu->name), 'id' => $menu->category_id]) }} @endif">
        <div>{{ $menu->name }}</div>
    </a>
    @if($menu->children->count() > 0)
        <ul class="sub-menu-container">
            @foreach($menu->children as $childMenu)
                @include('frontend.elements.menu-item', ['menu' => $childMenu])
            @endforeach
        </ul>
    @endif
</li>