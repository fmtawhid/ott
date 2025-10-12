@extends('frontend::layouts.master')

@section('content')


    <!-- Main Banner -->

      @php
           $is_enable_banner = App\Models\MobileSetting::getValueBySlug('banner');
        @endphp


    <div id="banner-section" class="section-spacing-bottom px-0">
        @if( $is_enable_banner == 1)
        @include('frontend::components.section.banner', ['data' => $sliders ?? []])
        @endif
    </div>




    <div class="container-fluid padding-right-0">
        <div class="overflow-hidden">

            @php
            $is_enable_continue_watching = App\Models\MobileSetting::getValueBySlug('continue-watching');
           @endphp

            @if($user_id !=null && $is_enable_continue_watching == 1)

            <div id="continue-watch-section" class="section-wraper scroll-section section-hidden">

                <div class="card-style-slider movie-shimmer">
                    <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                       @for ($i = 0; $i < 6; $i++)
                         <div class="shimmer-container col mb-3">
                            <div class="continue-watch-card shimmer border rounded-3 placeholder-glow">
                                <div class="placeholder continue-watch-card-image position-relative">
                                  <div class="placeholder placeholder-glow">
                                    <a href="#" class="d-block image-link">
                                      <div class="placeholder w-100 continue-watch-image" style="height: 200px;"></div>
                                    </a>
                                    <div class="progress" role="progressbar" aria-label="Example 2px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                      <div class="placeholder placeholder-glow" style="height: 8px; width: 50%;"></div>
                                    </div>
                                  </div>
                                </div>
                                <div class="continue-watch-card-content">
                                  <div class="placeholder placeholder-glow title-wrapper">
                                    <h5 class="mb-1 font-size-18 title line-count-1 placeholder" style="height: 20px; width: 80%;"></h5>
                                  </div>
                                  <p class="font-size-14 fw-semibold placeholder" style="height: 14px; width: 60%;"></p>
                                </div>
                              </div>
                         </div>
                      @endfor
                  </div>
               </div>

            </div>
          @endif




          @if(isenablemodule('movie') == 1)
            <div id="top-10-moive-section" class="section-wraper scroll-section section-hidden">
                <div class="card-style-slider movie-shimmer">
                    <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                       @for ($i = 0; $i < 6; $i++)
                         <div class="shimmer-container col mb-3">
                             @include('components.card_shimmer_movieList')
                         </div>
                      @endfor
                  </div>
               </div>
            </div>

            <!-- Custom Ad Section: Only for placement 'home_page' -->
            <div id="custom-homepage-ad-section" class="section-wraper section-hidden d-none">
                <div class="custom-ad-container">
                    <div class="custom-ad-wrapper">
                        <div class="custom-ad-content">
                            <img src="" alt="" class="ad-image">
                            <div class="ad-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="latest-moive-section" class="section-wraper scroll-section section-hidden">
                <div class="card-style-slider movie-shimmer">
                    <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                       @for ($i = 0; $i < 6; $i++)
                         <div class="shimmer-container col mb-3">
                             @include('components.card_shimmer_movieList')
                         </div>
                      @endfor
                  </div>
               </div>
            </div>
         @endif

         <div  id="pay-per-view-movie-section" class="section-wraper scroll-section section-hidden">
            <div class="card-style-slider movie-shimmer">
                <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                   @for ($i = 0; $i < 6; $i++)
                     <div class="shimmer-container col mb-3">
                         @include('components.card_shimmer_movieList')
                     </div>
                  @endfor
              </div>
           </div>
        </div>

         <div id="language-section" class="section-wraper scroll-section section-hidden">
            <div class="card-style-slider movie-shimmer">
                <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                   @for ($i = 0; $i < 6; $i++)
                     <div class="shimmer-container col mb-3">
                         @include('components.card_shimmer_languageList')
                     </div>
                  @endfor
              </div>
           </div>
        </div>


        @if(isenablemodule('movie') == 1)

        <div  id="popular-moive-section" class="section-wraper scroll-section section-hidden">
            <div class="card-style-slider movie-shimmer">
                <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                   @for ($i = 0; $i < 6; $i++)
                     <div class="shimmer-container col mb-3">
                         @include('components.card_shimmer_movieList')
                     </div>
                  @endfor
              </div>
           </div>
        </div>
      @endif


      @if(isenablemodule('livetv')==1 )
      <div id="topchannel-section" class="section-wraper scroll-section section-hidden">
        <div class="card-style-slider shimmer-container">
            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="shimmer-container col mb-3">
                                @include('components.card_shimmer_channel')
                        </div>
                    @endfor
              </div>
          </div>
      </div>
   @endif

    @if(isenablemodule('tvshow')==1)
      <div id="popular-tvshow-section" class="section-wraper scroll-section section-hidden">
        <div class="card-style-slider movie-shimmer">
            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
               @for ($i = 0; $i < 6; $i++)
                 <div class="shimmer-container col mb-3">
                     @include('components.card_shimmer_movieList')
                 </div>
              @endfor
          </div>
       </div>
    </div>
   @endif

   <div id="favorite-personality" class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider shimmer-container">
        <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-7 mt-3">
                @for ($i = 0; $i < 7; $i++)
                    <div class="shimmer-container col mb-3">
                            @include('components.card_shimmer_crew')
                    </div>
                @endfor
        </div>
    </div>
  </div>

  @if(isenablemodule('movie')==1 )
  <div id="free-movie-section"  class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider movie-shimmer">
        <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
           @for ($i = 0; $i < 6; $i++)
             <div class="shimmer-container col mb-3">
                 @include('components.card_shimmer_movieList')
             </div>
          @endfor
      </div>
    </div>
  </div>
