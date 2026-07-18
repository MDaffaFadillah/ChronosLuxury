@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between py-3">
        <!-- Mobile Navigation -->
        <div class="flex justify-between flex-1 md:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-zinc-650 bg-neutral-900 border border-white/5 rounded cursor-default select-none">
                    {!! __('&laquo; Previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-zinc-350 bg-neutral-900 border border-white/5 rounded hover:text-luxury-gold hover:border-luxury-gold transition duration-300">
                    {!! __('&laquo; Previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-zinc-350 bg-neutral-900 border border-white/5 rounded hover:text-luxury-gold hover:border-luxury-gold transition duration-300">
                    {!! __('Next &raquo;') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-zinc-650 bg-neutral-900 border border-white/5 rounded cursor-default select-none">
                    {!! __('Next &raquo;') !!}
                </span>
            @endif
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
            <div>
                <!-- Page numbers list -->
                <span class="relative z-0 inline-flex shadow-sm gap-2">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('Previous') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-xs font-medium text-zinc-600 bg-neutral-900 border border-white/5 rounded-md cursor-default select-none" aria-hidden="true">&lsaquo;</span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-xs font-semibold text-zinc-400 bg-neutral-900 border border-white/5 rounded-md hover:text-luxury-gold hover:border-luxury-gold transition duration-300" aria-label="{{ __('Previous') }}">&lsaquo;</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-zinc-620 bg-neutral-950 border border-white/5 rounded-md cursor-default select-none" aria-disabled="true">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-black bg-luxury-gold border border-luxury-gold rounded-md cursor-default select-none">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-zinc-400 bg-neutral-900 border border-white/5 rounded-md hover:text-luxury-gold hover:border-luxury-gold transition duration-300" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-xs font-semibold text-zinc-400 bg-neutral-900 border border-white/5 rounded-md hover:text-luxury-gold hover:border-luxury-gold transition duration-300" aria-label="{{ __('Next') }}">&rsaquo;</a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('Next') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-xs font-medium text-zinc-650 bg-neutral-900 border border-white/5 rounded-md cursor-default select-none" aria-hidden="true">&rsaquo;</span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
