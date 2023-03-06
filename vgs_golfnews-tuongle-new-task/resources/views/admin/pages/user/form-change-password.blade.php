@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');
    $level = config('zvn.user_level');

    $elementsInfo = [
        [
           'label'   => Form::label('password', 'Mật khẩu', $formLabelAttr),
           'element' => Form::text('password', '',  $formInputAttr),
        ],
        [
            'label'   => Form::label('password_confirmation', 'Nhập lại mật khẩu', $formLabelAttr),
            'element' => Form::text('password_confirmation', '', $formInputAttr),
        ],
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
        @include ('admin.templates.x_title', ['title' => "Thay đổi mật khẩu"])
        <div class="x_content">
            {!!
                Form::open(['method' => 'POST',
                   'url' => route("admin.$controllerName.change_password"),
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