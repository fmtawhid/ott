@extends('frontend::layouts.master')

@section('content')


    <!-- Main Banner -->
    <div class="container-fluid padding-right-0">
        <div class="overflow-hidden">
            <!-- No Content Message -->
            <div id="no-content-message" class="text-center py-5 d-none">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="no-content-box">
                                <i class="ph ph-shopping-cart" style="font-size: 180px; color: #6c757d;"></i>
                                <h3 class="mt-3">{{ __('messages.lbl_no_content_purchase_at') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @php
            $user_id = auth()->id() ?? null ;
        @endphp            
         {{-- <div  id="pay-per-view-movie-section" class="section-wraper scroll-section section-hidden">
            <div class="card-style-slider movie-shimmer">
                <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                   @for ($i = 0; $i < 6; $i++)
                     <div class="shimmer-container col mb-3">
                         @include('components.card_shimmer_movieList')
                     </div>
                  @endfor
              </div>
           </div>
        </div> --}}

        

        <div  id="pay-per-view-moive-section" class="section-wraper scroll-section section-hidden">
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
      

      <div id="pay-per-view-tvshow-section" class="section-wraper scroll-section section-hidden">
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



<div id="pay-per-view-session-section" class="section-wraper scroll-section section-hidden">
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

<div id="pay-per-view-episode-section" class="section-wraper scroll-section section-hidden">
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
            if (entry.target.id === 'pay-per-view-moive-section' ) {
                fetchPopularMovies();
            }else if (entry.target.id === 'pay-per-view-tvshow-section' ) {
                fetchPopularTvshows();
            }else if (entry.target.id === 'video-section' ) {
                fetchVideoData();
            }else if (entry.target.id === 'pay-per-view-movie-section'){
                fetchpeyperviewmovies();
            } else if (entry.target.id === 'pay-per-view-session-section') {
                fetchPopularSessions();
            } else if (entry.target.id === 'pay-per-view-episode-section') {
                fetchPopularEpisodes();
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


    function checkAllSectionsEmpty() {
        const sections = [
            'pay-per-view-moive-section',
            'pay-per-view-tvshow-section',
            'video-section',
            'pay-per-view-movie-section',
            'pay-per-view-session-section',
            'pay-per-view-episode-section'
        ];

        let allEmpty = true;
        sections.forEach(sectionId => {
            const section = document.getElementById(sectionId);
            if (section && section.querySelector('.slick-item')) {
                allEmpty = false;
            }
        });

        const noContentMessage = document.getElementById('no-content-message');
        if (allEmpty) {
            noContentMessage.classList.remove('d-none');
        } else {
            noContentMessage.classList.add('d-none');
        }
    }

    function fetchPopularMovies() {
        fetch(`${envURL}/api/movies-pay-per-view`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('pay-per-view-moive-section').innerHTML = data.html;
                slickGeneral('slick-general-movies-pay-per-view', rtlMode);
                checkAllSectionsEmpty();
            })
            .catch(error => {
                console.error('Error fetching Pay Per View Movies:', error);
                checkAllSectionsEmpty();
            });
    }


  
    function fetchPopularTvshows() {
     fetch(`${envURL}/api/tvshows-pay-per-view`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('pay-per-view-tvshow-section').innerHTML = data.html;
            slickGeneral('slick-general-tvshows-pay-per-view', rtlMode);
            checkAllSectionsEmpty();
        })
        .catch(error => {
            console.error('Error fetching Pay Per View Tvshows:', error);
            checkAllSectionsEmpty();
        });
    }

   function fetchVideoData() {
      fetch(`${envURL}/api/videos-pay-per-view`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('video-section').innerHTML = data.html;
           slickGeneral('slick-general-video-section', rtlMode);
           checkAllSectionsEmpty();
       })
       .catch(error => {
           console.error('Error fetching Pay Per Videos Video:', error);
           checkAllSectionsEmpty();
       });
   }


   function fetchpeyperviewmovies (){
    fetch(`${envURL}/api/pay-per-view`)
       .then(response => response.json())
       .then(data => {
           document.getElementById('pay-per-view-movie-section').innerHTML = data.html;
           slickGeneral('slick-general-pav-per-view', rtlMode);
           checkAllSectionsEmpty();
       })
       .catch(error => {
           console.error('Error fetching Video:', error);
           checkAllSectionsEmpty();
       });
   }

function fetchPopularSessions() {
    fetch(`${envURL}/api/sessions-pay-per-view`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('pay-per-view-session-section').innerHTML = data.html;
            slickGeneral('slick-general-season-pay-per-view', rtlMode);
            checkAllSectionsEmpty();
        })
        .catch(error => {
            console.error('Error fetching Pay Per View Sessions:', error);
            checkAllSectionsEmpty();
        });
}

function fetchPopularEpisodes() {
    fetch(`${envURL}/api/episodes-pay-per-view`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('pay-per-view-episode-section').innerHTML = data.html;
            slickGeneral('slick-general-episode-pay-per-view', rtlMode);
            checkAllSectionsEmpty();
        })
        .catch(error => {
            console.error('Error fetching Pay Per View Episodes:', error);
            checkAllSectionsEmpty();
        });
}

});


function slickGeneral(className, rtlmode) {
  jQuery(`.${className}`).each(function () {
    let slider = jQuery(this);
    let slideSpacing = slider.data("spacing");


    function addSliderSpacing(spacing) {
      slider.css('--spacing', `${spacing}px`);
    }
    addSliderSpacing(slideSpacing);
    slider.slick({
      slidesToShow:     slider.data("items"),
      slidesToScroll:   1,
      speed:            slider.data("speed"),
      autoplay:         slider.data("autoplay"),
      centerMode:       slider.data("center"),
      infinite:         slider.data("infinite"),
      arrows:           slider.data("navigation"),
      dots:             slider.data("pagination"),
      prevArrow:        "<span class='slick-arrow-prev'><span class='slick-nav'><i class='ph ph-caret-left'></i></span></span>",
      nextArrow:        "<span class='slick-arrow-next'><span class='slick-nav'><i class='ph ph-caret-right'></i></span></span>",
      rtl:              rtlmode,
      responsive: [
        { breakpoint: 1600, settings: { slidesToShow: slider.data("items-desktop") } },
        { breakpoint: 1400, settings: { slidesToShow: slider.data("items-laptop") } },
        { breakpoint: 1200, settings: { slidesToShow: slider.data("items-tab") } },
        { breakpoint:  768, settings: { slidesToShow: slider.data("items-mobile-sm") } },
        { breakpoint:  576, settings: { slidesToShow: slider.data("items-mobile") } }
      ]
    });

    // Cache slide items
    let slideItems = slider.find(".slick-track .slick-item");
    function updateFirstLast() {
      let active = slider.find(".slick-active");
      slideItems.removeClass("first last");

      if (active.length === 1) {
        active.addClass("first");
      } else {
        active.first().addClass("first");
        active.last().addClass("last");
      }
    }

    updateFirstLast();

 
    slider.on('afterChange', updateFirstLast);
  });
}

slickGeneral('my-slider', false);


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
</style>
@endpush

