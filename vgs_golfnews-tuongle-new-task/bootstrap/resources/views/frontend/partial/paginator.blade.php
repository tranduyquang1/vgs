@if ($paginator->hasPages())
    <div class="mbp_pagination">
        <ul class="page_navigation">

            <li class="page-item @if ($paginator->onFirstPage()) disabled @endif">
                <a class="page-link" href="{{ '?page='.($paginator->currentPage()-1) ?? 'javascript:void()' }}" tabindex="-1" aria-disabled="true">
                    <span class="flaticon-left-arrow"></span> Trở về
                </a>
            </li>

            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="javascript:void()">{{ $page }} <span class="sr-only">(current)</span></a>
                            </li>
                        @else
                            <li class="page-item"><a class="page-link" href="?page={{ $page }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <li class="page-item @if (!$paginator->hasMorePages()) disabled @endif">
                <a class="page-link" href="{{ '?page='.($paginator->currentPage()+1) ?? 'javascript:void()'}}">Tiếp tục <span class="flaticon-right-arrow-1"></span></a>
            </li>

        </ul>
    </div>

@endif
