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
        $listLanguage = [
            '0' => 'Tiếng Việt',
            '1' => 'English',
        ];

        $elementsInfo = [

           [
                'label'   => Form::label('tournament_categories_id', 'Chuyên trang', $formLabelAttr),
                'element' => Form::select('tournament_categories_id', $listTournamentCategory, @$item['tournament_categories_id'], $formInputAttr),
           ],
           [
               'label'   => Form::label('date', 'Ngày', $formLabelAttr),
               'element' => Form::text('date', @$item['date'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('time', 'Thời gian', $formLabelAttr),
               'element' => Form::text('time', @$item['time'],  $formInputAttr),
           ],
           [
               'label'   => Form::label('activities', 'Hoạt động', $formLabelAttr),
               'element' => Form::text('activities', @$item['activities'],  $formInputAttr),
           ],
           
           [
               'label'   => Form::label('language', 'Ngôn ngữ', $formLabelAttr),
               'element' => Form::select('language', $listLanguage, @$item['language'], $formInputAttr)
           ],
           [
               'label'   => Form::label('order', 'Thứ tự', $formLabelAttr),
               'element' => Form::number('order', @$item['order'], $formInputAttr)
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
                           'id' => 'tournament-live-scheldule-form'
                        ])
                    !!}
                    {!! FormTemplate::show($elementsInfo) !!}
                    {!! FormTemplate::show($submit) !!}
                    {!! Form::hidden ('id', @$item['id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


