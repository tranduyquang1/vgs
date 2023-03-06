@php
    use App\Helpers\Template as Template;
    use App\Helpers\Form as FormTemplate;

    $suggestionsModel = new \App\Models\SuggestionsModel();
    $suggestions = $suggestionsModel->where('status', 'active')->orderBy('sort', 'asc')->get();

    $statusModel = new \App\Models\old\StatusModel();
    $statusList = $statusModel->where('status', 'active')->orderBy('sort', 'desc')->get();
    $statues = [0 => '-- Chọn trạng thái --'];
    foreach ($statusList as $value) {
        $statues[$value->id] = $value->name;
    }

    $class = ($index % 2 == 0) ? "even" : "odd";
    $id = $item['id'] ?? null;
    $note = $item['note'];
    $status = $item['status'];
    $targetId = \Illuminate\Support\Str::random(32);
    $createdHistory = Template::showItemHistory($item['created_by'], $item['created']);
    $logs = $item->logs()->where('company_id', $id)->orderBy('id', 'desc')->get();
    $user = session()->get('userInfo');
    $isBlock = $item['cont_no_block'] == 1;
    $isEdit = $item['is_edit_qc'] == 1;
@endphp
<tr class="@if($isEdit) tr-highlight @else {{ $class }} pointer  @endif row-item" data-id="{{ $id }}">
    <form action="{{ route($controllerName.'/update') }}" method="GET" class="update-form" data-id="{{ $id }}">
        <td>{{ $index }}</td>

        <!-- hidden -->
        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="is_edit_qc" value="1">
        @if(!empty($sheetId)) <input type="hidden" name="sheets_id" value="{{ $sheetId }}"> @endif

    <!-- process row -->
        <td>
            <div class="form-group row d-flex align-items-center">
                <label for="status" class="control-label col-md-4 col-sm-4 col-xs-12">Trạng thái</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    {{ Form::select('status', $statues, $item['status'] ?? '', ['class' => 'form-control', 'disabled' => $isBlock, 'data-id' => $id]) }}
                </div>
            </div>
            <div class="form-group row d-flex align-items-center">
                <label for="times_check" class="control-label col-md-4 col-sm-4 col-xs-12">Lần kiểm</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    {{ Form::select('times_check', config('zvn.template.times_check'), $item['times_check'] ?? 1, ['class' => 'form-control', 'disabled' => $isBlock, 'data-id' => $id]) }}
                </div>
            </div>
            <div class="form-group row d-flex align-items-center mb-0">
                <label for="note" class="control-label col-md-4 col-sm-4 col-xs-12">Ghi chú</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="input-group">
                        @if(!$isBlock)
                            <div class="input-group-btn box-hints" data-id="{{ $id }}">
                                <button type="button" class="btn btn-default dropdown-toggle btn-active-field"
                                        style="padding: 6.5px 12px" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    @foreach($suggestions as $sug)
                                        <li><a href="#" class="suggestions-input" data-value="{{ $sug->content }}"
                                               data-id="{{ $targetId }}">{{ $sug->content }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <input type="text" name="note" value="{{ $note }}" @if($isBlock) disabled readonly
                               @endif class="form-control" data-itemId="{{ $id }}" data-id="{{ $targetId }}"
                               placeholder="Ghi chú">
                    </div>
                </div>
            </div>
            <div class="form-group row d-flex align-items-center">
                <label class="control-label col-md-4 col-sm-4 col-xs-12"></label>
                <div class="col-md-8 col-sm-8 col-xs-12 text-center">
                    <button type="submit" class="btn btn-sm btn-primary btn-submit w-100" data-id="{{ $id }}"
                            @if($isBlock) disabled readonly @endif>Xác nhận
                    </button>
                </div>
            </div>
        </td>

        <!-- Cont no -->
        <td class="text-center">
            <input type="text" name="cont_no" class="form-control text-center" @if($isBlock) disabled readonly
                   @endif value="{{ $item['cont_no'] }}">
            @if($isBlock)
                <button type="button" class="btn btn-sm btn-danger disabled mt-1">Đã khóa</button>
            @else
                <button type="button" class="btn btn-sm btn-success btn-block-cont mt-1" data-id="{{ $id }}"
                        @if($isEdit) data-confirm="true" @else data-confirm="false" @endif>Khóa
                </button>
                <input type="hidden" name="cont_no_block" class="cont_no_block" data-id="{{ $id }}" value="0">
            @endif
        </td>

        <!-- history -->
        <td class="history-log" data-id="{{ $id }}">

            <div class="text-center">
                <p class="display-info text-center mb-2">
                    @if(count($logs) > 0)
                        <b>{{ $logs->first()->user()->first()->fullname }}</b> đã cập nhật vào lúc
                        <b>{{ \Carbon\Carbon::parse($logs->first()->created)->format('H:i:s d-m-Y') }}</b>
                    @endif
                </p>
            </div>

            @include('admin.pages.files.partial.history')
        </td>

        <!-- field excel -->
        <td>
            <p>Ngày xuất hàng</p>
            <b>{{ !empty($item['ngay_xuat_hang']) ? \Carbon\Carbon::parse($item['ngay_xuat_hang'])->format('d-m-Y') : '' }}</b>
        </td>
        <td>
            <p>Tuần xuất hàng</p>
            <b>{{ $item['tuan_xuat_hang'] }}</b>
        </td>
        <td>
            <p>ART</p>
            <b>{{ $item['art'] }} - {{ $item['revision'] }}</b>
        </td>
        <td>
            <p>ART theo kiểu mới</p>
            <b>{{ $item['art_theo_kieu_moi'] }} - {{ $item['revision_theo_kieu_moi'] }}</b>
        </td>
        <td>
            <p>Tên mã hàng</p>
            <b>{{ $item['ten_ma_hang'] }} - {{ $item['code_nm'] }}</b>
        </td>
        <td>
            <p>Số lượng</p>
            <b>{{ $item['so_luong'] }}</b>
        </td>
        <td>
            <p>Nhãn tuần</p>
            <b>{{ $item['nhan_tuan'] }}</b>
        </td>
        <td>
            <p>Deviation</p>
            <b>{{ $item['deviation'] }}</b>
        </td>
        <td>
            <p>Chữ cái Cont nội bộ</p>
            <b>{{ $item['chu_cai_cont_noi_bo'] }}</b>
        </td>
        <td>
            <p>Qc kiểm</p>
            <b>{{ $item['qc_kiem'] }}</b>
        </td>
        <td>
            <p>Ghi chú</p>
            <b>{{ $item['message'] }}</b>
        </td>
    </form>
</tr>

<style>
    td p:last-child {
        margin-bottom: 0;
    }
</style>