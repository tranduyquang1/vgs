@extends('admin.main')
@php
    use App\Helpers\Template as Template;
    $user = session('userInfo');
    $excelField = config('zvn.excel_field');
    unset($excelField['status'], $excelField['times_check'], $excelField['qc_kiem'], $excelField['note'], $excelField['message'], $excelField['ngay_xuat_hang'], $excelField['cont_no_block']);

    $statusModel = new \App\Models\old\StatusModel();
    $statusList = $statusModel->where('status', 'active')->orderBy('sort', 'desc')->get();
    $statues = [''=> '-- Chọn trạng thái --'];
    foreach ($statusList as $value) {
        $statues[$value->id] = $value->name;
    }
@endphp

@section('content')

    @include ('admin.templates.page_header', ['pageIndex' => true, 'nonButton' => true])

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Tìm kiếm'])
                <div class="x_content">
                    <form method="GET" class="form-search">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="item form-group d-flex align-items-center">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="ngay_xuat_hang">Ngày
                                        xuất hàng</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="text" id="ngay_xuat_hang" name="ngay_xuat_hang"
                                               class="form-control datepicker"
                                               value="{{ $params['ngay_xuat_hang'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            @foreach ($excelField as $key => $name)
                                <div class="col-md-4">
                                    <div class="item form-group d-flex align-items-center">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                               for="{{ $key }}">{{ $name }}</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" id="{{ $key }}" name="{{ $key }}" class="form-control"
                                                   value="{{ $params[$key] ?? ''}}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-4">
                                <div class="item form-group d-flex align-items-center">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="status">Trạng
                                        thái</label>
                                    <div class="col-md-8 col-sm-8">
                                        {{ Form::select('status', $statues, $params['status'] ?? '', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="item form-group d-flex align-items-center">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="time_checks">Lần
                                        kiểm</label>
                                    <div class="col-md-8 col-sm-8">
                                        {{ Form::select('times_check', ['' => '-- Chọn lần kiểm --'] + config('zvn.template.times_check'), $params['times_check'] ?? '', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-info">Tìm kiếm</button>
                                <a href="{{ route($controllerName) }}" class="btn btn-danger">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(count($items) > 0)
        <div class="row mt-3 mb-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-export-search"
                        data-link="{{ route('company/export') }}">Export dữ liệu
                </button>
            </div>
        </div>
        @include('admin.pages.company.list')
    @else
        @if(!$isSearch && url()->current() != route('company'))
            <div class="row mt-3">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                        <strong>Không tìm thấy kết quả cho tìm kiếm</strong>
                    </div>
                </div>
            </div>
        @endif
    @endif


    @if (count($items) > 0)
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    @include('admin.templates.x_title', ['title' => 'Phân trang'])
                    @include('admin.templates.pagination')
                </div>
            </div>
        </div>
    @endif

@endsection
