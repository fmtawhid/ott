
<div class="detail-page-info section-spacing">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="movie-detail-content">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-7">
                            <div class="d-flex align-items-center">
                                @if($data['is_restricted'] == 1)
                                    <span class="movie-badge rounded fw-bold font-size-12 px-2 py-1 me-3">{{__('frontend.age_restriction')}}</span>
                                @endif
                              <ul class="genres-list ps-0 mb-2 d-flex flex-wrap align-items-center gap-2">
    @if(isset($data['genres']) && $data['genres']->isNotEmpty())
        @foreach($data['genres'] as $index => $genreResource)
            <li class="position-relative fw-semibold d-flex align-items-center">
                {{ $genreResource->name ?? '--' }}
                @if(!$loop->last)
                    <span class="mx-1">•</span>
                @endif
            </li>
        @endforeach
    @else
        <li>No genres found</li>
    @endif
</ul>


                            </div>
                        </div>
                        @if($data['your_review'] == null)
                            <div class="col-md-5 mt-md-0 mt-4 text-md-end" id="addratingbtn">
                                @if(Auth::check())
                                <button class="btn btn-dark"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rattingModal"
                                        data-entertainment-id="{{ $data['id'] }}">
                                    <span class="d-flex align-items-center justify-content-center gap-2">
                                        <span class="text-warning"><i class="ph-fill ph-star"></i></span>
                                        <span>{{ __('frontend.rate_this') }}</span>
                                    </span>
                                </button>
                                @else
                                    <a href="{{ url('/login') }}" class="btn btn-dark">
                                        <span class="d-flex align-items-center justify-content-center gap-2">
                                            <span class="text-warning"><i class="ph-fill ph-star"></i></span>
                                            <span>{{ __('frontend.rate_this') }}</span>
                                        </span>
                                    </a>
                                @endif
                            </div>
                            {{-- @else
                            @if(Auth::check())
                            <div class="col-md-5 mt-md-0 mt-4 text-md-end d-none"  id="addratingbtn">
                                <button
                                class="btn btn-dark"
                                data-bs-toggle="modal"
                                data-bs-target="#rattingModal"
                                data-entertainment-id="{{ $data['id'] }}">
                                    <span class="d-flex align-items-center justify-content-center gap-2">
                                        <span class="text-warning"><i class="ph-fill ph-star"></i></span>
                                        <span>{{ __('frontend.rate_this') }}</span>
                                    </span>
                                </button>
                            </div>
                            @endif --}}
                        @endif
                    </div>
                    @if($data['movie_access'] == 'pay-per-view' && !\Modules\Entertainment\Models\Entertainment::isPurchased($data['id'],$data['type']))
                    <div class="bg-dark text-white p-3 mb-2 d-flex justify-content-between align-items-center" style="border-width: 2px;">
                        <div>
                            @if($data['purchase_type'] === 'rental')
                                <span>
                                    {!! __('messages.rental_info', [
                                        'days' => $data['available_for'],
                                        'hours' => $data['access_duration']
                                    ]) !!}
                                    <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#rentalPurchaseModal">
                                        <i class="ph ph-info">i</i>
                                    </button>
                                </span>
                            @else
                                <span>
                                    {!! __('messages.purchase_info', [
                                        'days' => $data['available_for'],
                                    ]) !!}
                                    <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#onetimePurchaseModal">
                                        <i class="ph ph-info">i</i>
                                    </button>
                                </span>
                            @endif
                        </div>

                        <div>
                            <div>
                                @if($data['purchase_type'] === 'rental')
                                    <a href="{{ route('pay-per-view.paymentform',['id' => $data['id'],'type' => $data['type']]) }}" class="btn btn-success d-flex align-items-center">
                                        <i class="bi bi-lock-fill me-1"></i>
                                        @if($data['discount'] > 0)
                                            <span class="me-2">
                                                {{ __('messages.rent_button', ['price' => Currency::format($data['price'] - ($data['price'] * ($data['discount'] / 100)), 2)]) }}
                                            </span>
                                            <span class="text-decoration-line-through text-white-50">
                                                {{ Currency::format($data['price'], 2) }}
                                            </span>
                                        @else
                                            {{ __('messages.rent_button', ['price' => Currency::format($data['price'], 2)]) }}
                                        @endif
                                    </a>
                                @else
                                    <a href="{{ route('pay-per-view.paymentform',['id' => $data['id'],'type' => $data['type']]) }}" class="btn btn-success d-flex align-items-center">
                                        <i class="bi bi-unlock-fill me-1"></i>
                                        @if($data['discount'] > 0)
                                            <span class="me-2">
                                                {{ __('messages.one_time_button', ['price' => Currency::format($data['price'] - ($data['price'] * ($data['discount'] / 100)), 2)]) }}
                                            </span>
                                            <span class="text-decoration-line-through text-white-50">
                                                {{ Currency::format($data['price'], 2) }}
                                            </span>
                                        @else
                                            {{ __('messages.one_time_button', ['price' => Currency::format($data['price'], 2)]) }}
                                        @endif
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    <h4>{{ $data['name'] }}</h4>
                    <p class="font-size-14">{!! $data['description'] !!}</p>
                    <ul class="list-inline mt-4 mb-0 mx-0 p-0 d-flex align-items-center flex-wrap gap-3 movie-metalist">
                        <li>
                            <span class="d-flex align-items-center gap-2">
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($data['release_date'])->format('Y') }}</span>
                            </span>
                        </li>
                        <li>
                            <span class="d-flex align-items-center gap-2">
                                <span><i class="ph ph-translate lh-base"></i></span>
                                <span class="fw-medium">{{ $data['language'] }}</span>
                            </span>
                        </li>
                        <li>
                            <span class="d-flex align-items-center gap-2">
                                <span><i class="ph ph-clock lh-base"></i></span>
                                {{ $data['duration'] ? formatDuration($data['duration']) : '--' }}
                            </span>
                        </li>
                        <!--<li>-->
                        <!--    @if($data['imdb_rating'])-->
                        <!--        <span class="d-flex align-items-center gap-2">-->
                        <!--            <span><i class="ph ph-star lh-base"></i></span>-->
                        <!--            <span class="fw-medium">{{ $data['imdb_rating'] }} (IMDb)</span>-->
                        <!--        </span>-->
                        <!--    @endif-->
                        <!--</li>-->
                    </ul>
                    @php


                   $qualityOptions = [];
                        if($data['type']=='movie'){
                          $videoLinks = $data['video_links'];
                          $episode_id='';
                          $type=$data['video_upload_type'];
                          $video_url= $data['video_upload_type']=== 'Local' ? $data['video_url_input'] : $data['video_url_input'] ;

                         if($data['enable_quality']==1){

                            foreach($videoLinks as $link) {
                              $qualityOptions[$link->quality] = [
                                  'value' => $link->type === 'Local' ? setBaseUrlWithFileName($link->url) : Crypt::encryptString($link->url),
                                  'type' => $link->type // Add the type here
                              ];
                            }

                         }

                        }else{

                             $episodeData=$data['episodeData'];
                             $videoLinks = $episodeData['video_links'];
                             $episode_id = $episodeData['id'];
                             $type=$episodeData['video_upload_type'];
                             $video_url= $episodeData['video_upload_type']=== 'Local' ? ($episodeData['video_url_input']) : Crypt::encryptString($episodeData['video_url_input']) ;

                          foreach($videoLinks as $link) {
                            $qualityOptions[$link->quality] = [
                                'value' => $link->type === 'Local' ? setBaseUrlWithFileName($link->url) : Crypt::encryptString($link->url),
                                'type' => $link->type // Add the type here
                            ];
                          }


                        }


                        $qualityOptionsJson = json_encode($qualityOptions);

                        if ($data['type'] == 'movie' && isset($data['subtitle_info'])) {
                            $subtitleInfoJson = json_encode($data['subtitle_info']->toArray(request()));
                        } elseif ($data['type'] == 'tvshow' && isset($episodeData) && isset($episodeData['subtitle_info'])) {
                            $subtitleInfoJson = json_encode($episodeData['subtitle_info']->toArray(request()));
                        } else {
                            $subtitleInfoJson = json_encode([]);
                        }

                            $Isepisodepurhcase = false;
                            if(isset($episodeData) && isset($episodeData['access']) && $episodeData['access'] == 'pay-per-view') {
                                $Isepisodepurhcase = \Modules\Entertainment\Models\Entertainment::isPurchased($episode_id,'episode');
                            }
                    @endphp


                    @if($data['movie_access'] != 'pay-per-view' || \Modules\Entertainment\Models\Entertainment::isPurchased($data['id'],$data['type']) )
                    <div class="d-flex align-items-center flex-wrap gap-4 mt-5">
                        <div class="play-button-wrapper">
                                            @if(
                            isset($episodeData)
                            && isset($episodeData['access'])
                            && $episodeData['access'] == 'pay-per-view'
                            && !$Isepisodepurhcase
                        )
                            <a
                                href="{{ route('pay-per-view.paymentform', ['id' => $episode_id,'type'=> 'episode']) }}"
                                class="btn btn-primary"
                            >
                            <span class="d-flex align-items-center justify-content-center gap-2">
                                <span><i class="ph-fill ph-lock"></i></span>
                                <span>{{ __('frontend.watch_now') }}</span>
                            </span>
                            </a>
                        @else
                            <button
                                class="btn btn-primary"
                                id="watchNowButton"
                                data-type="{{ $type }}"
                                data-entertainment-id="{{ $data['id'] }}"
                                data-entertainment-type="{{ $data['type'] }}"
                                data-video-url="{{ $video_url }}"
                                data-movie-access="{{ $data['movie_access'] }}"
                                content-video-type="video"
                                data-plan-id="{{ $data['plan_id'] }}"
                                data-user-id="{{ auth()->id() }}"
                                data-purchase-type="{{ $data['purchase_type'] }}"
                                data-profile-id="{{ getCurrentProfile(auth()->id(),request()) }}"
                                data-episode-id="{{ $episode_id }}"
                                data-first-episode-id="1"
                                data-quality-options="{{ $qualityOptionsJson }}"
                                data-subtitle-info="{{ $subtitleInfoJson }}",
                                data-contentid="{{ $data['type'] == 'movie' ? $data['id'] : $episode_id }}",
                                data-contenttype="{{ $data['type'] }}",
                                content-video-type="video"
                            >
                                <span class="d-flex align-items-center justify-content-center gap-2">
                                    <span><i class="ph-fill ph-play"></i></span>
                                    <span>{{ __('frontend.watch_now') }}</span>
                                </span>
                            </button>
                        @endif
                        </div>
                        @endif
                        {{-- @dd($data); --}}
                        <ul class="actions-list list-inline m-0 p-0 d-flex align-items-center flex-wrap gap-3">
                            <li>
                                <x-watchlist-button :entertainment-id="$data['id']" :in-watchlist="$data['is_watch_list']" customClass="watch-list-btn" />
                            </li>
                            <li class="position-relative share-button dropend dropdown">
                                <button type="button" class="action-btn btn btn-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ph ph-share-network"></i>
                                </button>
                                <div class="share-wrapper">
                                    <div class="share-box dropdown-menu">
                                        <svg width="15" height="40" viewBox="0 0 15 40" class="share-shape" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.8842 40C6.82983 37.2868 1 29.3582 1 20C1 10.6418 6.82983 2.71323 14.8842 0H0V40H14.8842Z" fill="currentColor"></path>
                                        </svg>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="https://www.facebook.com/sharer?u={{ urlencode(Request::url()) }}" target="_blank" rel="noopener noreferrer" class="share-ico"><i class="ph ph-facebook-logo"></i></a>
                                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($data['name']) }}&url={{ urlencode(Request::url()) }}" target="_blank" rel="noopener noreferrer" class="share-ico"><i class="ph ph-x-logo"></i></a>
                                            <a href="#" data-link="{{ Request::url() }}" class="share-ico iq-copy-link" id="copyLink"><i class="ph ph-link"></i></a>

                                            <span id="copyFeedback" style="display: none; margin-left: 10px;">{{ __('frontend.copied') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- <li>
                                <button class="action-btn btn btn-dark">
                                    <i class="ph ph-download-simple"></i>
                                </button>
                            </li> -->
                            <li>
                            <x-like-button :entertainmentId="$data['id']" :isLiked="$data['is_likes']" :type="$data['type']"/>
                            </li>

                            <!--- Cast button -->
                            @php
                            $video_upload_type = $data['video_upload_type'];
                            $plan_type = getActionPlan('video-cast');
                            @endphp
                            @if(!empty($plan_type) &&  ($video_upload_type == "Local" || $video_upload_type == "URL"))
                            @php
                            $video_url11 = ($video_upload_type == "URL") ? Crypt::decryptString($video_url) : $video_url;
                            @endphp
                            <li>
                                <button class="action-btn btn btn-dark" data-name="{{ $video_url11 }}" id="castme">
                                    <i class="ph ph-screencast"></i>
                                </button>
                            </li>
                            @endif
                            <!--- End cast button -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- One-time Purchase Modal -->
<div class="modal fade" id="onetimePurchaseModal" tabindex="-1" aria-labelledby="onetimePurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width:500px;">
        <div class="modal-content section-bg text-white rounded shadow border-0 p-4">

            <!-- Header Info -->
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    @if(isset($data['is_restricted']) && $data['is_restricted'] == 1)
                        <span class="badge bg-light text-dark fw-bold px-2 py-1 me-2">{{ __('messages.lbl_age_restriction') }}</span>
                    @endif
                    @if(isset($data['genres']) && count($data['genres']) > 0)
                        <span class="text-white-50 small">
                            @foreach($data['genres'] as $key => $genre)
                                {{ is_array($genre) ? (!empty($genre['name']) ? $genre['name'] : '--') : (isset($genre) && isset($genre->name) ? $genre->name : '--') }}@if(!$loop->last) &bull; @endif
                            @endforeach
                        </span>
                    @endif
                </div>
                <button class="custom-close-btn btn btn-primary" data-bs-dismiss="modal">
                    <i class="ph ph-x"></i>
                </button>
            </div>

             <!-- Movie Title -->
             <h4 class="fw-bold mb-2">{{ $data['name'] }}</h4>

            <!-- Movie Metadata -->
            <ul class="list-inline mb-4 d-flex flex-wrap gap-4">
                {{-- <li class="d-flex align-items-center gap-1"><span>{{ \Carbon\Carbon::parse($data['release_date'])->format('Y') }}</span></li> --}}
                <li class="d-flex align-items-center gap-1"><i class="ph ph-translate me-1"></i><span>{{ $data['language'] }}</span></li>
                <li class="d-flex align-items-center gap-1"><i class="ph ph-clock me-1"></i><span> {{ $data['duration'] ? formatDuration($data['duration']) : '--' }}</span></li>
                @if($data['imdb_rating'])
                    <li class="d-flex align-items-center gap-1"><i class="ph-fill ph-star text-warning"></i><span>{{ $data['imdb_rating'] }} ({{ __('messages.lbl_IMDb') }})</span></li>
                @endif
            </ul>

            <!-- Validity & Watch Time -->
            <div class="rounded p-5 mb-4 bg-dark">
                <div class="">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                         <p class="text-muted m-0 small">{{ __('messages.lbl_validity') }}</p>
                        <h6 class="fw-semibold m-0">{{ __('messages.lbl_watch_time') }}</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-4 border-bottom">
                       <p class="text-muted m-0 small">{{ __('messages.lbl_unlimited') }}</p>
                         @php
                            $availableDays = is_numeric($data['available_for']) ? (int)$data['available_for'] : 0;
                        @endphp

                        <h6 class="fw-semibold m-0">
                            {{ \Carbon\Carbon::now()->format('d-m-Y') }} to
                            {{ \Carbon\Carbon::now()->addDays($availableDays)->format('d-m-Y') }}
                        </h6>
                    </div>
                </div>
                {{-- <hr class="font-size-14 text-body"> --}}
                <ul class="font-size-14 text-body">
                    <li>{!! __('messages.info_start_days', ['days' => $data['available_for']]) !!}</li>
                    <li>{{ __('messages.info_multiple_times') }}</li>
                    <li>{!! __('messages.info_non_refundable') !!}</li>
                    <li>{{ __('messages.info_not_premium') }}</li>
                    <li>{{ __('messages.info_supported_devices') }}</li>
                </ul>
                 <!-- Agreement Checkbox -->
                <div class="form-check mb-4 d-flex align-items-center gap-3 p-0">
                    <input class="form-check-input m-0" type="checkbox" checked id="agreeCheckbox">
                    <label class="form-check-label small text-white-50" for="rentalAgreeCheckbox">
                        {{ __('messages.lbl_agree_term') }}
                        <a href="{{ route('page.show', ['slug' => 'terms-conditions']) }}" class="text-decoration-underline text-white">{{ __('messages.terms_use') }}</a>.
                    </label>
                </div>

                <!-- Rent Button -->
                <div class="text-center">
                    <a href="{{ route('pay-per-view.paymentform', ['id' => $data['id']]) }}" id="onetimeSubmitButton"
                    class="btn btn-success fw-semibold d-inline-flex justify-content-center align-items-center gap-2">
                        <i class="ph ph-lock-key"></i>

                        @if($data['discount'] > 0)
                            {{ __('messages.btn_onetime_payment', [
                                'price' => Currency::format($data['price'] - ($data['price'] * ($data['discount'] / 100)), 2)
                            ]) }}
                            <span class="text-decoration-line-through small text-white-50 ms-2">
                                {{ Currency::format($data['price'], 2) }}
                            </span>
                        @else
                            {{ __('messages.btn_onetime_payment', [
                                'price' => Currency::format($data['price'], 2)
                            ]) }}
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Rental Purchase Modal -->
<div class="modal fade" id="rentalPurchaseModal" tabindex="-1" aria-labelledby="rentalPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width:500px;">
        <div class="modal-content section-bg text-white rounded shadow-lg border-0 p-4">

            <!-- Header Info -->
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    @if(isset($data['is_restricted']) && $data['is_restricted'] == 1)
                        <span class="badge bg-light text-dark fw-bold px-2 py-1 me-2">{{ __('messages.lbl_age_restriction') }}</span>
                    @endif
                    @if(isset($data['genres']) && count($data['genres']) > 0)
                        <span class="text-white-50 small">
                            @foreach($data['genres'] as $key => $genre)
                                {{ is_array($genre) ? (!empty($genre['name']) ? $genre['name'] : '') : (isset($genre) && isset($genre->name) ? $genre->name : '--') }}@if(!$loop->last) &bull; @endif
                            @endforeach
                        </span>
                    @endif
                </div>
                <button class="custom-close-btn btn btn-primary" data-bs-dismiss="modal">
                    <i class="ph ph-x"></i>
                </button>
            </div>

            <!-- Movie Title -->
            <h4 class="fw-bold mb-2">{{ $data['name'] }}</h4>

            <!-- Movie Metadata -->
            <ul class="list-inline mb-4 d-flex flex-wrap gap-4">
                {{-- <li class="d-flex align-items-center gap-1"><span>{{ \Carbon\Carbon::parse($data['release_date'])->format('Y') }}</span></li> --}}
                <li class="d-flex align-items-center gap-1"><i class="ph ph-translate me-1"></i><span>{{ $data['language'] }}</span></li>
                <li class="d-flex align-items-center gap-1"><i class="ph ph-clock me-1"></i><span> {{ $data['duration'] ? formatDuration($data['duration']) : '--' }}</span></li>
                @if($data['imdb_rating'])
                    <li class="d-flex align-items-center gap-1"><i class="ph-fill ph-star text-warning"></i><span>{{ $data['imdb_rating'] }} ({{ __('messages.lbl_IMDb') }})</span></li>
                @endif
            </ul>

            <!-- Validity & Duration -->
            <div class="rounded p-5 mb-4 bg-dark">
                <div class="">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <p class="text-muted m-0 small">{{ __('messages.lbl_validity') }}</p>
                        <h6 class="fw-semibold m-0">{{ __('messages.lbl_days', ['days' => $data['available_for']]) }}</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-4 border-bottom">
                        <p class="text-muted m-0 small">{{ __('messages.lbl_watch_duration') }}</p>
                        <h6 class="fw-semibold m-0">{{ __('messages.lbl_days', ['days' => $data['access_duration']]) }}</h6>
                    </div>
                </div>
                <ul class="font-size-14 text-body ">
                    <li>{!! __('messages.rental_info_start', ['days' => $data['available_for']]) !!}</li>
                    <li>{!! __('messages.rental_info_duration', ['hours' => $data['access_duration']]) !!}</li>
                    <li>{!! __('messages.info_non_refundable') !!}</li>
                    <li>{{ __('messages.info_not_premium') }}</li>
                    <li>{{ __('messages.info_supported_devices') }}</li>
                </ul>


                <!-- Terms Checkbox -->
                <div class="form-check mb-4 d-flex align-items-center gap-3 p-0">
                    <input class="form-check-input m-0" type="checkbox" checked id="rentalAgreeCheckbox">
                    <label class="form-check-label small text-white-50" for="rentalAgreeCheckbox">
                        {{ __('messages.lbl_agree_term') }}
                        <a href="{{ route('page.show', ['slug' => 'terms-conditions']) }}" class="text-decoration-underline text-white">{{ __('messages.terms_use') }}</a>.
                    </label>
                </div>

                <!-- Rent Button -->
                <div class="">
                    <a href="{{ route('pay-per-view.paymentform', ['id' => $data['id']]) }}" id="rentalSubmitButton"
                    class="btn btn-success fw-semibold d-inline-flex justify-content-center align-items-center gap-2 w-100">
                        <i class="ph ph-film-reel"></i>

                        @if($data['discount'] > 0)
                            {{ __('messages.btn_rent_payment', [
                                'price' => Currency::format($data['price'] - ($data['price'] * ($data['discount'] / 100)), 2)
                            ]) }}
                            <span class="text-decoration-line-through small text-white-50 ms-2">
                                {{ Currency::format($data['price'], 2) }}
                            </span>
                        @else
                            {{ __('messages.btn_rent_payment', [
                                'price' => Currency::format($data['price'], 2)
                            ]) }}
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const oneTimeCheckbox = document.getElementById('agreeCheckbox');
        const oneTimeButton = document.getElementById('onetimeSubmitButton');
        oneTimeCheckbox.addEventListener('change', function () {
            if (this.checked) {
                oneTimeButton.classList.remove('disabled-link');
                oneTimeButton.style.pointerEvents = 'auto';
                oneTimeButton.style.opacity = '1';
            } else {
                oneTimeButton.classList.add('disabled-link');
                oneTimeButton.style.pointerEvents = 'none';
                oneTimeButton.style.opacity = '0.5';
            }
        });

        const rentalCheckbox = document.getElementById('rentalAgreeCheckbox');
        const rentalButton = document.getElementById('rentalSubmitButton');
        rentalCheckbox.addEventListener('change', function () {
            if (this.checked) {
                rentalButton.classList.remove('disabled-link');
                rentalButton.style.pointerEvents = 'auto';
                rentalButton.style.opacity = '1';
            } else {
                rentalButton.classList.add('disabled-link');
                rentalButton.style.pointerEvents = 'none';
                rentalButton.style.opacity = '0.5';
            }
        });
    });
