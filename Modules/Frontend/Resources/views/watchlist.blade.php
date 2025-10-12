@extends('frontend::layouts.master')
@section('content')
<div class="section-spacing-bottom">
    <div class="page-title" id="page_title">
        <h4 class="m-0 text-center">{{__('frontend.my_watchlist')}}</h4>
    </div>

    <div class="container-fluid">
        <div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="watch-list">

        </div>
        <div class="card-style-slider shimmer-container section-spacing-top">
            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 mt-3">
                    @for ($i = 0; $i < 12; $i++)
                    <div class="shimmer-container col mb-3">
                        @include('components.card_shimmer_movieList')
                    </div>
                    @endfor
            </div>
        </div>

   </div>



    <div class="container-fluid" id="empty-watch-list" >
        <div class="row flex-column justify-content-center align-items-center">
            <div class="col-sm-12 text-center">
                <!-- <span class="watch-list-add-btn d-block text-center fw-bold m-auto">
                    <a href="{{route('movies')}}"> <i class="ph ph-plus text-white"></i></a>
                </span> -->
                <div class="my-5 py-2 add-watch-list-info text-center">


                    <h4>{{__('frontend.your_watchlist_empty')}}</h4>
                    <p class="mb-0 watchlist-description">{{__('frontend.add_watchlist_content')}}</p>
                </div>
                <div>
                    <a href="{{route('movies')}}"> <button class="btn btn-primary"> {{__('frontend.add_movies')}} </button></a>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="{{ asset('js/entertainment.min.js') }}" defer></script>

<script>
    const noDataImageSrc = '{{ asset('img/NoData.png') }}';
    const shimmerContainer = document.querySelector('.shimmer-container');
    const emptyWatchList = document.getElementById('empty-watch-list');
    const pageTitle = document.getElementById('page_title');
    const isWatchList=true;
    const EntertainmentList = document.getElementById('watch-list');
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;
    let actor_id= null;
    let movie_id=null;
    let type=null;
    let per_page=12;
    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
    const apiUrl = `${baseUrl}/api/watch-list`;
    const csrf_token='{{ csrf_token() }}'
</script>

@endsection
