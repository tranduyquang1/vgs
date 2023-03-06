@php
    use App\Helpers\Template as Template;
    $listBtnAction = Template::showButtonAction($controllerName, $item->id);
@endphp

<li class="dd-item dd3-item" data-id="{{ $item->id }}">
    <div class="dd-handle dd3-handle">Drag</div>
    <div class="dd3-content ">
        <div class="category-item">
            <div>{{ $item->name }}</div>
            <div class="area-action">
                @livewire('status-button', ['model' => 'menus', 'status' => $item->status, 'rowId' => $item->id], key($item->id))
                <div>{!! $listBtnAction !!}</div>
            </div>
        </div>
    </div>
    @if (count($item->children) > 0)
        <ol class="dd-list">
            @foreach ($item->children as $itemChild)
                @include('admin.pages.menu.list-item', ['item' => $itemChild, 'myLoop' => $loop])
            @endforeach
        </ol>
    @endif
</li>
