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
                <th class="column-title">#</th>
                <th class="column-title">Hình ảnh</th>
                <th class="column-title">Tiêu đề</th>
                <th class="column-title">On Slider</th>
                <th class="column-title">Tiêu điểm</th>
                <th class="column-title">Danh mục</th>
                <th class="column-title">Định dạng</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Published</th>
                <th class="column-title">Published Display</th>
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
                    @endphp

                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td style="max-width: 70px">{!! $thumb !!}</td>
                        <td>{!! $title !!}</td>
                        <td>@livewire('button-post-is-on-slider', ['value' => $item->is_on_slider, 'rowId' =>
                            $item->id], key($item->id))
                        </td>
                        <td>@livewire('button-post-is-hot-news', ['value' => $item->is_hot_news, 'rowId' => $item->id],
                            key($item->id))
                        </td>
                        <td>{{ @$item->category->name }}</td>
                        <td>{{ @$postFormat[$item->format] ?? 'Album' }}</td>
                        <td>{{ $postStatus[$item->status] }}</td>
                        <td>{{ $item->published_at }}</td>
                        <td>{{ $item->published_at_display }}</td>
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