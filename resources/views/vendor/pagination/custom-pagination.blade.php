@if ($paginator->hasPages())
    <tr class="footable-paging">
        <td colspan="8">
            <div class="footable-pagination-wrapper">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="footable-page-nav disabled" data-page="first" aria-disabled="true">
                            <a class="footable-page-link" href="#">«</a>
                        </li>
                        <li class="footable-page-nav disabled" data-page="prev" aria-disabled="true">
                            <a class="footable-page-link" href="#">‹</a>
                        </li>
                    @else
                        <li class="footable-page-nav" data-page="first">
                            <a class="footable-page-link" href="{{ $paginator->url(1) }}">«</a>
                        </li>
                        <li class="footable-page-nav" data-page="prev">
                            <a class="footable-page-link" href="{{ $paginator->previousPageUrl() }}">‹</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="footable-page disabled" aria-disabled="true"><a class="footable-page-link" href="#">{{ $element }}</a></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="footable-page visible active" data-page="{{ $page }}" aria-current="page">
                                        <a class="footable-page-link" href="#">{{ $page }}</a>
                                    </li>
                                @else
                                    <li class="footable-page visible" data-page="{{ $page }}">
                                        <a class="footable-page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="footable-page-nav" data-page="next">
                            <a class="footable-page-link" href="{{ $paginator->nextPageUrl() }}">›</a>
                        </li>
                        <li class="footable-page-nav" data-page="last">
                            <a class="footable-page-link" href="{{ $paginator->url($paginator->lastPage()) }}">»</a>
                        </li>
                    @else
                        <li class="footable-page-nav disabled" data-page="next" aria-disabled="true">
                            <a class="footable-page-link" href="#">›</a>
                        </li>
                        <li class="footable-page-nav disabled" data-page="last" aria-disabled="true">
                            <a class="footable-page-link" href="#">»</a>
                        </li>
                    @endif
                </ul>
                <div class="divider"></div>
                <span class="label label-default">{{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>
            </div>
        </td>
    </tr>
@endif
