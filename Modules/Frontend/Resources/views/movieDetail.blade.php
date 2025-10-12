@extends('frontend::layouts.master')

@section('content')

<div id="thumbnail-section">

@if( $continue_watch===true)

@include('frontend::components.section.thumbnail',  ['data' => $data['video_url_input'] ,'type'=>$data['video_upload_type'],'thumbnail_image'=>$data['thumbnail_image'],'watched_time'=>$data['watched_time'], 'subtitle_info' => $data['subtitle_info'],'content_type' => 'movie', 'content_id' => $data['id'], 'is_trailer' => false, 'video_type' => $data['video_upload_type'],'content_video_type'=>'video' ])
@else
@include('frontend::components.section.thumbnail',  ['data' => $data['trailer_url'] ,'type'=>$data['trailer_url_type'],'thumbnail_image'=>$data['thumbnail_image'],'watched_time'=>0,'subtitle_info' => $data['subtitle_info'],'dataAccess' => $data['movie_access'] , 'contentType' => $data['type'], 'contentId' => $data['id'],'content_type' => 'movie', 'content_id' => $data['id'], 'is_trailer' => true, 'video_type' => $data['video_upload_type'],'content_video_type'=>'trailer' ])

    @endif
</div>

<div id="detail-section">
    @include('frontend::components.section.data_detail',  ['data' => $data])
</div>


<div class="short-menu mb-5">
    <div class="container-fluid">
        <div class="py-4 px-md-5 px-3 movie-detail-menu rounded">
            <div class="d-flex align-items-center gap-2">
                <div class="left">
                    <i class="ph ph-caret-left"></i>
                </div>
                <div class="custom-nav-slider">
                    <ul class="list-inline m-0 p-0 d-flex align-items-center">
                        @if($data['casts'] != null || $data['directors'] !=null )
                        <li>
                            <a href="#movie-cast" class="link-body-emphasis">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span><i class="ph ph-user-circle-gear align-middle"></i></span>
                                    <span class="font-size-18">{{ __('frontend.casts') }} & {{ __('frontend.directors') }}</span>
                                </span>
                            </a>
                        </li>
                        @endif

                        <li id="reviweList" class="flex-shrink-0 @if($data['your_review'] == null && count($data['three_reviews']) == 0) d-none @endif">
                            <a href="#review-list" class="link-body-emphasis">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span><i class="ph ph-star align-middle"></i></span>
                                    <span class="font-size-18">{{ __('frontend.reviews') }}</span>
                                </span>
                            </a>
                        </li>

                        @if(count($data['more_items']) !=0 )
                        <li>
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
                    <i class="ph ph-caret-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid padding-right-0">
    <div class="overflow-hidden">
        @if(count( $data['casts']) >0)
        <div id="movie-cast" class="half-spacing">
            @include('frontend::components.section.castcrew',  ['data' => $data['casts']->toArray(request()), 'title'=> __('frontend.casts'),'entertainment_id' =>$data['id'], 'type'=>'actor', 'slug'=>''])
        </div>
        @endif

        @if(count( $data['directors']) >0)
        <div id="favorite-personality">
            @include('frontend::components.section.castcrew',  ['data' => $data['directors']->toArray(request()),'title'=> __('frontend.directors'),'entertainment_id' =>$data['id'],'type'=>'director', 'slug'=>''])
        </div>
        @endif
    </div>
</div>

<div class="container-fluid">
    <div id="add-review">
        @include('frontend::components.section.add_review',  ['addreview' => 'Add Review'])
    </div>

    <div id="review-list" class="@if($data['your_review'] == null && count($data['three_reviews']) == 0) d-none @endif" >
        @include('frontend::components.section.review_list',  ['data' => $data['three_reviews'], 'your_review'=> $data['your_review'], 'title'=> $data['name'], 'total_review'=>count($data['reviews'])])
    </div>

</div>
<div class="container-fluid padding-right-0">
    <div class="overflow-hidden">
        @include('frontend::components.section.custom_ad_banner', [
            'placement' => 'movie_detail',
            'content_id' => $data['id'] ?? '',
            'content_type' => $data['type'] ?? '',
            'category_id' => $data['category_id'] ?? ''
        ])
        @if(count($data['more_items']) !=0 )
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
                    <a href="{{ Auth::check() ? route('subscriptionPlan') : route('login') }}" class="btn btn-primary mt-5">{{__('frontend.upgrade')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