@endif

<div id="genres-section" class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider shimmer-container">
        <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                @for ($i = 0; $i < 6; $i++)
                    <div class="shimmer-container col mb-3">
                            @include('components.card_shimer_genres')
                    </div>
                @endfor
        </div>
    </div>
</div>

@if(isenablemodule('video')==1 )
<div id="video-section" class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider movie-shimmer">
        <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
           @for ($i = 0; $i < 6; $i++)
             <div class="shimmer-container col mb-3">
                 @include('components.card_shimmer_movieList')
             </div>
          @endfor
      </div>
    </div>
</div>
@endif


   @if( $user_id != null && isenablemodule('movie')==1)

   <div id="base-on-last-watch-section" class="section-wraper scroll-section section-hidden">
     <div class="card-style-slider movie-shimmer">
        <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
           @for ($i = 0; $i < 6; $i++)
             <div class="shimmer-container col mb-3">
                 @include('components.card_shimmer_movieList')
             </div>
          @endfor
        </div>
      </div>
   </div>


   <div id="most-like-section" class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider movie-shimmer">
       <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
          @for ($i = 0; $i < 6; $i++)
            <div class="shimmer-container col mb-3">
                @include('components.card_shimmer_movieList')
            </div>
         @endfor
       </div>
     </div>
  </div>

  <div id="most-view-section" class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider movie-shimmer">
       <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
          @for ($i = 0; $i < 6; $i++)
            <div class="shimmer-container col mb-3">
                @include('components.card_shimmer_movieList')
            </div>
         @endfor
       </div>
     </div>
  </div>

  <div id="tranding-in-country-section" class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider movie-shimmer">
       <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
          @for ($i = 0; $i < 6; $i++)
            <div class="shimmer-container col mb-3">
                @include('components.card_shimmer_movieList')
            </div>
         @endfor
       </div>
     </div>
  </div>

@endif

@if($user_id != null)

<div id="favorite-genres-section" class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider shimmer-container">
        <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                @for ($i = 0; $i < 7; $i++)
                    <div class="shimmer-container col mb-3">
                            @include('components.card_shimer_genres')
                    </div>
                @endfor
        </div>
    </div>
</div>

<div id="user-favorite-personality" class="section-wraper scroll-section section-hidden">
    <div class="card-style-slider shimmer-container">
        <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-7 mt-3">
                @for ($i = 0; $i < 7; $i++)
                    <div class="shimmer-container col mb-3">
                            @include('components.card_shimmer_crew')
                    </div>
                @endfor
        </div>
    </div>
  </div>


@endif





      </div>
   </div>



@endsection

@push('after-scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {
        const sections = document.querySelectorAll('.scroll-section');

        const options = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1 // Trigger when 10% of the section is in view
        };

        const callback = (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('section-hidden');
                    entry.target.classList.add('section-visible');
                }
            });
        };

        const observer = new IntersectionObserver(callback, options);

        sections.forEach(section => {
            observer.observe(section);
        });
    });

