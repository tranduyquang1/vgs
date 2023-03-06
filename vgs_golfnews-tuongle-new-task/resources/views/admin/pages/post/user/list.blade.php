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
                        <td>{{ $loop->index + 1 }}</td>
                        <td style="max-width: 70px">{!! $thumb !!}</td>
                        <td>{!! $title !!}</td>
                        <td>{{ $item->is_on_slider ? 'Có' : 'Không' }}</td>
                        <td>{{ $item->is_hotnews ? 'Có' : 'Không' }}</td>
                        <td>{{ @$item->category->name }}</td>
                        <td>{{ @$postFormat[$item->format] ?? 'Album' }}</td>
                        <td>{{ $postStatus[$item->status] }}</td>
                        <td>
                            @livewire('datetime-for-posts', ['value' => $publishedDate, 'rowId' =>
                            $item->id, 'field' => 'published_at_display'], key($item->id))
                        </td>
                        <td>
                            <div class="zvn-box-btn-filter">
                                <a href="{{ route("admin.$controllerName.form", ['id' => $item->id]) }}" type="button"
                                   class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top"
                                   data-original-title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                @include ('admin.templates.list_empty', ['colspan' => 7])
            @endif
            </tbody>
        </table>
    </div>
</div>