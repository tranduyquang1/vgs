@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
        use App\Helpers\Template;
        use App\Models\TournamentCategories ;

        $formInputAttr = config('zvn.template.form_input');
        $formLabelAttr = config('zvn.template.form_label');
        $bannerPages = config('zvn.banner.page');
        $bannerPositions = config('zvn.banner.position');
        $bannerMobileTypes = config('zvn.banner_type');

        $tournamentCategory = TournamentCategories::orderBy('id','asc')->get();
        $listTournamentCategory[0]= 'Chọn trang'; 
        if($tournamentCategory){

            foreach ($tournamentCategory as $key => $value) {
                $listTournamentCategory[$value['id']]=$value['name'];
                
        }

        }
        $listTypePage = [
            '1' => 'Live Stream',
            '2' => 'Live Score',
        ];

        $elementsInfo = [
           [
               'label'   => Form::label('name', 'Tên', $formLabelAttr),
               'element' => Form::text('name', @$item['name'],  $formInputAttr),
           ],
           [
                'label'   => Form::label('tournament_categories_id', 'Chuyên trang', $formLabelAttr),
                'element' => Form::select('tournament_categories_id', $listTournamentCategory, @$item['tournament_categories_id'], $formInputAttr),
           ],
           [
               'label'   => Form::label('url_key', 'Url Livescore (Hoặc Key Youtube)', $formLabelAttr),
               'element' => Form::text('url_key', @$item['url_key'],  $formInputAttr),
           ],
           
           [
               'label'   => Form::label('type', 'Loại trang', $formLabelAttr),
               'element' => Form::select('type', $listTypePage, @$item['type'], $formInputAttr)
           ],
           [
               'label'   => Form::label('content', 'Nội dung text', $formLabelAttr),
               'element' => Form::textarea('content', @$item['content'],  $formInputAttr),
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
                'label'   => Form::label('image', 'Hình ảnh', $formLabelAttr),
                'element' => Form::file('image', ['class' => $formInputAttr['class'] . ' image-upload-with-preview'] ),
                'thumb'   => !empty(@$item['image']) ? Template::showItemThumbFull(@$item['image'], @$item['name']) : Template::showItemThumbUpload('backend/img/image_holder.jpg', 'image preview') ,
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
                           'id' => 'tournament-live-form'
                        ])
                    !!}
                    {!! FormTemplate::show($elementsInfo) !!}
                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden('image_current', @$item['image']) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


