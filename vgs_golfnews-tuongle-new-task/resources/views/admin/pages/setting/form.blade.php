@extends('admin.main')
@section('content')
    <div class="page-header zvn-page-header">
        <div class="zvn-page-header-title">
            <h3>Cấu hình</h3>
        </div>
    </div>
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <ul class="nav nav-tabs bar_tabs" id="tab-config" role="tablist">
                <ul id="settingTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li @if ($keyValue == 'setting-main') class="active" @endif><a
                                href="{{ route("admin.$controllerName.index", ['key_value' => 'setting-main']) }}"
                                role="tab">Cấu hình chung</a></li>
                    <li @if ($keyValue == 'setting-email') class="active" @endif><a
                                href="{{ route("admin.$controllerName.index", ['key_value' => 'setting-email']) }}"
                                role="tab">Email</a></li>
                    <li @if ($keyValue == 'setting-social') class="active" @endif><a
                                href="{{ route("admin.$controllerName.index", ['key_value' => 'setting-social']) }}"
                                role="tab">Social</a></li>
                    <li @if ($keyValue == 'setting-seo') class="active" @endif><a
                                href="{{ route("admin.$controllerName.index", ['key_value' => 'setting-seo']) }}"
                                role="tab">SEO</a></li>
                </ul>
            </ul>
            <div class="tab-content" id="tab-config-content">
                <div class="tab-pane fade active in" role="tabpanel">
                    @switch($keyValue)
                        @case('setting-main')
                        @include("admin.pages.$controllerName.child.form-general", ['item' => $item])
                        @break
                        @case('setting-email')
                        @include("admin.pages.$controllerName.form-email", ['item' => $item])
                        @break
                        @case('setting-social')
                        @include("admin.pages.$controllerName.child.form-social", ['item' => $item])
                        @break
                        @case('setting-seo')
                        @include("admin.pages.$controllerName.child.form-seo", ['item' => $item])
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
@endsection