document.addEventListener("DOMContentLoaded", function() {
    function intializeremoveButton() {
            $('.continue_remove_btn').off('click').on('click', function() {
                const itemId = this.getAttribute('data-id');
                const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
                const data = {
                    id: itemId,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                };

            fetch(`${baseUrl}/api/delete-continuewatch`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => {

                    if (response.ok) {

                         window.successSnackbar('Continuewatch remove successfully');

                         this.closest('.remove-continuewatch-card').remove();
                         const totalSlickItems = $('.continue-watch-delete .slick-item').length;
                        if (totalSlickItems === 0) {
                           $('.continue-watching-block').addClass('d-none');
                          }
                    } else {
                        alert('Failed to delete item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while trying to delete the item.');
                });
        });
}
const envURL = document.querySelector('meta[name="baseUrl"]').getAttribute('content');

// Observer for scrolling
const sections = document.querySelectorAll('.scroll-section');
const options = { root: null, rootMargin: '0px', threshold: 0.1 };
const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.remove('section-hidden');
            entry.target.classList.add('section-visible');
            if(entry.target.id === 'continue-watch-section'){
              fetchContinueWatch();
            } else if (entry.target.id === 'top-10-moive-section' ) {
                fetchTop10Movies();
                fetchCustomHomePageAd(); // Fetch and show custom ad after Top 10 section
            } else if (entry.target.id === 'latest-moive-section') {
                fetchLatestMovies();
            }else if (entry.target.id === 'language-section' ) {
                fetchLanguages();
            }else if (entry.target.id === 'popular-moive-section' ) {
                fetchPopularMovies();
            }else if (entry.target.id === 'topchannel-section' ) {
                fetchTopChannels();
            }else if (entry.target.id === 'popular-tvshow-section' ) {
                fetchPopularTvshows();
            }else if (entry.target.id === 'favorite-personality' ) {
                fetchfavoritePersonality();
            } else if (entry.target.id === 'free-movie-section' ) {
                fetchFreeMovie();
            }else if (entry.target.id === 'genres-section' ) {
                fetchGenerData();
            }else if (entry.target.id === 'video-section' ) {
                fetchVideoData();
            }else if (entry.target.id === 'base-on-last-watch-section' ) {
                fetchBaseonlastwatch();
            }else if (entry.target.id === 'most-like-section' ) {
                fetchMostLikeMoive();
            }else if (entry.target.id === 'most-view-section' ) {
                fetchMostViewMoive();
            }else if (entry.target.id === 'tranding-in-country-section' ) {
                fetchCountryTraingingMoive();
            }else if (entry.target.id === 'favorite-genres-section' ) {
                fetchFavoriteGenerData();
            }else if (entry.target.id === 'user-favorite-personality' ) {
                fetchUserfavoritePersonality();
            }else if (entry.target.id === 'pay-per-view-movie-section'){
                fetchpeyperviewmovies();
            }

            observer.unobserve(entry.target);
        }
    });
}, options);


sections.forEach(section => {
    observer.observe(section);
});

const rtlMode = document.documentElement.getAttribute('dir') === 'rtl';

;

function fetchContinueWatch() {
    fetch(`${envURL}/api/v2/web-continuewatch-list`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('continue-watch-section').innerHTML = data.html;
            slickGeneral('slick-general-continue-watch', rtlMode);
            intializeremoveButton()
        })
        .catch(error => {
            console.error('Error fetching Top 10 Movies:', error);
        });
}

// Fetch Top 10 Movies
function fetchTop10Movies() {
    fetch(`${envURL}/api/v2/top-10-movie`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('top-10-moive-section').innerHTML = data.html;
            slickGeneral('slick-general-top-10', rtlMode);
        })
        .catch(error => {
            console.error('Error fetching Top 10 Movies:', error);
        });
}

function fetchLatestMovies() {
    fetch(`${envURL}/api/latest-movie`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('latest-moive-section').innerHTML = data.html;
            slickGeneral('slick-general-latest-movie', rtlMode);
        })
        .catch(error => {
            console.error('Error fetching Latest Movies:', error);
        });
}


