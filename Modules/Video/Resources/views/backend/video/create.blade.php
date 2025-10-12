@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.videos.index" />
<p class="text-danger" id="error_message"></p>

    {{-- <form method="POST" id="form" action="{{ route('backend.videos.store') }}" enctype="multipart/form-data"> --}}
    {{ html()->form('POST' ,route('backend.videos.store'))
    ->attribute('enctype', 'multipart/form-data')
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open()
}}
        @csrf

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5>{{__('customer.about')}} {{ __('video.singular_title') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-lg-6">
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_poster'), 'poster')->class('form-label') }}
                            <div class="input-group btn-file-upload">
                                {{ html()->button(__('<i class="ph ph-image"></i>'.__('messages.lbl_choose_image')))
                                    ->class('input-group-text form-control')
                                    ->type('button')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerPoster')
                                    ->attribute('data-hidden-input', 'file_url_poster')
                                    ->style('height: 13.8rem')
                                }}

                                {{ html()->text('poster_input')
                                    ->class('form-control')
                                    ->placeholder(__('placeholder.lbl_image'))
                                    ->attribute('aria-label', 'Poster Image')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerPoster')
                                    ->attribute('data-hidden-input', 'file_url_poster')
                                }}
                            </div>
                            <div class="uploaded-image" id="selectedImageContainerPoster">
                                @if(old('poster_url', isset($data) ? $data->poster_url : ''))
                                    <img src="{{ old('poster_url', isset($data) ? $data->poster_url : '') }}" id="selectedPosterImage" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                @endif
                                <button class="btn btn-danger btn-sm position-absolute close-icon d-none"
                                id="removePostBtn">&times;</button>
                                {{ html()->hidden('poster_url_removed', 0)->id('poster_url_removed') }}
                            </div>
                            {{ html()->hidden('poster_url')->id('file_url_poster')->value(old('poster_url', isset($data) ? $data->poster_url : '')) }}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_poster_tv'), 'poster_tv')->class('form-label') }}
                            <div class="input-group btn-file-upload">
                                {{ html()->button(__('<i class="ph ph-image"></i>'.__('messages.lbl_choose_image')))
                                    ->class('input-group-text form-control')
                                    ->type('button')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerPosterTv')
                                    ->attribute('data-hidden-input', 'file_url_poster_tv')
                                    ->style('height: 13.8rem')
                                }}

                                {{ html()->text('poster_input')
                                    ->class('form-control')
                                    ->placeholder(__('placeholder.lbl_image'))
                                    ->attribute('aria-label', 'Poster Image')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerPosterTv')
                                    ->attribute('data-hidden-input', 'file_url_poster_tv')
                                }}
                            </div>
                            <div class="uploaded-image" id="selectedImageContainerPosterTv">
                                @if(old('poster_tv_url', isset($data) ? $data->poster_tv_url : ''))
                                    <img src="{{ old('poster_tv_url', isset($data) ? $data->poster_tv_url : '') }}" id="selectedPosterTvImage" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                @endif
                                <button class="btn btn-danger btn-sm position-absolute close-icon d-none"
                                id="removePostBtn">&times;</button>
                                {{ html()->hidden('poster_tv_url_removed', 0)->id('poster_tv_url_removed') }}
                            </div>
                            {{ html()->hidden('poster_tv_url')->id('file_url_poster_tv')->value(old('poster_tv_url', isset($data) ? $data->poster_tv_url : '')) }}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                {{ html()->label(__('video.lbl_title') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                                {{ html()->text('name')->attribute('value', old('name'))->placeholder(__('placeholder.lbl_video_title'))->class('form-control')->attribute('required','required') }}
                                <span class="text-danger" id="error_msg"></span>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Title field is required</div>
                            </div>
                            <div class="col-md-6">
                                {{ html()->label(__('movie.lbl_movie_access') , 'movie_access')->class('form-label') }}
                                <div class="d-flex align-items-center gap-3">
                                <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                    <div class="">
                                        <input class="form-check-input" type="radio" name="access" id="paid" value="paid"
                                            onchange="showPlanSelection(this.value === 'paid')"
                                            {{ old('access') == 'paid' ? 'checked' : '' }} checked>
                                        <span class="form-check-label" >{{__('movie.lbl_paid')}}</span>
                                    </div>
                                </label>
                                <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                    <div >
                                        <input class="form-check-input" type="radio" name="access" id="free" value="free"
                                            onchange="showPlanSelection(this.value === 'paid')"
                                            {{ old('access') == 'free' ? 'checked' : '' }}>
                                        <span class="form-check-label" >{{__('movie.lbl_free')}}</span>
                                    </div>
                                </label>
                                <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                    <div>
                                        <input class="form-check-input" type="radio" name="access" id="pay-per-view" value="pay-per-view"
                                            onchange="showPlanSelection(this.value === 'pay-per-view')"
                                            {{ old('access') == 'pay-per-view' ? 'checked' : '' }}>
                                        <span class="form-check-label" for="pay-per-view">{{__('messages.lbl_pay_per_view')}}</span>
                                    </div>
                                </label>
                                </div>
                                @error('access')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 row g-3 mt-2 {{ old('movie_access') == 'pay-per-view' ? '' : 'd-none' }}" id="payPerViewFields">
                                <div class="col-md-4">
                                    {{ html()->label(__('messages.lbl_price') . '<span class="text-danger">*</span>', 'price')->class('form-label')->for('price') }}
                                    {{ html()->number('price', old('price'))->class('form-control')->attribute('placeholder', __('messages.enter_price'))->attribute('step', '0.01')->required() }}
                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback" id="price-error">Price field is required</div>
                                </div>
                                <div class="col-md-4">
                                    {{ html()->label(__('messages.purchase_type'). '<span class="text-danger">*</span>', 'access_duration')->class('form-label') }}
                                    {{ html()->select('purchase_type', [
                                            '' => __('messages.lbl_select_purchase_type'),
                                            'rental' => __('messages.lbl_rental'),
                                            'onetime' => __('messages.lbl_one_time_purchase')
                                        ], old('purchase_type', 'rental'))
                                        ->id('purchase_type')
                                        ->class('form-control select2')
                                        ->required()
                                        ->attributes(['onchange' => 'toggleAccessDuration(this.value)'])
                                    }}
                                    @error('purchase_type') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback" id="purchase_type-error">Purchase Type field is required</div>
                                </div>
                                <div class="col-md-4 d-none" id="accessDurationWrapper">
                                    {{ html()->label(__('messages.lbl_access_duration') . __('messages.lbl_in_days') . '<span class="text-danger">*</span>', 'access_duration')->class('form-label') }}
                                    {{ html()->number('access_duration', old('access_duration'))->class('form-control')->attribute('pattern', '[0-9]*')->attribute('oninput', 'this.value = this.value.replace(/[^0-9]/g, "")')->attribute('placeholder', __('messages.access_duration'))->required() }}
                                    @error('access_duration') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback" id="access_duration-error">Access Duration field is required</div>
                                </div>

                                <div class="col-md-4">
                                    {{ html()->label(__('messages.lbl_discount') . ' (%)', 'discount')->class('form-label') }}
                                    {{ html()->number('discount', old('discount'))->class('form-control')->attribute('placeholder', __('messages.enter_discount'))->attribute('min', 1)->attribute('max', 99)->attribute('step', '0.01') }}
                                    @error('discount') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback" id="discount-error">Available For field is required</div>

                                </div>
                                <div class="col-md-4">
                                    {{ html()->label(__('messages.lbl_total_price'), 'total_amount')->class('form-label') }}
                                    {{ html()->text('total_amount', null)->class('form-control')->attribute('disabled', true)->id('total_amount') }}
                                </div>
                                <div class="col-md-4">
                                    {{ html()->label(__('messages.lbl_available_for') . __('messages.lbl_in_days'). '<span class="text-danger">*</span>', 'available_for')->class('form-label') }}
                                    {{ html()->number('available_for', old('available_for'))->class('form-control')->attribute('pattern', '[0-9]*')->attribute('oninput', 'this.value = this.value.replace(/[^0-9]/g, "")')->attribute('placeholder', __('messages.available_for'))->required() }}
                                    @error('available_for') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback" id="available_for-error">Available For field is required</div>
                                </div>
                            </div>
                            <div class="col-md-6 {{ old('access', 'paid') == 'free' ? 'd-none' : '' }}" id="planSelection">
                                {{ html()->label(__('movie.lbl_select_plan'). ' <span class="text-danger">*</span>', 'type')->class('form-label') }}
                                {{ html()->select('plan_id', $plan->pluck('name', 'id')->prepend(__('placeholder.lbl_select_plan'), ''), old('plan_id'))->class('form-control select2')->id('plan_id')}}
                                @error('plan_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Plan field is required</div>
                            </div>



                            <div class="col-md-6 d-none">
                                {{ html()->label(__('movie.lbl_trailer_url_type'), 'type')->class('form-label') }}
                                {{ html()->select(
                                        'trailer_url_type',
                                        $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_type'), ''),
                                        old('trailer_url_type', 'HLS'), // Set 'HLS' as the default value
                                    )->class('form-control select2')->id('trailer_url_type') }}
                                @error('trailer_url_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 d-none" id="url_input">
                                {{ html()->label(__('movie.lbl_trailer_url'), 'trailer_url')->class('form-label') }}
                                {{ html()->text('trailer_url')->attribute('value', old('trailer_url'))->placeholder(__('placeholder.lbl_trailer_url'))->class('form-control') }}
                                @error('trailer_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 d-none" id="url_file_input">

                                    {{ html()->label(__('movie.lbl_trailer_video'), 'trailer_video')->class('form-label') }}

                                    <div class="input-group btn-video-link-upload">
                                        {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-upload"></i>')->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainertailerurl')->attribute('data-hidden-input', 'file_url_trailer') }}

                                        {{ html()->text('trailer_input')->class('form-control')->placeholder('Select Image')->attribute('aria-label', 'Trailer Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainertailerurl')->attribute('data-hidden-input', 'file_url_trailer') }}
                                    </div>

                                    <div class="mt-3" id="selectedImageContainertailerurl">
                                        @if (old('trailer_url', isset($data) ? $data->trailer_url : ''))
                                            <img src="{{ old('trailer_url', isset($data) ? $data->trailer_url : '') }}"
                                                class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                        @endif
                                    </div>

                                    {{ html()->hidden('trailer_video')->id('file_url_trailer')->value(old('trailer_url', isset($data) ? $data->poster_url : ''))->attribute('data-validation', 'iq_video_quality')  }}

                                    @error('trailer_video')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div> 


                            <div class="col-md-6">
                                {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                                <div class="d-flex justify-content-between align-items-center form-control">
                                    {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                                    <div class="form-check form-switch">
                                        {{ html()->hidden('status', 0) }}
                                        {{
                                            html()->checkbox('status', old('status', 1))
                                                ->class('form-check-input')
                                                ->id('status')
                                                ->value(1)
                                        }}
                                    </div>
                                </div>
                                @error('status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            {{ html()->label(__('movie.lbl_short_desc'), 'short_desc')->class('form-label') }}
                            <!-- <span class="text-primary cursor-pointer" id="GenrateshortDescription" ><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span> -->
                        </div>

                        {{ html()->textarea('short_desc', old('short_desc'))->class('form-control')->id('short_desc')->placeholder(__('placeholder.episode_short_desc'))->rows('8') }}
                        @error('short_desc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            {{ html()->label(__('movie.lbl_description'). '<span class="text-danger"> *</span>', 'description')->class('form-label mb-0') }}
                            <!-- <span class="text-primary cursor-pointer" id="GenrateDescription" ><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span> -->
                        </div>
                        {{ html()->textarea('description', old('description'))->class('form-control')->id('description')->placeholder(__('placeholder.lbl_video_description'))->attribute('required','required') }}
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="desc-error">Description field is required</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-5 mb-3">
            <h5>{{ __('movie.lbl_basic_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_duration') . ' <span class="text-danger">*</span>', 'duration')->class('form-label') }}
                        {{ html()->time('duration')->attribute('value', old('duration'))->placeholder(__('movie.lbl_duration'))->class('form-control min-datetimepicker-time')->attribute('required','required') }}
                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="duration-error">Duration field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_release_date') . ' <span class="text-danger">*</span>', 'release_date')->class('form-label') }}
                        {{ html()->date('release_date')->attribute('value', old('release_date'))->placeholder(__('movie.lbl_release_date'))->class('form-control datetimepicker')->required() }}
                        @error('release_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="release_date-error">Release Date field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_age_restricted'), 'is_restricted')->class('form-label') }}
                        <div class="d-flex justify-content-between align-items-center form-control">
                            {{ html()->label(__('movie.lbl_restricted_content'), 'is_restricted')->class('form-label mb-0 text-body') }}
                            <div class="form-check form-switch">
                                {{ html()->hidden('is_restricted', 0) }}
                                {{ html()->checkbox('is_restricted', old('is_restricted', false))->class('form-check-input')->id('is_restricted') }}
                            </div>
                        </div>
                        @error('is_restricted')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_download_status'), 'download_status')->class('form-label') }}
                        <div class="d-flex justify-content-between align-items-center form-control">
                            {{ html()->label(__('movie.lbl_download_status'), 'download_status')->class('form-label mb-0 text-body') }}
                            <div class="form-check form-switch">
                                {{ html()->hidden('download_status', 0) }}
                                {{ html()->checkbox('download_status',  old('download_status', 1))->class('form-check-input')->id('download_status')->value(1) }}
                            </div>
                        </div>
                        @error('download_status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-5 mb-3">
            <h5>{{ __('movie.lbl_video_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 d-none">
                        {{ html()->label(__('movie.lbl_video_upload_type'). '<span class="text-danger">*</span>', 'video_upload_type')->class('form-label') }}
                        {{ html()->select(
                                'video_upload_type',
                                $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), '')
                                    ->merge(['Embedded' => 'Embedded']), // Add Embedded option
                                old('video_upload_type', 'HLS'),
                            )->class('form-control select2')->id('video_upload_type')->required() }}
                        @error('video_upload_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Video Type field is required</div>
                    </div>
                    <div class="col-md-6 d-none" id="embed_code_input_section">
                        {{ html()->label(__('movie.lbl_embed_code') . ' <span class="text-danger">*</span>', 'embed_code')->class('form-label') }}
                        {{ html()->textarea('embed_code', old('embed_code'))->class('form-control')->id('embed_code')->placeholder('<iframe ...></iframe>') }}
                        @error('embed_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="embed-error">Embed Code field is required</div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 d-none" id="video_url_input_section">
                            {{ html()->label(__('movie.video_url_input') . '<span class="text-danger">*</span>', 'video_url_input')->class('form-control-label') }}
                            {{ html()->text('video_url_input')->attribute('value', old('video_url_input'))->placeholder(__('placeholder.video_url_input'))->class('form-control') }}
                            @error('video_url_input')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="url-error">Video URL field is required</div>
                            <div class="invalid-feedback" id="url-pattern-error" style="display:none;">
                            Please enter a valid URL starting with http:// or https://.
                        </div>
                        </div>

                        <div class="mb-3 d-none" id="video_file_input_section">
                            {{ html()->label(__('movie.video_file_input') . '<span class="text-danger">*</span>', 'video_file')->class('form-label') }}

                            <div class="input-group btn-video-link-upload mb-3">
                                {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-upload"></i>')->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerVideourl')->attribute('data-hidden-input', 'file_url_video') }}

                                {{ html()->text('video_file_input')->class('form-control')->placeholder('Select Image')->attribute('aria-label', 'Video Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerVideourl')->attribute('data-hidden-input', 'file_url_video') }}
                            </div>

                            <div class="mt-3" id="selectedImageContainerVideourl">
                                @if (old('video_file_input'))
                                    <img src="{{ old('video_file_input') }}"
                                        class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                @endif
                            </div>

                            {{ html()->hidden('video_file_input')->id('file_url_video')->value(old('video_file_input'))->attribute('data-validation', 'iq_video_quality')  }}

                            @error('video_file_input')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="file-error">Video File field is required</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="d-flex align-items-center justify-content-between mt-5 pt-5 mb-3">
            <h5>{{ __('movie.lbl_quality_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between form-control">
                            <label for="enable_quality" class="form-label mb-0 text-body">{{ __('movie.lbl_enable_quality') }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="enable_quality" value="0">
                                <input type="checkbox" name="enable_quality" id="enable_quality"
                                    class="form-check-input" value="1"
                                    {{ old('enable_quality', false) ? 'checked' : '' }} onchange="toggleQualitySection()">
                            </div>
                        </div>
                        @error('enable_quality')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="enable_quality_section" class="col-md-12 enable_quality_section d-none">
                        <div id="video-inputs-container-parent">
                            <div class="row gy-3 video-inputs-container">
                                <div class="col-md-4">
                                    {{ html()->label(__('movie.lbl_video_upload_type'), 'video_quality_type')->class('form-label') }}
                                    {{ html()->select(
                                            'video_quality_type[]',
                                            $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                            old('video_quality_type', ''),
                                        )->class('form-control select2 video_quality_type') }}
                                    @error('video_quality_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 video-input">
                                    {{ html()->label(__('movie.lbl_video_quality'), 'video_quality')->class('form-label') }}
                                    {{ html()->select('video_quality[]', $video_quality->pluck('name', 'value')->prepend(__('placeholder.lbl_select_quality'), ''))->class('form-control select2 video_quality') }}
                                </div>
                                <div class="col-md-4 d-none video-url-input quality_video_input">
                                    {{ html()->label(__('movie.video_url_input'), 'quality_video_url_input')->class('form-label') }}
                                    {{ html()->text('quality_video_url_input[]')->placeholder(__('placeholder.video_url_input'))->class('form-control') }}
                                </div>
                                <div class="col-md-4 d-none video-file-input quality_video_file_input">
                                    {{ html()->label(__('movie.video_file_input'), 'quality_video')->class('form-label') }}
                                    <div class="input-group btn-video-link-upload">
                                        {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-upload"></i>')->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerVideoqualityurl')->attribute('data-hidden-input', 'file_url_videoquality') }}
                                        {{ html()->text('videoquality_input')->class('form-control')->placeholder('Select Image')->attribute('aria-label', 'Video Quality Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerVideoqualityurl')->attribute('data-hidden-input', 'file_url_videoquality') }}
                                    </div>
                                    <div class="mt-3" id="selectedImageContainerVideoqualityurl">
                                        @if (old('video_quality_url', isset($data) ? $data->video_quality_url : ''))
                                            <img src="{{ old('video_quality_url', isset($data) ? $data->video_quality_url : '') }}"
                                                class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                        @endif
                                    </div>
                                    {{ html()->hidden('quality_video[]')->id('file_url_videoquality')->value(old('video_quality_url', isset($data) ? $data->poster_url : ''))->attribute('data-validation', 'iq_video_quality') }}
                                    @error('quality_video')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 d-none video-embed-input quality_video_embed_input">
                                    {{ html()->label(__('movie.lbl_embed_code'), 'quality_video_embed')->class('form-label') }}
                                    {{ html()->textarea('quality_video_embed[]')
                                        ->placeholder('<iframe ...></iframe>')
                                        ->class('form-control')
                                        ->rows(3) }}
                                </div>
                                <div class="col-sm-12 text-end mb-3">
                                    <button type="button"class="btn btn-secondary-subtle btn-sm fs-4 remove-video-input d-none"><i class="ph ph-trash align-middle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <a id="add_more_video" class="btn btn-sm btn-primary"><i class="ph ph-plus-circle"></i> {{__('episode.lbl_add_more')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Subtitle Section -->
        <div class="d-flex align-items-center justify-content-between mt-5 pt-5 mb-3">
            <h5>{{ __('movie.lbl_subtitle_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between form-control">
                            <label for="enable_subtitle" class="form-label mb-0 text-body">{{ __('movie.lbl_enable_subtitle') }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="enable_subtitle" value="0">
                                <input type="checkbox" name="enable_subtitle" id="enable_subtitle"
                                    class="form-check-input" value="1"
                                    {{ old('enable_subtitle', false) ? 'checked' : '' }} onchange="toggleSubtitleSection()">
                            </div>
                        </div>
                        @error('enable_subtitle')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="subtitle_section" class="col-md-12 d-none">
                        <div id="subtitle-inputs-container">
                            <div class="row gy-3 subtitle-row">
                                <div class="col-md-4">
                                    {{ html()->label(__('movie.lbl_language'), 'language')->class('form-label') }}
                                    {{ html()->select('subtitles[0][language]', $subtitle_language->pluck('name', 'value')->prepend(__('placeholder.lbl_select_language'), ''), old('subtitles.0.language'))->class('form-control select2 subtitle-language') }}
                                    @error('subtitles.0.language')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="invalid-feedback">{{ __('validation.required', ['attribute' => 'language']) }}</div>
                                </div>
                                <div class="col-md-4">
                                    {{ html()->label(__('movie.lbl_subtitle_file'), 'subtitle_file')->class('form-label') }}
                                    {{ html()->file('subtitles[0][subtitle_file]')->class('form-control subtitle-file')->accept('.srt,.vtt') }}
                                    @error('subtitles.0.subtitle_file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                <div class="invalid-feedback">{{ __('validation.required', ['attribute' => 'subtitle file']) }}</div>
                                </div>
                                <div class="col-md-3 pt-3">
                                    <div class="form-check mt-4">
                                        {{ html()->checkbox('subtitles[0][is_default]', old('subtitles.0.is_default', false))->class('form-check-input is-default-subtitle')->id('is_default_0') }}
                                        {{ html()->label(__('movie.lbl_default_subtitle'), 'is_default_0')->class('form-check-label') }}
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm mt-4 remove-subtitle d-none">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <a type="button" id="add-subtitle" class="btn btn-sm btn-primary">
                                <i class="ph ph-plus-circle"></i> {{__('episode.lbl_add_more')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h4 class="mb-0">&nbsp;{{__('messages.lbl_seo_settings')}}</h4>
        </div>

<div class="card">
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center form-control">
                    <label for="enableSeoIntegration" class="form-label mb-0 text-body">{{ __('movie.lbl_enable_seo-setting') }}</label>
                    <div class="form-check form-switch">
                        <input type="hidden" name="enable_seo" value="0">
                        <input type="checkbox"
                            name="enable_seo"
                            id="enableSeoIntegration"
                            class="form-check-input"
                            value="1"
                            {{ !empty($seo->meta_title) || !empty($seo->meta_keywords) || !empty($seo->meta_description) || !empty($seo->seo_image) || !empty($seo->google_site_verification) || !empty($seo->canonical_url) || !empty($seo->short_description) ? 'checked' : '' }}>

                    </div>
                </div>
            </div>


            <!-- SEO Fields Section -->
            <div id="seoFields" style="display: {{ !empty($seo->meta_title) || !empty($seo->meta_keywords) || !empty($seo->meta_description) || !empty($seo->seo_image) || !empty($seo->google_site_verification) || !empty($seo->canonical_url) || !empty($seo->short_description) ? 'block' : 'none' }};">
                <div class="row mb-3">
                    <!-- SEO Image -->
                     <div class="col-md-4 position-relative">
                        {{ html()->hidden('seo_image')->id('seo_image')->value(old('seo_image', $data->seo_image ?? '')) }}

                        {!! html()->label(__('messages.lbl_seo_image') . ' <span class="required">*</span>', 'seo_image')
                            ->class('form-label')
                            ->attribute('for', 'seo_image') !!}

                        <div class="input-group btn-file-upload">
                            {{ html()->button('<i class="ph ph-image"></i> ' . __('messages.lbl_choose_image'))
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerSeo')
                                ->attribute('data-hidden-input', 'seo_image')
                                ->id('seo-image-url-button')
                                ->style('height:13.6rem') }}

                            {{ html()->text('seo_image_input')
                                ->class('form-control')
                                ->placeholder(__('placeholder.lbl_image'))
                                ->attribute('aria-label', 'SEO Image')
                                ->attribute('readonly', true)
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerSeo')
                                ->attribute('data-hidden-input', 'seo_image') }}
                        </div>

                        <div class="uploaded-image mt-2" id="selectedImageContainerSeo">
                            <img id="selectedSeoImage"
                                src="{{ old('seo_image', $data->seo_image ?? '') }}"
                                alt="seo-image-preview"
                                class="img-fluid"
                                style="{{ old('seo_image', $data->seo_image ?? '') ? '' : 'display:none;' }}" />
                        </div>

                         @error('seo_image')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror

                        <!-- Invalid Feedback -->
                       <div class="invalid-feedback mt-1" id="seo_image_error" style="display: none;">
                            SEO Image is required
                        </div>
                    </div>

                    <!-- Meta Title + Google Verification -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between">
                                {!! html()->label(__('messages.lbl_meta_title') . ' <span class="required">*</span>', 'meta_title')
                                    ->class('form-label')
                                    ->attribute('for', 'meta_title') !!}

                                <div id="meta-title-char-count" class="text-muted">0/100 {{ __('messages.words') }}</div>
                            </div>

                            <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                                value="{{ old('meta_title', $seo->meta_title ?? '') }}" maxlength="100" placeholder="{{ __('placeholder.lbl_meta_title') }}" >

                            @error('meta_title')
                                <span class="text-danger" id="meta_title-error">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback"  id="meta_title_error" style="display: none;">meta title is required</div>
                        </div>

                        <div class="form-group mb-3">
                            {!! html()->label(__('messages.lbl_google_site_verification') . ' <span class="required">*</span>', 'google_site_verification')
                                    ->class('form-label')
                                    ->attribute('for', 'google_site_verification') !!}
                            <input type="text" name="google_site_verification" id="google_site_verification" class="form-control @error('google_site_verification') is-invalid @enderror"
                                   value="{{ old('google_site_verification', $seo->google_site_verification ?? '') }}" placeholder="{{ __('placeholder.lbl_google_site_verification') }}" >
                            @error('google_site_verification')
                                <span class="text-danger" id="google_site_verification-error">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="embed-error">Google Site Verification is required</div>
                        </div>
                    </div>

                    <!-- Meta Keywords + Canonical URL -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            {!! html()->label(__('messages.lbl_meta_keywords') . ' <span class="required">*</span>', 'meta_keywords_input')
                                ->class('form-label')
                                ->attribute('for', 'meta_keywords_input') !!}
                            <input type="text" name="meta_keywords" id="meta_keywords_input" class="form-control" placeholder="{{ __('placeholder.lbl_meta_keywords') }}" value="{{ is_array(old('meta_keywords')) ? ($seo->meta_keywords ?? '') : (old('meta_keywords', $seo->meta_keywords ?? '')) }}" />
                            <div id="meta_keywords_hidden_inputs"></div>
                            <div class="invalid-feedback" id="meta_keywords_error">
                                Meta Keywords are required
                            </div>
                            @error('meta_keywords')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            {!! html()->label(__('messages.lbl_canonical_url') . ' <span class="required">*</span>', 'canonical_url')
                                ->class('form-label')
                                ->attribute('for', 'canonical_url') !!}
                            <input type="text" name="canonical_url" id="canonical_url" class="form-control @error('canonical_url') is-invalid @enderror"
                                   value="{{ old('canonical_url', $seo->canonical_url ?? '') }}" placeholder="{{ __('placeholder.lbl_canonical_url') }}" >
                            {{-- @error('canonical_url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror --}}
                            <div class="invalid-feedback" id="embed-error">Canonical URL is required</div>
                        </div>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <div class="d-flex justify-content-between">
                            {!! html()->label(__('messages.lbl_short_description') . ' <span class="required">*</span>', 'short_description')
                                ->class('form-label')
                                ->attribute('for', 'short_description') !!}

                            <div id="meta-description-char-count" class="text-muted">0/200 {{ __('messages.words') }}</div>
                        </div>

                        <textarea name="short_description" id="short_description"
                                class="form-control @error('short_description') is-invalid @enderror"
                                maxlength="200" placeholder="{{ __('placeholder.lbl_short_description') }}" >{{ old('short_description', $seo->short_description ?? '') }}</textarea>

                        @error('short_description')
                            <span class="text-danger" id="short_description-error">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="embed-error">Site Meta Description is required</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
            {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
        </div>
        {{ html()->form()->close() }}

        @include('components.media-modal')
@endsection
@push('after-scripts')


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('seoForm');
    const submitButton = document.getElementById('submit-button');
    const seoCheckbox = document.getElementById('enableSeoIntegration');

    const metaTitle = document.getElementById('meta_title');
    const hiddenInputsContainer = document.getElementById('meta_keywords_hidden_inputs');
    const errorMsg = document.getElementById('meta_keywords_error');
    const tagifyInput = document.getElementById('meta_keywords_input');
    const tagifyWrapper = tagifyInput.closest('.tagify');
    const keywordInputs = hiddenInputsContainer.querySelectorAll('input[name="meta_keywords[]"]');
    const googleVerification = document.getElementById('google_site_verification');
    const canonicalUrl = document.getElementById('canonical_url');
    const shortDescription = document.getElementById('short_description');
    const seoImage = document.getElementById('seo_image');
    const seoImagePreview = document.getElementById('selectedSeoImage');
    const seoImageError = document.querySelector('#seo_image_input + .invalid-feedback');

    const metaKeywordsError = document.getElementById('meta_keywords_error');
    console.log('Form:', document.getElementById('seoForm'));
    console.log('Tagify Wrapper:', document.getElementById('meta_keywords_input')?.closest('.tagify'));
    console.log('SEO Image Error:', document.querySelector('#seo_image_input + .invalid-feedback'));

    document.getElementById('enableSeoIntegration')?.addEventListener('change', function () {
        document.getElementById('seoFields').style.display = this.checked ? 'block' : 'none';
        if (this.checked) {
            metaTitle.setAttribute('required', 'required');
            tagifyInput.setAttribute('required', 'required');
            googleVerification.setAttribute('required', 'required');
            canonicalUrl.setAttribute('required', 'required');
            shortDescription.setAttribute('required', 'required');
            seoImage.setAttribute('required', 'required');
        }else{
            metaTitle.removeAttribute('required');
            tagifyInput.removeAttribute('required');
            googleVerification.removeAttribute('required');
            canonicalUrl.removeAttribute('required');
            shortDescription.removeAttribute('required');
            seoImage.removeAttribute('required');
        }
    });
});
</script>

<script src="{{ asset('js/tagify.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/tagify.css') }}">

  <script>
    // JavaScript to update character count dynamically
    function updateCharCount() {
        const metaTitleInput = document.getElementById('meta_title');
        const charCountElement = document.getElementById('meta-title-char-count');
        const charCount = metaTitleInput.value.length;
        charCountElement.textContent = `${charCount}/100 {{ __('messages.words') }}`;
    }
</script>

<script>

document.addEventListener("DOMContentLoaded", function () {
    // Meta Title Character Count
    const metaTitleInput = document.getElementById('meta_title');
    const metaTitleCharCountDisplay = document.getElementById('meta-title-char-count');

    // Meta Description Character Count
    const metaDescriptionInput = document.getElementById('short_description');
    const metaDescriptionCharCountDisplay = document.getElementById('meta-description-char-count');

    // Function to update character count
    function updateCharCount(inputField, charCountDisplay, limit) {
        const currentLength = inputField.value.length;
        charCountDisplay.textContent = `${currentLength}/${limit}`;

        // Change color based on length
        charCountDisplay.style.color = currentLength > limit ? 'red' : 'green';

        // Update character count as the user types
        inputField.addEventListener('input', function() {
            const currentLength = inputField.value.length;
            charCountDisplay.textContent = `${currentLength}/${limit}`;
            charCountDisplay.style.color = currentLength > limit ? 'red' : 'green';
        });
    }

    // Update character count for Meta Title
    if (metaTitleInput && metaTitleCharCountDisplay) {
        updateCharCount(metaTitleInput, metaTitleCharCountDisplay, 100);
    }

    // Update character count for Meta Description
    if (metaDescriptionInput && metaDescriptionCharCountDisplay) {
        updateCharCount(metaDescriptionInput, metaDescriptionCharCountDisplay, 200);
    }

    // Meta Keywords with Tagify
    const input = document.querySelector('#meta_keywords_input');
    const hiddenContainer = document.getElementById('meta_keywords_hidden_inputs');

     if (input) {
        const tagify = new Tagify(input, {
            originalInputValueFormat: (valuesArr) => JSON.stringify(valuesArr.map(item => item.value)) // Format as JSON string
        });

        // Sync hidden inputs and update meta tag dynamically
        function syncHiddenInputs() {
            if (hiddenContainer) {
                hiddenContainer.innerHTML = ''; // Clear existing hidden inputs

                // Loop through each tag and create a hidden input field
                tagify.value.forEach(item => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'meta_keywords[]'; // Name the inputs for proper array submission
                    hiddenInput.value = item.value; // Value of the hidden input is the tag value
                    hiddenContainer.appendChild(hiddenInput);
                });

                // Update meta tag content dynamically
                const metaTag = document.getElementById('dynamicMetaKeywords');
                if (metaTag) {
                    const keywords = tagify.value.map(item => item.value).join(', '); // Join the tag values into a string
                    metaTag.setAttribute('content', keywords); // Set the content attribute of the meta tag
                }
            }
        }

        // Call syncHiddenInputs when tags are added, removed, or changed
        tagify.on('add', syncHiddenInputs);
        tagify.on('remove', syncHiddenInputs);
        tagify.on('change', syncHiddenInputs);

        // Optional: Restore old input if validation failed
        @if (old('meta_keywords'))
            // Ensure the old value is in array format before passing it to Tagify
            const oldTags = Array.isArray(@json(old('meta_keywords'))) ? @json(old('meta_keywords')) : JSON.parse(@json(old('meta_keywords')));
            tagify.addTags(oldTags); // Restores tags if there's any old input
        @endif
    }
});

</script>



    <script>

document.addEventListener('DOMContentLoaded', function () {
        flatpickr('.min-datetimepicker-time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // Format for time (24-hour format)
            time_24hr: true // Enable 24-hour format

        });

        flatpickr('.datetimepicker', {
            dateFormat: "Y-m-d", // Format for date (e.g., 2024-08-21)

        });

        // Function to validate numeric fields
        function validateNumericField(input, errorId) {
                    const value = parseFloat(input.value);
                    const errorElement = document.getElementById(errorId);

                    if (isNaN(value) || value <= 0) {
                        input.classList.add('is-invalid');
                        errorElement.style.display = 'block';
                        errorElement.textContent = "{{ __('messages.value_must_be_greater_than_zero') }}";
                        return false;
                    } else {
                        input.classList.remove('is-invalid');
                        errorElement.style.display = 'none';
                        return true;
                    }
                }

                // Function to validate discount field
                function validateDiscount(input) {
                    const value = parseFloat(input.value);
                    const errorElement = document.getElementById('discount-error');

                     if (value < 1 || value > 99) {
                        input.classList.add('is-invalid');
                        errorElement.style.display = 'block';
                        errorElement.textContent = "{{ __('messages.discount_must_be_between_zero_and_ninety_nine') }}";
                        return false;
                    } else {
                        input.classList.remove('is-invalid');
                        errorElement.style.display = 'none';
                        return true;
                    }
                }

                 function validateAvailableForGreaterThanAccessDuration(availableInput, accessInput, errorId) {
                        const availableValue = parseFloat(availableInput.value);
                        const accessValue = parseFloat(accessInput.value);
                        const errorElement = document.getElementById(errorId);

                        // Run base numeric validation first
                        const isValid = validateNumericField(availableInput, errorId);

                        if (!isValid || isNaN(accessValue)) return;

                        if (availableValue <= accessValue) {
                            availableInput.classList.add('is-invalid');
                            errorElement.style.display = 'block';
                            errorElement.textContent = "{{ __('messages.available_for_must_be_greater_than_access_duration') }}";
                        } else {
                            availableInput.classList.remove('is-invalid');
                            errorElement.style.display = 'none';
                        }
                    }

                // Add blur event listeners to numeric fields
                const priceInput = document.querySelector('input[name="price"]');
                const accessDurationInput = document.querySelector('input[name="access_duration"]');
                const discountInput = document.querySelector('input[name="discount"]');
                const availableForInput = document.querySelector('input[name="available_for"]');

                if (priceInput) {
                    priceInput.addEventListener('blur', function() {
                        validateNumericField(this, 'price-error');
                    });
                }

                if (accessDurationInput) {
                    accessDurationInput.addEventListener('blur', function() {
                        validateNumericField(this, 'access_duration-error');
                    });
                }

                if (discountInput) {
                    discountInput.addEventListener('blur', function() {
                        validateDiscount(this);
                    });
                }

                if (availableForInput) {
                    availableForInput.addEventListener('blur', function() {
                        validateNumericField(this, 'available_for-error');
                    });
                }

                if (availableForInput && accessDurationInput) {
                    availableForInput.addEventListener('blur', function () {
                            validateAvailableForGreaterThanAccessDuration(availableForInput, accessDurationInput, 'available_for-error');
                    });

                    accessDurationInput.addEventListener('blur', function () {
                        if (availableForInput.value.trim() !== '') {
                            validateAvailableForGreaterThanAccessDuration(availableForInput, accessDurationInput, 'available_for-error');
                        }
                    });
                 }
    });

      tinymce.init({
          selector: '#description',
          plugins: 'link image code',
          toolbar: 'undo redo | styleselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | removeformat | code | image',
          setup: function(editor) {
                // Setup TinyMCE to listen for changes
                editor.on('change', function(e) {
                    // Get the editor content
                    const content = editor.getContent().trim();
                    const $textarea = $('#description');
                    const $error = $('#desc-error');

                    // Check if content is empty
                    if (content === '') {
                        $textarea.addClass('is-invalid'); // Add invalid class if empty
                        $error.show(); // Show validation message

                    } else {
                        $textarea.removeClass('is-invalid'); // Remove invalid class if not empty
                        $error.hide(); // Hide validation message
                    }
                });
            }
      });


      function calculateTotal() {
                const price = parseFloat(document.querySelector('input[name="price"]').value) || 0;
                const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
                let total = price;

                if (discount > 0 && discount < 100) {
                    total = price - ((price * discount) / 100);
                }

                document.getElementById('total_amount').value = total.toFixed(2);
            }

            document.addEventListener('DOMContentLoaded', function () {
                const priceInput = document.querySelector('input[name="price"]');
                const discountInput = document.querySelector('input[name="discount"]');

                priceInput.addEventListener('input', calculateTotal);
                discountInput.addEventListener('input', calculateTotal);

                // Trigger initial calculation if old values exist
                calculateTotal();
            });

      $(document).on('click', '.variable_button', function() {
          const textarea = $(document).find('.tab-pane.active');
          const textareaID = textarea.find('textarea').attr('id');
          tinyMCE.activeEditor.selection.setContent($(this).attr('data-value'));
      });

        document.addEventListener('DOMContentLoaded', function() {

            function handleTrailerUrlTypeChange(selectedValue) {
                var FileInput = document.getElementById('url_file_input');
                var URLInput = document.getElementById('url_input');

                if (selectedValue === 'Local') {
                    FileInput.classList.remove('d-none');
                    URLInput.classList.add('d-none');
                } else if (selectedValue === 'URL' || selectedValue === 'YouTube' || selectedValue === 'HLS' || selectedValue === 'x265' ||
                    selectedValue === 'Vimeo') {
                    URLInput.classList.remove('d-none');
                    FileInput.classList.add('d-none');
                } else {
                    FileInput.classList.add('d-none');
                    URLInput.classList.add('d-none');
                }
            }

            var initialSelectedValue = document.getElementById('trailer_url_type').value;
            handleTrailerUrlTypeChange(initialSelectedValue);
            $('#trailer_url_type').change(function() {
                var selectedValue = $(this).val();
                handleTrailerUrlTypeChange(selectedValue);
            });


        });
function handleQualityTypeChange(selectElement) {
    const container = selectElement.closest('.row');
    const urlInput = container.querySelector('.quality_video_input');
    const fileInput = container.querySelector('.quality_video_file_input');
    const embedInput = container.querySelector('.quality_video_embed_input');

    // Hide all inputs first
    urlInput.classList.add('d-none');
    fileInput.classList.add('d-none');
    embedInput.classList.add('d-none');

    // Show the appropriate input based on selection
    switch(selectElement.value) {
        case 'URL':
        case 'YouTube':
        case 'HLS':
        case 'Vimeo':
        case 'x265':
            urlInput.classList.remove('d-none');
            break;
        case 'Local':
            fileInput.classList.remove('d-none');
            break;
        case 'Embedded':
            embedInput.classList.remove('d-none');
            break;
    }
}

// Initialize quality type handlers for existing inputs
$(document).ready(function() {
    document.querySelectorAll('.video_quality_type').forEach(select => {
        handleQualityTypeChange(select);
    });

    // For dynamically added quality inputs
    $(document).on('change', '.video_quality_type', function() {
        handleQualityTypeChange(this);
    });
});

        function showPlanSelection() {
                const planSelection = document.getElementById('planSelection');
                const payPerViewFields = document.getElementById('payPerViewFields');
                const planIdSelect = document.getElementById('plan_id');
                const priceInput = document.querySelector('input[name="price"]');
                const selectedAccess = document.querySelector('input[name="access"]:checked');
                const releaseDateField = document.querySelector('input[name="release_date"]').closest('.col-md-6');
                const releaseDateInput = document.querySelector('input[name="release_date"]');
                const downlaodstatusDataFeild = document.querySelector('input[name="download_status"]').closest('.col-md-6');
                const purchaseTypeSelect = document.querySelector('select[name="purchase_type"]');
                const accessDurationInput = document.querySelector('input[name="access_duration"]');
                const availableForInput = document.querySelector('input[name="available_for"]');

                if (!selectedAccess) return;

                const value = selectedAccess.value;

                // Handle visibility and required attributes
                if (value === 'paid') {
                    planSelection.classList.remove('d-none');
                    payPerViewFields.classList.add('d-none');
                    planIdSelect.setAttribute('required', 'required');
                    priceInput.removeAttribute('required');
                    purchaseTypeSelect.required = false;
                    accessDurationInput.required = false;
                    availableForInput.required = false;
                    releaseDateField.classList.remove('d-none');
                    downlaodstatusDataFeild.classList.remove('d-none');
                    releaseDateInput.setAttribute('required', 'required');
                } else if (value === 'pay-per-view') {
                    planSelection.classList.add('d-none');
                    payPerViewFields.classList.remove('d-none');
                    planIdSelect.removeAttribute('required');
                    priceInput.setAttribute('required', 'required');
                    purchaseTypeSelect.required = true;
                    accessDurationInput.required = purchaseTypeSelect.value === 'rental';
                    availableForInput.required = true;
                    releaseDateField.classList.add('d-none');
                    downlaodstatusDataFeild.classList.add('d-none');
                    releaseDateInput.removeAttribute('required');
                } else {
                    planSelection.classList.add('d-none');
                    payPerViewFields.classList.add('d-none');
                    planIdSelect.removeAttribute('required');
                    priceInput.removeAttribute('required');
                    purchaseTypeSelect.required = false;
                    accessDurationInput.required = false;
                    availableForInput.required = false;
                    releaseDateField.classList.remove('d-none');
                    downlaodstatusDataFeild.classList.remove('d-none');
                    releaseDateInput.setAttribute('required', 'required');
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                // Initial setup
                showPlanSelection();

                // Event listeners for movie access radio buttons
                const accessRadios = document.querySelectorAll('input[name="access"]');
                accessRadios.forEach(function (radio) {
                    radio.addEventListener('change', showPlanSelection);
                });
            });

            function toggleAccessDuration(value) {
                const accessDuration = document.getElementById('accessDurationWrapper');
                const accessDurationInput = document.querySelector('input[name="access_duration"]');
                const selectedAccess = document.querySelector('input[name="access"]:checked');

                if (value === 'rental') {
                    accessDuration.classList.remove('d-none');
                    // Only set required if pay-per-view is selected
                    if (selectedAccess && selectedAccess.value === 'pay-per-view') {
                        accessDurationInput.required = true;
                    }
                } else {
                    accessDuration.classList.add('d-none');
                    accessDurationInput.required = false;
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const purchaseType = document.getElementById('purchase_type');
                if (purchaseType) {
                    toggleAccessDuration(purchaseType.value);
                    purchaseType.addEventListener('change', function () {
                        toggleAccessDuration(this.value);
                    });
                }
            });

        function toggleQualitySection() {

var enableQualityCheckbox = document.getElementById('enable_quality');
var enableQualitySection = document.getElementById('enable_quality_section');

if (enableQualityCheckbox.checked) {

 enableQualitySection.classList.remove('d-none');

  } else {

  enableQualitySection.classList.add('d-none');
}
}

document.addEventListener('DOMContentLoaded', function () {
toggleQualitySection();
});


document.addEventListener('DOMContentLoaded', function() {

 function handleVideoUrlTypeChange(selectedtypeValue) {
    var VideoFileInput = document.getElementById('video_file_input_section');
    var VideoURLInput = document.getElementById('video_url_input_section');
    var EmbedCodeInput = document.getElementById('embed_code_input_section'); // <-- Add this line
    var videourl = document.getElementById('video_url_input');
    var videofile = document.querySelector('input[name="video_file_input"]');
    var fileError = document.getElementById('file-error');
    var urlError = document.getElementById('url-error');
    var urlPatternError = document.getElementById('url-pattern-error');
    if (selectedtypeValue === 'Local') {
        VideoFileInput.classList.remove('d-none');
        VideoURLInput.classList.add('d-none');
        if (EmbedCodeInput) EmbedCodeInput.classList.add('d-none'); // <-- Add this line
        videourl.removeAttribute('required');
        videofile.setAttribute('required', 'required');
        fileError.style.display = 'block';
    } else if (
        selectedtypeValue === 'URL' ||
        selectedtypeValue === 'YouTube' ||
        selectedtypeValue === 'HLS' ||
        selectedtypeValue === 'Vimeo' ||
        selectedtypeValue === 'x265'
    ) {
        VideoURLInput.classList.remove('d-none');
        VideoFileInput.classList.add('d-none');
        if (EmbedCodeInput) EmbedCodeInput.classList.add('d-none'); // <-- Add this line
        videourl.setAttribute('required', 'required');
        videofile.removeAttribute('required');
        validateVideoUrlInput();
    } else if (selectedtypeValue === 'Embedded') { // <-- Add this block
        if (EmbedCodeInput) EmbedCodeInput.classList.remove('d-none');
        VideoFileInput.classList.add('d-none');
        VideoURLInput.classList.add('d-none');
    } else {
        VideoFileInput.classList.add('d-none');
        VideoURLInput.classList.add('d-none');
        if (EmbedCodeInput) EmbedCodeInput.classList.add('d-none'); // <-- Add this line
    }
 }


 function validateVideoUrlInput() {
    var videourl = document.querySelector('input[name="video_url_input"]');
    var urlError = document.getElementById('url-error');
    var urlPatternError = document.getElementById('url-pattern-error');

    if (videourl.value === '') {
        urlError.style.display = 'block';
        urlPatternError.style.display = 'none';
        return false;
    } else {
        urlError.style.display = 'none';
        selectedValue = document.getElementById('video_upload_type').value;
                    if (selectedValue === 'YouTube') {
                        urlPattern = /^(https?:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/;
                        urlPatternError.innerText = '';
                        urlPatternError.innerText='Please enter a valid Youtube URL'
                    } else if (selectedValue === 'Vimeo') {
                        urlPattern = /^(https?:\/\/)?(www\.)?(vimeo\.com\/(channels\/[a-zA-Z0-9]+\/|groups\/[^/]+\/videos\/)?\d+)(\/.*)?$/;
                        urlPatternError.innerText = '';
                        urlPatternError.innerText='Please enter a valid Vimeo URL'
                    } else {
                        // General URL pattern for other types
                        urlPattern = /^https?:\/\/.+$/;
                        urlPatternError.innerText='Please enter a valid URL starting with http:// or https://.'
                    } // Simple URL pattern validation
        if (!urlPattern.test(videourl.value)) {
            urlPatternError.style.display = 'block';
            return false;
        } else {
            urlPatternError.style.display = 'none';
            return true;
        }
    }
}

var initialSelectedValue = document.getElementById('video_upload_type').value;
handleVideoUrlTypeChange(initialSelectedValue);
$('#video_upload_type').change(function() {
    var selectedtypeValue = $(this).val();
    handleVideoUrlTypeChange(selectedtypeValue);
});

// Real-time validation while typing
var videourl = document.querySelector('input[name="video_url_input"]');
if (videourl) {
    videourl.addEventListener('input', function() {
        validateVideoUrlInput();
    });
}
});


$(document).ready(function() {

$('#GenrateshortDescription').on('click', function(e) {

    e.preventDefault();

    var description = $('#short_desc').val();
    var name = $('#name').val();
    var type='short_desc';

    var generate_discription = "{{ route('backend.videos.generate-description') }}";
        generate_discription = generate_discription.replace('amp;', '');

    if (!description && !name) {
        // $('#error_msg').text('Name field is required');
         return;
     }

     $('#short_desc').text('Loading...')


  $.ajax({

       url: generate_discription,
       type: 'POST',
       headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
       data: {
               description: description,
               name: name,
               type:type
             },
       success: function(response) {

           $('#short_desc').text('')

            if(response.success){

             var data = response.data;
             $('#short_desc').html(data)

            } else {
                $('#error_message').text(response.message || 'Failed to get Description.');
            }
        },
       error: function(xhr) {
         $('#error_message').text('Failed to get Description.');
         $('#short_desc').text('');
           if (xhr.responseJSON && xhr.responseJSON.message) {
               $('#error_message').text(xhr.responseJSON.message);
           } else {
               $('#error_message').text('An error occurred while fetching the movie details.');
           }
        }
    });
  });
});

$(document).ready(function() {

$('#GenrateDescription').on('click', function(e) {

    e.preventDefault();

    var description = $('#description').val();
    var name = $('#name').val();
    var tvshow = $('#entertainment_id').val();
    var type='short_desc';


    var generate_discription = "{{ route('backend.seasons.generate-description') }}";
        generate_discription = generate_discription.replace('amp;', '');

    if (!description && !name) {
        $('#error_msg').text('Name field is required');
         return;
     }

    tinymce.get('description').setContent('Loading...');

  $.ajax({

       url: generate_discription,
       type: 'POST',
       headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
       data: {
               description: description,
               name: name,
               tvshow: tvshow,
               type:type
             },
       success: function(response) {

          tinymce.get('description').setContent('');

            if(response.success){

             var data = response.data;

             tinymce.get('description').setContent(data);

            } else {
                $('#error_message').text(response.message || 'Failed to get Description.');
            }
        },
       error: function(xhr) {
         $('#error_message').text('Failed to get Description.');
         tinymce.get('description').setContent('');

           if (xhr.responseJSON && xhr.responseJSON.message) {
               $('#error_message').text(xhr.responseJSON.message);
           } else {
               $('#error_message').text('An error occurred while fetching the movie details.');
           }
        }
    });
 });
});

// Add Subtitle Functionality
function toggleSubtitleSection() {
    if($('#enable_subtitle').is(':checked')) {
        $('#subtitle_section').removeClass('d-none');
        $('.subtitle-language').attr('required', true);
        $('.subtitle-file').attr('required', true);
    } else {
        $('#subtitle_section').addClass('d-none');
        $('.subtitle-language').removeAttr('required');
        $('.subtitle-file').removeAttr('required');
    }
}

// Initial state
toggleSubtitleSection();

// On change
$('#enable_subtitle').on('change', toggleSubtitleSection);

// Add new subtitle row
let subtitleIndex = 1;

$('#add-subtitle').on('click', function () {
    let newRow = $(`
        <div class="row gy-3 subtitle-row my-3">
            <div class="col-md-4">
                <select name="subtitles[${subtitleIndex}][language]" class="form-control select2 subtitle-language" required>
                    <option value="">{{ __('placeholder.lbl_select_language') }}</option>
                    @foreach($subtitle_language as $language)
                        <option value="{{ $language->value }}">{{ $language->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">{{ __('validation.required', ['attribute' => 'language']) }}</div>
            </div>
            <div class="col-md-4">
                <input type="file" name="subtitles[${subtitleIndex}][subtitle_file]" class="form-control subtitle-file" required>
                <div class="invalid-feedback">{{ __('validation.required', ['attribute' => 'subtitle file']) }}</div>
            </div>
            <div class="col-md-3">
                <div class="form-check mt-3">
                    <input type="checkbox" name="subtitles[${subtitleIndex}][is_default]" class="form-check-input is-default-subtitle" id="is_default_${subtitleIndex}">
                    <label class="form-check-label" for="is_default_${subtitleIndex}">{{ __('movie.lbl_default_subtitle') }}</label>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm mt-4 remove-subtitle">
                    <i class="ph ph-trash"></i>
                </button>
            </div>
        </div>
    `);
    $('#subtitle-inputs-container').append(newRow);
    subtitleIndex++;
    // Re-initialize select2 for the new select
    newRow.find('.subtitle-language').select2({
        width: '100%',
        placeholder: "{{ __('placeholder.lbl_select_language') }}",
        allowClear: true
    });
});

// Remove subtitle row
$(document).on('click', '.remove-subtitle', function() {
    $(this).closest('.subtitle-row').remove();
});

// Handle default subtitle selection
$(document).on('change', '.is-default-subtitle', function() {
    if($(this).is(':checked')) {
        $('.is-default-subtitle').not(this).prop('checked', false);
    }
});

// --- Embed Code Validation (Entertainment style) ---
function validateEmbedInput(inputId, errorId) {
    const embedInput = document.getElementById(inputId);
    const embedError = document.getElementById(errorId);
    const value = embedInput?.value.trim() || '';

    // Error messages from Laravel translations
    const msgRequired = "{{ __('messages.embed_code_required') }}";
    const msgInvalid = "{{ __('messages.embed_code_invalid') }}";
    const msgOnlyYoutubeVimeo = "{{ __('messages.embed_code_only_youtube_vimeo') }}";

    // Clear previous error
    if (embedError) embedError.style.display = 'none';
    if (embedInput) embedInput.classList.remove('is-invalid');

    if (!embedInput || value === '') {
        return showError(msgRequired);
    }

    // Extract iframe src
    const iframeMatch = value.match(/^<iframe[^>]+src=\"([^\"]+)\"[^>]*><\/iframe>$/i);
    if (!iframeMatch) {
        return showError(msgInvalid);
    }

    const src = iframeMatch[1];

    // Accept YouTube/Vimeo embeds with optional query params
    const isValidYouTubeEmbed = /^https:\/\/www\.youtube\.com\/embed\/[A-Za-z0-9_-]+(\?.*)?$/.test(src);
    const isValidVimeoEmbed = /^https:\/\/player\.vimeo\.com\/video\/\d+(\?.*)?$/.test(src);

    if (!isValidYouTubeEmbed && !isValidVimeoEmbed) {
        return showError(msgOnlyYoutubeVimeo);
    }

    return true;

    function showError(message) {
        if (embedError) embedError.innerText = message;
        if (embedError) embedError.style.display = 'block';
        if (embedInput) embedInput.classList.add('is-invalid');
        return false;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Live validation
    ['embed_code', 'trailer_embedded'].forEach((id, i) => {
        const input = document.getElementById(id);
        const errorId = i === 0 ? 'embed-error' : 'trailer-embed-error';
        if (input) {
            input.addEventListener('input', () => validateEmbedInput(id, errorId));
        }
    });

    // Form validation
    const form = document.getElementById('form-submit');
    if (form) {
        form.addEventListener('submit', function (e) {
            const videoType = document.getElementById('video_upload_type')?.value;
            const trailerType = document.getElementById('trailer_url_type')?.value;

            let isValid = true;

            if (videoType === 'Embedded') {
                isValid = validateEmbedInput('embed_code', 'embed-error');
            }

            if (!isValid) {
                e.preventDefault();
                return false;
                $('#submit-button').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> {{ trans("messages.save") }}');
            }

             // Only here, after validation passes, set loading/disabled

        });
    }
});

    </script>

    <style>
        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .close-icon {
            top: -13px;
            left: 54px;
            background: rgba(255, 0, 0, 0.6);
            border: none;
            border-radius: 50%;
            color: white;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            line-height: 25px;
        }

        .required {
                color: red;
            }
    </style>
@endpush
