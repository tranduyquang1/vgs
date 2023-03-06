@if(count($logs) > 0)    
<div class="text-center mt-2">
    <button class="btn btn-sm btn-warning text-white" type="button" data-toggle="modal" data-target="#modalLog-{{$id}}">Chi tiết lịch sử chỉnh sửa</button>
</div>
<!-- modal -->
<div class="modal fade" id="modalLog-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="modalLog-{{$id}}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title" id="modalLog-{{$id}}Label">Lịch sử chỉnh sửa</h5>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                    <table class="table table-bordered table-history mb-0">
                        <thead>
                            <tr>
                                <th>Người dùng</th>
                                <th>Cột</th>
                                <th>Dữ liệu cũ</th>
                                <th>Dữ liệu mới</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            @php 
                                $userName = $log->user()->first()->fullname;
                                $createdAt = \Carbon\Carbon::parse($log->created)->format('H:i:s d-m-Y');
                                $dataNew = json_decode($log->data_new, true);
                                $dataOld = json_decode($log->data_old, true);
                                $dataDiff = array_diff_assoc($dataNew, $dataOld);
                                unset($dataDiff['created'], 
                                    $dataDiff['modified'], 
                                    $dataDiff['modified_by'], 
                                    $dataDiff['is_edit_admin'], 
                                    $dataDiff['is_edit_qc'], 
                                    $dataDiff['is_edit_member'], 
                                    $dataDiff['is_confirm'],
                                    $dataDiff['ngay_xuat_hang']
                                );
                                $keyDiff = array_keys($dataDiff);
                            @endphp
                                @if(!empty($keyDiff))
                                    <tr>
                                        <td>{{ $userName }}</td>
                                        <td>
                                            @foreach($keyDiff as $key)
                                                <p>{{ @config('zvn.excel_field')[$key] }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($keyDiff as $key)
                                                @php 
                                                    $oldValue = $dataOld[$key];
                                                    if($key == 'status')
                                                        $oldValue = $dataOld[$key] == 0 ? 'Chọn trạng thái' : $statues[$dataOld[$key]];
                                                    if($key == 'cont_no_block') {
                                                        switch ($oldValue) {
                                                            case '':
                                                                $oldValue = '---';
                                                                break;
                                                            case 1:
                                                                $oldValue = 'Đã khóa';
                                                                break;
                                                           case 0:
                                                                $oldValue = 'Chưa khóa';
                                                                break;    
                                                        }
                                                    }
                                                       
                                                @endphp
                                                <p>{{ !empty($oldValue ) ? $oldValue : '---' }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($keyDiff as $key)
                                                @php 
                                                    $newValue = $dataNew[$key];
                                                    if($key == 'status')
                                                        $newValue = $dataNew[$key] == 0 ? 'Chọn trạng thái' : $statues[$dataNew[$key]];
                                                    
                                                    if($key == 'cont_no_block') {
                                                        switch ($newValue) {
                                                            case '':
                                                                $newValue = '---';
                                                                break;
                                                            case 1:
                                                                $newValue = 'Đã khóa';
                                                                break;
                                                           case 0:
                                                                $newValue = 'Chưa khóa';
                                                                break;    
                                                        }
                                                    } 
                                                        
                                                @endphp 
                                                <p>{{ !empty($newValue) ? $newValue : '---' }}</p>
                                            @endforeach
                                        </td>
                                    <td>{{ $createdAt }}</td>
                                    </tr>
                                @endif   
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
@endif  
<style>
.table-history > tbody > tr > td {
    background: #fff !important;
}    
</style>                   