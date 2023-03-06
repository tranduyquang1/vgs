@extends('admin.main')
@section('content')
    <div class="page-header zvn-page-header">
        <div class="zvn-page-header-title">
            <h3>Cấu hình Email</h3>
        </div>
    </div>
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('admin.pages.settings.form-email', ['item' => $items[0]])
        </div>
    </div>
@endsection

