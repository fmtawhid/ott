@extends('frontend::layouts.master')
@section('content')

<div class="list-page">
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-group input-group search-not-found">
                    <input type="text" class="form-control" placeholder="Search...." id="">
                    <button type="submit" class="remove-search d-none" id="movie-remove">
                        <i class="ph ph-x"></i>
                     </button>
                    <button class="input-group-text btn btn-primary px-3" id="movie-search">
                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </circle>
                            <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                         </svg>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div id="search_histroy" class="search-histroy mt-4"></div>
    </div>

    <div class="movie-lists section-spacing-bottom" id="search_list">
        <div class="container-fluid">
            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6" id="results"></div>
        </div>
    </div>
    <div class="movie-lists section-spacing-bottom shimmer-container d-none ">
        <div class="container-fluid card-style-slider ">
            <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 mt-3">
                    @for ($i = 0; $i < 12; $i++)
                        <div class="shimmer-container col mb-3">
                                @include('components.card_shimmer_movieList')
                        </div>
                    @endfor
            </div>
        </div>
    </div>

    <div class="search-not-found py-5 my-md-5" id="no_result"></div>

    <div  id="more-like-this" >

        @if( isenablemodule('movie') == 1 && $movieData->isNotEmpty()  )
         <div class="streamit-block">
            <div class="container-fluid padding-right-0">
               <div class="overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between my-2 me-2">
                        <h5 class="main-title text-capitalize mb-0 ">{{ __('frontend.popular_movie') }}</h5>
                        @if(count($movieData)>7)

                            @if(!empty($is_watch_list ))
                                <a href="{{ route('watchList') }}" class="view-all-button text-decoration-none flex-none"><span>{{__('frontend.view_all')}}</span> <i class="ph ph-caret-right"></i></a>
                            @else
                            <a href="{{  route('movies') }}" class="view-all-button text-decoration-none flex-none"><span>{{__('frontend.view_all')}}</span> <i class="ph ph-caret-right"></i></a>
                            @endif
                        @endif
                    </div>
                  <div class="card-style-slider {{ count($movieData) <= 6 ? 'slide-data-less' : '' }}">
                     <div class="slick-general slick-movie" data-items="6.5" data-items-desktop="5.5" data-items-laptop="4.5" data-items-tab="3.5" data-items-mobile-sm="3.5"
                         data-items-mobile="2.5" data-speed="1000" data-autoplay="false" data-center="false" data-infinite="false"
                         data-navigation="true" data-pagination="false" data-spacing="12">
                     </div>
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
         </div>
         @else
         <div class="footer-fix"></div>
        @endif
    </div>

</div>
@endsection
@push('after-scripts')
<script>
window.onload = function() {
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    const currentUrl = window.location.href;
    const searchNavLink = document.getElementById('search-drop');
    const searchDropdown = document.querySelector('.dropdown-menu');

    // Check if we are on the search page
    if (currentUrl.includes('/search')) {
        searchNavLink.classList.add('show');
        searchDropdown.classList.add('show');
    }

    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('query');

    // Set the search input value to the query if it exists
    const searchInput = document.querySelector('input[placeholder="Search...."]');
    searchInput.value = query || '';




    let debounceTimer;


    // If a query exists, run the search function
    if (query) {
        search(query);
    }

    document.getElementById('movie-search').addEventListener('click', function() {
        const envURL = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
        const query = searchInput.value;

        if (query) {
            // Redirect with query if it's present
            window.location.href = `${envURL}/search?query=${encodeURIComponent(query)}`;
        }
    });

    // Add event listener for Enter key press
    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            document.getElementById('movie-search').click();
        }
    });

    const removeSearchButton = document.querySelector('#movie-remove');
    // Add event listener to the search input
searchInput.addEventListener('input', function() {
    toggleRemoveButton(); // Show or hide the remove button based on input value
});

