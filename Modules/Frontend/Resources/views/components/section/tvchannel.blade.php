<div class="channel-block">
    <div class="d-flex align-items-center justify-content-between my-2 me-2">
        <h5 class="main-title text-capitalize mb-0">{{ $title }}</h5>
        @if(count($top_channel)>8)
        <a href="{{route('topChannelList')}}" class="view-all-button text-decoration-none flex-none"><span>{{__('frontend.view_all')}}</span> <i class="ph ph-caret-right"></i></a>
        @endif
    </div>
    <div class="card-style-slider slide-data-less">
    <div class="slick-general slick-general-topchannel" data-items="7.5" data-items-laptop="5.5" data-items-tab="4.5" data-items-mobile-sm="3.5"
        data-items-mobile="2.5" data-speed="1000" data-autoplay="false" data-center="false" data-infinite="false"
        data-navigation="true" data-pagination="false" data-spacing="12">
        @foreach ($top_channel as $data )
            <div class="slick-item">
                <a href="{{ route('livetv-details', ['id' => $data['id']]) }}" class="channel-card d-flex align-content-center align-items-center justify-content-center rounded">
                    <img src="{{ $data['poster_image'] }}" alt="channel icon" class="img-fluid object-cover rounded channel-img">
                </a>
            </div>
        @endforeach
    </div>
    </div>
</div>
