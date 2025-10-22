@php
    // Safe access to slug/id/type
    $slug = $value['slug'] ?? Str::slug($value['name'] ?? ''); // fallback slug
    $type = $value['type'] ?? 'movie';
    $id   = $value['id'] ?? null;
    $isSearch = request()->has('search') ? 1 : null;

    // Generate href based on type
    if ($type === 'tvshow') {
        // TV show route expects slug
        $href = $slug ? route('tvshow-details', ['slug' => $slug] + ($isSearch ? ['is_search' => $isSearch] : [])) : '#';
    } elseif ($type === 'movie') {
        // Movie route expects slug
        $href = $slug ? route('movie-details', ['slug' => $slug] + ($isSearch ? ['is_search' => $isSearch] : [])) : '#';
    } else {
        $href = '#';
    }
@endphp

<div class="iq-card card-hover entainment-slick-card">
    <div class="block-images position-relative w-100">
        <!-- Full card clickable -->
        <a href="{{ $href }}" class="position-absolute top-0 bottom-0 start-0 end-0 w-100 h-100"></a>

        <div class="image-box w-100">
            <img src="{{ $value['poster_image'] ?? $value->poster_image }}" 
                 alt="movie-card" class="img-fluid object-cover w-100 d-block border-0">

            {{-- Pay-per-view badge --}}
            @if(($value['movie_access'] ?? $value->movie_access) == 'pay-per-view')
                @if(\Modules\Entertainment\Models\Entertainment::isPurchased($id, $type))
                    <span class="position-absolute top-0 start-0 m-2 badge bg-success d-flex align-items-center gap-1 px-2 py-1 fs-6">
                        <i class="ph ph-film-reel"></i> {{ __('messages.rented') }}
                    </span>
                @else
                    <span class="position-absolute top-0 start-0 m-2 badge bg-success d-flex align-items-center gap-1 px-2 py-1 fs-6">
                        <i class="ph ph-film-reel"></i> {{ __('messages.rent') }}
                    </span>
                @endif
            @endif

            {{-- Paid plan badge --}}
            @if(($value['movie_access'] ?? $value->movie_access) == 'paid')
                @php
                    $current_user_plan = auth()->user() ? auth()->user()->subscriptionPackage : null;
                    $current_plan_level = $current_user_plan->level ?? 0;
                    $plan_level = $value['plan_level'] ?? 0;
                @endphp
                @if($plan_level > $current_plan_level)
                    <button type="button" class="product-premium border-0" 
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Premium">
                        <i class="ph ph-crown-simple"></i>
                    </button>
                @endif
            @endif
        </div>

        <div class="card-description with-transition">
            <div class="position-relative w-100">
                <ul class="genres-list ps-0 mb-2 d-flex align-items-center gap-5">
                    @php $genres = collect($value['genres'] ?? []); @endphp
                    @foreach($genres->slice(0, 2) as $gener)
                        <li class="small">{{ $gener['name'] ?? '--' }}</li>
                    @endforeach
                </ul>

                <h5 class="iq-title text-capitalize line-count-1">
                    {{ $value['name'] ?? '--' }}
                </h5>

                <div class="d-flex align-items-center gap-3">
                    <div class="movie-time d-flex align-items-center gap-1 font-size-14">
                        <i class="ph ph-clock"></i>
                        {{ ($value['duration'] ?? null) ? formatDuration($value['duration']) : '--' }}
                    </div>
                    <div class="movie-language d-flex align-items-center gap-1 font-size-14">
                        <i class="ph ph-translate"></i>
                        <small>{{ $value['language'] ?? '--' }}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mt-3">
                    <x-watchlist-button 
                        :entertainment-id="$id" 
                        :in-watchlist="$value['is_watch_list'] ?? false" 
                        customClass="watch-list-btn" 
                    />

                    <div class="flex-grow-1">
                        <a href="{{ $href }}" class="btn btn-primary w-100">
                            {{ __('frontend.watch_now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
