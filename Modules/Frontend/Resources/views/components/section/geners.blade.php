<div class="movie-geners-block">
   <div class="d-flex align-items-center justify-content-between my-2 me-2">
         <h5 class="main-title text-capitalize mb-0">{{ $title }}</h5>
         @if(count($genres)>7)
         <a href="{{route('genresList')}}" class="view-all-button text-decoration-none flex-none"><span>{{__('frontend.view_all')}}</span> <i class="ph ph-caret-right"></i></a>
      @endif
      </div>

      @php

      $baseClass = 'slick-general';

      if ($slug == 'gener-section') {
          $additionalClass = 'slick-general-gener-section';
      } elseif ($slug == 'favorite-genres') {
          $additionalClass = 'slick-general-favorite-genres';
      } else {
          $additionalClass = '';
      }

      $class = trim("$baseClass $additionalClass");

  @endphp


   <div class="card-style-slider slide-data-less">
      <div class="{{  $class }} " data-items="7.5" data-items-desktop="7.5" data-items-laptop="5.5" data-items-tab="4.5" data-items-mobile-sm="3.5"
         data-items-mobile="2.5" data-speed="1000" data-autoplay="false" data-center="false" data-infinite="false"
         data-navigation="true" data-pagination="false" data-spacing="12">
         @foreach($genres as $key => $value)
            <div class="swiper-slide">
                  <a href="{{ route('movies.genre', $value['id']) }}" class="text-center genres-card d-block position-relative">
                     <img src="{{ $value['genre_image'] }}" alt="genres img" class="object-cover rounded genres-img">
                     <span class="h6 mb-0 geners-title line-count-1"> {{ $value['name'] }} </span>
                  </a>
            </div>
         @endforeach
      </div>
   </div>
</div>
