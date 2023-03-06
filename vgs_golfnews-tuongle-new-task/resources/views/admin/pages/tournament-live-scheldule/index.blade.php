@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Template;
        use App\Models\BannersCategories;
        use App\Models\TournamentCategories;

        $listTournamentCategory = TournamentCategories::get();
        $listPage = [];
        if($listTournamentCategory){
            foreach ($listTournamentCategory as $key => $value) {
                $listPage[$value['id']] = $value['name'];
            }
        }
        // $xhtmlButtonFilter = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search'],'status_tiny_int_with_all');
        $xhtmlAreaSearch    = Template::showAreaSearch($controllerName, $params['search']);

        $pageSelect = ['default' => '-- Chọn trang hiển thị --'] + $listPage;


        $xhtmlSelectPage = Template::showSelectFilterCustom('tournament_categories_id', $pageSelect, @$params['filter']['tournament_categories_id'], false);

    @endphp

    @include ('admin.templates.page_header', ['pageIndex' => true, 'isBack' => false])
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Bộ lọc"])
                <div class="x_content">
                    <div class="row">
                        {{-- <div class="col-md-6">{!! $xhtmlButtonFilter !!}</div> --}}
                        <div class="col-md-6">{!! $xhtmlAreaSearch !!}</div>
                    </div>
                    <div class="d-flex">
                        <div>
                            <h5 class="text-center">Lọc theo trang hiển thị</h5>
                            {!! $xhtmlSelectPage !!}
                        </div>
                        {{-- <div>
                            <h5 class="text-center">Lọc theo banner mobile</h5>
                            {!! $xhtmlSelectMobile !!}
                        </div> --}}
                    </div>
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