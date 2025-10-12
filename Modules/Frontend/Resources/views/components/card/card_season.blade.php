
<div class="iq-card card-hover">

    <div class="block-images position-relative w-100">

        @if(isset($is_search) && $is_search==1 )
            <a href="{{ isset($value['season_id']) ? route('episode-details', ['id' => $value['id'], 'is_search' => request()->has('search') ? 1 : null])
                : route('tvshow-details', ['id' => $value['entertainment_id'], 'is_search' => request()->has('search') ? 1 : null]) }}"
                    class="position-absolute top-0 bottom-0 start-0 end-0 w-100 h-100">
            </a>
        @else
            <a href="{{ isset($value['season_id'])
                ? route('episode-details', ['id' => $value['id']])
                : route('tvshow-details', ['id' => $value['entertainment_id']]) }}"
                class="position-absolute top-0 bottom-0 start-0 end-0 w-100 h-100">
            </a>
        @endif
        <div class="image-box w-100">
            <img src="{{ $value['poster_image'] }}" alt="movie-card" class="img-fluid object-cover w-100 d-block border-0">
            @if($value['access'] == 'pay-per-view')
                @if(\Modules\Entertainment\Models\Entertainment::isPurchased($value['id'],$value['type']))
                    <!-- Display "RENTED" badge if the movie is purchased -->
                    <span class="position-absolute top-0 start-0 m-2 badge bg-success d-flex align-items-center gap-1 px-2 py-1 fs-6">
                        <i class="ph ph-film-reel"></i> {{ __('messages.rented') }}
                    </span>
                @else
                    <!-- Display "RENT" badge if the movie is available for rent -->
                    <span class="position-absolute top-0 start-0 m-2 badge bg-success d-flex align-items-center gap-1 px-2 py-1 fs-6">
                        <i class="ph ph-film-reel"></i> {{ __('messages.rent') }}
                    </span>
                @endif
            @endif
        </div>
        <div class="card-description with-transition">
            <div class="position-relative w-100">
            <ul class="genres-list ps-0 mb-2 d-flex align-items-center gap-5">
                @if(isset($value['season_id']))
                    <li class="small">{{ __('movie.episode') }}</li>
                @else
                    <li class="small">{{ __('movie.lbl_season') }}</li>
                @endif
            </ul>

            <h5 class="iq-title text-capitalize line-count-1"> {{ $value['name']  ?? '--'}} </h5>
            <div class="d-flex align-items-center gap-3">

            </div>
            <div class="d-flex align-items-center gap-3 mt-3  font-size-14">

                <div class="flex-grow-1">
                    <a href="{{ isset($value['season_id']) ? route('episode-details', ['id' => $value['id']]) : route('tvshow-details', ['id' => $value['entertainment_id']]) }}"
                        class="btn btn-primary w-100">
                        {{ __('frontend.watch_now') }}
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
