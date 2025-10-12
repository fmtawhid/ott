@extends('frontend::layouts.master')

@section('content')
<div class="list-page section-spacing-bottom px-0">
    <div class="page-title" id="page_title">
        <h4 class="m-0 text-center">{{__('frontend.coming_soon')}}</h4>
    </div>
    <div id="comingsoon-card-list">
        <div class="container-fluid">
            <div class="row gy-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="coming-soon">
            </div>
            <div class="card-style-slider shimmer-container">
                <div class="row gy-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="shimmer-container col mb-3">
                            @include('components.card_shimmer_commingSoon')
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
    const EntertainmentList = document.getElementById('coming-soon');
    const pageTitle = document.getElementById('page_title');
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;
    let actor_id= null;
    let movie_id=null;
    let type=null;
    let per_page=12;
    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
    const apiUrl = `${baseUrl}/api/coming-soon`;
    const csrf_token='{{ csrf_token() }}'


</script>


@endsection
