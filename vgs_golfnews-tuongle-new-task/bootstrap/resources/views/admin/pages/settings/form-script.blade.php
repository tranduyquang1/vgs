@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');

    $item = json_decode($item['value'],1);
    $elements = [
        [
            'label'   => Form::label('script_head', 'Script xuất hiện trong HEAD', $formLabelAttr),
            'element' => Form::textarea('script_head', $item['script_head'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('google_map', 'Google Map', $formLabelAttr),
            'element' => Form::textarea('google_map', $item['google_map'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('google_analyst', 'Google Analyst', $formLabelAttr),
            'element' => Form::textarea('google_analyst', $item['google_analyst'],  $formInputAttr)
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
    {!! Form::hidden ('key_value', 'setting-script') !!}
    {!! Form::close() !!}
    </div>
</div>