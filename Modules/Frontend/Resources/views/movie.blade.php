@extends('frontend::layouts.master')

@section('content')

@if(isset($featured_movies) && !is_null($featured_movies) && !empty($featured_movies) && !in_array($access_type, ['pay-per-view', 'purchased']))

<div class="banner-section" class="section-spacing-bottom px-0">
    <div class="slick-banner  main-banner" data-speed="1000" data-autoplay="true" data-center="false" data-infinite="false" data-navigation="true" data-pagination="true" data-spacing="0">
        @forelse($featured_movies as $movie)
        @php
        $sliderImage = $movie['file_url'] ?? null;
        $movie = !empty($movie['data']) ? $movie['data']->toArray(request()) : NULL;
        @endphp
        @if(isset($movie) && !is_null($movie) && !empty($movie))
        <div class="slick-item banner-slide" style="background-image: linear-gradient(to right, rgba(0,0,0,0.8) 40%, transparent), url({{ setBaseUrlWithFileName(($sliderImage) ? $sliderImage : $movie['thumbnail_image']) }});">
            <div class="movie-content h-100">
                <div class="container-fluid h-100">
                    <div class="row align-items-center h-100">
                        <div class="col-xxl-4 col-lg-6">
                            <div class="movie-info">
                                @if(!empty($movie['genres']))
                                <div class="movie-tag mb-3">
                                    <ul class="list-inline m-0 p-0 d-flex align-items-center flex-wrap movie-tag-list">
                                        @foreach($movie['genres'] as $genre)
                                            <li>
                                                <a href="#" class="tag">{{ $genre['name'] }}</a>

                                                {{-- <a href="{{ route('genre.movies', $genre['id']) }}" class="tag">{{ $genre['name'] }}</a> --}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <h4 class="movie-title mb-2">{{ $movie['name'] }}</h4>

                                <p class="mb-0 font-size-14 line-count-3">{!! $movie['description'] !!}</p>

                                <ul class="movie-meta list-inline mt-4 mx-0 p-0 d-flex align-items-center flex-wrap gap-3">
                                    @if(!empty($movie['release_date']))
                                    <li>
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="ph ph-calendar"></i>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</span>
                                        </span>
                                    </li>
                                    @endif

                                    @if(!empty($movie['language']))
                                    <li>
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="ph ph-translate"></i>
                                            <span class="fw-medium">{{ ucfirst($movie['language']) }}</span>
                                        </span>
                                    </li>
                                    @endif

                                    @if(!empty($movie['duration']))
                                    <li>
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="ph ph-clock"></i>
                                            <span class="fw-medium">{{ $movie['duration'] }}</span>
                                        </span>
                                    </li>
                                    @endif

                                    @if(!empty($movie['imdb_rating']))
                                    <li>
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="ph ph-star"></i>
                                            <span class="fw-medium">{{ $movie['imdb_rating'] }} IMDb</span>
                                        </span>
                                    </li>
                                    @endif
                                </ul>
                                <div class="mt-5 mb-md-0 mb-3">
                                    <div class="movie-actions d-flex align-items-center flex-wrap column-gap-3 row-gap-2">
                                        <a href="{{ route('movie-details', $movie['id']) }}" class="btn btn-primary" tabindex="-1">
                                            <span class="d-flex align-items-center justify-content-center gap-2">
                                                <span><i class="ph-fill ph-play"></i></span>
                                                <span>Watch Now</span>
                                            </span>
                                        </a>
                                        <a href="{{ route('movie-details', $movie['id']) }}" class="btn btn-dark">
                                            <span><i class="ph ph-info"></i></span>
                                            <span>More Info</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-6 d-lg-block d-none"></div>
                        <div class="col-xxl-4 d-xxl-block d-none"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @empty
            <div class="slick-item banner-slide">
                <div class="movie-content h-100">
                    <div class="container-fluid h-100">
                        <div class="row align-items-center h-100">
                            <div class="col-12 text-center">
                                <h2>No Featured Movies Available</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endif
<div class="list-page section-spacing-bottom px-0">
    <div class="movie-lists">

        <div class="container-fluid">


        <h4 class="mb-5" >@if($access_type == 'pay-per-view')
                    {{__('messages.pay_per_view')}}
                @elseif($access_type == 'purchased')
                    {{__('messages.lbl_unlock_videos')}}
                @else
                    {{__('frontend.movies')}}
                @endif</h4>

            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6" id="entertainment-list">
            </div>
            <div class="card-style-slider shimmer-container">
                <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                        @for ($i = 0; $i < 12; $i++)
                            <div class="shimmer-container col mb-3">
                                    @include('components.card_shimmer_movieList')
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
    const envURL = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
    const shimmerContainer = document.querySelector('.shimmer-container');
    const EntertainmentList = document.getElementById('entertainment-list');
    const pageTitle = document.getElementById('page_title');
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;
    const per_page = 12;
    const csrf_token='{{ csrf_token() }}'
    const language = "{{ $language ?? '' }}";
    const genreId = "{{ $genre_id ?? '' }}"; // Get genre_id from the Blade template
    const accessType = "{{ $access_type ?? '' }}";

    // Initialize the API URL
    let apiUrl = `${envURL}/api/v2/movie-list?page=${currentPage}&is_ajax=1&per_page=${per_page}`;

    // Add query parameters only if they exist
    if (language) {
        apiUrl += `&language=${language}`;
    }
    if (genreId) {
        apiUrl += `&genre_id=${genreId}`;
    }
    if (accessType) {
        apiUrl += `&access_type=${accessType}`;
    }

    const showNoDataImage = () => {
        shimmerContainer.innerHTML = '';
        const noDataImage = document.createElement('img');
        noDataImage.src = noDataImageSrc;
        noDataImage.alt = 'No Data Found';
        noDataImage.style.display = 'block';
        noDataImage.style.margin = '0 auto';
        shimmerContainer.appendChild(noDataImage);
    };

    const loadData = async () => {
        if (!hasMore || isLoading) return;

        isLoading = true;
        shimmerContainer.style.display = '';  // Show shimmer container
        try {
            const response = await fetch(`${apiUrl}&page=${currentPage}`);
            const data = await response.json();

            if (data?.html) {
                EntertainmentList.insertAdjacentHTML(currentPage === 1 ? 'afterbegin' : 'beforeend', data.html);
                hasMore = !!data.hasMore;
                if (hasMore) currentPage++;
                shimmerContainer.style.display = 'none';  // Hide shimmer container
                initializeWatchlistButtons();
            } else {
                showNoDataImage();
            }
        } catch (error) {
            console.error('Fetch error:', error);
            showNoDataImage();
        } finally {
            isLoading = false;
        }
    };

    const handleScroll = () => {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500 && hasMore) {
            loadData();
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        loadData();  // Load the first page of movies
        window.addEventListener('scroll', handleScroll);  // Attach scroll listener
        initializeWatchlistButtons()
    });

    function initializeWatchlistButtons() {

  const watchList = typeof isWatchList!== 'undefined' ? !!emptyWatchList : null;
  const watchListPresent = typeof emptyWatchList !== 'undefined' ? !!emptyWatchList : null;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $('.watch-list-btn').off('click').on('click', function () {

      var $this = $(this);
      var isInWatchlist = $this.data('in-watchlist');
      var entertainmentId = $this.data('entertainment-id');
      const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
      var entertainmentType = $this.data('entertainment-type'); // Get the type
      let action = isInWatchlist == '1' ? 'delete' : 'save';
      var data = isInWatchlist
          ? { id: [entertainmentId], _token: csrf_token }
          : { entertainment_id: entertainmentId, type: entertainmentType, _token: csrfToken };

      // Perform the AJAX request
      $.ajax({
          url: action === 'save' ? `${baseUrl}/api/save-watchlist` : `${baseUrl}/api/delete-watchlist?is_ajax=1`,
          method: 'POST',
          data: data,
          success: function (response) {
            window.successSnackbar(response.message)
              $this.find('i').toggleClass('ph-check ph-plus');
              $this.toggleClass('btn-primary btn-dark');
              $this.data('in-watchlist', !isInWatchlist);
              var newInWatchlist = !isInWatchlist ? 'true' : 'false';
              var newTooltip = newInWatchlist === 'true' ? 'Remove Watchlist' : 'Add Watchlist';

              // Destroy the current tooltip
              $this.tooltip('dispose');

              // Update the tooltip attribute
              $this.attr('data-bs-title', newTooltip);

              // Reinitialize the tooltip
              $this.tooltip();
              if (action !== 'save' && watchList) {
                $this.closest('.iq-card').remove();
                if (EntertainmentList.children.length === 0) {
                  if (watchListPresent) {
                    emptyWatchList.style.display = '';
                    const noDataImage = document.createElement('img');
                    noDataImage.src = noDataImageSrc;
                    noDataImage.alt = 'No Data Found';
                    noDataImage.style.display = 'block';
                    noDataImage.style.margin = '0 auto';
                    emptyWatchList.appendChild(noDataImage);
                }
                }
                // shimmerContainer.style.display = 'none';

            }
          },
          error: function (xhr) {
              if (xhr.status === 401) {
                  window.location.href = `${baseUrl}/login`;
              } else {
                  console.error(xhr);
              }
          }
      });
  });
  // Initialize tooltips for all watchlist buttons on page load
//    $('[data-bs-toggle="tooltip"]').tooltip();

}
 // Initialize Banner Swiper
 new Swiper('.banner-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    });
</script>

@endsection
