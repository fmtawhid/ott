@extends('frontend::layouts.master')

@section('content')
@if(!is_null($sliders) && !empty($sliders))

<div class="banner-section" class="section-spacing-bottom px-0">
    <div class="slick-banner main-banner" data-speed="1000" data-autoplay="true" data-center="false" data-infinite="false" data-navigation="true" data-pagination="true" data-spacing="0">
        @forelse($sliders as $slider)
        @php
            $sliderImage = $slider['file_url'] ?? null;
            $slider = !empty($slider['data']) ? $slider['data']->toArray(request()) : NULL;
        @endphp
        @if(isset($slider) && !is_null($slider) && !empty($slider))
        <div class="slick-item banner-slide" style="background-image: linear-gradient(to right, rgba(0,0,0,0.8) 40%, transparent), url({{ setBaseUrlWithFileName(($sliderImage) ? $sliderImage : $slider['thumbnail_image']) }});">
            <div class="movie-content h-100">
                <div class="container-fluid h-100">
                    <div class="row align-items-center h-100">
                        <div class="col-xxl-4 col-lg-6">
                            <div class="movie-info">

                                {{-- Genre Tags --}}
                                @if(!empty($slider['genres']))
                                <div class="movie-tag mb-3">
                                    <ul class="list-inline m-0 p-0 d-flex align-items-center flex-wrap movie-tag-list">
                                        @foreach($slider['genres'] as $genre)
                                            <li>
                                                <a href="#" class="tag">{{ $genre['name'] }}</a>

                                                {{-- <a href="{{ route('genre.movies', $genre['id']) }}" class="tag">{{ $genre['name'] }}</a> --}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <h4 class="movie-title mb-2">{{ $slider['name'] ?? '-' }}</h4>
                                <p class="mb-0 font-size-14 line-count-3">{!! $slider['description'] !!}</p>

                                {{-- Meta --}}
                                <ul class="movie-meta list-inline mt-4 mx-0 p-0 d-flex align-items-center flex-wrap gap-3">
                                    @if(!empty($slider['release_date']))
                                    <li>
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="ph ph-calendar"></i>
                                            <span class="fw-medium">{{ date('Y', strtotime($slider['release_date'])) }}</span>
                                        </span>
                                    </li>
                                    @endif

                                    @if(!empty($slider['language']))
                                    <li>
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="ph ph-translate"></i>
                                            <span class="fw-medium">{{ ucfirst($slider['language']) }}</span>
                                        </span>
                                    </li>
                                    @endif

                                    @if(!empty($slider['duration']))
                                    <li>
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="ph ph-clock"></i>
                                            <span class="fw-medium">{{ $slider['duration'] }}</span>
                                        </span>
                                    </li>
                                    @endif

                                    @if(!empty($slider['imdb_rating']))
                                    <li>
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="ph ph-star"></i>
                                            <span class="fw-medium">{{ $slider['imdb_rating'] }} IMDb</span>
                                        </span>
                                    </li>
                                    @endif
                                </ul>

                                {{-- Actions --}}
                                <div class="mt-5 mb-md-0 mb-3">
                                    <div class="movie-actions d-flex align-items-center flex-wrap column-gap-3 row-gap-2">
                                        <a href="{{ route('tvshow-details', $slider['id']) }}" class="btn btn-primary" tabindex="-1">
                                            <span class="d-flex align-items-center justify-content-center gap-2">
                                                <span><i class="ph-fill ph-play"></i></span>
                                                <span>Watch Now</span>
                                            </span>
                                        </a>
                                        <a href="{{ route('tvshow-details', $slider['id']) }}" class="btn btn-dark">
                                            <span><i class="ph ph-info"></i></span>
                                            <span>More Info</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-6 d-lg-block d-none"></div>
                        <div class="col-xxl-4 d-xxl-block d-none"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @empty
            <div class="slick-item banner-slide">
                <div class="movie-content h-100">
                    <div class="container-fluid h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-12 text-center">
                                <h2>No TV Shows Available</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endif
<div class="list-page">
    <div class="movie-lists section-spacing-bottom">
        <div class="container-fluid">
        <h4 class="mb-5" >{{__('frontend.tvshows')}}</h4>
            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6" id="entertainment-list">

            </div>
            <div class="card-style-slider shimmer-container">
                <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                        @for ($i = 0; $i < 12; $i++)
                        <div class="shimmer-container col mb-3">
                            @include('components.card_shimmer_movieList')
                        </div>
                        @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/entertainment.min.js') }}" defer></script>

<script>

    const noDataImageSrc = '{{ asset('img/NoData.png') }}';
    const shimmerContainer = document.querySelector('.shimmer-container');
    const EntertainmentList = document.getElementById('entertainment-list');
    const pageTitle = document.getElementById('page_title');
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;
    let movie_id= null;
    let actor_id= null;
    let type=null;
    let per_page=12;

    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');

    const apiUrl = `${baseUrl}/api/v2/tvshow-list`;
    const csrf_token='{{ csrf_token() }}'
    // Initialize Banner Swiper
    new Swiper('.banner-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    });
</script>
@endsection
