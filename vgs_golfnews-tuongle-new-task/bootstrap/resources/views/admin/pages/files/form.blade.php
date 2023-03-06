@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');

    $inputHiddenID    = Form::hidden('id', $item['id']);
    $inputHiddenThumb = Form::hidden('file_current', $item['thumb']);

    $elements = [
        [
            'label'   => Form::label('description', 'Mô tả', $formLabelAttr),
            'element' => Form::text('description', $item['description'],  $formInputAttr )
        ],
        [
            'label'   => Form::label('file', 'Tập tin', $formLabelAttr),
            'element' => Form::file('file', $formInputAttr ),
            'thumb'   => (!empty($item['id'])) ? Template::showItemFile($controllerName, $item['file']) : null,
            'type'    => "thumb"
        ],
        [
            'element' => $inputHiddenID . $inputHiddenThumb . Form::submit('Save', ['class'=>'btn btn-success']),
            'type'    => "btn-submit"
        ]
    ];
@endphp

@include ('admin.templates.error')
{{ Form::open([
                'method'         => 'POST',
                'url'            => route("$controllerName/save"),
                'accept-charset' => 'UTF-8',
                'enctype'        => 'multipart/form-data',
                'class'          => 'form-horizontal form-label-left',
                'id'             => 'main-form'])
                }}
{!! FormTemplate::show($elements)  !!}
{{ Form::close() }}