// Function to toggle the remove button based on input value
function toggleRemoveButton() {
    if (searchInput.value.trim() !== '') {
        removeSearchButton.style.display = 'block'; // Show the button
    } else {
        removeSearchButton.style.display = 'none'; // Hide the button
    }
}


    // Hide the remove button initially if there's no value in the input
    toggleRemoveButton();
    removeSearchButton.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));

        const newUrl = `${window.location.origin}${window.location.pathname}`;
        window.history.pushState({}, '', newUrl); // Update the URL without reloading the page
        const query = document.getElementById('search-query').value;
       search(query)

    });

    function search(query) {
        clearTimeout(debounceTimer); // Clear the previous timer

        debounceTimer = setTimeout(() => {
            if (query.length === 0) {
                // Clear search results and history
                $('#search_histroy').empty();
                $('#results').empty();
                $('#no_result').empty();
                $('#more-like-this').removeClass('d-none'); // Show popular movies section
                $('.remove-search').addClass('d-none');
            } else {
                $('.remove-search').removeClass('d-none');
                performSearch(query);
                if (isLoggedIn) {
                    getSearchKey(query);
                }
                $('.shimmer-container').removeClass('d-none'); // Show shimmer while searching
            }
        }, 300);
    }

    function performSearch(query) {
        const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
        const searchApiUrl = `${baseUrl}/api/get-search`;
        const searchUrl = `${searchApiUrl}?search=${encodeURIComponent(query)}&is_ajax=1`;

        $.ajax({
            url: searchUrl,
            method: 'GET',
            success: function(response) {
                if (response.status) {
                    if (response.html === '') {
                        $('.shimmer-container').addClass('d-none');
                        $('.movie-lists').removeClass('d-none');
                        $('#more-like-this').removeClass('d-none'); // Show popular movies section if no results
                        $('#no_result').html(`
                            <div class="container-fluid">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div class="image">
                                        <img src="{{ asset('/img/web-img/search-not-found.png') }}" class="img-fluid" alt="search-not-found">
                                    </div>
                                    <div class="content">
                                        <h5 class="mb-3">Sorry, Could not Find Your Search!</h5>
                                        <span>Try something new</span>
                                    </div>
                                </div>
                            </div>
                        `);
                    } else {
                        $('.shimmer-container').addClass('d-none');
                    $('.no_result').removeClass('d-none');
                    $('#no_result').empty().append('');
                    $('#results').empty().append('')
                    $('#more-like-this').addClass('d-none');
                    $('#results').empty().append(response.html);
                    const resultCount = $(response.html).find('.slick-item').length;

                    if (resultCount > 1) {
                        // Initialize or reinitialize slick if there are multiple results
                        slickInstance.slick({
                            infinite: true,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        });
                        updateFirstLastClasses(slickInstance);
                    }
                    }
                }
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }

    function getSearchKey(query) {
        const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
        const searchlistApiUrl = `${baseUrl}/api/search-list`;
        const searchlistUrl = `${searchlistApiUrl}?search=${encodeURIComponent(query)}&is_ajax=1&per_page=20`;

        $.ajax({
            url: searchlistUrl,
            method: 'GET',
            success: function(response) {
                if (response.status) {
                    $("#search_histroy").empty();
                    response.data.forEach(item => {
                        const searchHtml = `
                            <div id="search-history-${item.id}" class="history-item">
                                <span onclick="performSearch('${item.search_query}')">
                                    ${item.search_query}
                                </span>
                                <button onclick="removeSearchHistory(${item.id})">Remove</button>
                            </div>
                        `;
                        $("#search_histroy").append(searchHtml);
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }

    function removeSearchHistory(id) {
        const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
        const searchApiUrl = `${baseUrl}/api/delete-search?id=${id}`;

        $.ajax({
            url: searchApiUrl,
            method: 'GET',
            success: function(response) {
                if (response.status) {
                    $("#search-history-" + id).addClass('d-none');
                }
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }
};



function updateFirstLastClasses(slider) {
        let active = slider.find(".slick-active");
        slider.find(".slick-item").removeClass("first last");
        if (active.length > 0) {
            active.first().addClass("first");
            active.last().addClass("last");
        }
    }

document.addEventListener('DOMContentLoaded', () => {
      loadData(`.movie-shimmer`, 'tranding_movie', `.slick-movie`);
    // loadData(`.tvshow-shimmer`, 'tranding_tvshow', `.slick-tvshow`);

    const slickInstance = $('.slick-general');
    updateFirstLastClasses(slickInstance);
    slickInstance.on('afterChange', function(event, slick, currentSlide) {
        updateFirstLastClasses(slickInstance);
    });


    });

    function loadData(containerSelector, apiSection, slickInstance) {

const container = document.querySelector(containerSelector);
 const baseUrl = "{{ env('APP_URL') }}";
 const apiUrl = `${baseUrl}/api/get-tranding-data`;
 const csrf_token='{{ csrf_token() }}'
 if (!apiSection) {
    return;
}

fetch(`${apiUrl}?is_ajax=1&section=${apiSection}`)
    .then(response => response.json())
    .then(data => {
        if (data?.html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(data.html, 'text/html');
            const slickItems = doc.querySelectorAll('.entainment-slick-card');
               if(slickItems){
                slickItems.forEach(item => {
                        if (item.outerHTML.trim() !== '<div class="slick-item"></div>') {
                            // Create a new slick item wrapper
                            const newItem = document.createElement('div');
                            newItem.classList.add('slick-item');
                            newItem.innerHTML = item.outerHTML; // Add the outer HTML of the item
                            updateFirstLastClasses($(slickInstance));
                            // Add the new item to the Slick instance
                            $(slickInstance).slick('slickAdd', newItem.outerHTML);
                            $(slickInstance).slick('setPosition');
                        }
                    });
                   }
                //    const firstItem = $(slickInstance).find('.slick-item').first();
                // if (firstItem.length) {
                //     firstItem.addClass('first'); // Change to your class
                // }


                 if(container){
                    container.style.display = 'none';
                 }
                // $(slickInstance).slick('setPosition');
        } else {
            container.innerHTML = '';
            console.error('Invalid data from the API');
        }
    })
    .catch(error => console.error('Fetch error:', error))
    .finally(() => {
    });
}

</script>
@endpush
