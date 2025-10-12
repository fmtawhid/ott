@php
    $currentRoute = Route::currentRouteName();
    $noAbsoluteRoutes = ['movie-details', 'tvshow-details', 'episode-details', 'video-detail','pay-per-view.paymentform','pay-per-view'];
@endphp
<header class="{{ $currentRoute === 'user.login' && !in_array($currentRoute, $noAbsoluteRoutes) ? 'header-absolute' : '' }}">
    <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar header-hover-menu py-xl-0">
        <div class="container-fluid navbar-inner">
            <div class="d-flex align-items-center justify-content-between w-100 landing-header">
                <div class="d-flex gap-3 gap-xl-0 align-items-center">
                    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar_main"
                        aria-controls="navbar_main"
                        class="d-xl-none btn btn-primary rounded-pill toggle-rounded-btn">
                        <i class="ph ph-arrow-right"></i>
                    </button>
                    @include('frontend::components.partials.logo')
                </div>

                @include('frontend::components.partials.horizontal-nav')
                <div class="right-panel">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-btn">
                            <span class="navbar-toggler-icon"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-flex flex-md-row flex-column align-items-md-center align-items-end justify-content-end gap-xl-4 gap-0">
                            <ul class="navbar-nav align-items-center list-inline justify-content-end mt-md-0 mt-3">
                                <li class="flex-grow-1">
                                    <div class="search-box position-relative text-end">
                                        <a href="#" class="nav-link p-0 d-md-inline-block d-none" id="search-drop" data-bs-toggle="dropdown">
                                           <div class="btn-icon btn-sm rounded-pill btn-action">
                                              <span class="btn-inner">
                                                 <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                                                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                 </svg>
                                              </span>
                                           </div>
                                        </a>
                                        <ul class="dropdown-menu p-0 dropdown-search m-0 iq-search-bar" style="width: 20rem;">
                                           <li class="p-0">
                                              <div class="form-group input-group mb-0">
                                                <button type="submit" id="search-button" class="search-submit">
                                                    <svg class="icon-15" width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                                                        <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                 </button>
                                                 <input type="text" id="search-query" class="form-control border-0" placeholder="Search...">
                                              </div>
                                           </li>
                                        </ul>
                                     </div>
                                </li>
                            </ul>
                            <ul class="navbar-nav align-items-center mb-0 list-inline justify-content-end">
                                <li class="nav-item dropdown dropdown-language-wrapper">
                                    <button class="btn btn-dark gap-3 px-3 dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('flags/' . App::getLocale() . '.png') }}" alt="flag" class="img-fluid me-2" style="width: 20px; height: auto; min-width: 15px;"
                                        onerror="this.onerror=null; this.src='{{asset('flags/globe.png')}}';">
                                        {{ strtoupper(App::getLocale()) }}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-language mt-0">
                                        @foreach (config('app.available_locales') as $locale => $title)
                                            <a class="dropdown-item" href="{{ route('frontend.language.switch', $locale) }}">
                                                <span class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset('flags/' . $locale . '.png') }}" alt="flag" class="img-fluid mr-2" style="width: 20px;height: auto;min-width: 15px;">
                                                    <span>{{ $title }}</span>
                                                    <span class="active-icon"><i class="ph-fill ph-check-fat align-middle"></i></span>
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </li>

                                @if(auth()->check())
                                    @if(auth()->user()->user_type == 'user')
                                        <li class="nav-item">
                                            @if(auth()->user()->is_subscribe == 0)
                                                <button class="btn btn-warning-subtle font-size-14 text-uppercase subscribe-btn" onclick="window.location.href='{{ route('subscriptionPlan') }}'">
                                                    {{__('frontend.subscribe')}}
                                                </button>
                                            @else
                                                <button class="btn btn-warning-subtle font-size-14 text-uppercase subscribe-btn" onclick="window.location.href='{{ route('subscriptionPlan') }}'">
                                                    {{__('frontend.upgrade')}}
                                                </button>
                                            @endif
                                        </li>
                                    @endif

                                  {{-- <li class="nav-item dropdown ms-3">
    <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ph ph-bell icon-24"></i>
        @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadCount }}
                <span class="visually-hidden">unread notifications</span>
            </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm p-0 mt-2" aria-labelledby="notificationDropdown" style="min-width: 300px;">
        <li class="dropdown-header py-2 px-3 fw-bold">{{ __('Notifications') }}</li>
        @forelse(auth()->user()->notifications->take(5) as $notification)
            <li class="dropdown-item px-3 py-2 small text-wrap">
                {{ $notification->data['message'] ?? 'New notification' }}
                <br><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
            </li>
        @empty
            <li class="dropdown-item px-3 py-2 text-muted small">{{ __('No new notifications') }}</li>
        @endforelse
        <li>
            <a class="dropdown-item text-center text-primary fw-semibold py-2" href="{{ route('backend.notification-templates.index') }}">
                {{ __('View all') }}
            </a>
        </li>
    </ul>
