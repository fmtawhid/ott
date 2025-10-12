@php
    $dataArray = is_array($data) ? $data : $data->toArray(request());
@endphp

<div class="streamit-block">
    <div class="d-flex align-items-center justify-content-between my-2 me-2">
        <h5 class="main-title text-capitalize mb-0">{{ $title }}</h5>
        @if($type != 'movies-pay-per-view' && $type != 'tvshows-pay-per-view')
            @if(count($data)>6)

                @if(!empty($is_watch_list ))
                    <a href="{{ route('watchList') }}" class="view-all-button text-decoration-none flex-none"><span>{{__('frontend.view_all')}}</span> <i class="ph ph-caret-right"></i></a>
                @else
                <a href="{{
                        $type == 'tvshow'
                            ? route('tv-shows')
                            : ($type == 'pay-per-view'
                                ? route('pay-per-view')
                                : route('movies'))
                    }}"
                    class="view-all-button text-decoration-none flex-none">
                        <span>{{ __('frontend.view_all') }}</span>
                        <i class="ph ph-caret-right"></i>
                    </a>
                @endif
            @endif
        @endif
    </div>

    @php

    $baseClass = 'slick-general';

    if ($slug == 'latest_movie') {
        $additionalClass = 'slick-general-latest-movie';
    } elseif ($slug == 'popular_movie') {
        $additionalClass = 'slick-general-popular-movie';
    }else if($slug == 'popular_tvshow'){
        $additionalClass = 'slick-general-popular-tvshow';
    }else if($slug == 'free_movie'){
        $additionalClass = 'slick-general-free-movie';
    }else if($slug =='based_on_last_watch'){
        $additionalClass = 'slick-general-last-watch';
    }else if($slug =='most-like'){
        $additionalClass = 'slick-general-most-like';
    }else if($slug =='most-view'){
        $additionalClass = 'slick-general-most-view';
    }else if($slug =='tranding-in-country'){
        $additionalClass = 'slick-general-tranding-country';
    }else if($slug == 'per_pay_view'){
        $additionalClass = 'slick-general-pav-per-view';
    }else if($slug == 'movies_pay_per_view'){
        $additionalClass = 'slick-general-movies-pay-per-view';
    }else if($slug == 'tvshows_pay_per_view'){
        $additionalClass = 'slick-general-tvshows-pay-per-view';
    }
    else {
        $additionalClass = '';
    }

    $class = trim("$baseClass $additionalClass");
@endphp


    <div class="card-style-slider {{ count($data) <= 6 ? 'slide-data-less' : '' }}">
        <div class="{{  $class }}" data-items="6.5" data-items-desktop="5.5" data-items-laptop="4.5" data-items-tab="3.5" data-items-mobile-sm="3.5"
            data-items-mobile="2.5" data-speed="1000" data-autoplay="false" data-center="false" data-infinite="false"
            data-navigation="true" data-pagination="false" data-spacing="12">
            @foreach($dataArray  as $value)
            <div class="slick-item">
                @if(isset($value['type']) && $value['type'] === 'video')
                    @include('frontend::components.card.card_video', ['data' => $value])
                 @elseif(isset($value['type']) && $value['type'] === 'episode')
                 @include('frontend::components.card.card_pay_per_view', ['data' => $value])
                @else
                    @include('frontend::components.card.card_entertainment', ['value' => $value])
                @endif
                {{-- @include('frontend::components.card.card_entertainment', ['value' => $value]) --}}
            </div>
            @endforeach

        </div>
    </div>
</div>
