@foreach ($moreinfinity as $category)
    @php 
        $channel_data = $category['channel_data']->toArray(request()); 
        $isSingleItem = count($channel_data) === 1;
    @endphp

    <div class="moreinfinity-card">
        <div class="d-flex align-items-center justify-content-between my-2 me-2">
            <h5 class="main-title text-capitalize mb-0">{{ $category['name'] }}</h5>
            <a href="{{ route('livetv-channels', ['id' => $category['id']]) }}" class="view-all-button text-decoration-none flex-none">
                <span>{{ ('View All') }}</span>
                <i class="ph ph-caret-right"></i>
            </a>
        </div>


    <div class="card-style-slider">
        @if ($isSingleItem)
        @php $resource = $channel_data[0]; @endphp
            {{-- Single item: skip slider and align to left --}}
            <div class="d-flex" style="justify-content: flex-start;">
                <div style="flex: 0 0 auto; max-width: 500px;">
                    @include('frontend::components.card.card_tv_category', ['moreinfinity_card' => $channel_data[0]])
                </div>
            </div>
        @else
            {{-- Multiple items: show slider --}}
            <div class="slick-general"
                data-items="5.5"
                data-items-desktop="5"
                data-items-laptop="4.5"
                data-items-tab="3.5"
                data-items-mobile-sm="2.5"
                data-items-mobile="2.5"
                data-speed="1000"
                data-autoplay="false"
                data-center="false"
                data-infinite="false"
                data-navigation="true"
                data-pagination="false"
                data-spacing="12">
                
                @foreach ($channel_data as $resource)
                    <div class="swiper-slide">
                        @include('frontend::components.card.card_tv_category', ['moreinfinity_card' => $resource])
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endforeach