@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;
        use App\Models\BannersCategory as BannersCategory;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');
        $bannerPages = config('zvn.banner.page');
        $bannerPositions = config('zvn.banner.position');
        $bannerMobileTypes = config('zvn.banner_type');

        $bannerCategory = BannersCategory::where('status',1)->orderBy('id','asc')->get();
        $listBannerCategory[0]= 'Chọn trang'; 
        if($bannerCategory){

            foreach ($bannerCategory as $key => $value) {
                $listBannerCategory[$value['id']]=$value['name'];
                
        }

        }
        $listDevice = [
            '10' => 'Chọn thiết bị',
            '0' => 'PC',
            '1' => 'Mobile',
        ];


        $listPosition = [
            '0' => 'Chọn vị trí',
            '1' => 'Banner Top (1522x300)',
            '2' => 'Banner Background (1609x900)',
            '3' => 'Banner Horizontal (1600x200)',
            '4' => 'Banner in post (1600x900)'
    ];
        $elementsInfo = [
           [
               'label'   => Form::label('name', 'Tên', $formLabelAttr),
               'element' => Form::text('name', @$item['name'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('url', 'Link', $formLabelAttr),
               'element' => Form::text('url', @$item['url'],  $formInputAttr),
           ],
           [
                'label'   => Form::label('category_id', 'Chuyên trang', $formLabelAttr),
                'element' => Form::select('category_id', $listBannerCategory, @$item['category_id'], $formInputAttr),
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
               'label'   => Form::label('is_mobile', 'Thiết bị', $formLabelAttr),
               'element' => Form::select('is_mobile', $listDevice, @$item['is_mobile'], $formInputAttr)
           ],
           [
               'label'   => Form::label('position', 'Vị trí', $formLabelAttr),
               'element' => Form::select('position', $listPosition, @$item['position'], $formInputAttr)
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
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


