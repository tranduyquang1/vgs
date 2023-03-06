@php
    use App\Helpers\Template;
    use App\Helpers\Highlight;
    $postFormat = config('zvn.template.post_format');
    $postStatus = config('zvn.template.post_status');
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">ID</th>
                <th class="column-title">Hình ảnh</th>
                <th class="column-title">Tiêu đề</th>
{{--                <th class="column-title">Tin tài trợ</th>--}}
                <th class="column-title">On Slider</th>
                <th class="column-title">Tiêu điểm</th>
                <th class="column-title">Được xem nhiều</th>
                <th class="column-title">Lượt xem</th>
                <th class="column-title">Danh mục</th>
                <th class="column-title">Định dạng</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Ngày published</th>
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if (count($items) > 0)
                @foreach ($items as $key => $item)
                    @php
                        $title = Highlight::show($item->title, $params['search'], 'title');
                        $thumb = Template::showItemThumb($controllerName, $item->thumbnail ?? 'default.jpg', $item->name);
                        if ($item->is_old) $thumb = Template::showItemThumbbyUrl('https://cdn.golfnews.vn', $item->thumbnail, $item->name);
                        $listBtnAction = Template::showButtonAction($controllerName, $item['id']);
                        $publishedDate = date('Y-m-d\TH:i:s', strtotime($item->published_at_display));
                    @endphp

                    <tr>
                        <td>{{ $item->id }}</td>
                        <td style="max-width: 70px">{!! $thumb !!}</td>
                        <td>{!! $title !!}</td>
{{--                        <td>--}}
{{--                            @livewire('switch-posts-field', ['value' => $item->is_ads_news, 'rowId' =>--}}
{{--                            $item->id, 'field' => 'is_ads_news'], key($item->id))--}}
{{--                        </td>--}}
                        <td>
                            @livewire('switch-posts-field', ['value' => $item->is_on_slider, 'rowId' =>
                            $item->id, 'field' => 'is_on_slider'], key($item->id))
                        </td>
                        <td>
                            @livewire('switch-posts-field', ['value' => $item->is_hot_news, 'rowId' =>
                            $item->id, 'field' => 'is_hot_news'], key($item->id))
                        </td>
                        <td>
                            @livewire('switch-posts-field', ['value' => $item->is_most_read, 'rowId' =>
                            $item->id, 'field' => 'is_most_read'], key($item->id))
                        </td>
                        <td>{{ views($item)->unique()->count() }}</td>
                        <td>{{ @$item->category->name }}</td>
                        <td>{{ @$postFormat[$item->format] ?? 'Album' }}</td>
                        <td>
                            @livewire('select-post-status', ['selected' => $item->status, 'rowId' => $item->id], key($item->id))
                        </td>
{{--                        <td>{{ $item->published_at_display }}</td>--}}
                        <td>
                            @livewire('datetime-for-posts', ['value' => $publishedDate, 'rowId' =>
                            $item->id, 'field' => 'published_at_display'], key($item->id))
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