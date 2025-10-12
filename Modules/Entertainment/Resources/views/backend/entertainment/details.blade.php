@extends('backend.layouts.app')

@section('content')
    <x-back-button-component route="{{ $route }}" />
    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-2">
                    <div class="poster">
                        <img src="{{ $data->poster_url ? $data->poster_url : setDefaultImage($data['poster_url']) }}"
                            alt="{{ $data->name }}" class="img-fluid w-100">
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="details">
                        <h1 class="mb-2">{{ $data->name ?? '-' }}</h1>
                        <p class="mb-3">{!! $data->description ?? '-' !!}</p>
                        <div class="d-flex flex-wrap align-items-center gap-3 gap-xl-5">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0">{{ __('movie.lbl_release_date') }} :</h6>
                                {{ \Carbon\Carbon::parse($data->release_date)->format('d M, Y') ?? '-' }}
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0">{{ __('movie.lbl_duration') }} :</h6>
                                {{ formatDuration($data->duration) ?? '-' }}
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0"ng>{{ __('movie.lbl_trailer_url') }} :</h6>
                                @if ($data->trailer_url != null)
                                    <a href="{{ $data->trailer_url }}" target="_blank"><u>{{ $data->trailer_url }}</u></a>
                                @else
                                    <a> - </a>
                                @endif
                            </div>
                        </div>
                        <hr class="my-5 border-bottom-0">
                        <div class="movie-info">
                            <h5>{{ __('messages.lbl_movie_info') }}</h5>
                            <div class="d-flex flex-wrap align-items-center gap-3 gap-xl-5">
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="m-0">{{ __('movie.lbl_genres') }} :</h6>
                                    @foreach ($data->entertainmentGenerMappings as $mapping)
                                        {{ optional($mapping->genre)->name ?? '-' }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="m-0">{{ __('messages.lbl_languages') }} :</h6>
                                    {{ ucfirst($data->language) ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 border-bottom-0">
                        <div class="rating">
                            <h5>{{ __('dashboard.rating') }}</h5>
                            <div class="d-flex flex-wrap align-items-center gap-3 gap-xl-5">
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="m-0">{{ __('movie.lbl_imdb_rating') }}:</h6>
                                    {{ $data->IMDb_rating ?? '-' }}
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="m-0">{{ __('messages.lbl_content_rating') }} :</h6>
                                    {{ $data->content_rating ?? '-' }}
                                </div>
                            </div>
                        </div>

                        @if ($data->type === 'tvshow')
                            <hr class="my-5 border-bottom-0">
                            <div class="tvshow-details">
                                <h2>{{ __('messages.lbl_tvshow_details') }}</h2>
                                <div class="d-flex flex-wrap align-items-center gap-3 gap-xl-5">
                                    <div class="d-flex align-items-center gap-2">
                                        <h6 class="m-0">{{ __('movie.seasons') }}:</h6>
                                        {{ $data->season->count() ?? '-' }}
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <h6 class="m-0">{{ __('messages.lbl_total_episodes') }}:</h6>
                                        {{ $data->season->sum(function ($season) {return $season->episodes->count();}) ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="cast-crew mt-5 pt-5">
                <div class="actors-directors">
                    <div class="actors">
                        <h3 class="mb-3">{{ __('messages.lbl_actor_actress') }}</h3>
                        <div class="actor-list">
                            @foreach ($data->entertainmentTalentMappings as $talentMapping)
                                @if (optional($talentMapping->talentprofile)->type == 'actor')
                                    <div class="actor">
                                        <img src="{{ setBaseUrlWithFileName(optional($talentMapping->talentprofile)->file_url) }}"
                                            alt="" class="rounded avatar avatar-150">
                                        <h6 class="actor-title mb-0">
                                            {{ optional($talentMapping->talentprofile)->name ?? '-' }}</h6>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="directors mt-5 pt-5">
                        <h3>{{ __('castcrew.directors') }}</h3>
                        <div class="director-list">
                            @foreach ($data->entertainmentTalentMappings as $talentMapping)
                                @if (optional($talentMapping->talentprofile)->type == 'director')
                                    <div class="director">
                                        <img src="{{ setBaseUrlWithFileName(optional($talentMapping->talentprofile)->file_url) }}"
                                            alt="{{ optional($talentMapping->talentprofile)->name }}"
                                            class="rounded avatar avatar-150">
                                        <h6 class="actor-title mb-0">
                                            {{ optional($talentMapping->talentprofile)->name ?? '-' }}</h6>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>



            @php
                $totalReviews = count($data->entertainmentReviews);
                $averageRating = $data->entertainmentReviews->avg('rating');
            @endphp
            <div class="reviews mt-5 pt-5">
                <div class="card-body p-30">
                    <div class="row align-items-center">
                        <div class="col-md-3 col-lg-2">
                            <div class="rating-review-wrapper">
                                <div class="rating-review">
                                    <h2 class="rating-review__title display-4 mb-0">
                                        <span class="rating-review__out-of">{{ round($averageRating, 1) }}</span>/5
                                    </h2>
                                    @php $rating = round($averageRating, 1); @endphp
                                    <div class="rating-icons">
                                        @foreach (range(1, 5) as $i)
                                            <span class="ph-stack" style="width:1em">
                                                <i class="ph-star body-text"></i>
                                                @if ($rating > 0)
                                                    @if ($rating > 0.5)
                                                        <i class="ph-fill ph-star text-warning"></i>
                                                    @else
                                                        <i class="ph-fill ph-star-half text-warning"></i>
                                                    @endif
                                                @else
                                                    <i class="ph ph-star"></i>
                                                @endif
                                                @php $rating--; @endphp
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="rating-review__info d-flex flex-wrap gap-3 mt-4">
                                        <span>{{ $data->entertainmentReviews ? $data->entertainmentReviews->count('rating') : 0 }}
                                            ratings </span><span> and </span>
                                        <span>{{ $data->entertainmentReviews ? $data->entertainmentReviews->filter(fn($review) => $review->review !== null)->count() : 0 }}
                                            reviews</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-10">
                            <ul class="common-list common-list__style2 rating-progress after-none gap-10 list-inline">
                                @php
                                    // Calculate the total number of reviews
                                    $totalReviews = $data->entertainmentReviews->count();

                                    // Define an array for the ratings (1 to 5)
                                    $ratings = [5, 4, 3, 2, 1];
                                @endphp

                                @foreach ($ratings as $rating)
                                    @php
                                        // Calculate the count of each rating
                                        $ratingCount = $data->entertainmentReviews
                                            ->where('rating', (string) $rating . '.0')
                                            ->count('rating');

                                        // Calculate the percentage for each rating
                                        $percentage = $totalReviews > 0 ? ($ratingCount / $totalReviews) * 100 : 0;
                                    @endphp

                                    <li
                                        class="{{ strtolower(trans_choice('RatingLevels', $rating)) }} d-flex align-items-center gap-3 mb-3">
                                        <span class="review-name d-flex align-items-center gap-1"><i
                                                class="ph ph-fill ph-star text-warning"></i>
                                            <span>{{ $rating }}</span> </span>
                                        <div class="progress w-100 bg-dark-subtle">
                                            <div class="progress-bar bg-success" style="width: {{ $percentage }}%"
                                                role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <span class="review-count">{{ $ratingCount }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            @php
                $filteredReviews =
                    $data->entertainmentReviews?->filter(fn($review) => !is_null($review->review))->sortByDesc('rating') ?? collect();
            @endphp

            <div class="reviews mt-5 pt-5">
                <h3 class="mb-4">{{ __('review.title') }}</h3>

                @if ($filteredReviews->count() > 0)
                    @foreach ($filteredReviews as $review)
                        <div class="review border-bottom pb-5 mb-5">
                            <div class="reviewer d-flex align-items-center gap-3">
                                <img class="reviewer-profile-image avatar avatar-80"
                                    src="{{ setBaseUrlWithFileName(optional($review->user)->file_url) ?? default_user_avatar() }}"
                                    alt="{{ optional($review->user)->first_name ?? '-' }}">
                                <div class="reviewer-info flex-grow-1">
                                    <div class="row gy-4 align-items-start justify-content-between">
                                        <div class="col-md-10 col-lg-9 col-xl-10">
                                            <h4>{{ optional($review->user)->first_name ?? '-' }}
                                                {{ optional($review->user)->last_name ?? '-' }}</h4>
                                            <p class="mt-2 mb-0">{{ $review->review ?? '-' }}</p>
                                        </div>
                                        <div class="col-md-2 col-lg-3 col-xl-2 text-md-end">
                                            <p class="mb-1"><strong>
                                                    <span class="star">
                                                        @php
                                                            $rating = $review->rating;
                                                            $fullStars = floor($rating);
                                                            $halfStar = $rating - $fullStars > 0 ? 1 : 0;
                                                            $emptyStars = 5 - ($fullStars + $halfStar);
                                                        @endphp

                                                        @foreach (range(1, 5) as $i)
                                                            <span class="ph-stack" style="width:1em">
                                                                @if ($i <= $fullStars)
                                                                    <i class="ph-fill ph-star text-warning"></i>
                                                                @elseif ($halfStar)
                                                                    <i class="ph-fill ph-star-half text-warning"></i>
                                                                    @php $halfStar = 0; @endphp
                                                                @else
                                                                    <i class="ph ph-star"></i>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    </span>

                                                    {{ $review->rating ?? 0 }} </strong></p>
                                            <small
                                                class="review-date mb-0">{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') ?? '-' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">
                        <h6 class="text-muted">{{ __('No reviews yet') }}</h6>
                    </div>
                @endif
            </div>




        @endsection
        <style>
            .star-rating {
                display: flex;
            }

            .star {
                font-size: 1.2rem;
                color: var(--bs-border-color);
                /* Default color for empty stars */
                margin-right: 2px;
            }

            .star.filled {
                color: var(--bs-warning);
                /* Color for filled stars */
            }
        </style>
