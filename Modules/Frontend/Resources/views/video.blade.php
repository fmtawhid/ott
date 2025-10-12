@extends('frontend::layouts.master')

@section('content')
@if(!is_null($sliders) && !empty($sliders))
<!-- Banner Section -->
<div class="banner-section" class="section-spacing-bottom px-0">
    <div class="slick-banner main-banner" data-speed="1000" data-autoplay="true" data-center="false" data-infinite="false" data-navigation="true" data-pagination="true" data-spacing="0">
        @forelse($sliders as $video)
        @php
        $sliderImage = $video['file_url'] ?? null;
        $video = !empty($video['data']) ? $video['data']->toArray(request()) : NULL;
        @endphp
        @if(isset($video) && !is_null($video) && !empty($video))
            <div class="slick-item banner-slide" style="background-image: linear-gradient(to right, rgba(0,0,0,0.8) 40%, transparent), url({{ setBaseUrlWithFileName(($sliderImage) ? $sliderImage : $video['poster_image']) }});">
                <div class="movie-content h-100">
                    <div class="container-fluid h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-xxl-4 col-lg-6">
                                <div class="movie-info">
                                    <h4 class="movie-title mb-2">{{ $video['name'] }}</h4>
                                    <p class="mb-0 font-size-14 line-count-3">{!! $video['description'] !!}</p>
                                    <div class="mt-5 mb-md-0 mb-3">
                                        <div class="movie-actions d-flex align-items-center flex-wrap column-gap-3 row-gap-2">
                                            <a href="{{ route('video-details', $video['id']) }}" class="btn btn-primary" tabindex="-1">
                                                <span class="d-flex align-items-center justify-content-center gap-2">
                                                    <span><i class="ph-fill ph-play"></i></span>
                                                    <span>Watch Now</span>
                                                </span>
                                            </a>
                                            <a href="{{ route('video-details', $video['id']) }}" class="btn btn-dark">
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
                                <h2>No Featured Videos Available</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endif

<!-- Rest of your existing content -->
<div class="list-page">

    <div class="movie-lists section-spacing-bottom px-0">

        <div class="container-fluid">

           <h4 class="mb-5" >{{__('frontend.video')}}</h4>
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
    const csrf_token='{{ csrf_token() }}'
    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
    const apiUrl = `${baseUrl}/api/video-list`;
</script>
@endsection

@push('styles')
<style>
.banner-slide {
    height: 600px;
    background-size: cover;
    background-position: center;
}

.movie-content {
    padding: 2rem 0;
}

.movie-title {
    color: #fff;
    font-size: 2.5rem;
}

.movie-description {
    color: rgba(255, 255, 255, 0.8);
    max-width: 600px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Banner Slider
    $('.slick-banner').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000
    });
});
</script>
@endpush
