@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');

    $item = $item->value;

    $elementsAccount  = [
        [
            'label'   => Form::label('facebook', 'Facebook', $formLabelAttr),
            'element' => Form::text('facebook', @$item['facebook'],  $formInputAttr),
        ],
        [
            'label'   => Form::label('youtube', 'Youtube', $formLabelAttr),
            'element' => Form::text('youtube', @$item['youtube'],  $formInputAttr),
        ],
        [
            'label'   => Form::label('instagram', 'Instagram', $formLabelAttr),
            'element' => Form::text('instagram', @$item['instagram'],  $formInputAttr),
        ],
        [
            'label'   => Form::label('twitter', 'Twitter', $formLabelAttr),
            'element' => Form::text('twitter', @$item['twitter'],  $formInputAttr),
        ],
        [
            'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
            'type'      => "btn-submit"
        ]
    ];

@endphp

<div class="x_panel">
    @include ('admin.templates.x_title', ['title' => ""])
    <div class="x_content">
        {!! Form::open([
               'method'  => 'POST',
               'url'     => route("admin.$controllerName.save"),
               'enctype' => 'multipart/form-data',
               'class'   => 'form-horizontal form-label-left',
               'id'      => 'email-account-form'
           ]) !!}
        {!! FormTemplate::show($elementsAccount) !!}
        {!! Form::hidden ('key_value', 'setting-social') !!}
        {!! Form::close() !!}
    </div>
</div>