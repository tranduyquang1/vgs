@extends('admin.main')
@section('content')
    @php
        use App\Helpers\Template as Template;
        use App\Helpers\Highlight as Highlight;
    @endphp
    @include ('admin.templates.page_header', ['pageIndex' => false, 'nonButton' => true])

    <style>
        .panel_toolbox {
            min-width: 15px;
        }
    </style>
@endsection