@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template as Template;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');

        $elements   = [
            [
                'label'   => Form::label('name', 'Tên', $formLabelAttr),
                'element' => Form::text('name', $item['name'],  $formInputAttr),
            ],
            [
                'label'   => Form::label('status', 'Trạng thái', $formLabelAttr),
                'element' => [
                    'Kích hoạt'       => Form::radio('status', 'active', ('active' == $item['status'] || empty($item['status']))),
                    'Chưa kích hoạt'  => Form::radio('status', 'inactive', ('inactive' == $item['status'])),
                ],
                'type'    => 'radio'
            ],
            [
                'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
                'type'      => "btn-submit"
            ],
        ];
    @endphp

    @include ('admin.templates.page_header', ['pageIndex' => false, 'nonButton' => true])
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Form"])
                <div class="x_content">
                    {!! Form::open([
                            'method'  => 'POST', 
                            'url'     => route("$controllerName/save"),
                            'enctype' => 'multipart/form-data',
                            'class'   => 'form-horizontal form-label-left',
                            'id'      => 'main-form'
                        ]) !!}
                    {!! FormTemplate::show($elements) !!}
                    {!! Form::hidden ('id', $item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
