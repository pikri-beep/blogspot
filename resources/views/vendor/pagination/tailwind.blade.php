@if ($paginator->hasPages())

<div class="flex items-center justify-between mt-16">

    {{-- PREVIOUS --}}
    @if ($paginator->onFirstPage())

    <span class="text-gray-300">
        ← Previous
    </span>

    @else

    <a href="{{ $paginator->previousPageUrl() }}" class="text-gray-700 hover:text-sky-600 transition">
        ← Previous
    </a>

    @endif

    {{-- NEXT --}}
    @if ($paginator->hasMorePages())

    <a href="{{ $paginator->nextPageUrl() }}" class="text-gray-700 hover:text-sky-600 transition">
        Next →
    </a>

    @else

    <span class="text-gray-300">
        Next →
    </span>

    @endif

</div>

@endif