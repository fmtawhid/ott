<div class="continue-watch-card">

    @php
        $duration =
            $value['watched_time'] ??
            ($value['entertainment_type'] == 'video' && isset($value->video['duration'])
                ? $value->video['duration']
                : (isset($value->entertainment['duration'])
                    ? $value->entertainment['duration']
                    : '00:00'));
        $episode_name = null;
        $episode_poster_url = null;

        if ($value['entertainment_type'] == 'tvshow' && isset($value['episode_id']) && $value['episode_id']) {
            $episode = \Modules\Episode\Models\Episode::where('id', $value['episode_id'])->first();
            if ($episode) {
                $episode_name = $episode->name;
                $episode_poster_url = $episode->poster_url;
            }
        }

        $name =
            ($episode_name)
                ? $episode_name
                : ($value['name'] ??
                    ($value['entertainment_type'] == 'video' && isset($value->video['name'])
                        ? $value->video['name']
                        : (isset($value->entertainment['name'])
                            ? $value->entertainment['name']
                            : 'Unknown')));

        $poster_image =
            ($episode_poster_url)
                ? setBaseUrlWithFileName($episode_poster_url)
                : ($value['poster_image'] ??
                    ($value['entertainment_type'] == 'video' && isset($value->video['poster_url'])
                        ? setBaseUrlWithFileName($value->video['poster_url'])
                        : (isset($value->entertainment['poster_url'])
                            ? setBaseUrlWithFileName($value->entertainment['poster_url'])
                            : 'default-poster.jpg')));

        if (!function_exists('convertSeconds')) {
        function convertSeconds($time)
        {
            [$hours, $minutes, $seconds] = array_map('intval', explode(':', $time));
            return $hours * 3600 + $minutes * 60 + $seconds;
        }
    }
    $total_watched_time = $value['total_watched_time'] ?? '00:00:00';
    $totalDurationInSeconds = convertSeconds($total_watched_time);
    $watchedTime = $value['watched_time'] ?? '00:00:00';
    $watchedTimeInSeconds = convertSeconds($watchedTime);

    $progressPercentage = $totalDurationInSeconds > 0 ? ($watchedTimeInSeconds / $totalDurationInSeconds) * 100 : 0;
    @endphp
    <div class="continue-watch-card-image position-relative">

        @if($value['entertainment_type'] == 'episode' || $value['entertainment_type'] == 'tvshow')

        @if(isset($value['episode_id']) && $value['episode_id'] != null)

           <a href="{{ route('episode-details', ['id' => $value['episode_id'],'continue_watch' => true]) }}"
                class="d-block image-link">
                <img src="{{ setBaseUrlWithFileName($poster_image) }}" alt="movie-card" class="img-fluid object-cover w-100 continue-watch-image">
            </a>

            @else

            <a href="{{ route('tvshow-details', ['id' => $value['entertainment_id']]) }}"
                class="d-block image-link">
                <img src="{{ setBaseUrlWithFileName($poster_image) }}" alt="movie-card" class="img-fluid object-cover w-100 continue-watch-image">
            </a>
            @endif

        @endif

        @if($value['entertainment_type'] == 'movie')

     <a href="{{  route('movie-details', ['id' => $value['entertainment_id'],'continue_watch' => true]) }}"
            class="d-block image-link">
            <img src="{{ setBaseUrlWithFileName($poster_image) }}" alt="movie-card" class="img-fluid object-cover w-100 continue-watch-image">
        </a>
      @endif

      @if($value['entertainment_type'] == 'video')

      <a href="{{  route('video-detail', ['id' => $value['entertainment_id']]) }}"
          class="d-block image-link">
          <img src="{{ setBaseUrlWithFileName($poster_image) }}" alt="movie-card" class="img-fluid object-cover w-100 continue-watch-image">
      </a>
     @endif

        <button class="continue_remove_btn remove_btn btn btn-primary" data-id="{{ $value['id'] ?? $value->id }}">
            <i class="ph ph-x"></i>
        </button>
        <div class="progress" role="progressbar" aria-label="Progress bar" aria-valuenow="{{ $progressPercentage }}"
            aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: {{ $progressPercentage }}%"></div>
        </div>
    </div>
    <div class="continue-watch-card-content">

        @if($value['entertainment_type'] == 'episode' || $value['entertainment_type'] == 'tvshow')

        @if(isset($value['episode_id']) && $value['episode_id'] != null)

        <a href="{{ route('episode-details', ['id' => $value['episode_id'],'continue_watch' => true]) }}"
            class="title-wrapper">
            <h5 class="mb-1 font-size-18 title line-count-1">{{ $name }}</h5>
        </a>


        @else

        <a href="{{ route('tvshow-details', ['id' => $value['entertainment_id']]) }}"
            class="title-wrapper">
            <h5 class="mb-1 font-size-18 title line-count-1">{{ $name }}</h5>
        </a>
        @endif
    @endif

    @if($value['entertainment_type'] == 'movie')

    <a href="{{  route('movie-details', ['id' => $value['entertainment_id'],'continue_watch' => true]) }}"
        class="title-wrapper">
        <h5 class="mb-1 font-size-18 title line-count-1">{{ $name }}</h5>
    </a>
  @endif

  @if($value['entertainment_type'] == 'video')

  <a href="{{  route('video-detail', ['id' => $value['entertainment_id']]) }}"
    class="title-wrapper">
            <h5 class="mb-1 font-size-18 title line-count-1">{{ $name }}</h5>
  </a>
 @endif



        <span class="font-size-14 fw-semibold">{{ $duration }}</span>
    </div>
</div>

