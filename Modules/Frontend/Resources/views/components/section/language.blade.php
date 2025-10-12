<div class="language-block">
   <div class="d-flex align-items-center justify-content-between my-2 me-2">
         <h5 class="main-title text-capitalize mb-0">{{ $title }}</h5>
         @if(count($popular_language)>6)
         <a href="{{route('languageList')}}" class="view-all-button text-decoration-none flex-none"><span>{{__('frontend.view_all')}}</span> <i class="ph ph-caret-right"></i></a>
         @endif
   </div>
   <div class="card-style-slider slide-data-less">
      <div class="slick-general slick-general-language" data-items="6.5" data-items-laptop="5.5" data-items-tab="3.5" data-items-mobile-sm="3.5"
      data-items-mobile="2.5" data-speed="1000" data-autoplay="false" data-center="false" data-infinite="false"
      data-navigation="true" data-pagination="false" data-spacing="12">
         @foreach($popular_language as $data)
               <div class="slick-item">
                  <a href="{{ route('movies.language', strtolower($data->name)) }}" class="rounded border language-card d-flex align-items-center flex-wrap gap-3 justify-content-center">
                        <span class="language-inner">{{ substr($data->name, 0, 1) }}</span>
                        <span class="text-capitalize language-title line-count-1">{{ $data->name }}</span>
                  </a>
               </div>

         @endforeach
      </div>
   </div>
</div>
