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
                <th class="column-title">Chuyên trang</th>
                <th class="column-title">Ngày</th>
                <th class="column-title">Thời gian</th>
                <th class="column-title">Hoạt động</th>
                <th class="column-title">Thứ tự</th>
                <th class="column-title">Ngôn ngữ</th>
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if (count($items) > 0)
                @foreach ($items as $key => $item)
                    @php
                        $name = Highlight::show($item->name, $params['search'], 'name');
                        $thumb = Template::showItemThumbFull($item->image, $item->name);
                        $listBtnAction = Template::showButtonAction($controllerName, $item['id']);
                    @endphp

                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            @livewire('select-tournament-live-scheldule-page', ['selected' => $item->tournament_categories_id, 'rowId' => $item->id], key($item->id))
                        </td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->time }}</td>
                        <td>{{ $item->activities }}</td>
                        <td>{{ $item->order }}</td>
                        <td>
                            @livewire('select-tournament-scheldule-language', ['selected' => $item->language, 'rowId' => $item->id], key($item->id))
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