@extends('admin.main')
@php
    use App\Helpers\Template as Template;
    $user = session('userInfo');
@endphp

@section('content')

    @include ('admin.templates.page_header', ['pageIndex' => true, 'nonButton' => true])
    @include ('admin.templates.zvn_notify')

    @if(in_array($user['level'], [1,2]))
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    @include('admin.templates.x_title', ['title' => 'Upload file'])
                    <div class="x_content">
                        @include('admin.pages.files.form', ['item' => null])
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Danh sách'])
                @include('admin.pages.files.list')
            </div>
        </div>
    </div>

    @if (count($items) > 0 && $user['level'] == 1)
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
