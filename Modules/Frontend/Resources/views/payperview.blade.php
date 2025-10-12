@extends('frontend::layouts.master')

@section('content')
<!-- Rest of your existing content -->
<div class="list-page">

    <div class="movie-lists section-spacing-bottom px-0">

        <div class="container-fluid">

           <h4 class="mb-5 text-center">{{__('messages.pay_per_view')}}</h4>
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
    const apiUrl = `${baseUrl}/api/pay-per-view-list`;
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
