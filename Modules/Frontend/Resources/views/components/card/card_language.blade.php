<div>
    <a href="{{ route('movies.language', strtolower($popular_language->name)) }}" class="rounded border language-card d-flex align-items-center flex-wrap gap-3 justify-content-center">
        <span class="language-inner">{{ substr($popular_language->name, 0, 1) }}</span>
        <span class="text-capitalize language-title line-count-1">{{ $popular_language->name }}</span>
    </a>
</div> 