@php
    use App\Helpers\Template;
    use App\Helpers\Highlight;
    $bannerPage = config('zvn.banner.page');
    $bannerPosition = config('zvn.banner.position');
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">#</th>
                <th class="column-title">Thông tin</th>
                
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if (count($items) > 0)
                @foreach ($items as $key => $item)
                    @php
                        $name = Highlight::show($item->name, $params['search'], 'name');
                        $thumb = Template::showItemThumbFull($item->thumb, $item->name);
                        $listBtnAction = Template::showButtonAction($controllerName, $item['id']);
                    @endphp

                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <p><strong>Tên: </strong>{!! $name !!}</p>
                            <p><strong>Link: </strong>{{ $item->url }}</p>
                        </td>
                        
                        
                        <td>
                            @livewire('status-button', ['model' => 'banners_category', 'status' => $item->status, 'rowId' =>
                            $item->id], key($item->id))
                        </td>
                        <td class="last">{!! $listBtnAction !!}</td>
                    </tr>
                @endforeach
            @else
                @include ('admin.templates.list_empty', ['colspan' => 7])
            @endif
            </tbody>
        </table>
    </div>
</div>