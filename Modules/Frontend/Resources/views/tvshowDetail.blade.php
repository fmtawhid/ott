@extends('frontend::layouts.master')

@section('content')

<div id="thumbnail-section">
    @include('frontend::components.section.thumbnail',  ['data' => $data['trailer_url'] ,'type'=>$data['trailer_url_type'],'thumbnail_image'=>$data['thumbnail_image'],'subtitle_info' => '', 'content_type' => 'tvshow', 'content_id' => $data['id'], 'video_type' => $data['video_upload_type'], 'content_video_type'=>'trailer'])
</div>

<div id="detail-section">
    <div id="tvshow-id">
        @include('frontend::components.section.data_detail',  ['data' => $data,'subtitle_info' => ''])
    </div>
</div>

<div class="short-menu mb-5">
    <div class="container-fluid">
        <div class="py-4 px-md-5 px-3 movie-detail-menu rounded">
            <div class="d-flex align-items-center gap-2">
                <div class="left">
                    <i class="ph ph-caret-left align-middle"></i>
                </div>
                <div class="custom-nav-slider">
                    <ul class="list-inline m-0 p-0 d-flex align-items-center">
                        <li class="flex-shrink-0">
                            <a href="#seasons" class="link-body-emphasis">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span><i class="ph ph-film-reel align-middle"></i></span>
                                    <span class="font-size-18">{{ __('frontend.episodes') }}</span>
                                </span>
                            </a>
                        </li>
                        @if($data['casts'] != null || $data['directors'] !=null )
                        <li class="flex-shrink-0">
                            <a href="#movie-cast" class="link-body-emphasis">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span><i class="ph ph-user-circle-gear align-middle"></i></span>
                                    <span class="font-size-18">{{ __('frontend.casts') }} & {{ __('frontend.directors') }}</span>
                                </span>
                            </a>
                        </li>
                        @endif

                        @if(count($data['three_reviews']) !=0 )
                        <li class="flex-shrink-0">
                            <a href="#review-list" class="link-body-emphasis">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span><i class="ph ph-star align-middle"></i></span>
                                    <span class="font-size-18">{{__('frontend.reviews')}}</span>
                                </span>
                            </a>
                        </li>
                        @endif
                        @if($data['more_items'] != null)
                        <li class="flex-shrink-0">
                            <a href="#more-like-this" class="link-body-emphasis">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span><i class="ph ph-dots-three-circle align-middle"></i></span>
                                    <span class="font-size-18">{{__('frontend.more_like_this')}}</span>
                                </span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="right">
                    <i class="ph ph-caret-right align-middle"></i>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @if($data['movie_access'] == 'pay-per-view' && \Modules\Entertainment\Models\Entertainment::isPurchased($data['id'],$data['type'])) --}}
<div class="container-fluid">
    <div id="seasons">
        @include('frontend::components.section.seasons',  ['data' => $data['tvShowLinks']])
    </div>
</div>
{{-- @endif --}}
<div class="container-fluid padding-right-0">
    <div class="overflow-hidden">
        <div id="movie-cast" class="half-spacing">
            @include('frontend::components.section.castcrew',  ['data' => $data['casts']->toArray(request()), 'title'=> __('frontend.casts'),'entertainment_id' =>$data['id'], 'type'=>'actor', 'slug'=>''])
        </div>

        <div id="favorite-personality">
            @include('frontend::components.section.castcrew',  ['data' => $data['directors']->toArray(request()),'title'=> __('frontend.directors'),'entertainment_id' =>$data['id'],'type'=>'director', 'slug'=>''])
        </div>
    </div>
</div>

<div class="container-fluid">
    <div id="add-review">
        @include('frontend::components.section.add_review',  ['addreview' => 'Add Review'])
    </div>

    @if($data['three_reviews'] != null)
        <div id="review-list">
            @include('frontend::components.section.review_list',  ['data' => $data['three_reviews']->toArray(request()), 'your_review'=> $data['your_review'], 'title'=> $data['name'], 'total_review'=>count($data['reviews'])])
        </div>
    @endif
</div>

<div class="container-fluid padding-right-0">
    <div class="overflow-hidden">
        @include('frontend::components.section.custom_ad_banner', [
            'placement' => 'tvshow_detail',
            'content_id' => $data['id'] ?? '',
            'content_type' => $data['type'] ?? '',
            'category_id' => $data['category_id'] ?? ''
        ])
        @if($data['more_items'] != null)
            <div id="more-like-this">
                @include('frontend::components.section.entertainment',  ['data' => $data['more_items'], 'title'=>__('frontend.more_like_this'),'type' => $data['type'],'slug'=>''])
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="DeviceSupport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
            <div class="modal-body user-login-card m-0 p-4 position-relative">
                <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
                    <i class="ph ph-x text-white fw-bold align-middle"></i>
                </button>

                <div class="modal-body">
                    {{__('frontend.device_not_support')}}
                  </div>

                <div class="d-flex align-items-center justify-content-center">
                    <a href="{{ Auth::check() ? route('subscriptionPlan') : route('login') }}" class="btn btn-primary mt-5" >{{__('frontend.upgrade')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
