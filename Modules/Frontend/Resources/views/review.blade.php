@extends('frontend::layouts.master')
@section('content')
<div class="review-page section-spacing-bottom px-0">
    <div class="container-fluid">
        <div class="page-title">
            <h4 class="m-0 text-center">{{__('frontend.all')}} {{__('frontend.reviews')}}</h4>
        </div>
        <div class="row">
            <div class="col-xl-3">
                <div class="row">
                    <div class="col-xl-12 col-lg-4 col-sm-5">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="iq-card">
                                    <div class="block-images position-relative w-100">

                                    <a href="{{$entertainment['type'] == 'tvshow' ? route('tvshow-details', ['id' => $entertainment['id']]) : route('movie-details', ['id' => $entertainment['id']]) }}"  class="position-absolute top-0 bottom-0 start-0 end-0 w-100 h-100"></a>

                                        <!-- <a href="/movie-details" class="position-absolute top-0 bottom-0 start-0 end-0"></a> -->
                                        <div class="image-box w-100">

                                            @php
                                            $current_user_plan =auth()->user() ? auth()->user()->subscriptionPackage : null;
                                            $current_plan_level= $current_user_plan->level ?? 0;
                                            $plan_level= $entertainment['plan_level'];
                                            @endphp
                                    
                                          
                                    

                                            <img src="{{setBaseUrlWithFileName($entertainment->poster_url)}}" alt="movie card" class="img-fluid object-cover w-100 d-block border-0">
                                            @if($plan_level > $current_plan_level)
                                            <span class="product-premium"><i class="ph ph-crown-simple"></i></span>
                                            @endif
                                        </div>
                                        <div class="card-details mt-3">
                                            <h4 class="iq-title text-capitalize line-count-1"> {{ $entertainment->name }}</h4>
                                            <div class="d-flex align-items-center gap-5">
                                                <div class="movie-time">
                                                    <p class="movie-time-text font-size-18 fw-medium mb-0">{{ $entertainment->created_at->format('Y') }}</p>
                                                </div>
                                                <div class="movie-language d-flex align-items-center gap-1">
                                                    <i class="ph-fill ph-star text-warning"></i>
                                                    <p class="font-size-18 fw-medium mb-0">{{ $entertainment->IMDb_rating }}(IMDb)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-8 col-sm-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="ratting-card">
                                    <div class="d-flex align-items-center gap-4 mb-4">
                                        <h2 class="m-0">{{ number_format($averageRating, 1) }}</h2>
                                        <div class="data">
                                            <ul class="list-inline m-0 p-0 d-flex align-items-center gap-1">
                                                <li class="text-warning"><i class="ph-fill ph-star"></i></li>
                                                <li class="text-warning"><i class="ph-fill ph-star"></i></li>
                                                <li class="text-warning"><i class="ph-fill ph-star"></i></li>
                                                <li class="text-warning"><i class="ph-fill ph-star"></i></li>
                                                <li class="text-warning"><i class="ph-fill ph-star"></i></li>
                                            </ul>
                                            <p class="m-0">{{__('frontend.individual_rating')}}</p>
                                        </div>
                                    </div>
                                    @foreach (range(5, 1) as $rating)
                                    <div class="row align-items-center g-3">
                                        <div class="col-xl-2 col-lg-1 col-md-2 col-2">
                                            <span class="d-flex align-items-center gap-2">
                                                <span class="h6 mb-0">{{ $rating }}</span>
                                                <i class="ph-fill ph-star text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="col-xl-7 col-lg-9 col-md-7 col-7">
                                            @php
                                                $percentage = $ratingCounts[$rating] > 0 ? ($ratingCounts[$rating] / $reviewCount) * 100 : 0;
                                            @endphp
                                            <div class="progress w-100 progress-ratings" role="progressbar" aria-label="Basic example" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar @if($rating == 5) bg-success @elseif($rating == 4) bg-success @elseif($rating == 3) bg-warning @elseif($rating == 2) bg-warning @else bg-danger @endif" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-2 col-md-3 col-3 flex-shrink-0">
                                            <span class="text-body">{{ $ratingCounts[$rating] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 mt-xl-0 mt-5">
                <div class="mb-2 d-flex align-items-center justify-content-between">
                    <h5>{{ $entertainment->name }}</h5>
                    <select class="form-control w-auto" id="sort-reviews">
                        <option>Newest</option>
                        <option value="top_star">Top Star</option>
                    </select>
                </div>
                <ul class="list-inline review-list-inner m-0 p-0" id="review-list">

                </ul>
                <div class="card-style-slider shimmer-container">
                    <ul class="list-inline review-list-inner m-0 p-0">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="shimmer-container col mb-3">
                                     <li>   @include('components.card_shimmer_rating')</li>
                                </div>
                            @endfor
                            </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/entertainment.min.js') }}" defer></script>

<script>
    const noDataImageSrc = '{{ asset('img/NoData.png') }}';
     const movie_id = "{{ $entertainment->id ?? '' }}";
    const shimmerContainer = document.querySelector('.shimmer-container');
    const EntertainmentList = document.getElementById('review-list');
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;
    let actor_id= null;
    let moive_id=movie_id;
    let type=null;
    let per_page=3;
   const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');;
    const apiUrl = `${baseUrl}/api/get-rating`;
    const csrf_token='{{ csrf_token() }}'
    let currentSortType = 'newest'; // Default sorting state


</script>

@endsection
