@php
    use App\Helpers\Template as Template;

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
    $statusCheck = $item['is_edit_qc'] == 1 && !empty($status) ? true : false;
@endphp
<tr class="@if($item['is_edit_admin'] == 1) tr-highlight @else {{ $class }} pointer  @endif  @if(request()->get('row_id') == $id) row-active @endif row-item"
    data-id="{{ $id }}">
    <form action="{{ route($controllerName.'/update') }}" method="GET" class="update-form">
        <td>{{ $index }}</td>

        <!-- hidden -->
        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="is_edit_admin" value="1">
        @if(!empty($sheetId)) <input type="hidden" name="sheets_id" value="{{ $sheetId }}"> @endif

    <!-- delete item -->
        <td class="text-center">
            <a href="{{ route('company/delete', ['id' => !empty($id) ? $id : 0]) }}" type="button"
               class="btn btn-danger btn-delete btn-round pl-4 pr-4" data-toggle="tooltip" data-placement="top"
               data-original-title="Delete">
                Xóa
            </a>
            <button class="btn btn-primary btn-sm btn-mail btn-round pt-1 pb-1 mt-2" type="button"
                    data-link="{{ route('files/companyEmail', ['id' => $id, 'line_number' => $index]) }}">Gửi mail
            </button>
        </td>

        <!-- process row -->
        <td>
            <div class="form-group row d-flex align-items-center">
                <label for="status" class="control-label col-md-4 col-sm-4 col-xs-12">Trạng thái</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    {{ Form::select('status', $statues, $item['status'] ?? '', ['class' => 'form-control', 'disabled' => $statusCheck]) }}
                </div>
            </div>
            <div class="form-group row d-flex align-items-center">
                <label for="times_check" class="control-label col-md-4 col-sm-4 col-xs-12">Lần kiểm</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    {{ Form::select('times_check', config('zvn.template.times_check'), $item['times_check'] ?? 1, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group row d-flex align-items-center mb-0">
                <label for="note" class="control-label col-md-4 col-sm-4 col-xs-12">Ghi chú</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle btn-active-field"
                                    style="padding: 6.5px 10px" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                @foreach($suggestions as $sug)
                                    <li><a href="#" class="suggestions-input" data-value="{{ $sug->content }}"
                                           data-id="{{ $targetId }}">{{ $sug->content }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="text" name="note" value="{{ $note }}" class="form-control"
                               data-id="{{ $targetId }}" placeholder="Ghi chú">
                    </div>
                </div>
            </div>
            <div class="form-group row d-flex align-items-center">
                <label class="control-label col-md-4 col-sm-4 col-xs-12"></label>
                <div class="col-md-8 col-sm-8 col-xs-12 text-center">
                    <button type="submit" class="btn btn-sm btn-primary btn-submit w-100" data-id="{{ $id }}">Xác nhận
                    </button>
                </div>
            </div>
        </td>

        <!-- Cont no -->
        @if($user['level'] == 1)
            <td class="text-center">
                <input type="text" name="cont_no" class="form-control text-center" value="{{ $item['cont_no'] }}">
                @if($item['cont_no_block'] == 1)
                    <button type="button" class="btn btn-sm btn-danger disabled mt-1">Đã khóa</button>
                @else
                    <button type="button" class="btn btn-sm btn-success btn-block-cont mt-1" data-id="{{ $id }}">Khóa
                    </button>
                @endif
                <input type="hidden" name="cont_no_block" class="cont_no_block" data-id="{{ $id }}" value="0">
            </td>
        @else
            <td>
                <input type="text" name="cont_no" class="form-control text-center" isabled readonly
                       value="{{ $item['cont_no'] }}">
            </td>
    @endif

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
            <input type="text" name="ngay_xuat_hang" class="form-control text-center datepicker"
                   value="{{ !empty($item['ngay_xuat_hang']) ? \Carbon\Carbon::parse($item['ngay_xuat_hang'])->format('d-m-Y') : '' }}">
        </td>
        <td>
            <p>Tuần xuất hàng</p>
            <input type="text" name="tuan_xuat_hang" class="form-control text-center"
                   value="{{ $item['tuan_xuat_hang'] }}"></td>
        <td>
            <p>Art</p>
            <input type="text" name="art" class="form-control text-center" value="{{ $item['art'] }}"></td>
        <td>
            <p>Art theo kiểu mới</p>
            <input type="text" name="art_theo_kieu_moi" class="form-control text-center"
                   value="{{ $item['art_theo_kieu_moi'] }}"></td>
        <td>
            <p>Tên mã hàng</p>
            <input type="text" name="ten_ma_hang" class="form-control text-center" value="{{ $item['ten_ma_hang'] }}">
        </td>
        <td>
            <p>Revision</p>
            <input type="text" name="revision" class="form-control text-center" value="{{ $item['revision'] }}"></td>
        <td>
            <p>Revison theo kiểu mới</p>
            <input type="text" name="revision_theo_kieu_moi" class="form-control text-center"
                   value="{{ $item['revision_theo_kieu_moi'] }}"></td>
        <td>
            <p>Code nm</p>
            <input type="text" name="code_nm" class="form-control text-center" value="{{ $item['code_nm'] }}"></td>
        <td>
            <p>Số lượng</p>
            <input type="text" name="so_luong" class="form-control text-center" value="{{ $item['so_luong'] }}"></td>
        <td>
            <p>Nhãn tuần</p>
            <input type="text" name="nhan_tuan" class="form-control text-center" value="{{ $item['nhan_tuan'] }}"></td>
        <td>
            <p>Devitation</p>
            <input type="text" name="deviation" class="form-control text-center" value="{{ $item['deviation'] }}"></td>
        <td>
            <p>Chữ cái Cont</p>
            <input type="text" name="chu_cai_cont_noi_bo" class="form-control text-center"
                   value="{{ $item['chu_cai_cont_noi_bo'] }}"></td>
        <td>
            <p>Qc kiểm</p>
            <input type="text" name="qc_kiem" class="form-control text-center" value="{{ $item['qc_kiem'] }}"></td>
        <td>
            <p>Ghi chú</p>
            <input type="text" name="message" class="form-control text-center" value="{{ $item['message'] }}"></td>
    </form>
</tr>

<style>
    td p:last-child {
        margin-bottom: 0;
    }
</style>