@extends('admin.main')
@php
    use App\Helpers\Template as Template;
    $user = session('userInfo');
@endphp

@section('content')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="mt-3 col-md-12 text-right">
            @if(in_array($user['level'], [1, 2]))
                <button type="button" class="btn btn-success btn-view-add" data-url="{{ route('files/add', ['files_id' => request()->id]) }}">Thêm mới</button>
            @endif
            @if(in_array($user['level'], [1, 2]))
                <a href="{{ route('files/export', ['id' => request()->id]) }}" class="btn btn-info">Xuất Excel</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <ul class="nav nav-tabs bar_tabs" id="tab-sheets" role="tablist">
                @foreach($sheets as $indexSheet => $sheet)
                    <li role="presentation" class="@if($indexSheet == 0 && !request()->get('sheetId') || request()->get('sheetId') && request()->get('sheetId') == $sheet->id) active @endif">
                        <a id="sheets-{{ $sheet->id }}-tab" data-toggle="tab" href="#sheets-{{ $sheet->id }}" role="tab"
                           aria-controls="sheets-{{ $sheet->id }}" aria-selected="true">
                            {{ $sheet->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="tab-sheets-content">
                @foreach($sheets as $indexSheet => $sheet)
                    <div class="tab-pane fade @if($indexSheet == 0 && !request()->get('sheetId') || request()->get('sheetId') && request()->get('sheetId') == $sheet->id) active in @endif" id="sheets-{{ $sheet->id }}"
                         role="tabpanel" aria-labelledby="sheets-{{ $sheet->id }}-tab">
                        <div class="x_panel table-scroll">
                            <div class="x_content">
                                @if($showFileName)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="mb-1"><b>Tên file: </b> {{ $sheet->file()->first()->file }}</h4>
                                            <h4 class="mb-3"><b>Mô tả: </b>  {{ $sheet->file()->first()->description }}</h4>
                                        </div>
                                    </div>
                                @endif
                                <div class="d-flex">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                            @switch($user['level'])
                                            @case(1)
                                            @case(2)
                                                @include('admin.pages.files.title.admin')
                                                @break
                                            @case(3)
                                                @include('admin.pages.files.title.qc')
                                                @break
                                            @case(4)
                                                @include('admin.pages.files.title.viewer')
                                                @break
                                        @endswitch
                                        </thead>
                                        <tbody data-sheet="{{ $sheet->id }}">
                                            @foreach($sheet->company()->get() as $key => $item)
                                                @php
                                                    $index = $key + 1;
                                                @endphp
                                                @switch($user['level'])
                                                    @case(1)
                                                    @case(2)
                                                        @include('admin.pages.files.item.admin', ['item' => $item, 'index' => $index])
                                                        @break
                                                    @case(3)
                                                        @include('admin.pages.files.item.qc', ['item' => $item, 'index' => $index])
                                                        @break
                                                    @case(4)
                                                        @include('admin.pages.files.item.viewer', ['item' => $item, 'index' => $index])
                                                        @break
                                                @endswitch
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="company-form-modal" tabindex="-1" role="dialog" aria-labelledby="addFormTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body show-company-form">

                </div>
            </div>
        </div>
    </div>

@endsection
