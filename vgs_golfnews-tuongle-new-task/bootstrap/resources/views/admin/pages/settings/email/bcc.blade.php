@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;
    use App\Helpers\Highlight as Highlight;

    $formInputAttr = config('zvn.template.form_input');
    $formInputAttrSelect2 = ['class' => $formInputAttr['class'].' select-category', 'multiple' => true];
    $formLabelAttr = config('zvn.template.form_label');

    $element  = [
        [
            'label'   => Form::label('email', 'Email', $formLabelAttr),
            'element' => Form::text('email', null,  $formInputAttr),
        ],
        [
            'label'   => Form::label('template[]', 'Template', $formLabelAttr),
            'element' => Form::select('template[]', $arrEmailTemplate, null, $formInputAttrSelect2)
        ],
        [
                'label'   => Form::label('status', 'Trạng thái', $formLabelAttr),
                'element' => [
                    'Kích hoạt'  => Form::radio('status', 'active', true),
                    'Chưa kích hoạt'  => Form::radio('status', 'inactive'),
                ],
                'type'    => 'radio'
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
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Template</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @if (count($emailBcc) > 0)
                    @foreach ($emailBcc as $key => $val)
                        @php
                            $index  = $key + 1;
                            $class  = ($index % 2 == 0) ? "odd" : "even";
                            $email                  = $val['email'];
                            $templateIds = !empty($val['template']) ? json_decode($val['template'], true) : [];
                            $template               = Template::showItemSelect2('emailBcc', $val['id'], $arrEmailTemplate, $templateIds, 'template', false);
                            $status                 = Template::showItemButton('emailBcc', $val['id'], $val['status'], 'status');
                            $listBtnAction          = Template::showButtonAction('emailBcc', $val['id']);
                        @endphp

                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td>{{ $email }}</td>
                            <td width="50%">{!! $template !!}</td>
                            <td>{!! $status !!} </td>
                            <td class="last">{!! $listBtnAction !!}</td>
                        </tr>
                    @endforeach
                @else
                    @include ('admin.templates.list_empty', ['colspan' => 5])
                @endif
                </tbody>
            </table>
        </div>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#bccModal">
            Thêm BCC mới
        </button>
    </div>
</div>

<div class="modal fade" id="bccModal" style="margin-top: 50px">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Thêm Email Bcc</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open([
                               'method'  => 'POST',
                               'url'     => route("emailBcc/save"),
                               'enctype' => 'multipart/form-data',
                               'class'   => 'form-horizontal form-label-left',
                               'id'      => 'email-bcc-form'
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