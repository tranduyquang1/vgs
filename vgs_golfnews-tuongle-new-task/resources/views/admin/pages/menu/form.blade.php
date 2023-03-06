@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;
        use App\Models\TournamentCategories;

        $listTournamentCategories[0] ='Chọn chuyên trang';
        $TournamentCategories = TournamentCategories::where('status',1)->get()->pluck('name', 'id');
        foreach ($TournamentCategories as $key => $value) {
            $listTournamentCategories[$key]=$value;
        }
        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');
        $menuTypes = config('zvn.menu_type');
        $elementsInfo = [
           [
               'label'   => Form::label('name', 'Tên (*)', $formLabelAttr),
               'element' => Form::text('name', @$item['name'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('parent_id', 'Danh mục cha', $formLabelAttr),
               'element' => Form::select('parent_id', $parents, @$item['parent_id'] ?? 1, ['class' => $formInputAttr['class'] . ' select-category'])
           ],
           [
               'label'   => Form::label('type', 'Loại menu', $formLabelAttr),
               'element' => Form::select('type', $menuTypes, @$item['type'], ['class' => $formInputAttr['class'] . ' select-category'])
           ],
           [
                'label'   => Form::label('is_special_page', 'Loại trang', $formLabelAttr),
                'element' => [
                    'Mặc định'  => FormTemplate::radioShowModalSpecialPage('is_special_page','is_special_page', 0,'', (0 === @$item['is_special_page'] || @$item['is_special_page']==null) ? 'checked': '',""),
                    'Chuyên trang'   => FormTemplate::radioShowModalSpecialPage('is_special_page','is_special_page', 1,'', (1 === @$item['is_special_page'])? 'checked': '',"data-toggle='modal' data-target='#special-page-modal'"),
                ],
                'type'    => 'radio-show-modal-menu',
            ],
           
           [
               'label'   => Form::label('link', 'Link', $formLabelAttr),
               'element' => Form::text('link', @$item['link'] ?? '#',  $formInputAttr),
           ],
           [
               'label'   => Form::label('category_id', 'Danh mục', $formLabelAttr),
               'element' => Form::select('category_id', $categories, @$item['category_id'] ?? 0, ['class' => $formInputAttr['class'] . ' select-category', 'placeholder' => 'Chọn danh mục'])
           ],
           [
                'label'   => Form::label('status', 'Trạng thái', $formLabelAttr),
                'element' => [
                    'Kích hoạt'       => Form::radio('status', 1, (1 === @$item['status'] || empty(@$item['status']))),
                    'Chưa kích hoạt'  => Form::radio('status', 0, (0 === @$item['status'])),
                ],
                'type'    => 'radio'
           ]
        ];
        $elmentsSpecialPage =[
            [
               'label'   => Form::label('tournament_categories_id', 'Chọn chuyên trang', $formLabelAttr),
               'element' => Form::select('tournament_categories_id', $listTournamentCategories, @$item['tournament_categories_id']?? null, ['class' => $formInputAttr['class'] . ' select-category'])
           ],
        ];
        $submit = [
            [
                'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
                'type'      => "btn-submit"
            ]
        ];

    @endphp


    @include ('admin.templates.page_header', ['pageIndex' => false, 'isBack' => true])
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Form"])
                <div class="x_content">
                    {!!
                        Form::open(['method' => 'POST',
                           'url' => route("admin.$controllerName.save"),
                           'enctype' => 'multipart/form-data',
                           'class' => 'form-horizontal form-label-left',
                           'id' => 'category-form'
                        ])
                    !!}
                    {!! FormTemplate::show($elementsInfo) !!}
                    <div class="modal fade" id="special-page-modal" tabindex="-1" role="dialog" aria-labelledby="toddlersLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="toddlersLabel">Thông tin chuyên trang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                {!! FormTemplate::show($elmentsSpecialPage) !!}
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" >OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


