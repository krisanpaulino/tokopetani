@if ($paginator->hasPages())
    {{-- <div class="col-12">
        <div class="pagination d-flex justify-content-center mt-5">
            <a href="#" class="rounded">&laquo;</a>
            <a href="#" class="active rounded">1</a>
            <a href="#" class="rounded">2</a>
            <a href="#" class="rounded">3</a>
            <a href="#" class="rounded">4</a>
            <a href="#" class="rounded">5</a>
            <a href="#" class="rounded">6</a>
            <a href="#" class="rounded">&raquo;</a>
        </div>
    </div> --}}
    {{-- <nav>
        <ul class="pagination"> --}}
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        {{-- <a href="#" class="rounded disabled" aria-label="@lang('pagination.previous')">&laquo;</a> --}}
        {{--
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </li> --}}
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="rounded"
            aria-label="@lang('pagination.previous')">&laquo;</a>
        {{-- <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li> --}}
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <a class="rounded disabled" aria-disabled="true">{{ $element }}</a>

            {{-- <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li> --}}
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a href="#" class="active rounded">{{ $page }}</a>
                    {{-- <li class="active" aria-current="page"><span>{{ $page }}</span></li> --}}
                @else
                    <a href="{{ $url }}" class="rounded">{{ $page }}</a>
                    {{-- <li><a href="{{ $url }}">{{ $page }}</a></li> --}}
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"
            class="rounded">&raquo;</a>
        {{-- <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li> --}}
    @else
        {{-- <a href="#" rel="next" aria-disabled="true" aria-label="@lang('pagination.next')"
            class="disabled rounded">&raquo;</a> --}}
        {{-- <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </li> --}}
    @endif
    {{-- </ul>
    </nav> --}}
@endif
