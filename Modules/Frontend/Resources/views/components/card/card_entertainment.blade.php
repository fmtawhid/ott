


<div class="iq-card card-hover entainment-slick-card">

    <div class="block-images position-relative w-100">
        @if(isset($is_search) && $is_search==1 )

        <a href="{{ $value['type'] == 'tvshow'
        ? route('tvshow-details', ['id' => $value['id'], 'is_search' => request()->has('search') ? 1 : null])
        : route('movie-details', ['id' => $value['id'], 'is_search' => request()->has('search') ? 1 : null]) }}"
           class="position-absolute top-0 bottom-0 start-0 end-0 w-100 h-100">
      </a>
        @else
        <a href="{{ $value['type'] == 'tvshow' ? route('tvshow-details', ['id' => $value['id']]) : route('movie-details', ['id' => $value['id']]) }}"
            class="position-absolute top-0 bottom-0 start-0 end-0 w-100 h-100">
         </a>
         @endif
      <div class="image-box w-100">
        <img src="{{ $value['poster_image'] }}" alt="movie-card" class="img-fluid object-cover w-100 d-block border-0" >
        @if($value['movie_access'] == 'pay-per-view')
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
        @if($value['movie_access']=='paid' )

        @php
        $current_user_plan =auth()->user() ? auth()->user()->subscriptionPackage : null;
        $current_plan_level= $current_user_plan->level ?? 0;
        @endphp

        @if($value['plan_level'] > $current_plan_level)
        <button type="button" class="product-premium border-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Premium"><i class="ph ph-crown-simple"></i></button>
        @endif
        @endif
    </div>
      <div class="card-description with-transition">
        <div class="position-relative w-100">
        <ul class="genres-list ps-0 mb-2 d-flex align-items-center gap-5">
            @foreach(collect($value['genres'])->slice(0, 2) as $gener)
                <li class="small">{{ $gener['name'] ?? $gener->resource->genre->name  ?? '--' }}</li>
            @endforeach
        </ul>

          <h5 class="iq-title text-capitalize line-count-1"> {{ $value['name']  ?? '--'}} </h5>
          <div class="d-flex align-items-center gap-3">
            <div class="movie-time d-flex align-items-center gap-1 font-size-14">
              <i class="ph ph-clock"></i>
              {{ $value['duration'] ? formatDuration($value['duration']) : '--' }}
            </div>
            <div class="movie-language d-flex align-items-center gap-1 font-size-14">
              <i class="ph ph-translate"></i>
              <small>{{ $value['language'] }}</small>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3 mt-3">
                <x-watchlist-button :entertainment-id="$value['id']" :in-watchlist="$value['is_watch_list']" customClass="watch-list-btn" />

              <div class="flex-grow-1">
                <a href="{{ $value['type'] == 'tvshow' ? route('tvshow-details', ['id' => $value['id']]) : route('movie-details', ['id' => $value['id']]) }}"
                    class="btn btn-primary w-100">
                     {{ __('frontend.watch_now') }}
                 </a>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

