@extends('frontend::layouts.master')

@section('content')

<div class="list-page section-spacing-bottom px-0">
    <div class="page-title">
        <h4 class="m-0 text-center">{{__('frontend.continue_watching_movies')}}</h4>
    </div>
    <div class="movie-list">
        <div class="container-fluid">
            <div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="continue-watch">

            </div>
            <div class="card-style-slider shimmer-container">
                <div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                        @for ($i = 0; $i < 10; $i++)
                            <div class="shimmer-container col mb-3">
                                    @include('components.card_shimmer_continue_watch')
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
    const movie_id = "{{ $entertainment_id ?? '' }}";
    const shimmerContainer = document.querySelector('.shimmer-container');
    const EntertainmentList = document.getElementById('continue-watch');
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;
    let actor_id= null;
    let type=null;
    let per_page=10;
    const baseUrl =  "{{ env('APP_URL') }}";
    const apiUrl = `${baseUrl}/api/continuewatch-list?page=${currentPage}&is_ajax=1&per_page=${per_page}`;
    const csrf_token='{{ csrf_token() }}'
</script>

@endsection
