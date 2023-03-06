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
               'element' => Form::text('title', @$item->title,  $formInputAttr),
            ],
            [
               'label'   => Form::label('excerpt', 'Mô tả', $formLabelAttr),
               'element' => Form::text('excerpt', @$item->excerpt,  $formInputAttr),
            ],
            [
                'label'   => Form::label('content', 'Nội dung', $formLabelAttr),
                'element' => Form::textarea('content', @$item->content,  $formInputAttrCkEditor)
            ],
            [
                'label'   => Form::label('thumbnail', 'Hình ảnh (default - 16x9 - 720px)', $formLabelAttr),
                'element' => Form::file('thumbnail', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item->thumbnail) ? Template::showItemThumb($controllerName, @$item->thumbnail, @$item->title) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
            ],
            [
                'label'   => Form::label('thumbnail_large', 'Hình ảnh (slider - 16x7 - 1920px)', $formLabelAttr),
                'element' => Form::file('thumbnail_large', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item->thumbnail_large) ? Template::showItemThumb($controllerName, @$item->thumbnail_large, @$item->title) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
            ],
            [
                'label'   => Form::label('thumbnail_small', 'Hình ảnh (small - 1x1 - 100px)', $formLabelAttr),
                'element' => Form::file('thumbnail_small', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item->thumbnail_small) ? Template::showItemThumb($controllerName, @$item->thumbnail_small, @$item->title) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
                'type'    => "thumb"
            ],
            [
               'label'   => Form::label('audio', 'Audio', $formLabelAttr),
               'element' => Form::file('audio',  $formInputAttr) . '<p>'.@$item->audio.'</p>',
            ],
        ];

        $elementsType = [
            [
                'label'   => Form::label('language', 'Ngôn ngữ', $formLabelAttr),
                'element' => Form::select('language', [1 =>'Tiếng Anh', 0 =>'Tiếng Việt'], @$item->language, ['class' => $formInputAttr['class'], 'placeholder' => '-- Chọn giá trị --'])
            ],
            [
                'label'   => Form::label('published_at_display', 'Ngày published', $formLabelAttr),
                'element' => Form::datetimeLocal('published_at_display', @$item->published_at_display, $formInputAttr)
            ],
            [
               'label'   => Form::label('category_id', 'Danh mục', $formLabelAttr),
               'element' => Form::select('category_id', $categories, @$item->category_id ?? 0, ['class' => $formInputAttr['class'] . ' select-category'])
            ],
            [
                'label'   => Form::label('format', 'Định dạng', $formLabelAttr),
                'element' => Form::select('format', $postFormatValues, @$item->format,  ['class' => $formInputAttr['class'], 'placeholder' => '-- Chọn giá trị --'])
            ],
            [
               'label'   => Form::label('external_video_url', 'Link video khác', $formLabelAttr),
               'element' => Form::text('external_video_url', @$item->external_video_url,  $formInputAttr),
            ],
            [
               'label'   => Form::label('youtube_url', 'Link video Youtube', $formLabelAttr),
               'element' => Form::text('youtube_url', @$item->youtube_url,  $formInputAttr),
            ],
            /*
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
            */
        ];

        $elementsSeo = [
           [
               'label'   => Form::label('meta_title', 'Meta title', $formLabelAttr),
               'element' => Form::text('meta_title', @$item->meta_title,  $formInputAttr),
           ],
           [
               'label'   => Form::label('meta_description', 'Meta description', $formLabelAttr),
               'element' => Form::textarea('meta_description', @$item->meta_description,  $formInputAttr),
           ],
           [
               'label'   => Form::label('meta_keyword', 'Meta keyword', $formLabelAttr),
               'element' => Form::textarea('meta_keyword', @$item->meta_keyword,  $formInputAttr),
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
                    {!! Form::hidden('thumb_current', @$item->thumbnail) !!}
                    {!! Form::hidden('thumb_large_current', @$item->thumbnail_large) !!}
                    {!! Form::hidden('thumb_small_current', @$item->thumbnail_small) !!}
                    {!! Form::hidden('status', @$item->status ?? 'pending') !!}
                    {!! Form::hidden('audio_current', @$item->audio) !!}
                    {!! Form::hidden ('id', @$item->id) !!}
                    {!! Form::hidden ('user_level', $userLevel) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


