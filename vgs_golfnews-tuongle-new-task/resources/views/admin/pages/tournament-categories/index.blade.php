@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Template;
        $xhtmlButtonFilter = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search'],'status_tiny_int_with_all');
        $xhtmlAreaSearch    = Template::showAreaSearch($controllerName, $params['search']);
        $pageSelect = ['default' => '-- Chọn trang hiển thị --'] + config('zvn.banner.page');
        $xhtmlSelectPage = Template::showSelectFilterCustom('page', $pageSelect, @$params['filter']['page'], false);
        $positionSelect = ['default' => '-- Chọn vị trí hiển thị --'] + config('zvn.banner.position');
        $xhtmlSelectPosition = Template::showSelectFilterCustom('position', $positionSelect, @$params['filter']['position'], false);
    @endphp

    @include ('admin.templates.page_header', ['pageIndex' => true, 'isBack' => false])
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Bộ lọc"])
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6">{!! $xhtmlButtonFilter !!}</div>
                        <div class="col-md-6">{!! $xhtmlAreaSearch !!}</div>
                    </div>
                    {{-- <div class="d-flex">
                        <div>
                            <h5 class="text-center">Lọc theo trang hiển thị</h5>
                            {!! $xhtmlSelectPage !!}
                        </div>
                        <div>
                            <h5 class="text-center">Lọc theo vị trí hiển thị</h5>
                            {!! $xhtmlSelectPosition !!}
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Danh sách'])
                @include("admin.pages.$controllerName.list")
            </div>
        </div>
    </div>

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