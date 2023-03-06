@extends('admin.main')
@php
    use App\Helpers\Template as Template;
    $xhtmlButtonFilter  = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search'],'status');
    $arrSelectType      = array_merge(['default' => ['name' => '-- Kiểu bài viết --']], config('zvn.template.type'));
    $xhtmlSelectType    = Template::showSelectFilter('type' , $arrSelectType, $params['select']['value']);
    $category = ['default' => '-- Chọn danh mục --'] + $cateNews;
    $xhtmlSelectCategory= Template::showSelectFilter('category_id' , $category, $params['select']['value'], false);
    $xhtmlAreaSeach     = Template::showAreaSearch($controllerName, $params['search']);
@endphp

@section('content')
    
    @include ('admin.templates.page_header', ['pageIndex' => true])
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Bộ lọc'])
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6">{!! $xhtmlButtonFilter !!}</div>
                        <div class="col-md-6">{!! $xhtmlAreaSeach !!}</div>
                        <div class="col-md-2">{!! $xhtmlSelectType !!}</div>
                        <div class="col-md-2">{!! $xhtmlSelectCategory !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Danh sách'])
                @include('admin.pages.article.list')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Phân trang'])
                @include('admin.templates.pagination')
            </div>
        </div>
    </div>

@endsection
