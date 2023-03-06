@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;

    $formInputAttr = config('zvn.template.form_input');
    $formInputAttrCkEditor = ['class' => $formInputAttr['class'].' ckeditor', 'id' => 'ckeditor'];
    $formLabelAttr = config('zvn.template.form_label');

    $item = $item->value;
    $elements = [
        [
            'label'   => Form::label('company_name', 'Tên CTY', $formLabelAttr),
            'element' => Form::text('company_name', @$item['company_name'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('address', 'Địa chỉ', $formLabelAttr),
            'element' => Form::text('address', @$item['address'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('address_hcm', 'Địa chỉ HCM', $formLabelAttr),
            'element' => Form::text('address_hcm', @$item['address_hcm'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('hotline', 'Hotline', $formLabelAttr),
            'element' => Form::text('hotline', @$item['hotline'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('url_price_quotation', 'Link báo giá Ads', $formLabelAttr),
            'element' => Form::text('url_price_quotation', @$item['url_price_quotation'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('home_video', 'Bài viết trung tâm (ID)', $formLabelAttr),
            'element' => Form::text('home_video', @$item['home_video'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('introduce', 'Giới thiệu', $formLabelAttr),
            'element' => Form::textarea('introduce', @$item['introduce'],  $formInputAttrCkEditor)
        ],
        [
            'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
            'type'      => "btn-submit"
        ],
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
                'id'      => 'main-form'
            ]) !!}
        {!! Template::uploadImage('logo', @$item['logo']) !!}
        {!! Template::uploadImage('logo_footer', @$item['logo_footer']) !!}
        {!! FormTemplate::show($elements) !!}
        {!! Form::hidden ('key_value', $keyValue) !!}
        {!! Form::close() !!}
    </div>
</div>