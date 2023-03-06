@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Template;
        // $xhtmlButtonFilter = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search'],'status_of_post');
        $xhtmlAreaSearch    = Template::showAreaSearch($controllerName, $params['search']);
        $statusSelect = ['default' => '-- Chọn giá trị --'] + config('zvn.template.post_status');
        $xhtmlSelectStatus = Template::showSelectFilterCustom('post_status', $statusSelect, @$params['filter']['post_status'], false);
        $categorySelect = ['default' => '-- Chọn giá trị --'] + $categories;
        $xhtmlSelectCategory = Template::showSelectFilterCustom('category_id', $categorySelect, @$params['filter']['category_id'], false);
        $formatSelect = ['default' => '-- Chọn giá trị --'] + config('zvn.template.post_format');
        $xhtmlSelectFormat = Template::showSelectFilterCustom('post_format', $formatSelect, @$params['filter']['post_format'], false);
        $isOnSliderSelect = ['default' => '-- Chọn giá trị --', 0 => 'Không', 1 => 'Có'];
        $xhtmlSelectIsOnSlider = Template::showSelectFilterCustom('post_is_on_slider', $isOnSliderSelect, @$params['filter']['post_is_on_slider'], false);
        $isHotNewsSelect = ['default' => '-- Chọn giá trị --', 0 => 'Không', 1 => 'Có'];
        $xhtmlSelectIsHotNews = Template::showSelectFilterCustom('post_is_hot_news', $isOnSliderSelect, @$params['filter']['post_is_hot_news'], false);
    @endphp

    @include ('admin.templates.page_header', ['pageIndex' => true, 'isBack' => false])
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Bộ lọc"])
                <div class="x_content">
                    <div class="row">
{{--                        <div class="col-md-6">{!! $xhtmlButtonFilter !!}</div>--}}
                        <div class="col-xs-12">{!! $xhtmlAreaSearch !!}</div>
                    </div>
                    <div class="d-flex" style="flex-wrap: wrap">
                        <div>
                            <h5 class="text-center">Lọc theo trạng thái {{ ini_get('upload_max_filesize') }}</h5>
                            {!! $xhtmlSelectStatus !!}
                        </div>
                        <div>
                            <h5 class="text-center">Lọc theo danh mục {{ ini_get('post_max_size') }}</h5>
                            {!! $xhtmlSelectCategory !!}
                        </div>
                        <div>
                            <h5 class="text-center">Lọc theo định dạng</h5>
                            {!! $xhtmlSelectFormat !!}
                        </div>
                        <div>
                            <h5 class="text-center">Lọc theo tin ở slider</h5>
                            {!! $xhtmlSelectIsOnSlider !!}
                        </div>
                        <div>
                            <h5 class="text-center">Lọc theo tin tiêu điểm</h5>
                            {!! $xhtmlSelectIsHotNews !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{route("admin.$controllerName.vietnameseform.seagames")}}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm mới bài viết SeaGames</a>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Danh sách'])
                @include("admin.pages.{$controllerName}.{$userLevel}.list")
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