@extends('frontend::layouts.master')

@section('content')
<div class="list-page section-spacing-bottom px-0">
    <div class="page-title">

        <h4 class="m-0 text-center">{{__('frontend.personality_list')}}</h4>
    </div>
    <div class="movie-lists">
        <div class="container-fluid">
            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-7" id="entertainment-list">

            </div>
            <div class="card-style-slider shimmer-container">
                <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-7 mt-3">
                        @for ($i = 0; $i < 21; $i++)
                            <div class="shimmer-container col mb-3">
                                    @include('components.card_shimmer_crew')
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
const type_value = "{{ $type ?? '' }}";
const shimmerContainer = document.querySelector('.shimmer-container');
const EntertainmentList = document.getElementById('entertainment-list');
let currentPage = 1;
let isLoading = false;
let hasMore = true;
let actor_id= null;
let moive_id=movie_id;
let type=type_value;
let per_page=21;
const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
const apiUrl = `${baseUrl}/api/castcrew-list`;

</script>

@endsection
