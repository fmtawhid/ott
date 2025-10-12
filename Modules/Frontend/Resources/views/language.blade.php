@extends('frontend::layouts.master')

@section('content')
<div class="list-page section-spacing-bottom px-0">
    <div class="page-title">
        <h4 class="m-0 text-center">{{__('frontend.all_languages')}}</h4>
    </div>
    <div class="movie-lists">
        <div class="container-fluid">
            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-6" id="language_list">
                </div>
                <div class="card-style-slider shimmer-container">
                    <div  class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-6">
                            @for ($i = 0; $i < 12; $i++)
                                <div class="shimmer-container col mb-3">
                                        @include('components.card_shimmer_languageList')
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
        const EntertainmentList = document.getElementById('language_list');
        let currentPage = 1;
        let isLoading = false;
        let hasMore = true;
        let actor_id= null;
        let movie_id=null;
        let type=null;
        let per_page=12;
        const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
        const apiUrl = `${baseUrl}/languages-data`;
        const csrf_token='{{ csrf_token() }}'
    </script>
    @endsection

