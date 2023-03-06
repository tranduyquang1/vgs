@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');

    $item = json_decode($item['value'],1);
    $elements = [
        [
            'label'   => Form::label('facebook1', 'Facebook 1', $formLabelAttr),
            'element' => Form::text('facebook1', $item['facebook1'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('facebook1', 'Facebook 2', $formLabelAttr),
            'element' => Form::text('facebook2', $item['facebook2'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('facebook3', 'Facebook 3', $formLabelAttr),
            'element' => Form::text('facebook3', $item['facebook3'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('youtube1', 'Youtube 1', $formLabelAttr),
            'element' => Form::text('youtube1', $item['youtube1'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('youtube2', 'Youtube 2', $formLabelAttr),
            'element' => Form::text('youtube2', $item['youtube2'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('google', 'Email', $formLabelAttr),
            'element' => Form::text('google', $item['google'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('instagram', 'Instagram', $formLabelAttr),
            'element' => Form::text('instagram', $item['instagram'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('twitter', 'Twitter', $formLabelAttr),
            'element' => Form::text('twitter', $item['twitter'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('linkedin', 'Linkedin', $formLabelAttr),
            'element' => Form::text('linkedin', $item['linkedin'],  $formInputAttr)
        ],
        [
            'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
            'type'      => "btn-submit"
        ],
    ];

@endphp

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
    {!! Form::hidden ('key_value', 'setting-social') !!}
    {!! Form::close() !!}
    </div>
</div>