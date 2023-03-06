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
                <th class="column-title">Nội dung</th>
                <th class="column-title">Sắp xếp</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Tạo mới</th>
                <th class="column-title">Chỉnh sửa</th>
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if (count($items) > 0)
                @foreach ($items as $key => $val)
                    @php
                        $index  = $key + 1;
                        $class  = ($index % 2 == 0) ? "odd" : "even";
                        $name               = Highlight::show($val['content'], $params['search'], 'content');
                        $sort               = Template::showInputAjax($controllerName, $val['id'], 'sort', $val['sort']);
                        $status             = Template::showItemButton($controllerName, $val['id'], $val['status'], 'status');
                        $createHistory      = Template::showItemHistory($val['created_by'], $val['created']);
                        $modifyHistory      = Template::showItemHistory($val['modified_by'], $val['modified']);
                        $listBtnAction      = Template::showButtonAction($controllerName, $val['id']);
                    @endphp

                    <tr class="{{ $class }} pointer">
                        <td>{{ $index }}</td>
                        <td>{!! $name !!}</td>
                        <td>{!! $sort !!}</td>
                        <td>{!! $status !!}</td>
                        <td>{!! $createHistory !!}</td>
                        <td>{!! $modifyHistory !!}</td>
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