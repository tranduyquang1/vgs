@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;

    $formInputAttr = config('zvn.template.form_input');
    $formInputAttrCkEditor = ['class' => $formInputAttr['class'].' ckeditor', 'id' => 'ckeditor'];
    $formLabelAttr = config('zvn.template.form_label');
    $formCkeditor  = config('zvn.template.form_ckeditor');
    $statusValue      = ['default' => 'Select status', 'active' => config('zvn.template.status.active.name'), 'inactive' => config('zvn.template.status.inactive.name')];

    $inputHiddenID    = Form::hidden('id', $item['id']);
    $inputHiddenThumb = Form::hidden('thumb_current', $item['thumb']);
    $category = ['default' => '-- Chọn danh mục --'] + $cateNews;

    $elements = [
        [
            'label'   => Form::label('name', 'Tên', $formLabelAttr),
            'element' => Form::text('name', $item['name'],  $formInputAttr )
        ],
        [
               'label'   => Form::label('name', 'Slug', $formLabelAttr),
               'element' => Form::text('slug', $item['slug'],  $formInputAttr),
        ],
        [
            'label'   => Form::label('description', 'Mô tả', $formLabelAttr),
            'element' => Form::textArea('description', $item['description'],  $formInputAttr )
        ],
        [
            'label'   => Form::label('content', 'Nội dung', $formLabelAttr),
            'element' => Form::textArea('content', $item['content'],  $formInputAttrCkEditor )
        ],
        [
            'label'   => Form::label('type', 'Trạng thái', $formLabelAttr),
            'element' => [
                    'Kích hoạt'       => Form::radio('status', 'active', ('active' == $item['status'] || empty($item['status']))),
                    'Chưa kích hoạt'  => Form::radio('status', 'inactive', ('inactive' == $item['status'])),
            ],
            'type'    => 'radio'
        ],
        [
           'label'   => Form::label('status', 'Kiểu bài', $formLabelAttr),
           'element' => [
                    'Bình thường' => Form::radio('type', 'normal', ('normal' == $item['type'] || empty($item['type']))),
                    'Nổi bậc'  => Form::radio('type', 'featured', ('featured' == $item['type'])),
           ],
           'type'    => 'radio'
        ],
        [
            'label'   => Form::label('category_id', 'Danh mục', $formLabelAttr),
            'element' => Form::select('category_id', $category, $item['category_id'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('thumb', 'Thumb (Kích thước: 1200x628)', $formLabelAttr),
            'element' => Form::file('thumb', $formInputAttr ),
            'thumb'   => (!empty($item['id'])) ? Template::showItemThumb($controllerName, $item['thumb'] ?? 'default.jpg', $item['name']) : null ,
            'type'    => "thumb"
        ]
    ];
@endphp

@section('content')
    {{ Form::open([
                        'method'         => 'POST',
                        'url'            => route("$controllerName/save"),
                        'accept-charset' => 'UTF-8',
                        'enctype'        => 'multipart/form-data',
                        'class'          => 'form-horizontal form-label-left',
                        'id'             => 'main-form' ])  }}

    @include ('admin.templates.page_header', ['pageIndex' => false])
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Form'])
                <div class="x_content">
                    {!! FormTemplate::show($elements)  !!}
                    {!! Form::hidden ('thumb_current', $item['thumb']) !!}
                    {!! Form::hidden ('id', $item['id']) !!}
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
