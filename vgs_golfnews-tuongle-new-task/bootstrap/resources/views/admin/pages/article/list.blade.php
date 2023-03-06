@php
    use App\Helpers\Template as Template;
    use App\Helpers\Highlight as Highlight;
@endphp
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">#</th>
                <th class="column-title">Thông tin</th>
                <th class="column-title">Hình ảnh</th>
                <th class="column-title">Thể loại</th>
                <th class="column-title">Kiểu bài viết</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if (count($items) > 0)
                @foreach ($items as $key => $val)
                    @php
                        $index           = $key + 1;
                        $class           = ($index % 2 == 0) ? "even" : "odd";
                        $id              = $val['id'];
                        $name            = Highlight::show($val['name'], $params['search'], 'name');
                        $content         = Highlight::show($val['content'], $params['search'], 'content');
                        $description     = Highlight::show($val['description'], $params['search'], 'description');
                        $thumb           = Template::showItemThumb($controllerName, $val['thumb'], $val['name']);
                        $category        = Template::showItemSelect($controllerName, $id, $cateNews, $val['category_id'], 'category_id', false);
                        $status          = Template::showItemButton($controllerName, $id, $val['status'], 'status');
                        $type            = Template::showItemSelect($controllerName, $id, Config('zvn.template.type'), $val['type'], 'type');
                        $listBtnAction   = Template::showButtonAction($controllerName, $id);
                    @endphp

                    <tr class="{{ $class }} pointer">
                        <td>{{ $index }}</td>
                        <td width="25%">
                            <p><strong>Tên:</strong> {!! $name !!}</p>
                            <p><strong>Mô tả:</strong> {!! $description !!}</p>
                        </td>
                        <td width="15%">
                            <p>{!! $thumb !!}</p>
                        </td>
                        <td width="15%">{!! $category !!}</td>
                        <td width="12%">{!! $type !!}</td>
                        <td>{!! $status !!}</td>
                        <td class="last">{!! $listBtnAction !!}</td>
                    </tr>
                @endforeach
            @else
                @include('admin.templates.list_empty', ['colspan' => 7])
            @endif
            </tbody>
        </table>
    </div>
</div>
           