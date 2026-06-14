@props(['paginator', 'item' => 'data'])

@if (isset($paginator) && $paginator->hasPages())
    <div class="pagination-wrap">
        <div class="pagination-info">
            Menampilkan {{ $paginator->firstItem() ?? 0 }} sampai {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} {{ $item }}
        </div>
        <div>
            {{ $paginator->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endif
