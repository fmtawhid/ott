<div class="slick-banner main-banner" data-speed="1000" data-autoplay="true" data-center="false" data-infinite="false" data-navigation="true" data-pagination="true" data-spacing="0">

  @foreach($data as $slider)

   @if($slider['data'] != null)

    @php
        $data = $slider['data']->toArray(request());

    @endphp


    @if(isenablemodule($slider['type'])==1)

    <div class="slick-item" style="background-image: url({{ setBaseUrlWithFileName($slider['file_url']) }});">
      <div class="movie-content h-100">
        <div class="container-fluid h-100">
          <div class="row align-items-center h-100">
            <div class="col-xxl-4 col-lg-6">
              <div class="movie-info">
                <div class="movie-tag mb-3">
                  <ul class="list-inline m-0 p-0 d-flex align-items-center flex-wrap movie-tag-list">
                      @if(!empty($data['genres']))
                      @foreach($data['genres'] as $genres)
                          <li>
                              <a href="#" class="tag">{{ $genres['name'] ?? 'Hello empty Name' }}</a>
                          </li>
                      @endforeach
                  @endif
                  </ul>
                </div>
                <h4 class="mb-2">{{ $data['name'] }}</h4>
                <!-- <p class="mb-0 font-size-14 line-count-3">{!! $data['description'] !!}</p> -->
                <p class="mb-0 font-size-14 line-count-3">
                    {{ \Illuminate\Support\Str::limit(strip_tags($data['description'] ?? 'Hello Empty Description'), 200, '...') }}
                </p>





                <ul class="list-inline mt-4 mb-0 mx-0 p-0 d-flex align-items-center flex-wrap gap-3">

                  <li>
                      @if(!empty($data['release_date']))
                    <span class="d-flex align-items-center gap-2">
                      <span class="fw-medium">{{ date('Y', strtotime($data['release_date'])) }}</span>
                    </span>
                    @endif
                  </li>
                  <li>
                    @if(!empty($data['language']))
                      <span class="d-flex align-items-center gap-2">
                        <span><i class="ph ph-translate lh-base"></i></span>
                        <span class="fw-medium">{{ ucfirst($data['language']) }}</span>
                      </span>
                    @endif
                  </li>
                  <li>
                      @if(!empty($data['duration']))
                    <span class="d-flex align-items-center gap-2">
                      <span><i class="ph ph-clock lh-base"></i></span>
                      <span class="fw-medium">{{ str_replace(':', 'h ', $data['duration']) . 'm' }}</span>
                    </span>
                    @endif
                  </li>
                  @if(!empty($data['imdb_rating']))
                  <li>
                    <span class="d-flex align-items-center gap-2">
                      <span><i class="ph ph-star lh-base"></i></span>
                      <span class="fw-medium">{{ $data['imdb_rating'] }}(IMDB)</span>
                    </span>
                  </li>
                  @endif
                </ul>
                <div class="mt-5">
                  <div class="d-flex align-items-center gap-3">
                  @if($slider['type']!="livetv")
                    <x-watchlist-button :entertainment-id="$data['id']" :in-watchlist="$data['is_watch_list']" customClass="watch-list-btn" />
                  @endif
                    <div class="flex-grow-1">
                        <a href="{{
                            $slider['type'] == 'livetv' ? route('livetv-details', ['id' => $data['id']]) :
                            ($slider['type'] == 'video' ? route('video-details', ['id' => $data['id']]) :
                            ($data['type'] == 'tvshow' ? route('tvshow-details', ['slug' => $data['slug']]) :
                           route('movie-details', ['slug' => $data['slug'] ?? Str::slug($data['name'])])
                            ))
                        }}" class="btn btn-primary">
                         <span class="d-flex align-items-center justify-content-center gap-2">
                             <span><i class="ph-fill ph-play"></i></span>
                             <span>{{__('frontend.play_now')}}</span>
                         </span>
                     </a>
                    </div>
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

    @endif
  @endforeach
</div>
@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const playButtons = document.querySelectorAll('.play-now-btn');
    playButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const encryptedUrl = this.getAttribute('data-encrypted-url');

            if (encryptedUrl) {
                fetch('{{ route('decrypt.url') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ encrypted_url: encryptedUrl })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        window.open(data.url, '_blank');
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });
});

    </script>
@endpush