</script>

<script>
    document.getElementById('copyLink').addEventListener('click', function (e) {
        e.preventDefault();

        var url = this.getAttribute('data-link');

        var tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        tempInput.setSelectionRange(0, 99999);
        window.successSnackbar('Link copied.');

        document.execCommand("copy");

        document.body.removeChild(tempInput);

        this.style.display = 'none';

        var feedback = document.getElementById('copyFeedback');
        feedback.style.display = 'inline';

        setTimeout(() => {
            feedback.style.display = 'none';
            this.style.display = 'inline';
        }, 1000);
    });
</script>

<script>
    $(document).ready(function () {
        $('#watchNowButton').on('click', function () {
            const button = $(this);
            const movie_access = button.data('movie-access');
            const puchase_type = button.data('purchase-type');
        const data = {
                user_id: button.data('user-id'),
                entertainment_id: button.data('entertainment-id'),
                entertainment_type: button.data('entertainment-type'),
                _token: '{{ csrf_token() }}'
            };
            if (movie_access == 'pay-per-view' && puchase_type == 'rental') {
                $.ajax({
                    url: '{{ route("pay-per-view.start-date") }}', // or '/pay-per-view/start-date'
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        // console.log('Start date set:', response);
                        // You can now proceed with video playback or other logic
                    },
                    error: function (xhr) {
                        console.error('Failed to set start date:', xhr.responseText);
                    }
                });
            }
        });
    });
</script>

