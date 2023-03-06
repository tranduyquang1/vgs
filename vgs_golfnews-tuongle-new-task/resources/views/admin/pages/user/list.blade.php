@php
    use App\Helpers\Template;
    use App\Helpers\Highlight;

    $user = \App\Models\User::find(session('userInfo')['id']);
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">#</th>
                <th class="column-title">Email</th>
                <th class="column-title">Level</th>
                <th class="column-title">Trạng thái</th>
                <th class="column-title">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if (count($items) > 0)
                @foreach ($items as $key => $item)
                    @php
                        $email = Highlight::show($item->email, $params['search'], 'email');
                        $listBtnAction = Template::showButtonAction($controllerName, $item['id']);
                    @endphp

                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{!! $email !!}</td>
                        <td>{{ $levelSelect[$item->level] }}</td>
                        <td>
                            @if($user->can('user-status', $item->id))
                                @livewire('status-button', ['model' => 'users', 'status' => $item->status, 'rowId' =>
                                $item->id], key($item->id))
                            @endif
                        </td>
                        <td>
                            <div class="zvn-box-btn-filter">
                                <a href="{{ route("admin.$controllerName.form", ['id' => $item->id]) }}" type="button"
                                   class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top"
                                   data-original-title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                @if($user->can('user-status', $item->id))
                                    <a href="{{ route("admin.$controllerName.delete", ['id' => $item->id]) }}"
                                       type="button"
                                       class="btn btn-icon btn-danger btn-delete" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endif
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