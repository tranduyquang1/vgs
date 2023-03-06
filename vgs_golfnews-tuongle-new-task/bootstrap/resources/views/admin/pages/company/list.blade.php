@php


    $statusModel = new \App\Models\old\StatusModel();
    $statusList = $statusModel->where('status', 'active')->orderBy('sort', 'desc')->get();
    $statues = [0 => '-- Chọn trạng thái --'];
    foreach ($statusList as $value) {
        $statues[$value->id] = $value->name;
    }
@endphp
<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
        <tr class="headings">
            <th class="column-title" style="min-width: 60px">#</th>
            <th class="column-title" style="min-width: 100px">Xem chi tiết</th>
            <th class="column-title" style="min-width: 200px">Thông tin</th>
            <th class="column-title" style="min-width: 260px">Kiểm hàng</th>
            <th class="column-title" style="min-width: 150px">Cont No</th>
            <th class="column-title" style="min-width: 120px">Ngày xuất hàng</th>
            <th class="column-title" style="min-width: 120px">Tuần xuất hàng</th>
            <th class="column-title" style="min-width: 120px">ART/Rev</th>
            <th class="column-title" style="min-width: 120px">ART/Re theo thiết kế mới R02</th>
            <th class="column-title" style="min-width: 120px">Tên mã hàng/ Code NM</th>
            <th class="column-title" style="min-width: 120px">Số lượng</th>
            <th class="column-title" style="min-width: 120px">Nhãn tuần</th>
            <th class="column-title" style="min-width: 120px">Deviation</th>
            <th class="column-title" style="min-width: 120px">Chữ cái Cont nội bộ</th>
            <th class="column-title" style="min-width: 120px">Qc kiểm</th>
            <th class="column-title" style="min-width: 120px">Ghi chú</th>
        </tr>
        </thead>
        <tbody>
        @if (count($items) > 0)
            @foreach ($items as $key => $item)
                @php
                    $index           = $key + 1;
                    $class           = ($index % 2 == 0) ? "even" : "odd";
                    $id              = $item['id'];
                    $sheet           = $item->sheet()->first();
                    $file            = $item->sheet()->first()->file()->first();
                @endphp

                <tr class="{{ $class }} pointer">
                    <td>{{ $index }}</td>
                    <td>
                        <a href="{{ route('files/view', ['id' => $file->id, 'sheetId' => $sheet->id,'row_id' => $id]) }}"
                           class="btn btn-sm btn-round btn-info" target="_blank">Xem</a>
                    </td>
                    <td>
                        <p><b>Tên file:</b> {{ $file->file }}</p>
                        <p><b>Tên sheet:</b> {{ $sheet->name }}</p>
                    </td>
                    <!-- process row -->
                    <td>
                        <div class="form-group row d-flex align-items-center">
                            <label for="status" class="control-label col-md-4 col-sm-4 col-xs-12">Trạng thái kiểm
                                hàng</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                {{ $statues[$item['status']] }}
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
                                {{ $item['note'] }}
                            </div>
                        </div>
                    </td>

                    <!-- Cont no -->
                    <td>
                        <p>Cont NO</p>
                        {{ $item['cont_no'] }}
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
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>   