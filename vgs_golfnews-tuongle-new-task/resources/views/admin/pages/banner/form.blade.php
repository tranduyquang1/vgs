@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');
        $bannerPages = config('zvn.banner.page');
        $bannerPositions = config('zvn.banner.position');
        $bannerMobileTypes = ['' => 'Không chọn'] + config('zvn.banner_type');

        $elementsInfo = [
           [
               'label'   => Form::label('name', 'Tên', $formLabelAttr),
               'element' => Form::text('name', @$item['name'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('url', 'Link', $formLabelAttr),
               'element' => Form::text('url', @$item['url'] ?? '#',  $formInputAttr),
           ],
           [
                'label'   => Form::label('page', 'Trang hiển thị', $formLabelAttr),
                'element' => [
                    'Home'      => Form::checkbox('is_home', 1, @$item->is_home),
                    'Category'  => Form::checkbox('is_category', 1, @$item->is_category),
                    'Post'      => Form::checkbox('is_post', 1, @$item->is_post),
                ],
                'type'    => 'checkbox'
           ],
           [
               'label'   => Form::label('position', 'Vị trí hiển thị', $formLabelAttr),
               'element' => Form::select('position', $bannerPositions, @$item['position'], $formInputAttr)
           ],
           [
                'label'   => Form::label('status', 'Trạng thái', $formLabelAttr),
                'element' => [
                    'Kích hoạt'       => Form::radio('status', 1, (1 === @$item['status'] || empty(@$item['status']))),
                    'Chưa kích hoạt'  => Form::radio('status', 0, (0 === @$item['status'])),
                ],
                'type'    => 'radio'
           ],
           [
                'label'   => Form::label('thumb', 'Hình ảnh', $formLabelAttr),
                'element' => Form::file('thumb', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item['thumb']) ? Template::showItemThumbFull(@$item['thumb'], @$item['name']) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
           ]
        ];

        $submit = [
            [
                'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
                'type'      => "btn-submit"
            ]
        ];

    @endphp


    @include ('admin.templates.page_header', ['pageIndex' => false, 'isBack' => true])
    @include ('admin.templates.error')
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                @include ('admin.templates.x_title', ['title' => "Form"])
                <div class="x_content">
                    {!!
                        Form::open(['method' => 'POST',
                           'url' => route("admin.$controllerName.save"),
                           'enctype' => 'multipart/form-data',
                           'class' => 'form-horizontal form-label-left',
                           'id' => 'category-form'
                        ])
                    !!}
                    {!! FormTemplate::show($elementsInfo) !!}
                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden('thumb_current', @$item['thumb']) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::hidden ('is_mobile', 0) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


