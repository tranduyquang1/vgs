@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');
    $level = config('zvn.user_level');

    $elementsInfo = [
        [
           'label'   => Form::label('name', 'Họ tên', $formLabelAttr),
           'element' => Form::text('name', @$item['name'],  $formInputAttr),
        ],
        [
           'label'   => Form::label('email', 'Email', $formLabelAttr),
           'element' => Form::text('email', @$item['email'],  $formInputAttr),
        ],
        [
           'label'   => Form::label('password', 'Password', $formLabelAttr),
           'element' => Form::text('password', @$item['password'],  $formInputAttr),
        ],
        [
           'label'   => Form::label('level', 'Level', $formLabelAttr),
           'element' => Form::select('level', $level, @$item['level'], $formInputAttr)
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

    $submit = [
        [
            'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
            'type'      => "btn-submit"
        ]
    ];

@endphp

<div class="col-xs-12">
    <div class="x_panel">
        @include ('admin.templates.x_title', ['title' => "Thêm mới"])
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