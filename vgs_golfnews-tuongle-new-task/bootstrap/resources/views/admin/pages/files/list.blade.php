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
                    <th class="column-title">Tên file</th>
                    <th class="column-title">Miêu tả</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Gửi mail</th>
                    <th class="column-title">Ngày up</th>
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
                            $file            = $val['file'];
                            $sort            = Template::showInputAjax($controllerName, $val['id'], 'sort', $val['sort']);
                            $status          = Template::showItemButton($controllerName, $val['id'], $val['status'], 'status');
                            $description     = Highlight::show($val['description'], $params['search'], 'description');
                            $createdHistory  = Template::showItemHistory($val['created_by'], $val['created']);
                            $listBtnAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td><a href="{{ asset('images/'.$controllerName.'/'.$file) }}" download>{{ $file }}</a></td>
                            <td>{{ $description }}</td>
                            <td>{!! $status !!}
                            <td><button type="button" class="btn btn-sm btn-primary btn-round btn-mail" data-link="{{ route($controllerName.'/mail', ['id' => $id]) }}">Gửi mail</button></td>
                            <td>{{ \Carbon\Carbon::parse($val['created'])->format('H:i:s d-m-Y') }}</td>
                            <td class="last">{!! $listBtnAction !!}</td>
                        </tr>
                    @endforeach
                @else
                    @include('admin.templates.list_empty', ['colspan' => 8])
                @endif
            </tbody>
        </table>
    </div>
</div>
           