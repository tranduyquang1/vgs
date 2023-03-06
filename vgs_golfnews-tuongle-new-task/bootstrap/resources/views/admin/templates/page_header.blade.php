@php
    $pageTitle = 'Quản lý ' . ucfirst(config('zvn.template.header')[$controllerName]);
    if(!(isset($nonButton) && $nonButton)) {
        $pageButton = sprintf('<a href="%s" class="btn btn-success"><i class="fa fa-arrow-left"></i> Quay về</a>', url()->previous()).
        '<button class="btn btn-info" type="submit"><i class="fa fa-save mr-1"></i>Lưu thông tin</button>';
    }
    if($pageIndex == true) {
        $pageButton = sprintf('<a href="%s" class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm mới</a>', route($controllerName . '/form'));
    }
@endphp

<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>{{ $pageTitle }}</h3>
    </div>
    @if(!(isset($nonButton) && $nonButton))
        <div class="zvn-add-new pull-right">
            @if(isset($ordering) && $ordering)
                <button type="button" class="btn btn-warning btn-update" data-type="ordering"><i class="fa fa-refresh"></i> Sắp xếp</button>
            @endif
            {!! $pageButton !!}
        </div>
    @endif
</div>