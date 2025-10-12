
<div class="season-card p-4 rounded-3">
    <div class="d-flex flex-sm-row flex-column gap-5">
        <div class="season-image flex-shrink-0">
            <img src="{{ $data['poster_image'] }}" alt="movie image" class="object-fit-cover rounded">
            @if($data['access'] == 'pay-per-view')
                @if(\Modules\Entertainment\Models\Entertainment::isPurchased($data['id'],'episode'))
                    <!-- Display "RENTED" badge if the movie is purchased -->
                    <span class="position-absolute top-0 start-0 m-2 badge bg-success d-flex align-items-center gap-1 px-2 py-1 fs-6">
                        <i class="ph ph-film-reel"></i> {{ __('messages.rented') }}
                    </span>
                @else
                    <!-- Display "RENT" badge if the movie is available for rent -->
                    <span class="position-absolute top-0 start-0 m-2 badge bg-success d-flex align-items-center gap-1 px-2 py-1 fs-6">
                        <i class="ph ph-film-reel"></i> {{ __('messages.rent') }}
                    </span>
                @endif
            @endif
            @php

                  $qualityOptions = [];

                   $videoLinks = $data['video_links'];

                   foreach($videoLinks as $link) {
                      $qualityOptions[$link->quality] = $link->url;
                   }

                 $qualityOptionsJson = json_encode($qualityOptions);

                 $video_url_input=null;

                 if($data['video_upload_type']=='Local'){

                    $video_url_input=$data['video_url_input'];
                 }else{

                    $video_url_input=Crypt::encryptString($data['video_url_input']);
                 }

                    $subtitleInfoJson = $data['subtitle_info']
                        ? json_encode($data['subtitle_info']->toArray(request()))
                        : json_encode([])
               @endphp
               @php
                   $isWatchButton = $data['access'] != 'pay-per-view' || \Modules\Entertainment\Models\Entertainment::isPurchased($data['id'],'episode');
               @endphp
            {{-- @if($data['access'] != 'pay-per-view' || \Modules\Entertainment\Models\Entertainment::isPurchased($data['id'],'episode') ) --}}
            <button class="season-watch-btn {{ $isWatchButton ? '' : 'd-none' }}" id="seasonWatchBtn_{{  $data['id'] }}"
                            data-entertainment-id="{{ $data['entertainment_id'] }}"
                            data-entertainment-type="tvshow"
                            data-video-url= {{ $video_url_input }}
                            data-movie-access="{{ $data['access'] }}"
                            data-plan-id="{{ $data['plan_id'] }}"
                            data-user-id="{{ auth()->id() }}"
                            data-profile-id="{{ getCurrentProfile(auth()->id(),request()) }}"
                            data-episode-id="{{ $data['id'] }}"
                            data-first-episode-id="{{ $index+1 }}"
                            data-quality-options={{ $qualityOptionsJson }}
                            data-subtitle-info="{{ $subtitleInfoJson }}"
                            data-contentid="{{ $data['id'] }}",
                            data-contenttype="tvshow",
                            content-video-type="video"
                            >
                <span class="d-flex align-items-center justify-content-center gap-2">
                    <span><i class="ph-fill ph-play"></i></span>
                    {{__('frontend.watch_now')}}
                </span>
            </button>
            {{-- @endif --}}
        </div>
        <div class="season-content flex-grow-1">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{  $data['name'] }}</h5>
            </div>
            <ul class="list-inline mt-3 mb-3 mx-0 p-0 d-flex align-items-center season-meta-list flex-wrap">
                <li class="season-meta-list-item">
                    <span class="season-meta">E{{ $index+1 }}</span>
                </li>
                <li class="season-meta-list-item">

                    {{ $data['duration'] ? formatDuration($data['duration']) : '--' }}

                </li>
                <li class="season-meta-list-item">
                    <span class="season-meta">{{  $data['release_date'] ? formatDate($data['release_date']) : '-' }}</span>
                </li>
            </ul>
            <p class="mt-0 mb-3 font-size-14">
               {!! $data['description'] !!}
            </p>
            <a href="{{ route('episode-details', ['id' => $data['id']]) }} " class="fw-semibold">{{__('frontend.view_more_info')}}</a>
        </div>
    </div>
</div>
