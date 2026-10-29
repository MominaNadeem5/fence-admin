@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Pagination">
        <span class="pagination-info">
            Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}
        </span>

        <div class="pagination-links">
            @if ($paginator->onFirstPage())
                <span class="page-link disabled">&larr; Previous</span>
            @else
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr; Previous</a>
            @endif

            <span class="page-link current">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

            @if ($paginator->hasMorePages())
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &rarr;</a>
            @else
                <span class="page-link disabled">Next &rarr;</span>
            @endif
        </div>
    </nav>
@endif
