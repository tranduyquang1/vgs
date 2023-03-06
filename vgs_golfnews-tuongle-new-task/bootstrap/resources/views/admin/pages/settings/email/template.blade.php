@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;
    use App\Helpers\Highlight as Highlight;

    $formInputAttr = config('zvn.template.form_input');
    $formLabelAttr = config('zvn.template.form_label');

    $element  = [
        [
            'label'   => Form::label('name', 'Mã', $formLabelAttr),
            'element' => Form::text('name', null,  $formInputAttr),
        ],
        [
            'label'   => Form::label('title', 'Tiêu đề', $formLabelAttr),
            'element' => Form::textarea('title', null,  $formInputAttr),
        ],
        [
            'label'   => Form::label('content', 'Nội dung', $formLabelAttr),
            'element' => Form::textarea('content', null,  $formInputAttr),
        ],
        [
            'element'  => Form::submit('Lưu', ['class'=>'btn btn-success']),
            'type'     => "btn-submit"
        ]
    ];

@endphp
<div class="x_panel">
    @include ('admin.templates.x_title', ['title' => "Cấu hình Email Bcc"])
    <div class="x_content">
        <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#templateModal">
            Thêm Email Template
        </button>
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Tiêu đề</th>
                    <th class="column-title">Nội dung</th>
                </tr>
                </thead>
                <tbody>
                @if (count($emailTemplate) > 0)
                    @foreach ($emailTemplate as $key => $val)
                        @php
                            $index  = $key + 1;
                            $class  = ($index % 2 == 0) ? "odd" : "even";
                            $name               = $val['name'];
                            $title              = Template::showTextareaAjax('emailTemplate', $val['id'], 'title', $val['title'], 'textarea-resize-v');
                            $content            = Template::showTextareaAjax('emailTemplate', $val['id'], 'content', $val['content'], 'textarea-resize-v');
                            $listBtnAction      = Template::showButtonAction('emailTemplate', $val['id']);
                        @endphp

                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td width="35%" class="text-center"><b>{!! $name !!}</b><br> {!! $title !!}</td>
                            <td width="65%"><b></b> <br>{!! $content !!} </td>
                        </tr>
                    @endforeach
                @else
                    @include ('admin.templates.list_empty', ['colspan' => 3])
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="templateModal" style="margin-top: 50px">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Thêm Email Template mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open([
                               'method'  => 'POST',
                               'url'     => route("emailTemplate/save"),
                               'enctype' => 'multipart/form-data',
                               'class'   => 'form-horizontal form-label-left',
                               'id'      => 'email-template-form'
                           ]) !!}
                        {!! FormTemplate::show($element) !!}
                        {!! Form::hidden ('id', '') !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>