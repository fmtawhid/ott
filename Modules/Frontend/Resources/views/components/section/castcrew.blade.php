<div class="favourite-person-block">
   <div class="d-flex align-items-center justify-content-between my-2 me-2">
         <h5 class="main-title text-capitalize mb-0">{{ $title }}</h5>
         @if(count($data)>8)
         <a href="{{ route('movie-castcrew-list',['id' => $entertainment_id ,'type' => $type]) }}" class="view-all-button text-decoration-none flex-none"><span>{{__('frontend.view_all')}}</span> <i class="ph ph-caret-right"></i></a>
         @endif
   </div>

   @php

   $baseClass = 'slick-general';

   if ($slug == 'favorite_personality') {
       $additionalClass = 'slick-general-castcrew';
   } elseif ($slug == 'user-favorite_personality') {
       $additionalClass = 'slick-general-favorite-personality';
   } else {
       $additionalClass = '';
   }

   $class = trim("$baseClass $additionalClass");

@endphp


   <div class="card-style-slider {{ count($data) <= 8 ? 'slide-data-less' : '' }}">
      <div class="{{  $class }}"  data-items="8.5" data-items-desktop="6.5" data-items-laptop="5.5" data-items-tab="4.5" data-items-mobile-sm="3.5"
      data-items-mobile="2.5" data-speed="1000" data-autoplay="false" data-center="false" data-infinite="false"
      data-navigation="true" data-pagination="false" data-spacing="12">
            @foreach($data as $value )
            <div class="slick-item">
                  @include('frontend::components.card.card_castcrew',  ['data' => $value])
            </div>
         @endforeach
      </div>
   </div>
</div>
