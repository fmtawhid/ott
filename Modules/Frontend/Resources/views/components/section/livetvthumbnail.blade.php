<div class="container-fluid">
    <div class="livetv-banner-wrapper">
        <div class="slick-banner live-tv-banner" data-speed="1000" data-autoplay="false" data-center="false" data-infinite="false" data-navigation="true" data-pagination="true" data-spacing="0">
            @foreach ($livetvthumbnail as $channel)
                <div class="slick-item livetv-item" style="background-image: url('{{ $channel['poster_image'] }}');">
                    <div class="livetv-content-wrapper">
                        <div class="livetv-content-inner d-flex flex-column justify-content-end">
                            <span class="live-card-badge">
                                <span class="live-badge fw-semibold text-uppercase">{{__('frontend.live')}}</span>
                            </span>
                            <div class="livetv-content">
                                <ul class="list-inline m-0 p-0 d-flex align-items-center justify-content-center flex-wrap movie-tag-list">
                                    <li>
                                        <a href="#" class="tag">{{$channel['category']}}</a>
                                    </li>
                                </ul>
                                <h4 class="mt-2 mb-0">{{ $channel['name'] }}</h4>
                                <div class="mt-5">
                                    <a href="{{ route('livetv-details', ['id' => $channel['id']]) }}" class="btn btn-dark">
                                        <span class="d-flex align-items-center justify-content-center gap-2">
                                            <span><i class="ph-fill ph-play"></i></span>
                                            <span>{{__('frontend.play_now')}}</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
