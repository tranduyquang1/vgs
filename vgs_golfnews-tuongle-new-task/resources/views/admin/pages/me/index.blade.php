@extends('admin.main')
@section('content')
    @include ('admin.templates.page_header', ['pageIndex' => false, 'isBack' => false])
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
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
                   'label'   => Form::label('', 'Email', $formLabelAttr),
                   'element' => Form::text('', @$item['email'],  $formInputAttr + ['disabled' => true]),
                ]
            ];

            $elementsPassword = [
                [
                    'label'   => Form::label('password_old', 'Mật khẩu hiện tại', $formLabelAttr),
                    'element' => Form::password('password_old', $formInputAttr),
                ],
                [
                    'label'   => Form::label('password_new', 'Mật khẩu mới', $formLabelAttr),
                    'element' => Form::password('password_new', $formInputAttr),
                ],
                [
                    'label'   => Form::label('password_confirmation', 'Xác nhận mật khẩu', $formLabelAttr),
                    'element' => Form::password('password_confirmation',  $formInputAttr),
                ],
                [
                    'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
                    'type'      => "btn-submit"
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
                @include ('admin.templates.x_title', ['title' => "Cập nhật thông tin"])
                <div class="x_content">
                    {!!
                        Form::open(['method' => 'POST',
                           'url' => route("admin.$controllerName.save_info"),
                           'enctype' => 'multipart/form-data',
                           'class' => 'form-horizontal form-label-left',
                           'id' => 'me-info-form'
                        ])
                    !!}
                    {!! FormTemplate::show($elementsInfo) !!}
                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
        <div class="col-xs-12">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Thay đổi mật khẩu"])
                <div class="x_content">
                    {!!
                        Form::open(['method' => 'POST',
                           'url' => route("admin.$controllerName.change_password"),
                           'enctype' => 'multipart/form-data',
                           'class' => 'form-horizontal form-label-left',
                           'id' => 'me-password-form'
                        ])
                    !!}
                    {!! FormTemplate::show($elementsPassword) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection


