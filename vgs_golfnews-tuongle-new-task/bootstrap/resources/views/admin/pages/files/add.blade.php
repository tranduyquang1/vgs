@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');
    $formDatepicker = config('zvn.template.form_datepicker_modal');

    $elements = [
        [
               'label'   => Form::label('sheets_id', 'Tab', $formLabelAttr),
               'element' => Form::select('sheets_id', $sheets, null, $formInputAttr)
        ],
        [
            'label'   => Form::label('cont_no', 'Cont No', $formLabelAttr),
            'element' => Form::text('cont_no', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('ngay_xuat_hang', 'Ngày xuất hàng', $formLabelAttr),
            'element' => Form::text('ngay_xuat_hang', null,  $formDatepicker)
        ],
        [
            'label'   => Form::label('tuan_xuat_hang', 'Tuần xuất hàng', $formLabelAttr),
            'element' => Form::text('tuan_xuat_hang', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('art', 'ART', $formLabelAttr),
            'element' => Form::text('art', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('art_theo_kieu_moi', 'ART theo thiết kế mới R02', $formLabelAttr),
            'element' => Form::text('art_theo_kieu_moi', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('ten_ma_hang', 'Tên mã hàng', $formLabelAttr),
            'element' => Form::text('ten_ma_hang', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('revision', 'Revision', $formLabelAttr),
            'element' => Form::text('revision', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('revision_theo_kieu_moi', 'Revision theo thiết kế mới R02', $formLabelAttr),
            'element' => Form::text('revision_theo_kieu_moi', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('code_nm', 'Code NM', $formLabelAttr),
            'element' => Form::text('code_nm', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('so_luong', 'Số lượng', $formLabelAttr),
            'element' => Form::text('so_luong', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('nhan_tuan', 'Nhãn tuần', $formLabelAttr),
            'element' => Form::text('nhan_tuan', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('deviation', 'Deviation', $formLabelAttr),
            'element' => Form::text('deviation', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('chu_cai_cont_noi_bo', 'Chữ cái CONT nội bộ', $formLabelAttr),
            'element' => Form::text('chu_cai_cont_noi_bo', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('qc_kiem', 'Qc kiểm', $formLabelAttr),
            'element' => Form::text('qc_kiem', null,  $formInputAttr )
        ],
        [
            'label'   => Form::label('message', 'Ghi chú', $formLabelAttr),
            'element' => Form::text('message', null,  $formInputAttr )
        ],
        [
            'element' => Form::submit('Save', ['class'=>'btn btn-success']),
            'type'    => "btn-submit"
        ]
    ];
@endphp

{{ Form::open([
                'method'         => 'POST',
                'url'            => route("files/postAdd"),
                'accept-charset' => 'UTF-8',
                'enctype'        => 'multipart/form-data',
                'class'          => 'form-horizontal form-label-left',
                'id'             => 'main-form'])
                }}
{!! FormTemplate::show($elements) !!}
{!! Form::hidden('id', null)  !!}
{{ Form::close() }}
