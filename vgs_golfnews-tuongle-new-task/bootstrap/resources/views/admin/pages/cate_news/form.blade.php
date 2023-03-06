@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');

        $elementsInfo = [
           [
               'label'   => Form::label('name', 'Tên', $formLabelAttr),
               'element' => Form::text('name', $item['name'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('name', 'Slug', $formLabelAttr),
               'element' => Form::text('slug', $item['slug'],  $formInputAttr),
           ]
        ];

        $elementsCategory = [
           [
               'label'   => Form::label('parent_id', 'Danh mục cha', $formLabelAttr),
               'element' => Form::select('parent_id', $listMenus, $item['parent_id'], $formInputAttr)
           ]
        ];

        $elementsStatus = [
            [
                'label'   => Form::label('status', 'Trạng thái', $formLabelAttr),
                'element' => [
                    'Kích hoạt'       => Form::radio('status', 'active', ('active' == $item['status'] || empty($item['status']))),
                    'Chưa kích hoạt'  => Form::radio('status', 'inactive', ('inactive' == $item['status'])),
                ],
                'type'    => 'radio'
           ],
        ];

        $elementsSeo = [
           [
               'label'   => Form::label('meta_title', 'Meta title', $formLabelAttr),
               'element' => Form::text('meta_title', $item['meta_title'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('meta_description', 'Meta description', $formLabelAttr),
               'element' => Form::textarea('meta_description', $item['meta_description'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('meta_keyword', 'Meta keyword', $formLabelAttr),
               'element' => Form::textarea('meta_keyword', $item['meta_keyword'],  $formInputAttr),
           ]
       ];

    @endphp


    {!!
        Form::open(['method' => 'POST',
           'url' => route("$controllerName/save"),
           'enctype' => 'multipart/form-data',
           'class' => 'form-horizontal form-label-left',
           'id' => 'category-form'
        ])
    !!}
    @include ('admin.templates.page_header', ['pageIndex' => false])
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Thông tin"])
                <div class="x_content">
                    {!! FormTemplate::show($elementsInfo) !!}
                </div>
            </div>
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "SEO"])
                <div class="x_content">
                    {!! FormTemplate::show($elementsSeo) !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-sm-4">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Trạng thái"])
                <div class="x_content">
                    {!! FormTemplate::show($elementsStatus) !!}
                </div>
            </div>
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Danh mục"])
                <div class="x_content">
                    {!! FormTemplate::show($elementsCategory) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::hidden ('id', $item['id']) !!}
    {!! Form::close() !!}
@endsection


