<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            <p class="m-b-0">
                <span class="label label-pagination label-info label-pagination">{{ $items->perPage() }} phần tử trên trang</span>
                <span class="label label-pagination label-success label-pagination">
                    @if(in_array($controller, ['CateNews', 'CateProduct'])){{ $items->total() - 1  }} @else  {{ $items->total() }} @endif
                    phần tử
                </span>
                <span class="label label-pagination label-danger label-pagination">{{ $items->lastPage() }} trang</span>
            </p>
        </div>
        <div class="col-md-6">
            {!! $items->appends(request()->input())->links('admin.templates.components.paginator') !!}
        </div>
    </div>
</div>