</li> --}}


                                    <li class="nav-item flex-shrink-0 dropdown dropdown-user-wrapper">
                                        <a class="nav-link dropdown-user" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ setBaseUrlWithFileName(auth()->user()->file_url)}}" class="img-fluid user-image rounded-circle" alt="user image">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-user-menu border border-gray-900" aria-labelledby="navbarDropdown">
                                            <div class="bg-body p-3 d-flex justify-content-between align-items-center gap-3 rounded mb-4">
                                                <div class="d-inline-flex align-items-center gap-3">
                                                    <div class="image flex-shrink-0">
                                                        <img src="{{ setBaseUrlWithFileName(auth()->user()->file_url) }}" class="img-fluid dropdown-user-menu-image" alt="">
                                                    </div>
                                                    <div class="content">
                                                        <h6 class="mb-1">{{ auth()->user()->full_name ?? default_user_name() }}</h6>
                                                        <span class="font-size-14 dropdown-user-menu-contnet">{{ auth()->user()->email }}</span>
                                                    </div>
                                                </div>
                                                <div class="link">
                                                    <a href="{{ route('edit-profile') }}" class="link-body-emphasis">
                                                        <i class="ph ph-caret-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <ul class="d-flex flex-column gap-3 list-inline m-0 p-0">
                                                <li>
                                                    <a href="{{ route('watchList') }}" class="link-body-emphasis font-size-14">
                                                        <span class="d-flex align-items-center justify-content-between gap-3">
                                                            <span class="fw-medium">{{__('frontend.my_watchlist')}}</span>
                                                            <i class="ph ph-caret-right"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                        @if(getCurrentProfileSession('is_child_profile') == 0)
<li class="d-flex align-items-center justify-content-between py-2 {{ auth()->user()->pin ? 'border-bottom border-secondary' : '' }}">
    <a href="javascript:void(0);" class="link-body-emphasis font-size-14 d-flex align-items-center gap-2">
        <span class="fw-medium">{{ __('frontend.security_control') }}</span>
    </a>

    <!-- Toggle Switch -->
    <label class="toggle-switch mb-0 ms-2">
        <input
            type="checkbox"
            name="security_toggle"
            id="security_toggle"
            value="1"
            data-security-url="{{ route('security-control') }}"
            data-disable-url="{{ route('disable-security') }}"
            {{ auth()->user()->is_parental_lock_enable ? 'checked' : '' }}
        >
        <span class="slider"></span>
    </label>
</li>

<li id="security_control_section" class="{{ auth()->user()->is_parental_lock_enable ? '' : 'd-none' }}">
 <a href="{{ route('security-control') }}" id="pinActionBtn" class="d-flex align-items-center justify-content-between py-2 text-decoration-none text-white">
    <div class="d-flex align-items-center gap-2">
        <!-- Inserted SVG icon -->
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_8998_18394)">
                <path d="M5 10H13C13.1326 10 13.2598 9.94732 13.3536 9.85355C13.4473 9.75979 13.5 9.63261 13.5 9.5V3C13.5 2.86739 13.4473 2.74021 13.3536 2.64645C13.2598 2.55268 13.1326 2.5 13 2.5H6C5.86739 2.5 5.74021 2.55268 5.64645 2.64645C5.55268 2.74021 5.5 2.86739 5.5 3V3.5" stroke="#999797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.5 8.5L5 10L6.5 11.5" stroke="#999797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11 6H3C2.86739 6 2.74021 6.05268 2.64645 6.14645C2.55268 6.24021 2.5 6.36739 2.5 6.5V13C2.5 13.1326 2.55268 13.2598 2.64645 13.3536C2.74021 13.4473 2.86739 13.5 3 13.5H10C10.1326 13.5 10.2598 13.4473 10.3536 13.3536C10.4473 13.2598 10.5 13.1326 10.5 13V12.5" stroke="#999797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9.5 7.5L11 6L9.5 4.5" stroke="#999797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <defs>
                <clipPath id="clip0_8998_18394">
                    <rect width="16" height="16" fill="white"/>
                </clipPath>
            </defs>
        </svg>


        @if(empty(auth()->user()->pin))
            {{ __('frontend.set_pin') }}
        @else
            {{ __('frontend.change_pins') }}
        @endif
    </div>
</a>


    <div id="pinFormContainer" class="mt-2 d-none">
        <!-- JS will load the PIN form here -->
    </div>
