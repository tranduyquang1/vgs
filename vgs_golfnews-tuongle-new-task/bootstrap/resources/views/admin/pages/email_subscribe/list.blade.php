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
                <th class="column-title">Email</th>
                <th class="column-title">Thời gian</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if (count($items) > 0)
                @foreach ($items as $key => $val)
                    @php
                        $index  = $key + 1;
                        $class  = ($index % 2 == 0) ? "odd" : "even";
                        $email                  = Highlight::show($val['email'], $params['search'], 'email');
                        $status                 = Template::showItemButton($controllerName, $val['id'], $val['status'], 'recall');
                        $created                = date('d-m-Y H:i:s', strtotime($val['created']));
                        $listBtnAction          = Template::showButtonAction($controllerName, $val['id']);
                    @endphp

                    <tr class="{{ $class }} pointer">
                        <td class="">{{ $index }}</td>
                        <td> {!!$email!!}</td>
                        <td>{!! $created !!}</td>
                        <td>{!! $status !!}</td>
                        <td class="last">{!! $listBtnAction !!}</td>
                    </tr>
                @endforeach
            @else
                @include ('admin.templates.list_empty', ['colspan' => 5])
            @endif
            </tbody>
        </table>
    </div>
</div>