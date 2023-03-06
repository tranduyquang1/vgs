@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;
        use App\Models\BannersCategory as BannersCategory;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');

        $listBannersCategories[0] ='Chọn chuyên trang';
        $BannersCategories = BannersCategory::where('status',1)->get()->pluck('name', 'id');
        $listBannersCategories=array_merge($listBannersCategories,$BannersCategories->toArray());


        $elementsInfo = [
           [
               'label'   => Form::label('name', 'Tên', $formLabelAttr),
               'element' => Form::text('name', @$item['name'],  $formInputAttr),
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
                'label'   => Form::label('is_home', 'Hiển thị trong trang chủ', $formLabelAttr),
                'element' => [
                    'Có'       => Form::radio('is_home', 1, (1 === @$item['is_home'] )),
                    'Không'  => Form::radio('is_home', 0, (0 === @$item['is_home'] || empty(@$item['is_home']))),
                ],
                'type'    => 'radio'
           ],
           [
                'label'   => Form::label('multi_language', 'Song ngữ', $formLabelAttr),
                'element' => [
                    'Có'       => Form::radio('multi_language', 1, (1 === @$item['multi_language'] )),
                    'Không'  => Form::radio('multi_language', 0, (0 === @$item['multi_language'] || empty(@$item['multi_language']))),
                ],
                'type'    => 'radio'
           ],
           [
               'label'   => Form::label('menu_background_color', 'Mã màu Menu', $formLabelAttr),
               'element' => Form::text('menu_background_color', @$item['menu_background_color'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('site_background_color', 'Mã màu Background', $formLabelAttr),
               'element' => Form::text('site_background_color', @$item['site_background_color'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('amount_slider_posts', 'Số lượng slider posts', $formLabelAttr),
               'element' => Form::number('amount_slider_posts', @$item['amount_slider_posts'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('banner_category_id', 'Chọn Banners chuyên trang', $formLabelAttr),
               'element' => Form::select('banner_category_id', $listBannersCategories, @$item['banner_category_id']?? null, ['class' => $formInputAttr['class'] . ' select-category'])
           ],
           [
                'label'   => Form::label('logo_web_icon', 'Icon website', $formLabelAttr),
                'element' => Form::file('logo_web_icon', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item['logo_web_icon']) ? Template::showItemThumbFull(@$item['logo_web_icon'], @$item['name']) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
            ],
           [
                'label'   => Form::label('logo_menu', 'Logo Menu', $formLabelAttr),
                'element' => Form::file('logo_menu', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item['logo_menu']) ? Template::showItemThumbFull(@$item['logo_menu'], @$item['name']) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
            ],
           [
                'label'   => Form::label('logo_home', 'Logo Homepage', $formLabelAttr),
                'element' => Form::file('logo_home', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item['logo_home']) ? Template::showItemThumbFull(@$item['logo_home'], @$item['name']) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
            ],

        ];
        $elementsSeo = [
            [
               'label'   => Form::label('meta_title', 'Meta title', $formLabelAttr),
               'element' => Form::text('meta_title', @$item['meta_title'],  $formInputAttr),
            ],
            [
               'label'   => Form::label('meta_description', 'Meta description', $formLabelAttr),
               'element' => Form::textarea('meta_description', @$item['meta_description'],  $formInputAttr),
            ],
            [
               'label'   => Form::label('meta_keyword', 'Meta keyword', $formLabelAttr),
               'element' => Form::textarea('meta_keyword', @$item['meta_keyword'],  $formInputAttr),
            ],
            [
                'label'   => Form::label('logo_seo', 'Thumb SEO', $formLabelAttr),
                'element' => Form::file('logo_seo', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item['logo_seo']) ? Template::showItemThumbFull(@$item['logo_seo'], @$item['name']) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
            ],
           [
               'label'   => Form::label('google_analytics', 'Google_analytics', $formLabelAttr),
               'element' => Form::textarea('google_analytics', @$item['google_analytics'],  $formInputAttr),
            ],
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
                    <h2  style="text-align:center; font-weight:bold">Thông tin SEO</h2>
                    {!! FormTemplate::show($elementsSeo) !!}

                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden('logo_web_icon_current', @$item['logo_web_icon']) !!}
                    {!! Form::hidden('logo_seo_current', @$item['logo_seo']) !!}
                    {!! Form::hidden('logo_menu_current', @$item['logo_menu']) !!}
                    {!! Form::hidden('logo_home_current', @$item['logo_home']) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


