@if ($paginator->hasPages())
    <nav class="pagination-wrap hstack gap-2">
        <ul class="pagination listjs-pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="page-item pagination-prev disabled" href="#">
                    @lang('pagination.previous')
                </a>
            @else
                <li>
                    <a
                        class="page-item pagination-prev"
                        href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        aria-label="@lang('pagination.previous')"
                    >@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true">
                        <span>{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page">

                                <a class="page" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @else
                            <li>
                                <a class="page" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a
                        class="page-item pagination-next"
                        href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                        aria-label="@lang('pagination.next')"
                    >@lang('pagination.next')</a>
                </li>
            @else
                <a
                    class="page-item pagination-next disabled"
                    href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    aria-label="@lang('pagination.next')"
                >@lang('pagination.next')</a>
            @endif
        </ul>
    </nav>
@endif
