@extends('admin.main')
{{--@php--}}
{{--    $xhtmlButtonFilter = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search'], 'status_course');--}}
{{--@endphp--}}
@section('title', 'Administrator | Khóa học')
@section('content')
    @include ('admin.templates.page_header', ['pageIndex' => true, 'isBack' => false])
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Danh sách'])
                @include("admin.pages.$controllerName.list")
            </div>
        </div>
    </div>
@endsection