</li>
@endif




                                                </li>

                                                 <li>
                                                    <a href="{{ route('unlock.videos') }}" class="link-body-emphasis font-size-14">
                                                        <span class="d-flex align-items-center justify-content-between gap-3">
                                                            <span class="fw-medium">{{__('messages.lbl_unlock_videos')}}</span>
                                                            <i class="ph ph-caret-right"></i>
                                                        </span>
                                                    </a>
                                                </li>


                                                <li>
                                                    <a href="{{ route('edit-profile') }}" class="link-body-emphasis font-size-14">
                                                        <span class="d-flex align-items-center justify-content-between gap-3">
                                                            <span class="fw-medium">{{__('frontend.profile')}}</span>
                                                            <i class="ph ph-caret-right"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('subscriptionPlan') }}" class="link-body-emphasis font-size-14">
                                                        <span class="d-flex align-items-center justify-content-between gap-3">
                                                            <span class="fw-medium">{{__('frontend.subscription_plan')}}</span>
                                                            <i class="ph ph-caret-right"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('accountSetting') }}" class="link-body-emphasis font-size-14">
                                                        <span class="d-flex align-items-center justify-content-between gap-3">
                                                            <span class="fw-medium">{{__('frontend.account_setting')}}</span>
                                                            <i class="ph ph-caret-right"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('payment-history') }}" class="link-body-emphasis font-size-14">
                                                        <span class="d-flex align-items-center justify-content-between gap-3">
                                                            <span class="fw-medium">{{__('frontend.subscription_history')}}</span>
                                                            <i class="ph ph-caret-right"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                                <!--<li>-->
                                                <!--    <a href="{{ route('transaction-history') }}" class="link-body-emphasis font-size-14">-->
                                                <!--        <span class="d-flex align-items-center justify-content-between gap-3">-->
                                                <!--            <span class="fw-medium">{{__('frontend.pay_per_view_transactions')}}</span>-->
                                                <!--            <i class="ph ph-caret-right"></i>-->
                                                <!--        </span>-->
                                                <!--    </a>-->
                                                <!--</li>-->

                                                <li>
                                                    <a href="{{ route('user-logout') }}" class="link-primary font-size-14">
                                                        <span class="d-flex align-items-center justify-content-between gap-3">
                                                            <span class="fw-medium">{{__('frontend.logout')}}</span>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="btn btn-primary font-size-14 login-btn">
                                            {{__('frontend.login')}}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('security_toggle');
    const securityControlSection = document.getElementById('security_control_section');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    var securityToggle = document.getElementById('security_toggle');
    var toggleLabel = securityToggle?.closest('label');

    if (securityToggle) {
        securityToggle.addEventListener('click', function(event) {
            event.stopPropagation();
        });
        securityToggle.addEventListener('mousedown', function(event) {
            event.stopPropagation();
        });
    }
    if (toggleLabel) {
        toggleLabel.addEventListener('click', function(event) {
            event.stopPropagation();
        });
        toggleLabel.addEventListener('mousedown', function(event) {
            event.stopPropagation();
        });
    }

    if (toggle) {
        const dropdownItem = toggle.closest('.dropdown-item-flex');
        if (dropdownItem) {
            dropdownItem.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }

        toggle.addEventListener('change', function () {
            toggle.disabled = true;

            if (this.checked) {
                const securityUrl = this.dataset.securityUrl;

                fetch(securityUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        toggle.checked = true;
                        securityControlSection.classList.remove('d-none');
                        @if(auth()->check())
                            if (!{{ auth()->user()->pin ? 'true' : 'false' }}) {
                                $('#parentPinModal').modal('show');
                            }
                        @endif
                    } else {
                        throw new Error('Failed to enable security');
                    }
                })
                .catch(error => {
                    console.error('Error details:', error);
                    toggle.checked = false;
                    securityControlSection.classList.add('d-none');
                    window.successSnackbar('Error enabling security. Please try again.');
                })
                .finally(() => {
                    toggle.disabled = false;
                });

            } else {
                const disableUrl = this.dataset.disableUrl;

                fetch(disableUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        toggle.checked = false;
                        securityControlSection.classList.add('d-none');
                    } else {
                        throw new Error('Failed to disable security');
                    }
                })
                .catch(error => {
                    console.error('Error details:', error);
                    toggle.checked = true;
                    securityControlSection.classList.remove('d-none');
                    window.successSnackbar('Error disabling security. Please try again.');
                })
                .finally(() => {
                    toggle.disabled = false;
                });
            }
        });
    }
});
</script>

<script>
    window.onload = function() {
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('query');
    document.getElementById('search-query').value = query;
    const envURL = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
    const searchButton = document.getElementById('search-button');
    const searchInput = document.getElementById('search-query');


    // Handle search button click
    searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        const query = searchInput.value.trim();

        if (query) {
            // Redirect to the search page with query as a parameter
            window.location.href = `${envURL}/search?query=${encodeURIComponent(query)}`;
        }
    });

    // Add event listener for Enter key press
    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchButton.click();
        }
    });
};

</script>

 <style>
        /* Simple toggle switch CSS */
      li {
    list-style: none;
}

li a {
    color: white;
    font-size: 14px;
}

li a:hover {
    background-color: #222;
    border-radius: 6px;
}

.border-bottom {
    border-bottom: 1px solid #333 !important;
}

/* Your toggle switch styles */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 34px;   /* between 25 and 44 */
    height: 16px;  /* between 12 and 22 */
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 12px;    /* between 8 and 16 */
    width: 12px;
    left: 3px;
    bottom: 2px;  /* slight adjustment for vertical centering */
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input[type="checkbox"]:checked + .slider {
    background-color: rgb(212, 12, 12);
}

input[type="checkbox"]:checked + .slider:before {
    transform: translateX(17px); /* adjusted for 34px width */
}

input:disabled + .slider {
    background-color: #999;
    cursor: not-allowed;
}

.border-bottom {
    border-bottom: 1px solid #333 !important;
}

    </style>