function fetchLanguages() {
    fetch(`${envURL}/api/fetch-languages`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('language-section').innerHTML = data.html;
            slickGeneral('slick-general-language', rtlMode);
        })
        .catch(error => {
            console.error('Error fetching Language:', error);
        });
    }

    function fetchPopularMovies() {
    fetch(`${envURL}/api/popular-movie`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('popular-moive-section').innerHTML = data.html;
            slickGeneral('slick-general-popular-movie', rtlMode);
        })
        .catch(error => {
            console.error('Error fetching Popular Movies:', error);
        });
    }


  function  fetchTopChannels() {
    fetch(`${envURL}/api/top-channels`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('topchannel-section').innerHTML = data.html;
            slickGeneral('slick-general-topchannel', rtlMode);
        })
        .catch(error => {
            console.error('Error fetching Top channel:', error);
        });
    }

    function fetchPopularTvshows() {
     fetch(`${envURL}/api/popular-tvshows`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('popular-tvshow-section').innerHTML = data.html;
            slickGeneral('slick-general-popular-tvshow', rtlMode);
        })
        .catch(error => {
            console.error('Error fetching popular Tvshows:', error);
        });
    }

    function fetchfavoritePersonality() {
      fetch(`${envURL}/api/favorite-personality`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('favorite-personality').innerHTML = data.html;
            slickGeneral('slick-general-castcrew', rtlMode);
        })
        .catch(error => {
            console.error('Error fetching favorite personality:', error);
        });
    }

    function fetchFreeMovie() {
       fetch(`${envURL}/api/free-movie`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('free-movie-section').innerHTML = data.html;
            slickGeneral('slick-general-free-movie', rtlMode);
        })
        .catch(error => {
            console.error('Error fetching Free Movie:', error);
        });
    }


    function fetchGenerData() {
      fetch(`${envURL}/api/get-gener`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('genres-section').innerHTML = data.html;
           slickGeneral('slick-general-gener-section', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Gener:', error);
       });
   }


   function fetchVideoData() {
      fetch(`${envURL}/api/get-video`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('video-section').innerHTML = data.html;
           slickGeneral('slick-general-video-section', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
       });
   }

   function fetchBaseonlastwatch() {
      fetch(`${envURL}/api/base-on-last-watch-movie`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('base-on-last-watch-section').innerHTML = data.html;
           slickGeneral('slick-general-last-watch', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
       });
   }


   function fetchMostLikeMoive() {
      fetch(`${envURL}/api/most-like-movie`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('most-like-section').innerHTML = data.html;
           slickGeneral('slick-general-most-like', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
       });
   }

   function fetchMostViewMoive() {
      fetch(`${envURL}/api/most-view-movie`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('most-view-section').innerHTML = data.html;
           slickGeneral('slick-general-most-view', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
       });
   }

   function fetchCountryTraingingMoive() {
      fetch(`${envURL}/api/country-tranding-movie`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('tranding-in-country-section').innerHTML = data.html;
           slickGeneral('slick-general-tranding-country', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
       });
   }

   function  fetchFavoriteGenerData() {
      fetch(`${envURL}/api/favorite-genres`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('favorite-genres-section').innerHTML = data.html;
           slickGeneral('slick-general-favorite-genres', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
       });
   }

   function  fetchUserfavoritePersonality() {
      fetch(`${envURL}/api/user-favorite-personality`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('user-favorite-personality').innerHTML = data.html;
           slickGeneral('slick-general-favorite-personality', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
       });
   }

   function fetchpeyperviewmovies (){
    fetch(`${envURL}/api/pay-per-view`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('pay-per-view-movie-section').innerHTML = data.html;
           slickGeneral('slick-general-pav-per-view', rtlMode);
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
       });
   }

   function fetchCustomHomePageAd() {
        const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
        fetch(`${baseUrl}/api/custom-ads/get-active`)
            .then(response => response.json())
            .then(data => {
                if (data.success && Array.isArray(data.data)) {
                    // Filter for home_page placement
                    const ads = data.data.filter(item => item.placement === 'home_page');
                    if (ads.length > 0) {
                        let adHtml = `
                            <div class="custom-ad-box">
                                <div class="custom-ad-slider">
                                    ${ads.map(ad => {
                                        let content = '';
                                        if (ad.type === 'image') {
                                            let imgSrc = ad.url_type === 'local' ? `${ad.media}` : ad.media;
                                            content = `
                                                <div class="custom-ad-content">
                                                    ${ad.redirect_url ? `
                                                        <a href="${ad.redirect_url}" class="ad-link" target="_blank" rel="noopener noreferrer">
                                                            <img src="${imgSrc}" alt="${ad.name}" class="ad-image">
                                                            <div class="ad-overlay"></div>
                                                        </a>
                                                    ` : `
                                                        <img src="${imgSrc}" alt="${ad.name}" class="ad-image">
                                                        <div class="ad-overlay"></div>
                                                    `}
                                                </div>
                                            `;
                                        } else if (ad.type === 'video') {
                                            // Check if it's a YouTube URL
                                            let isYouTube = ad.media.includes('youtube.com') || ad.media.includes('youtu.be');
                                            if (isYouTube) {
                                                // Extract YouTube video ID
                                                let videoId = '';
                                                if (ad.media.includes('youtu.be/')) {
                                                    videoId = ad.media.split('youtu.be/')[1].split(/[?&]/)[0];
                                                } else if (ad.media.includes('youtube.com')) {
                                                    let url = new URL(ad.media);
                                                    videoId = url.searchParams.get('v');
                                                }
                                                content = `
                                                    <div class="custom-ad-content video-content">
                                                        <div class="video-container">
                                                            <iframe class="ad-video" src="https://www.youtube.com/embed/${videoId}?rel=0&autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1&loop=1&playlist=${videoId}" frameborder="0"></iframe>
                                                        </div>
                                                        <div class="ad-overlay"></div>
                                                        ${ad.redirect_url ? `<div class="ad-video-overlay" onclick="window.open('${ad.redirect_url}', '_blank')"></div>` : ''}
                                                    </div>
                                                `;
                                            } else if (ad.url_type == "url") {
                                                // Regular video file
                                                content = `
                                                    <div class="custom-ad-content video-content">
                                                        <div class="video-container">
                                                            <video class="ad-video" autoplay muted loop playsinline>
                                                                <source src="${ad.media}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                        <div class="ad-overlay"></div>
                                                        ${ad.redirect_url ? `<div class="ad-video-overlay" onclick="window.open('${ad.redirect_url}', '_blank')"></div>` : ''}
                                                    </div>
                                                `;
                                            }
                                            else {

                                                // Regular video file
                                                content = `
                                                    <div class="custom-ad-content video-content">
                                                        <div class="video-container">
                                                            <video class="ad-video" autoplay muted loop playsinline>
                                                                <source src="${baseUrl}${ad.media}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                        <div class="ad-overlay"></div>
                                                        ${ad.redirect_url ? `<div class="ad-video-overlay" onclick="window.open('${ad.redirect_url}', '_blank')"></div>` : ''}
                                                    </div>
                                                `;
                                            }
                                        }
                                        return `<div class="custom-ad-wrapper">${content}</div>`;
                                    }).join('')}
                                </div>
                            </div>
                        `;
                        const adSection = document.getElementById('custom-homepage-ad-section');
                        if (adSection) {
                            adSection.innerHTML = adHtml;
                            adSection.classList.remove('section-hidden');
                            adSection.classList.remove('d-none');
                            adSection.classList.add('section-visible');
                            $('.custom-ad-slider').slick({
                                dots: true,
                                arrows: false,
                                infinite: ads.length > 1,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                adaptiveHeight: true,
                                autoplay: true,
                                autoplaySpeed: 5000
                            });
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching custom homepage ad:', error);
            });
    }

// Slick General function to initialize the sliders
function slickGeneral(className, rtlmode) {
    jQuery(`.${className}`).each(function () {


    let slider = jQuery(this);

    let slideSpacing = slider.data("spacing");

    function addSliderSpacing(spacing) {
        slider.css('--spacing', `${spacing}px`);
    }

    addSliderSpacing(slideSpacing);

    slider.slick({
        slidesToShow: slider.data("items"),
        slidesToScroll: 1,
        speed: slider.data("speed"),
        autoplay: slider.data("autoplay"),
        centerMode: slider.data("center"),
        infinite: slider.data("infinite"),
        arrows: slider.data("navigation"),
        dots: slider.data("pagination"),
        prevArrow: "<span class='slick-arrow-prev'><span class='slick-nav'><i class='ph ph-caret-left'></i></span></span>",
        nextArrow: "<span class='slick-arrow-next'><span class='slick-nav'><i class='ph ph-caret-right'></i></span></span>",
        rtl: rtlmode,
        responsive: [
            {
                breakpoint: 1600, // screen size below 1600
                settings: {
                    slidesToShow:  slider.data("items-desktop"),
                }
            },
            {
                breakpoint: 1400, // screen size below 1400
                settings: {
                    slidesToShow:  slider.data("items-laptop"),
                }
            },
            {
                breakpoint: 1200, // screen size below 1200
                settings: {
                    slidesToShow:  slider.data("items-tab"),
                }
            },
            {
                breakpoint: 768, // screen size below 768
                settings: {
                    slidesToShow:  slider.data("items-mobile-sm"),
                }
            },
            {
                breakpoint: 576, // screen size below 576
                settings: {
                    slidesToShow:  slider.data("items-mobile"),
                }
            }
        ]
    });

    let active = slider.find(".slick-active");
    let slideItems = slider.find(".slick-track .slick-item");
    active.first().addClass("first");
    active.last().addClass("last");

    slider.on('afterChange', function (event, slick, currentSlide, nextSlide) {
        let active = slider.find(".slick-active");
        slideItems.removeClass("first last");
        active.first().addClass("first");
        active.last().addClass("last");
    });
});
}

});

</script>

@endpush
@push('after-styles')
<style>
    /* Add to your CSS file */
    .section-hidden {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }

    .section-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .custom-ad {
        margin: 32px auto;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        padding: 20px;
        position: relative;
        overflow: hidden;
    }

    .custom-ad a {
        width: 100%;
        display: block;
    }

    .custom-ad img.ad-image {
        width: 100%;
        max-width: 1200px;
        height: auto;
        aspect-ratio: 16/9;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.2);
        position: relative;
        z-index: 2;
        display: block;
        margin: 0 auto;
    }

    .custom-ad::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.3) 100%);
        z-index: 1;
    }

    @media (max-width: 1400px) {
        .custom-ad img {
            max-width: 1000px;
        }
    }

    @media (max-width: 1200px) {
        .custom-ad img {
            max-width: 800px;
        }
    }

    @media (max-width: 991px) {
        .custom-ad {
            padding: 15px;
        }
        .custom-ad img {
            max-width: 100%;
        }
    }

    @media (max-width: 767px) {
        .custom-ad {
            padding: 10px;
            margin: 20px auto;
        }
    }

    #custom-homepage-ad-section {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        padding: 0 15px;
    }

    /* New Ad Banner Styles */
    .custom-ad-container {
        width: 100%;
        max-width: 1720px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .custom-ad-box {
        padding:0 50px;
        margin: 30px 0;
    }
    .custom-ad-wrapper {
        position: relative;
        width: 100%;
        border-radius: 6px;
        overflow: hidden;
        background: rgba(0, 0, 0, 0.1);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
    }

    .custom-ad-content {
        position: relative;
        width: 100%;
        height: 350px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-ad-content .ad-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
        background: rgba(0, 0, 0, 0.8);
    }

    .ad-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            180deg,
            rgba(0, 0, 0, 0.3) 0%,
            rgba(0, 0, 0, 0.4) 50%,
            rgba(0, 0, 0, 0.6) 100%
        );
        z-index: 1;
    }

    .ad-title {
        position: absolute;
        bottom: 30px;
        left: 30px;
        color: #fff;
        font-size: 24px;
        font-weight: 600;
        z-index: 2;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .custom-ad-wrapper:hover .ad-image {
        transform: scale(1.05);
    }

    /* Responsive Styles */
    @media (max-width: 1800px) {
        .custom-ad-container {
            max-width: 100%;
            padding: 0 40px;
        }
    }

    @media (max-width: 1200px) {
        .custom-ad-container {
            padding: 0 30px;
        }
        .custom-ad-content {
            height: 300px;
        }
    }

    @media (max-width: 991px) {
        .custom-ad-container {
            padding: 0 20px;
        }
        .custom-ad-content {
            height: 250px;
        }
    }

    @media (max-width: 767px) {
        .custom-ad-container {
            padding: 0 15px;
        }
        .custom-ad-content {
            height: 200px;
        }
    }

    @media (max-width: 576px) {
        .custom-ad-content {
            height: 180px;
        }
    }

    .ad-link {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        position: relative;
        cursor: pointer;
    }

    .ad-link:hover .ad-image {
        transform: scale(1.05);
    }

    .custom-ad-content .ad-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
        background: rgba(0, 0, 0, 0.8);
    }

    .ad-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            180deg,
            rgba(0, 0, 0, 0.3) 0%,
            rgba(0, 0, 0, 0.4) 50%,
            rgba(0, 0, 0, 0.6) 100%
        );
        z-index: 1;
        pointer-events: none;
    }

    .ad-close-button {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.6);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        z-index: 20;
        transition: all 0.3s ease;
    }

    .ad-close-button:hover {
        background: rgba(0, 0, 0, 0.8);
        transform: scale(1.1);
    }

    .ad-close-button i {
        line-height: 1;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }

    /* Make sure close button is visible on all backgrounds */
    .ad-close-button::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.2);
        z-index: -1;
    }

    @media (max-width: 767px) {
        .ad-close-button {
            width: 28px;
            height: 28px;
            font-size: 16px;
            top: 10px;
            right: 10px;
        }
    }

    /* Add slider-specific styles if needed */
    .custom-ad-slider .slick-dots {
        bottom: 10px;
    }
    .custom-ad-slider .slick-arrow {
        display: none !important;
    }
    .custom-ad-slider .slick-prev,
    .custom-ad-slider .slick-next {
        width: 40px;
        height: 40px;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        color: #fff;
        display: flex !important;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        transition: background 0.2s;
    }
    .custom-ad-slider .slick-prev:hover,
    .custom-ad-slider .slick-next:hover {
        background: rgba(0,0,0,0.8);
    }
    .custom-ad-slider .slick-prev {
        left: 10px;
    }
    .custom-ad-slider .slick-next {
        right: 10px;
    }
    .custom-ad-content .ad-video-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        cursor: pointer;
        background: transparent;
    }
    .custom-ad-box .custom-ad-slider {
        width: 70%;
        height: auto;
        margin: auto;
    }

    /* Add spacing between multiple ads in slider */
    .custom-ad-slider .slick-slide {
        padding: 0 15px;
        margin: 0 5px;
    }

    .custom-ad-slider .slick-track {
        display: flex;
        align-items: center;
    }

    .custom-ad-slider .custom-ad-wrapper {
        margin: 0 10px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-ad-slider .custom-ad-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    }

    /* Ensure proper spacing for single ad */
    .custom-ad-slider .slick-slide:only-child {
        padding: 0;
        margin: 0;
    }

    .custom-ad-slider .slick-slide:only-child .custom-ad-wrapper {
        margin: 0;
    }

    @media(max-width:991px){
        .custom-ad-box .custom-ad-slider{
            width: 100%;
        }
        .custom-ad-box{
            padding: 0 20px;
        }
        .custom-ad-slider .slick-slide {
            padding: 0 10px;
            margin: 0 3px;
        }
        .custom-ad-slider .custom-ad-wrapper {
            margin: 0 5px;
        }
    }
    @media(max-width:575px){
        .custom-ad-content .ad-image{
            object-fit: contain;
        }
        .custom-ad-slider .slick-slide {
            padding: 0 5px;
            margin: 0 2px;
        }
        .custom-ad-slider .custom-ad-wrapper {
            margin: 0 3px;
        }
    }
    .custom-ad-slider {
    position: relative; /* required for absolute positioning of arrows */
}

