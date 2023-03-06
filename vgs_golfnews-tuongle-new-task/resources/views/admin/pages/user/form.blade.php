@extends('admin.main')
@section('content')
    @include ('admin.templates.page_header', ['pageIndex' => false, 'isBack' => true])
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        @if(@$item->id)
            @include("admin.pages.$controllerName.form-info")
            @include("admin.pages.$controllerName.form-change-password")
        @else
            @include("admin.pages.$controllerName.form-add")
        @endif
    </div>

@endsection


