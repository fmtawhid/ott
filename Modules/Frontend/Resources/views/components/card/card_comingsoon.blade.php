
<div class="col">
    <div class="comingsoon-card" style="background-image: url({{ $data['thumbnail_image'] }})">
        <div class="d-flex flex-column justify-content-between gap-2 h-100">
            <ul class="d-flex align-items-center flex-wrap justify-content-between gap-2 list-inline m-0 p-0 comingsoon-meta-list">
                <li class="meta-item">

                            <x-remind-button
                            :entertainment-id="$data['id']"
                            :inremindlist="Auth::check() ? ($data['is_userRemind'] ?? 0) : 0"
                        />

                </li>
            </ul>
            <div class="comingsoon-info">
                <ul class="list-inline mt-4 mb-0 mx-0 p-0 d-flex align-items-center flex-wrap gap-3">
                    @if($data['is_restricted'] == 1)
                        <li>
                            <span class="d-inline-block">
                                <span class="py-1 px-2 font-size-10 text-dark bg-white rounded fw-bold align-middle">
                                    {{__('frontend.age_restriction')}}
                                </span>
                            </span>
                        </li>
                    @endif
                    <li>
                        <span href="#" class="meta text-white">{{ \Carbon\Carbon::parse($data['release_date'])->format('d M, Y') }}</span>
                    </li>
                </ul>
                <h6 class="mt-3">{{ $data['name'] }}</h6>


                @if(!empty($data['genres']))
                <!-- <ul class="list-inline m-0 p-0 d-flex align-items-center flex-wrap movie-tag-list">
                    @foreach($data['genres'] as $gener)
                        <li>
                            <a href="#" class="tag">{{ $gener->name }}</a>
                        </li>
                    @endforeach
                </ul> -->
                @endif



                <p class="m-0 line-count-2 font-size-14">
                    {{ $data['description'] }}
                </p>
                <ul class="list-inline mt-2 mb-0 mx-0 p-0 d-flex align-items-center flex-wrap gap-3">
                    @if(!empty($data['season_name']))
                        <li>
                            <span class="fw-medium">{{ $data['season_name'] }}</span>
                        </li>
                    @endif

                    <li>
                        <span class="d-flex align-items-center gap-2">
                            <span><i class="ph ph-translate lh-base"></i></span>
                            <span class="fw-medium">{{ ucfirst($data['language']) }}</span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
