@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');
        $bannerPages = config('zvn.banner.page');
        $bannerPositions = config('zvn.banner.position');
        $bannerMobileTypes = ['' => 'Không chọn'] + config('zvn.banner_type');

        $elementsInfo = [
           [
               'label'   => Form::label('name', 'Tên', $formLabelAttr),
               'element' => Form::text('name', @$item['name'],  $formInputAttr),
           ],

           [
                'label'   => Form::label('status', 'Trạng thái', $formLabelAttr),
                'element' => [
                    'Kích hoạt'       => Form::radio('status', 1, (1 === @$item['status'] || empty(@$item['status']))),
                    'Chưa kích hoạt'  => Form::radio('status', 0, (0 === @$item['status'])),
                ],
                'type'    => 'radio'
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
                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


