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
                <th class="column-title">Tên</th>
                <th class="column-title">Sắp xếp</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Tạo mới</th>
                <th class="column-title">Chính sửa</th>
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if (count($items) > 0)
                @php
                    $a = 0;
                @endphp
                @foreach ($items as $key => $val)
                    @if($val['name'] != 'root')
                        @php
                            $index          = $a + 1;
                            $class          = ($index % 2 == 0) ? "odd" : "even";
                            $name           = Highlight::show($val['nameByLv'], $params['search'], 'name');
                            $status         = Template::showItemButton($controllerName, $val['id'], $val['status'], 'status');
                            $createHistory  = Template::showItemHistory($val['created_by'], $val['created']);
                            $modifyHistory  = Template::showItemHistory($val['modified_by'], $val['modified']);
                            $listBtnAction  = Template::showButtonAction($controllerName, $val['id']);
                            $btnOrdering    = Template::showBtnOrdering($controllerName,$items,$val['id'],['task'=>'ordering-menu','id_parent'=>$val['parent_id']]);
                            $a++;
                        @endphp

                        <tr class=" pointer">
                            <td class="">{{ $index }}</td>
                            <td class="">{!!  $name !!}</td>
                            <td>{!! $btnOrdering !!}</td>
                            <td>{!! $status !!}</td>
                            <td>{!! $createHistory !!}</td>
                            <td>{!! $modifyHistory !!}</td>
                            <td class="last">{!! $listBtnAction !!}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                @include ('admin.templates.list_empty', ['colspan' => 7])
            @endif
            </tbody>
        </table>
    </div>
</div>