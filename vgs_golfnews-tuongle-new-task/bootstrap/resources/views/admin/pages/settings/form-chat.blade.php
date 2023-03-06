@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;

    $settingMain = \App\Helpers\Fetch::get(public_path('cache/setting-main.json'), true);
    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');

    $item = json_decode($item['value'],1);
    /* Facebook */
    $itemHotline = json_decode($item['hotline'], 1);
    $statusHL = ($itemHotline['status'] == 'active') ? true : false;
    /* Facebook */
    $itemFacebook = json_decode($item['facebook'], 1);
    $statusFB = ($itemFacebook['status'] == 'active') ? true : false;
    /* Zalo */
    $itemZalo = json_decode($item['zalo'], 1);
    $statusZL = ($itemZalo['status'] == 'active') ? true : false;
    /* Service */
    $itemService = json_decode($item['service'], 1);
    $statusSE = ($itemService['status'] == 'active') ? true : false;

     $elementsHotline = [
        [
            'label'   => Form::label('hotline[phone]', 'Số điện thoại', $formLabelAttr),
            'element' => Form::text('hotline[phone]', $settingMain['hotline1'], array_merge($formInputAttr, ['disabled' => true]))
        ],
        [
            'label'   => Form::label('hotline[status]', 'Hiện thị hotline', $formLabelAttr),
            'element' => [
                'Hiện'  => Form::radio('hotline[status]', 'active', $statusHL),
                'Ẩn'    => Form::radio('hotline[status]', 'inactive', !$statusHL),
            ],
            'type'    => 'radio'
        ],
     ];

    $elementsFacebook = [
        [
            'label'   => Form::label('facebook[page_id]', 'Facebook Page ID', $formLabelAttr),
            'element' => Form::text('facebook[page_id]', $itemFacebook['page_id'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('facebook[position]', 'Vị trí hộp chat', $formLabelAttr),
            'element' => Form::select('facebook[position]', config('zvn.template.setting_position'), $itemFacebook['position'], $formInputAttr)
        ],
        [
            'label'   => Form::label('facebook[status]', 'Hiện thị hộp chat', $formLabelAttr),
            'element' => [
                'Hiện'  => Form::radio('facebook[status]', 'active', $statusFB),
                'Ẩn'    => Form::radio('facebook[status]', 'inactive', !$statusFB),
            ],
            'type'    => 'radio'
        ],
     ];

    $elementsZalo = [
        [
            'label'   => Form::label('zalo[page_id]', 'Key Zalo ID', $formLabelAttr),
            'element' => Form::text('zalo[page_id]', $itemZalo['page_id'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('zalo[position]', 'Vị trí hộp chat', $formLabelAttr),
            'element' => Form::select('zalo[position]', config('zvn.template.setting_position'), $itemZalo['position'], $formInputAttr)
        ],
        [
            'label'   => Form::label('zalo[status]', 'Hiện thị hộp chat', $formLabelAttr),
            'element' => [
                'Hiện'  => Form::radio('zalo[status]', 'active', $statusZL),
                'Ẩn'    => Form::radio('zalo[status]', 'inactive', !$statusZL),
            ],
            'type'    => 'radio'
        ],
    ];

    $elementsService = [
        [
            'label'   => Form::label('service[page_id]', 'Mã nhúng', $formLabelAttr),
            'element' => Form::textarea('service[page_id]', $itemService['page_id'],  $formInputAttr)
        ],
        [
            'label'   => Form::label('service[position]', 'Vị trí hộp chat', $formLabelAttr),
            'element' => Form::select('service[position]', config('zvn.template.setting_position'), $itemService['position'], $formInputAttr)
        ],
        [
            'label'   => Form::label('service[status]', 'Hiện thị hộp chat', $formLabelAttr),
            'element' => [
                'Hiện'  => Form::radio('service[status]', 'active', $statusSE),
                'Ẩn'    => Form::radio('service[status]', 'inactive', !$statusSE),
            ],
            'type'    => 'radio'
        ],
    ];

    $elementsSubmit = [
        [
            'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
            'type'      => "btn-submit"
        ],
    ];
@endphp

{!! Form::open([
            'method'  => 'POST',
            'url'     => route("$controllerName/save"),
            'enctype' => 'multipart/form-data',
            'class'   => 'form-horizontal form-label-left',
            'id'      => 'main-form'
        ]) !!}
<div class="x_panel">
    @include ('admin.templates.x_title', ['title' => "Hotline"])
    <div class="x_content">
        {!! FormTemplate::show($elementsHotline) !!}
        {!! FormTemplate::show($elementsSubmit) !!}
    </div>
</div>
<div class="x_panel">
    @include ('admin.templates.x_title', ['title' => "Facebook"])
    <div class="x_content">
        {!! FormTemplate::show($elementsFacebook) !!}
        {!! FormTemplate::show($elementsSubmit) !!}
    </div>
</div>
<div class="x_panel">
    @include ('admin.templates.x_title', ['title' => "Zalo"])
    <div class="x_content">
        {!! FormTemplate::show($elementsZalo) !!}
        {!! FormTemplate::show($elementsSubmit) !!}
    </div>
</div>
<div class="x_panel">
    @include ('admin.templates.x_title', ['title' => "Dịch vụ khác"])
    <div class="x_content">
        {!! FormTemplate::show($elementsService) !!}
        {!! FormTemplate::show($elementsSubmit) !!}
        {!! Form::hidden ('key_value', 'setting-chat') !!}
    </div>
</div>
{!! Form::close() !!}