.custom-ad-slider .slick-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
    font-size: 0; /* hide text */
    background: rgba(0, 0, 0, 0.5); /* optional: background for better visibility */
    width: 40px;
    height: 40px;
    border: none;
    cursor: pointer;
    border-radius: 50%;
}

.custom-ad-slider .slick-prev {
    left: 10px;
}

.custom-ad-slider .slick-next {
    right: 10px;
}
.custom-ad-slider .slick-dots{
    display:flex;
    justify-content:center;
    align-content:center;
    gap:5px;
}
.custom-ad-slider .slick-dots li button{
    width:20px;
    height:5px;
    border-radius:2px;
    background:#673b3a;
}
.custom-ad-slider .slick-dots li.slick-active button{
    width:30px;
    height:5px;
    border-radius:2px;
    background:var(--bs-primary);#673b3a
}
/* ===============================================   */
.custom-ad-box {
    position: relative;
    background: radial-gradient(ellipse at center, #0f0f23 0%, #000000 70%);
    overflow: hidden;
    border-radius: 12px;
    animation: twinkle 2s ease-in-out infinite alternate;
}

/* Layered stars: repeat in both directions */
.custom-ad-box::before,
.custom-ad-box::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 200%;
    height: 200%;
    background-image:
        radial-gradient(2px 2px at 20px 30px, #e50914, transparent),
        radial-gradient(2px 2px at 40px 70px, rgb(250, 130, 130), transparent),
        radial-gradient(2px 2px at 90px 40px, rgb(255, 102, 102), transparent),
        radial-gradient(2px 2px at 130px 80px, rgb(206, 1, 8), transparent),
        radial-gradient(2px 2px at 160px 30px, #f44336, transparent),
        radial-gradient(2px 2px at 200px 90px, rgb(253, 190, 190), transparent),
        radial-gradient(2px 2px at 300px 50px, rgb(244, 67, 54), transparent),
        radial-gradient(2px 2px at 400px 10px, rgb(255, 136, 136), transparent),
        radial-gradient(2px 2px at 500px 60px, rgb(255, 153, 153), transparent),
        radial-gradient(2px 2px at 600px 80px, rgb(255, 102, 102), transparent),
        radial-gradient(2px 2px at 700px 30px, rgb(255, 204, 204), transparent);
    background-repeat: repeat;
    background-size: 200px 200px;
    animation: starfield 20s linear infinite, starTwinkle 3s ease-in-out infinite alternate;
    z-index: 1;
}

.custom-ad-box::after {
    background-image:
        radial-gradient(2px 2px at 60px 20px, rgb(255, 94, 94), transparent),
        radial-gradient(2px 2px at 100px 60px, rgb(255, 102, 102), transparent),
        radial-gradient(2px 2px at 140px 10px, #e50914, transparent),
        radial-gradient(2px 2px at 180px 80px, rgb(250, 130, 130), transparent),
        radial-gradient(2px 2px at 220px 50px, #f44336, transparent),
        radial-gradient(2px 2px at 260px 90px, rgb(244, 67, 54), transparent),
        radial-gradient(2px 2px at 320px 30px, rgb(255, 153, 153), transparent),
        radial-gradient(2px 2px at 480px 50px, rgb(255, 120, 120), transparent),
        radial-gradient(2px 2px at 700px 70px, rgb(255, 80, 80), transparent);
    background-repeat: repeat;
    background-size: 200px 250px;
    animation: starfield 30s linear infinite reverse, starTwinkle 4s ease-in-out infinite alternate-reverse;
    z-index: 1;
}

/* Shooting stars going upward */
.custom-ad-box .shooting-star {
    position: absolute;
    width: 2px;
    height: 2px;
    background: linear-gradient(to top, #e50914, transparent);
    border-radius: 50%;
    animation: shooting 4s ease-in-out infinite;
    z-index: 3;
}

.custom-ad-box .shooting-star::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 1px;
    height: 50px;
    background: linear-gradient(to top, #f44336, transparent);
    transform-origin: bottom;
}

.custom-ad-box .shooting-star:nth-child(1) { left: 20%; bottom: -50px; animation-delay: 0s; }
.custom-ad-box .shooting-star:nth-child(2) { left: 60%; bottom: -50px; animation-delay: 1.5s; }
.custom-ad-box .shooting-star:nth-child(3) { left: 85%; bottom: -50px; animation-delay: 3s; }

@keyframes shooting {
    0%   { transform: translateY(0); opacity: 0; }
    10%  { opacity: 1; }
    90%  { opacity: 1; }
    100% { transform: translateY(-100vh); opacity: 0; }
}

/* Twinkle animation for main container */
@keyframes twinkle {
    0%   { filter: brightness(1); }
    100% { filter: brightness(1.2); }
}

/* Twinkling for stars */
@keyframes starTwinkle {
    0%   { opacity: 0.5; }
    50%  { opacity: 1; }
    100% { opacity: 0.7; }
}

/* Nebula with theme-based glow */
.custom-ad-box .nebula {
    position: absolute;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(229, 9, 20, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    animation: nebulaDrift 25s ease-in-out infinite;
    z-index: 2;
}

.custom-ad-box .nebula:nth-child(1) {
    top: 10%;
    left: 20%;
    animation-delay: 0s;
}

.custom-ad-box .nebula:nth-child(2) {
    top: 60%;
    right: 10%;
    background: radial-gradient(circle, rgba(244, 67, 54, 0.1) 0%, transparent 70%);
    animation-delay: 8s;
}
.ad-video{
    width:100%;
    height:auto;
}
@keyframes nebulaDrift {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33%      { transform: translate(30px, -20px) scale(1.1); }
    66%      { transform: translate(-20px, 15px) scale(0.9); }
}

/* Upward starfield motion */
@keyframes starfield {
    0%   { transform: translateY(100%); }
    100% { transform: translateY(-100%); }
}

/* Ensure ad content stays visible */
.custom-ad-box > * {
    position: relative;
    z-index: 10;
}

/* Mobile optimization */
@media (max-width: 768px) {
    .custom-ad-box::before,
    .custom-ad-box::after {
        animation-duration: 25s, 4s;
    }

    .custom-ad-box .shooting-star {
        animation-duration: 5s;
    }
}

/* Reduce motion accessibility */
@media (prefers-reduced-motion: reduce) {
    .custom-ad-box::before,
    .custom-ad-box::after,
    .custom-ad-box .shooting-star,
    .custom-ad-box .nebula,
    .custom-ad-box {
        animation: none !important;
        background: #0f0f23 !important;
    }
}

</style>
@endpush

