@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');
        $formInputAttrCkEditor = ['class' => $formInputAttr['class'].' ckeditor', 'id' => 'ckeditor'];
        $postStatusValues = config('zvn.template.post_status');
        $postFormatValues = config('zvn.template.post_format');

        $elementsInfo = [
           [
               'label'   => Form::label('title', 'Tiêu đề', $formLabelAttr),
               'element' => Form::text('title', @$item['title'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('excerpt', 'Mô tả', $formLabelAttr),
               'element' => Form::text('excerpt', @$item['excerpt'],  $formInputAttr),
           ],
           [
                'label'   => Form::label('content', 'Nội dung', $formLabelAttr),
                'element' => Form::textarea('content', @$item['content'],  $formInputAttrCkEditor)
           ],
           [
                'label'   => Form::label('thumbnail', 'Hình ảnh', $formLabelAttr),
                'element' => Form::file('thumbnail', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item['thumbnail']) ? Template::showItemThumb($controllerName, @$item['thumbnail'], @$item['title']) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
           ]
        ];

        $elementsType = [
            [
               'label'   => Form::label('category_id', 'Danh mục', $formLabelAttr),
               'element' => Form::select('category_id', $categories, @$item['category_id'] ?? 0, ['class' => $formInputAttr['class'] . ' select-category'])
            ],
            [
                'label'   => Form::label('statusâ', 'Trạng thái', $formLabelAttr),
                'element' => Form::select('status', $postStatusValues, @$item['status'],  ['class' => $formInputAttr['class'], 'placeholder' => '-- Chọn giá trị --'])
            ],
            [
                'label'   => Form::label('format', 'Định dạng', $formLabelAttr),
                'element' => Form::select('format', $postFormatValues, @$item['format'],  ['class' => $formInputAttr['class'], 'placeholder' => '-- Chọn giá trị --'])
            ],
            [
               'label'   => Form::label('youtube_url', 'Link video Youtube', $formLabelAttr),
               'element' => Form::text('youtube_url', @$item['youtube_url'],  $formInputAttr),
            ],
            [
                'label'   => Form::label('is_hot_news', 'Tin tiêu điểm', $formLabelAttr),
                'element' => [
                    'Kích hoạt'       => Form::radio('is_hot_news', 1, (1 === @$item['is_hot_news'])),
                    'Chưa kích hoạt'  => Form::radio('is_hot_news', 0, (0 === @$item['is_hot_news'] || empty(@$item['is_hot_news']))),
                ],
                'type'    => 'radio'
            ],
            [
                'label'   => Form::label('is_on_slider', 'Tin ở slider', $formLabelAttr),
                'element' => [
                    'Kích hoạt'       => Form::radio('is_on_slider', 1, (1 === @$item['is_on_slider'])),
                    'Chưa kích hoạt'  => Form::radio('is_on_slider', 0, (0 === @$item['is_on_slider'] || empty(@$item['is_on_slider']))),
                ],
                'type'    => 'radio'
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
                @include ('admin.templates.x_title', ['title' => ""])
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
                    <hr>
                    {!! FormTemplate::show($elementsType) !!}
                    <hr>
                    {!! FormTemplate::show($elementsSeo) !!}
                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden('thumb_current', @$item['thumbnail']) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


