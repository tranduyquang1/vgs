<tr>
    <form action="{{ route('files/search') }}" class="search-filter-form" data-sheet="{{ $sheet->id }}">
    <input type="hidden" name="sheet_id" value="{{ $sheet->id }}">    
    <td colspan="2" class="text-center" style="vertical-align: middle;">Tìm kiếm</td>
    <td><input type="text" name="search[cont_no]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td></td>
    <td><input type="text" name="search[ngay_xuat_hang]" class="form-control search-filter datepicker" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[tuan_xuat_hang]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[art]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[ten_ma_hang]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[revision]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[so_luong]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[nhan_tuan]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[deviation]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[chu_cai_cont_noi_bo]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[qc_kiem]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    <td><input type="text" name="search[note]" class="form-control search-filter" data-sheet="{{ $sheet->id }}"></td>
    </form>
</tr>
<tr class="headings">
    <th class="column-title" style="min-width: 30px">#</th>
    <th class="column-title" style="min-width: 300px">Kiểm hàng</th>
    <th class="column-title" style="min-width: 150px">Cont No</th>
    <th class="column-title" style="min-width: 220px">Lịch sử</th>
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