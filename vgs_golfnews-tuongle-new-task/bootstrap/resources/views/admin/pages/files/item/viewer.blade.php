@php
    use App\Helpers\Template as Template;
    $suggestionsModel = new \App\Models\SuggestionsModel();
    $suggestions = $suggestionsModel->where('status', 'active')->orderBy('sort', 'asc')->get();

    $class = ($index % 2 == 0) ? "even" : "odd";
    $id = $item['id'] ?? null;
    $note = $item['note'];
    $status = $item['status'];
    $targetId = \Illuminate\Support\Str::random(32);
    $createdHistory = Template::showItemHistory($item['created_by'], $item['created']);
    $logs = $item->logs()->where('company_id', $id)->orderBy('id', 'desc')->get();

    $statusModel = new \App\Models\old\StatusModel();
    $statusList = $statusModel->where('status', 'active')->orderBy('sort', 'desc')->get();
    $statues = [0 => '-- Chọn trạng thái --'];
    foreach ($statusList as $value) {
        $statues[$value->id] = $value->name;
    }

@endphp
<tr class="{{ $class }} pointer row-item" data-id="{{ $id }}">

    <td>{{ $index }}</td>
    <!-- process row -->
    <td>
        <div class="form-group row d-flex align-items-center">
            <label for="status" class="control-label col-md-4 col-sm-4 col-xs-12">Trạng thái</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
                {{ $statues[$item['status'] ?? 0] }}
            </div>
        </div>
        <div class="form-group row d-flex align-items-center">
            <label for="times_check" class="control-label col-md-4 col-sm-4 col-xs-12">Lần kiểm</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
                {{ config('zvn.template.times_check')[$item['times_check'] ?? 1] }}
            </div>
        </div>
        <div class="form-group row d-flex align-items-center">
            <label for="note" class="control-label col-md-4 col-sm-4 col-xs-12">Ghi chú</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
                {{ $note }}
            </div>
        </div>
    </td>

    <!-- Cont no -->
    <td>
        {{ $item['cont_no'] }}
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
