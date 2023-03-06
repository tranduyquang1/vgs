@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');
    $item = json_decode($item['value'],true);
    $elements = [
        [
            'label'   => Form::label('meta_title', 'Meta title', $formLabelAttr),
            'element' => Form::text('meta_title', $item['meta_title'],  $formInputAttr),
        ],
        [
            'label'   => Form::label('meta_description', 'Meta description', $formLabelAttr),
            'element' => Form::textarea('meta_description', $item['meta_description'],  $formInputAttr),
        ],
        [
            'label'   => Form::label('meta_keyword', 'Meta keyword', $formLabelAttr),
            'element' => Form::textarea('meta_keyword', $item['meta_keyword'],  $formInputAttr),
        ],
        [
            'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
            'type'     => "btn-submit"
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
        {!! Form::hidden ('key_value', 'setting-seo') !!}
        {!! Form::close() !!}
    </div>
</div>