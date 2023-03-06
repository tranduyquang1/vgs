@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');
        $homepagePosition = config('zvn.category_home_position');


        $elementsInfo = [
            [
               'label'   => Form::label('name', 'Tên', $formLabelAttr),
               'element' => Form::text('name', @$item['name'],  $formInputAttr),
            ],
            [
               'label'   => Form::label('parent_id', 'Danh mục cha', $formLabelAttr),
               'element' => Form::select('parent_id', $categories, @$item['parent_id'] ?? 1, ['class' => $formInputAttr['class'] . ' select-category'])
            ],
            [
               'label'   => Form::label('homepage_position', 'Ví trí xuất hiện ở Homepage', $formLabelAttr),
               'element' => Form::select('homepage_position', $homepagePosition, @$item['homepage_position'] ?? 1, ['class' => $formInputAttr['class'], 'placeholder' => 'Không xuất hiện ở Homepage'])
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

        $elementsSeo = [
            [
               'label'   => Form::label('meta_title', 'Meta title', $formLabelAttr),
               'element' => Form::text('meta_title', @$item['meta_title'],  $formInputAttr),
            ],
            [
               'label'   => Form::label('meta_description', 'Meta description', $formLabelAttr),
               'element' => Form::textarea('meta_description', @$item['meta_description'],  $formInputAttr),
            ],
            [
               'label'   => Form::label('meta_keyword', 'Meta keyword', $formLabelAttr),
               'element' => Form::textarea('meta_keyword', @$item['meta_keyword'],  $formInputAttr),
            ]
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
                    <hr>
                    {!! FormTemplate::show($elementsSeo) !!}
                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


