
@php
$footerData = getFooterData();

@endphp

<footer class="footer">
  <div class="footer-top">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xxl-2 col-xl-2 col-sm-6">
          <div class="footer-logo mb-4">
              <!--Logo -->
               @include('frontend::components.partials.logo')
          </div>
          <span class="font-size-14">
        
            {{$footerData['short_description']}}
            
          </span>

          <div class="mt-5">
            <p class="mb-2 font-size-14">{{__('frontend.email_us')}}: <a href="mailto:{{$footerData['inquriy_email']}}" class="link-body-emphasis">    {{$footerData['inquriy_email']}}</a></p>
            <p class="m-0 font-size-14">{{__('frontend.helpline_number')}}: <a href="tel: {{$footerData['helpline_number']}}" class="link-body-emphasis fw-medium">    {{$footerData['helpline_number']}}</a></p>
          </div>
        </div>
        @if(isenablemodule('tvshow')==1)
        <div class="col-xxl-2 col-xl-2 col-sm-6 mt-sm-0 mt-5">
            <h4 class="footer-title font-size-18 mb-5">{{__('frontend.premium_show')}}</h4>
            <ul class="list-unstyled footer-menu">
                @foreach($footerData['premiumShows'] as $show)
                <li class="mb-3">
                    <a href="{{ route('tvshow-details', $show->id) }}">{{ \Illuminate\Support\Str::limit($show->name, 35, '...') }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(isenablemodule('movie')==1)
        <div class="col-xxl-2 col-xl-2 col-sm-6 mt-xl-0 mt-5">
          <h4 class="footer-title font-size-18 mb-5">{{__('frontend.top_movie_to_watch')}}</h4>
          <ul class="list-unstyled footer-menu">
            @foreach($footerData['topMovies'] as $movie)
            <li class="mb-3">
              @if($movie->type=='movie')
              <a href="{{ route('movie-details', $movie->id) }}">{{ \Illuminate\Support\Str::limit($movie->name, 35, '...') }}</a>
              @else
              <a href="{{ route('tvshow-details', $movie->id) }}">{{ \Illuminate\Support\Str::limit($movie->name, 35, '...') }}</a>
              @endif
            </li>
            @endforeach
          </ul>
        </div>
        @endif
        <div class="col-xxl-3 col-xl-3 col-sm-6 mt-xl-0 mt-5">
          <h4 class="footer-title font-size-18 mb-5">{{__('frontend.usefull_links')}}</h4>
          <ul class="list-unstyled footer-menu column-count-2">
            @foreach($footerData['pages'] as $page)

            <li class="mb-3">
            <a href="{{ route('page.show', ['slug' => $page->slug]) }}">{{ $page->name }}</a>
            </li>
            @endforeach
            <li class="mb-3">
              <a href="{{route('faq')}}">{{__('frontend.faq')}}</a>
            </li>

          </ul>
        </div>
        <div class="col-xxl-3 col-xl-3 col-sm-6 mt-xl-0 mt-5">
          <h4 class="footer-title font-size-18 mb-5">{{__('frontend.download_app')}}</h4>
          <p class="mb-5">{{__('frontend.download_app_reason')}}</p>

          <ul class="app-icon list-inline m-0 p-0 d-flex align-items-center gap-3">

            @if($footerData['play_store_url'])
            <li>
              <a href="{{$footerData['play_store_url']}}" class="btn btn-link p-0">
              <img src="{{ asset('img/web-img/play_store.png') }}" alt="play store" class="img-fluid">
              </a>
            </li>
            @endif
            @if($footerData['app_store_url'])
            <li>
            <a href="{{$footerData['app_store_url']}}" class="btn btn-link p-0" target="_blank" >
              <img src="{{ asset('img/web-img/app_store.png') }}" alt="app store" class="img-fluid">
              </a>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container-fluid">
      <div class="text-center">
        © {{ now()->year }} <span class="text-primary">{{ env('APP_NAME') }}</span>. {{__('frontend.all_rights_reserved')}}.
      </div>
    </div>
  </div>
</footer>
<!-- sticky footer -->
  @include('frontend::components.partials.footer-sticky-menu')
