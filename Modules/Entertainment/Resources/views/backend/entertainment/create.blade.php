@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.movies.index" />

<p class="text-danger" id="error_message"></p>

@if(isenablemodule('enable_tmdb_api')==1)

    <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-3 mb-3">

            <a class="ph ph-info" data-bs-toggle="tooltip" title="To get a movie id, click on icon ." href="https://www.themoviedb.org/movie/533535-deadpool-wolverine" target="_blank"></a>
            {{ html()->label(__('movie.lbl_movie_id') . '<span class="text-danger">*</span>', 'movie_id')->class('form-label mb-0') }}
            {{ html()->text('movie_id')->attribute('value', old('movie_id'))->placeholder(__('placeholder.lbl_movie_id'))->class('form-control w-auto') }}
            <span class="text-danger" id="movie_id_error"></span>

        <div>
            <div id="loader" style="display: none;">
                <button class="btn btn-md btn-primary float-right">{{__('tvshow.lbl_loading')}}</button>
            </div>
            <button class="btn btn-md btn-primary float-right" id="import_movie">{{__('tvshow.lbl_import')}}</button>
        </div>
    </div>

@endif

    {{ html()->form('POST' ,route('backend.entertainments.store'))
    ->attribute('enctype', 'multipart/form-data')
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')
    ->class('requires-validation')
    ->attribute('novalidate', 'novalidate')
    ->open()
}}

        @csrf

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{__('movie.about_movie')}}</h5>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-4 col-lg-4">
                        <div class="position-relative">
                            {{ html()->hidden('type', $type)->id('type') }}
                            {{ html()->hidden('tmdb_id', null)->id('tmdb_id') }}
                            {{ html()->hidden('is_import', 0)->id('is_import') }}
                            {{ html()->label(__('movie.lbl_thumbnail'), 'thumbnail')->class('form-label') }}
                            <div class="input-group btn-file-upload">
                                {{ html()->button('<i class="ph ph-image"></i> ' . __('messages.lbl_choose_image'))->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerThumbnail')->attribute('data-hidden-input', 'thumbnail_url')->id('iq-image-url')->style('height:13.6rem') }}
                                {{ html()->text('thumbnail_input')->class('form-control')->placeholder('placeholder.lbl_image')->attribute('aria-label', 'Thumbnail Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerThumbnail')->attribute('data-hidden-input', 'thumbnail_url') }}
                            </div>
                            <div class="uploaded-image" id="selectedImageContainerThumbnail">
                                    <img id="selectedImage"
                                        src="{{ old('thumbnail_url', isset($data) ? $data->thumbnail_url : '') }}"
                                        alt="feature-image" class="img-fluid mb-2"
                                        style="{{ old('thumbnail_url', isset($data) ? $data->thumbnail_url : '') ? '' : 'display:none;' }}"/>
                            </div>
                            {{ html()->hidden('thumbnail_url')->id('thumbnail_url')->value(old('thumbnail_url', isset($data) ? $data->thumbnail_url : ''))}}
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_poster'), 'poster')->class('form-label') }}
                            <div class="input-group btn-file-upload">
                                {{ html()->button('<i class="ph ph-image"></i>' . __('messages.lbl_choose_image'))->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerPoster')->attribute('data-hidden-input', 'poster_url')->style('height:13.6rem') }}

                                {{ html()->text('poster_input')->class('form-control')->placeholder('placeholder.lbl_image')->attribute('aria-label', 'Poster Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerPoster')->attribute('data-hidden-input', 'poster_url') }}

                                {{ html()->hidden('poster_url')->id('poster_url')->value(old('poster_url', isset($data) ? $data->poster_url : '')) }}
                            </div>
                            <div class="uploaded-image" id="selectedImageContainerPoster">
                                <img id="selectedPosterImage"
                                    src="{{ old('poster_url', isset($data) ? $data->poster_url : '') }}" alt="feature-image"
                                    class="img-fluid mb-2 avatar-80 "
                                    style="{{ old('poster_url', isset($data) ? $data->poster_url : '') ? '' : 'display:none;' }}" />

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_poster_tv'), 'poster_tv')->class('form-label') }}
                            <div class="input-group btn-file-upload">
                                {{ html()->button('<i class="ph ph-image"></i>' . __('messages.lbl_choose_image'))->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerPosterTv')->attribute('data-hidden-input', 'poster_tv_url')->style('height:13.6rem') }}

                                {{ html()->text('poster_tv_input')->class('form-control')->placeholder('placeholder.lbl_image')->attribute('aria-label', 'Poster Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerPosterTv')->attribute('data-hidden-input', 'poster_tv_url') }}

                                {{ html()->hidden('poster_tv_url')->id('poster_tv_url')->value(old('poster_tv_url', isset($data) ? $data->poster_tv_url : '')) }}
                            </div>
                            <div class="uploaded-image" id="selectedImageContainerPosterTv">
                                <img id="selectedPosterTvImage"
                                    src="{{ old('poster_tv_url', isset($data) ? $data->poster_tv_url : '') }}" alt="feature-image"
                                    class="img-fluid mb-2 avatar-80 "
                                    style="{{ old('poster_tv_url', isset($data) ? $data->poster_tv_url : '') ? '' : 'display:none;' }}" />

                            </div>
                        </div>
                    </div>
                    <!-- <div class="row"> -->
                        <div class="col-md-3 col-lg-3 mb-3">
                            {{ html()->label(__('movie.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                            {{ html()->text('name')->attribute('value', old('name'))->placeholder(__('placeholder.lbl_movie_name'))->class('form-control')->attribute('required', 'required') }}
                            <span class="text-danger" id="error_msg"></span>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="name-error">Name field is required</div>
                        </div>
                        <!-- <div class="col-md-3 col-lg-3 mb-3">
                            {{ html()->label(__('movie.lbl_trailer_url_type') .' <span class="text-danger">*</span>', 'type')->class('form-label') }}
                            {{ html()->select(
                                    'trailer_url_type',
                                    $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_type'), ''),
                                    old('trailer_url_type', ''), // Set '' as the default value
                                )->class('form-control select2')->id('trailer_url_type')->required() }}
                            @error('trailer_url_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Trailer Type field is required</div>


                        </div> -->
                        {{ html()->hidden('trailer_url_type', 'HLS')->id('trailer_url_type') }}

                        <div class="col-md-3 col-lg-3 mb-3">
                            <!-- <div id="url_input">
                                {{ html()->label(__('movie.lbl_trailer_url') .' <span class="text-danger">*</span>', 'trailer_url')->class('form-label') }}
                                {{ html()->text('trailer_url')->attribute('value', old('trailer_url'))->placeholder(__('placeholder.lbl_trailer_url'))->class('form-control') }}
                                @error('trailer_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                    <div class="invalid-feedback" id="trailer-url-error">Video URL field is required</div>
                                    <div class="invalid-feedback" id="trailer-pattern-error" style="display:none;">
                                    Please enter a valid URL starting with http:// or https://.
                                </div>
                            </div> -->
                            <div id="url_input">
                                {{ html()->label(__('movie.lbl_trailer_url') .' (HLS) <span class="text-danger">*</span>', 'trailer_url')->class('form-label') }}
                                {{ html()->text('trailer_url')->attribute('value', old('trailer_url'))->placeholder(__('placeholder.lbl_trailer_url'))->class('form-control')->required() }}
                                @error('trailer_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="trailer-url-error">Video URL field is required</div>
                                <div class="invalid-feedback" id="trailer-pattern-error" style="display:none;">
                                Please enter a valid HLS URL starting with http:// or https://.
                            </div>
                         </div>



                            <div id="url_file_input" class="d-none">
                                {{ html()->label(__('movie.lbl_trailer_video'), 'trailer_video')->class('form-label') }}

                                <div class="input-group btn-video-link-upload">
                                    {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-upload"></i>')->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainertailerurl')->attribute('data-hidden-input', 'file_url_trailer') }}

                                    {{ html()->text('trailer_input')->class('form-control')->placeholder(__('placeholder.lbl_movie_name'))->attribute('aria-label', 'Trailer Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainertailerurl')->attribute('data-hidden-input', 'file_url_trailer') }}
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
                                <div class="invalid-feedback" id="trailer-file-error">Video File field is required</div>

                            </div>
                            <div id="trailer_embed_input_section" class="d-none">
                                {{ html()->label(__('movie.lbl_embed_code') . ' <span class="text-danger">*</span>', 'trailer_embedded')->class('form-label') }}
                                {{ html()->textarea('trailer_embedded')->placeholder('<iframe ...></iframe>')->class('form-control')->id('trailer_embedded') }}
                                @error('trailer_embedded')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="trailer-embed-error">Embed code is required</div>
                            </div>
                        </div>

                    <!-- </div> -->
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            {{ html()->label(__('movie.lbl_description'). ' <span class="text-danger">*</span>', 'description')->class('form-label mb-0') }}
                            <!--<span class="text-primary cursor-pointer"  id="GenrateDescription" ><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span>-->
                        </div>
                        {{ html()->textarea('description', old('description'))->class('form-control')->id('description')->placeholder(__('placeholder.lbl_movie_description'))->attribute('required', 'required')->rows(5) }}
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="desc-error">Description field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_movie_access'), 'movie_access')->class('form-label') }}
                        <div class="d-flex align-items-center gap-3">
                            <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                            <div>
                                <input class="form-check-input" type="radio" name="movie_access" id="paid"
                                    value="paid" onchange="showPlanSelection(this.value === 'paid')"
                                    {{ old('movie_access') == 'paid' ? 'checked' : '' }} checked>
                                <span class="form-check-label" >{{__('movie.lbl_paid')}}</span>
                            </div>
                            </label>
                            <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                            <div>
                                <input class="form-check-input" type="radio" name="movie_access" id="free"
                                    value="free" onchange="showPlanSelection(this.value === 'paid')"
                                    {{ old('movie_access') == 'free' ? 'checked' : '' }}>
                               <span class="form-check-label" >{{__('movie.lbl_free')}}</span>
                            </div>
                        </label>

                        <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                            <div>
                                <input class="form-check-input" type="radio" name="movie_access" id="pay-per-view" value="pay-per-view"
                                    onchange="showPlanSelection(this.value === 'pay-per-view')"
                                    {{ old('movie_access') == 'pay-per-view' ? 'checked' : '' }}>
                                <span class="form-check-label" for="pay-per-view">{{__('messages.lbl_pay_per_view')}}</span>
                            </div>
                        </label>
                        </div>
                        @error('movie_access')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 row g-3 mt-2 {{ old('movie_access') == 'pay-per-view' ? '' : 'd-none' }}" id="payPerViewFields">
                        <div class="col-md-4">
                            {{ html()->label(__('messages.lbl_price') . '<span class="text-danger">*</span>', 'price')->class('form-label')->for('price') }}
                            {{ html()->number('price', old('price'))->class('form-control')->attribute('placeholder',__('messages.enter_price'))->attribute('step', '0.01')->required() }}
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                            <div class="invalid-feedback" id="price-error">Price field is required</div>
                        </div>
                        <div class="col-md-4">
                            {{ html()->label(__('messages.purchase_type') . '<span class="text-danger">*</span>', 'access_duration')->class('form-label') }}
                            {{ html()->select('purchase_type', [
                                    // '' => __('messages.lbl_select_purchase_type'),
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
                            {{ html()->number('access_duration', old('access_duration'))->class('form-control')->attribute('placeholder', __('messages.access_duration'))->attribute('min', '1')->attribute('pattern', '[0-9]*')->attribute('oninput', 'this.value = this.value.replace(/[^0-9]/g, "")')->required() }}
                            @error('access_duration') <span class="text-danger">{{ $message }}</span> @enderror
                            <div class="invalid-feedback" id="access_duration-error">Access Duration field is required</div>
                        </div>

                        <div class="col-md-4">
                            {{ html()->label(__('messages.lbl_discount') . ' (%)', 'discount')->class('form-label') }}
                            {{ html()->number('discount', old('discount'))->class('form-control')->attribute('placeholder', __('messages.enter_discount'))->attribute('step', '0.01')->attribute('min', 0)->attribute('max', 99) }}
                            @error('discount') <span class="text-danger">{{ $message }}</span> @enderror
                            <div class="invalid-feedback" id="discount-error">Available For field is required</div>

                        </div>
                        <div class="col-md-4">
                            {{ html()->label(__('messages.lbl_total_price'), 'total_amount')->class('form-label') }}
                            {{ html()->text('total_amount', null)->class('form-control')->attribute('disabled', true)->id('total_amount') }}
                        </div>
                        <div class="col-md-4">
                            {{ html()->label(__('messages.lbl_available_for') .  __('messages.lbl_in_days') . '<span class="text-danger">*</span>', 'available_for')->class('form-label') }}
                            {{ html()->number('available_for', old('available_for'))->class('form-control')->attribute('placeholder', __('messages.available_for'))->attribute('min', '1')->attribute('pattern', '[0-9]*')->attribute('oninput', 'this.value = this.value.replace(/[^0-9]/g, "")')->required() }}
                            @error('available_for') <span class="text-danger">{{ $message }}</span> @enderror
                            <div class="invalid-feedback" id="available_for-error">Available For field is required</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 {{ old('movie_access', 'paid') == 'free' ? 'd-none' : '' }}" id="planSelection">
                        {{ html()->label(__('movie.lbl_select_plan'). '<span class="text-danger"> *</span>', 'type')->class('form-label') }}
                        {{ html()->select('plan_id', $plan->pluck('name', 'id')->prepend(__('placeholder.lbl_select_plan'), ''), old('plan_id'))->class('form-control select2')->id('plan_id') }}
                        @error('plan_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Plan field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                        <div class="d-flex justify-content-between align-items-center form-control">
                            {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                            <div class="form-check form-switch">
                                {{ html()->hidden('status', 0) }}
                                {{ html()->checkbox('status', old('status', 1))->class('form-check-input')->id('status')->value(1) }}
                            </div>
                        </div>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('movie.lbl_basic_info') }}</h5>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_movie_language') . '<span class="text-danger">*</span>', 'language')->class('form-label') }}
                        {{ html()->select('language', $movie_language->pluck('name', 'value')->prepend(__('placeholder.lbl_select_language'), ''), old('language'))->class('form-control select2')->id('language')->attribute('required', 'required') }}
                        @error('language')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Language field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
    {{ html()->label(__('movie.lbl_genres') . '<span class="text-danger">*</span>', 'genres')->class('form-label') }}
    {{ html()->select('genres[]', $genres->pluck('name', 'id'), old('genres'))
        ->class('form-control select2')
        ->id('genres')
        ->multiple()
        ->attribute('required', 'required') }}
    @error('genres')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <div class="invalid-feedback" id="name-error">Genres field is required</div>

</div>

<div class="col-md-6 col-lg-4">
    {{ html()->label(__('movie.lbl_countries'), 'countries')->class('form-label') }}
    {{ html()->select('countries[]', $countries->pluck('name', 'id'), old('countries'))
        ->class('form-control select2')
        ->id('countries')
        ->multiple()}}
    @error('countries')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <div class="invalid-feedback" id="country-error">Country field is required</div>
</div>


                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_imdb_rating') . ' <span class="text-danger">*</span>', 'IMDb_rating')->class('form-label') }}
                        {{ html()->text('IMDb_rating')
                                ->attribute('value', old('IMDb_rating'))
                                ->placeholder(__('movie.lbl_imdb_rating'))
                                ->class('form-control') }}
                        @error('IMDb_rating')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="imdb-error">IMDB Rating field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_content_rating') . '<span class="text-danger">*</span>', 'content_rating')->class('form-label') }}

                        {{ html()->text('content_rating')->attribute('value', old('content_rating'))->placeholder(__('placeholder.lbl_content_rating'))->class('form-control')->attribute('required','required') }}

                        @error('content_rating')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Content Rating field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_duration') . ' <span class="text-danger">*</span>', 'duration')->class('form-label') }}
                        {{ html()->time('duration')->attribute('value', old('duration'))->placeholder(__('movie.lbl_duration'))->class('form-control  min-datetimepicker-time')->attribute('required', 'required')->id('duration') }}
                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="duration-error">Duration field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                       {{ html()->label(__('movie.lbl_release_date').'<span class="text-danger">*</span>', 'release_date')->class('form-label') }}
                       {{ html()->text('release_date')->attribute('value', old('release_date'))->placeholder(__('movie.lbl_release_date'))->class('form-control datetimepicker')->attribute('required', 'required')->id('release_date') }}
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
                        <div class="col-md-6 col-lg-4" id="dowaloadstatuswapper">
                            {{ html()->label(__('movie.lbl_download_status'), 'download_status')->class('form-label') }}
                            <div class="d-flex justify-content-between align-items-center form-control">
                                {{ html()->label(__('messages.on'), 'download_status')->class('form-label mb-0 text-body') }}
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


        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h6>{{__('movie.lbl_actor_director')}}</h6>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6">
                        {{ html()->label(__('movie.lbl_actors') . '<span class="text-danger">*</span>', 'actors')->class('form-label') }}
                        {{ html()->select('actors[]', $actors->pluck('name', 'id'), old('actors'))->class('form-control select2')->id('actors')->multiple()->attribute('required', 'required') }}
                        @error('actors')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Actors field is required</div>
                    </div>
                    <div class="col-md-6">
                        {{ html()->label(__('movie.lbl_directors') . '<span class="text-danger">*</span>', 'directors')->class('form-label') }}
                        {{ html()->select('directors[]', $directors->pluck('name', 'id'), old('directors'))->class('form-control select2')->id('directors')->multiple()->attribute('required', 'required') }}
                        @error('directors')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Directors field is required</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('movie.lbl_video_info') }}</h5>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- <div class="row gy-3">
                    <div class="col-md-6">
                        {{ html()->label(__('movie.lbl_video_upload_type'). '<span class="text-danger">*</span>', 'video_upload_type')->class('form-label') }}
                        {{ html()->select(
                                'video_upload_type',
                                $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                old('video_upload_type', ''),
                            )->class('form-control select2')->id('video_upload_type')
                            ->required()
                        }}
                        @error('video_upload_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Video Type field is required</div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 d-none" id="video_url_input_section">
                            {{ html()->label(__('movie.video_url_input') . '<span class="text-danger">*</span>', 'video_url_input')->class('form-control-label') }}
                            {{ html()->text('video_url_input')->attribute('value', old('video_url_input'))->placeholder(__('placeholder.video_url_input'))->class('form-control')->id('video_url_input') }}
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

                                {{ html()->text('video_file_input')->class('form-control')->placeholder('Select Image')->attribute('aria-label', 'Video Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerVideourl')->attribute('data-hidden-input', 'file_url_video')}}
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

                        <div class="mb-3 d-none" id="video_embed_input_section">
                            {{ html()->label(__('movie.lbl_embed_code') . '<span class="text-danger">*</span>', 'embedded')->class('form-label') }}
                            {{ html()->textarea('embedded')->placeholder('<iframe ...></iframe>')->class('form-control')->id('embedded') }}
                            @error('embedded')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="embed-error">Embed code is required</div>
                        </div>
                    </div>
                </div> -->
                <div class="row gy-3">
                    <!-- Hidden input for video upload type with HLS as default -->
                    {{ html()->hidden('video_upload_type', 'HLS')->id('video_upload_type') }}
                    
                    <div class="col-md-12">
                        <div class="mb-3" id="video_url_input_section">
                            {{ html()->label(__('movie.video_url_input') . ' (HLS) <span class="text-danger">*</span>', 'video_url_input')->class('form-control-label') }}
                            {{ html()->text('video_url_input')->attribute('value', old('video_url_input'))->placeholder(__('placeholder.video_url_input'))->class('form-control')->id('video_url_input')->required() }}
                            @error('video_url_input')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="url-error">Video URL field is required</div>
                            <div class="invalid-feedback" id="url-pattern-error" style="display:none;">
                                Please enter a valid HLS URL starting with http:// or https://.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
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
                                    {{ html()->hidden('quality_video[]')->id('file_url_videoquality')->value(old('video_quality_url', isset($data) ? $data->video_quality_url : ''))->attribute('data-validation', 'iq_video_quality') }}
                                    @error('quality_video')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 d-none video-embed-input quality_video_embed_input">
                                    {{ html()->label(__('movie.lbl_embed_code'), 'quality_video_embed')->class('form-label') }}
                                    {{ html()->textarea('quality_video_embed_input[]')->placeholder('<iframe ...></iframe>')->class('form-control') }}
                                </div>
                                <div class="col-sm-12 text-end mb-3">
                                    <button type="button"class="btn btn-secondary-subtle btn-sm remove-video-input d-none"><i class="ph ph-trash align-middle"></i></button>
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
                                    {{ html()->label(__('messages.lbl_languages'), 'language')->class('form-label') }}
                                    {{ html()->select('subtitles[0][language]', $subtitle_language->pluck('name', 'value')->prepend(__('placeholder.lbl_select_language'), ''), old('subtitles.0.language'))->class('form-control select2 subtitle-language')->required() }}
                                    @error('subtitles.0.language')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="invalid-feedback">{{ __('validation.required', ['attribute' => 'language']) }}</div>
                                </div>
                                <div class="col-md-4">
                                    {{ html()->label(__('movie.lbl_subtitle_file'), 'subtitle_file')->class('form-label') }}
                                    {{ html()->file('subtitles[0][subtitle_file]')->class('form-control subtitle-file')->accept('.srt,.vtt')->required() }}
                                    @error('subtitles.0.subtitle_file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="invalid-feedback">{{ __('validation.required', ['attribute' => 'subtitle file']) }}</div>
                                </div>
                                <div class="col-md-3 pt-3">
                                    <div class="form-check mt-5">
                                        <input type="checkbox" name="subtitles[0][is_default]" class="form-check-input is-default-subtitle" id="is_default_0">
                                        <label class="form-check-label" for="is_default_0">{{ __('movie.lbl_default_subtitle') }}</label>
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
                                value="{{ old('meta_title', $seo->meta_title ?? '') }}" maxlength="100" placeholder="{{ __('placeholder.lbl_meta_title') }}" required>

                            @error('meta_title')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                             <div class="invalid-feedback" id="meta_title_error" style="display: none;">Meta Title is required</div>
                        </div>

                        <div class="form-group mb-3">
                            {!! html()->label(__('messages.lbl_google_site_verification') . ' <span class="required">*</span>', 'google_site_verification')
                                    ->class('form-label')
                                    ->attribute('for', 'google_site_verification') !!}
                            <input type="text" name="google_site_verification" id="google_site_verification" class="form-control @error('google_site_verification') is-invalid @enderror"
                                   value="{{ old('google_site_verification', $seo->google_site_verification ?? '') }}" placeholder="{{ __('placeholder.lbl_google_site_verification') }}" required>
                            {{-- @error('google_site_verification')
                                <span class="text-danger" id="google_site_verification-error">{{ $message }}</span>
                            @enderror --}}
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
                                   value="{{ old('canonical_url', $seo->canonical_url ?? '') }}" placeholder="{{ __('placeholder.lbl_canonical_url') }}" required>
                            {{-- @error('canonical_url')
                                <span class="text-danger" id="canonical_url-error">{{ $message }}</span>
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

                        {{-- @error('short_description')
                            <span class="text-danger" id="short_description-error">{{ $message }}</span>
                        @enderror --}}
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
    // JavaScript to update character count dynamically
    function updateCharCount() {
        const metaTitleInput = document.getElementById('meta_title');
        const charCountElement = document.getElementById('meta-title-char-count');
        const charCount = metaTitleInput.value.length;
        charCountElement.textContent = `${charCount}/100 {{ __('messages.words') }}`;
    }
</script>

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



    // function validateSeoImage() {
    //     const seoImageValue = document.getElementById('seo_image').value;
    //     const errorDiv = document.getElementById('seo_image_error');

    //     if (!seoImageValue) {
    //         errorDiv.style.display = 'block';
    //         return false;
    //     } else {
    //         errorDiv.style.display = 'none';
    //         return true;
    //     }
    // }

    // submitButton.addEventListener('click', function (e) {

    //     if (!validateSeoImage()) {
    //         e.preventDefault(); // stop form submit
    //     }

    //     // Tagify validation: check if it has tags
    //     if (tagifyInput.value === '') {
    //         if (keywordInputs.length === 0) {
    //             isValid = false;

    //             // Show error message
    //             errorMsg.style.display = 'block';

    //             // Add visual error indication to Tagify input
    //             if (tagifyWrapper) {
    //                 tagifyWrapper.classList.add('is-invalid');
    //             }
    //         } else {
    //             const tagifyInputValue = tagifyInput.value;
    //             const keywordValues = tagifyInputValue.map(item => item.value);
    //             document.getElementById('meta_keywords_input').value = JSON.stringify(keywordValues);
    //             // Hide error if input is valid
    //             errorMsg.style.display = 'none';
    //             if (tagifyWrapper) {
    //                 tagifyWrapper.classList.remove('is-invalid');
    //             }
    //         }
    //     }else {

    //         errorMsg.style.display = 'none';
    //         if (tagifyWrapper) {
    //             tagifyWrapper.classList.remove('is-invalid');
    //         }
    //     }


    //     if (isValid) {
    //         form.submit();
    //     } else {
    //         e.preventDefault();
    //     }
    // });
});
</script>

<script src="{{ asset('js/tagify.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/tagify.css') }}">



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
$(document).ready(function() {
    $('#genres').select2({
        width: '100%',
        placeholder: "{{ __('movie.lbl_genres') }}",
        allowClear: true
    });

    $('#countries').select2({
        width: '100%',
        placeholder: "{{ __('movie.lbl_countries') }}",
        allowClear: true
    });

    $('#actors').select2({
        width: '100%',
        placeholder: "{{ __('movie.lbl_actors') }}",
        allowClear: true
    });

    $('#directors').select2({
        width: '100%',
        placeholder: "{{ __('movie.lbl_directors') }}",
        allowClear: true
    });

    // Handle form submission
    $('#form-submit').on('submit', function(e) {
        e.preventDefault();

        // --- Embed validation ---
        const videoType = document.getElementById('video_upload_type')?.value;
        const trailerType = document.getElementById('trailer_url_type')?.value;
        let isValid = true;
        if (videoType === 'Embedded') {
            isValid = validateEmbedInput('embedded', 'embed-error');
        }
        if (trailerType === 'Embedded') {
            isValid = validateEmbedInput('trailer_embedded', 'trailer-embed-error') && isValid;
        }
        if (!isValid) {
            // Do not proceed with AJAX if validation fails
            $('#submit-button').prop('disabled', false).html('{{ trans("messages.save") }}');
            return;
        }

        // Get form data
        var formData = new FormData(this);

        // Add TinyMCE content to formData
        formData.append('description', tinymce.get('description').getContent());

        // Add CSRF token
        formData.append('_token', '{{ csrf_token() }}');

        // Show loading state
        $('#submit-button').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        // Send AJAX request
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    window.successSnackbar(response.message || 'Movie saved successfully');

                    // Redirect after a short delay
                    setTimeout(function() {
                        window.location.href = "{{ route('backend.movies.index') }}";
                    }, 1500);
                } else {
                    // Show error message
                    $('#error_message').text(response.message || 'An error occurred while saving the movie');
                    $('#submit-button').prop('disabled', false).html('{{ trans("messages.save") }}');
                }
            },
            error: function(xhr) {
                // Show error message
                $('#error_message').text(xhr.responseJSON?.message || 'An error occurred while saving the movie');

                // Reset button state
                $('#submit-button').prop('disabled', false).html('{{ trans("messages.save") }}');

                // Handle validation errors
                if (xhr.responseJSON?.errors) {
                    Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                        $(`[name="${key}"]`).addClass('is-invalid');
                        $(`#${key}-error`).text(xhr.responseJSON.errors[key][0]);
                    });
                }
            }
        });
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
        $(document).on('click', '.variable_button', function() {
            const textarea = $(document).find('.tab-pane.active');
            const textareaID = textarea.find('textarea').attr('id');
            tinyMCE.activeEditor.selection.setContent($(this).attr('data-value'));
        });

            document.addEventListener('DOMContentLoaded', function() {

                function handleTrailerUrlTypeChange(selectedValue) {
                    var FileInput = document.getElementById('url_file_input');
                    var URLInput = document.getElementById('url_input');
                    var EmbedInput = document.getElementById('trailer_embed_input_section');
                    var trailerfile = document.querySelector('input[name="trailer_video"]');
                    var trailerfileError = document.getElementById('trailer-file-error');
                    var urlError = document.getElementById('trailer-url-error');
                    var URLInputField = document.querySelector('input[name="trailer_url"]');
                    var trailerEmbedField = document.getElementById('trailer_embedded');

                    // Hide all sections first
                    FileInput.classList.add('d-none');
                    URLInput.classList.add('d-none');
                    EmbedInput.classList.add('d-none');

                    // Remove all required attributes
                    trailerfile?.removeAttribute('required');
                    URLInputField?.removeAttribute('required');
                    if (trailerEmbedField) trailerEmbedField.removeAttribute('required');

                    // Show appropriate section based on selection
                    switch(selectedValue) {
                        case 'Local':
                            FileInput.classList.remove('d-none');
                            trailerfile?.setAttribute('required', 'required');
                            break;
                        case 'Embedded':
                            EmbedInput.classList.remove('d-none');
                            if (trailerEmbedField) trailerEmbedField.setAttribute('required', 'required');
                            break;
                        case 'URL':
                        case 'YouTube':
                        case 'HLS':
                        case 'Vimeo':
                        case 'x265':
                            URLInput.classList.remove('d-none');
                            URLInputField?.setAttribute('required', 'required');
                            break;
                    }
                }


                // Handle initial state
                const trailerUrlType = document.getElementById('trailer_url_type');
                if (trailerUrlType) {
                    handleTrailerUrlTypeChange(trailerUrlType.value);

                    // Add change event listener
                    trailerUrlType.addEventListener('change', function() {
                        handleTrailerUrlTypeChange(this.value);
                    });

                    // Also handle select2 change event
                    $('#trailer_url_type').on('select2:select', function(e) {
                        handleTrailerUrlTypeChange(e.target.value);
                    });
                }
            });

            function showPlanSelection() {
                const planSelection = document.getElementById('planSelection');
                const payPerViewFields = document.getElementById('payPerViewFields');
                const planIdSelect = document.getElementById('plan_id');
                const priceInput = document.querySelector('input[name="price"]');
                const selectedAccess = document.querySelector('input[name="movie_access"]:checked');
                const releaseDateField = document.querySelector('input[name="release_date"]').closest('.col-md-6');
                const releaseDateInput = document.querySelector('input[name="release_date"]');
                const downlaodstatusDataFeild = document.querySelector('input[name="download_status"]').closest('.col-md-6');
                const downlaodstatusInput = document.querySelector('input[name="download_status"]');

                const purchaseTypeSelect = document.querySelector('select[name="purchase_type"]');
                const accessDurationInput = document.querySelector('input[name="access_duration"]');
                const availableForInput = document.querySelector('input[name="available_for"]');

                if (!selectedAccess) return;

                const value = selectedAccess.value;

                // Always show the download status wrapper

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
                    releaseDateInput.setAttribute('required', 'required');
                    downlaodstatusDataFeild.classList.remove('d-none');
                } else if (value === 'pay-per-view') {
                    planSelection.classList.add('d-none');
                    payPerViewFields.classList.remove('d-none');
                    planIdSelect.removeAttribute('required');
                    priceInput.setAttribute('required', 'required');
                    purchaseTypeSelect.required = true;
                    accessDurationInput.required = purchaseTypeSelect.value === 'rental';
                    availableForInput.required = true;
                    releaseDateField.classList.add('d-none');
                    releaseDateInput.removeAttribute('required');
                    downlaodstatusDataFeild.classList.add('d-none');
                } else {
                    planSelection.classList.add('d-none');
                    payPerViewFields.classList.add('d-none');
                    planIdSelect.removeAttribute('required');
                    priceInput.removeAttribute('required');
                    purchaseTypeSelect.required = false;
                    accessDurationInput.required = false;
                    availableForInput.required = false;
                    releaseDateField.classList.remove('d-none');
                    releaseDateInput.setAttribute('required', 'required');
                    downlaodstatusDataFeild.classList.remove('d-none');

                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                // Initial setup
                showPlanSelection();

                // Event listeners for movie access radio buttons
                const accessRadios = document.querySelectorAll('input[name="movie_access"]');
                accessRadios.forEach(function (radio) {
                    radio.addEventListener('change', showPlanSelection);
                });
            });

            function toggleAccessDuration(value) {
                const accessDuration = document.getElementById('accessDurationWrapper');
                const accessDurationInput = document.querySelector('input[name="access_duration"]');
                const selectedAccess = document.querySelector('input[name="movie_access"]:checked');

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

            function toggleQualitySection() {

                var enableQualityCheckbox = document.getElementById('enable_quality');
                var enableQualitySection = document.getElementById('enable_quality_section');

                if (enableQualityCheckbox.checked) {

                    enableQualitySection.classList.remove('d-none');

                } else {

                    enableQualitySection.classList.add('d-none');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                toggleQualitySection();
            });


            document.addEventListener('DOMContentLoaded', function() {

                function handleVideoUrlTypeChange(selectedType) {
                    const VideoFileInput = document.getElementById('video_file_input_section');
                    const VideoURLInput = document.getElementById('video_url_input_section');
                    const VideoEmbedInput = document.getElementById('video_embed_input_section');
                    const videoUrl = document.getElementById('video_url_input');
                    const videoFile = document.querySelector('input[name="video_file_input"]');
                    const embedInput = document.getElementById('embedded');

                    // First hide all sections
                    VideoFileInput?.classList.add('d-none');
                    VideoURLInput?.classList.add('d-none');
                    VideoEmbedInput?.classList.add('d-none');

                    // Remove all required attributes
                    videoUrl?.removeAttribute('required');
                    videoFile?.removeAttribute('required');
                    embedInput?.removeAttribute('required');

                    // Show appropriate section based on selection
                    switch(selectedType) {
                        case 'Local':
                            VideoFileInput?.classList.remove('d-none');
                            videoFile?.setAttribute('required', 'required');
                            break;
                        case 'Embedded':
                            VideoEmbedInput?.classList.remove('d-none');
                            embedInput?.setAttribute('required', 'required');
                            break;
                        case 'URL':
                        case 'YouTube':
                        case 'HLS':
                        case 'Vimeo':
                        case 'x265':
                            VideoURLInput?.classList.remove('d-none');
                            videoUrl?.setAttribute('required', 'required');
                            break;
                    }
                }

                // Handle initial state
                const videoUploadType = document.getElementById('video_upload_type');
                if (videoUploadType) {
                    handleVideoUrlTypeChange(videoUploadType.value);

                    // Add change event listener
                    videoUploadType.addEventListener('change', function() {
                        handleVideoUrlTypeChange(this.value);
                    });

                    // Also handle select2 change event
                    $('#video_upload_type').on('select2:select', function(e) {
                        handleVideoUrlTypeChange(e.target.value);
                    });
                }
            });
            function handleQualityTypeChange($container) {
    var type = $container.find('.video_quality_type').val();
    $container.find('.quality_video_input').addClass('d-none');
    $container.find('.quality_video_file_input').addClass('d-none');
    $container.find('.quality_video_embed_input').addClass('d-none');
    if (type === 'URL' || type === 'YouTube' || type === 'HLS' || type === 'Vimeo' || type === 'x265') {
        $container.find('.quality_video_input').removeClass('d-none');
    } else if (type === 'Local') {
        $container.find('.quality_video_file_input').removeClass('d-none');
    } else if (type === 'Embedded' || type === 'Embed') {
        $container.find('.quality_video_embed_input').removeClass('d-none');
    }
}

$(document).on('change', '.video_quality_type', function() {
    var $container = $(this).closest('.video-inputs-container');
    handleQualityTypeChange($container);
});



            /////////////////////////////////  Import Moive //////////////////////////////////////////////////////////////////////

            $(document).ready(function() {
                $('#import_movie').on('click', function(e) {
                    e.preventDefault();

                    var movieId = $('#movie_id').val();
                    $('#movie_id_error').text('');
                    $('#error_message').text('');

                    if (!movieId) {
                        $('#movie_id_error').text('Movie ID is required.');
                        return;
                    }

                    var baseUrl = "{{ url('/') }}";
                    var url = baseUrl + '/app/movies/import-movie/' + movieId;

                    $('#loader').show();
                    $('#import_movie').hide();

                    $.ajax({
                        url: '{{ route('backend.movies.import-movie', ':id') }}'.replace(':id',
                            movieId),
                        type: 'GET',
                        success: function(response) {

                            $('#loader').hide();
                            $('#import_movie').show();

                            if (response.success) {

                                var data = response.data;

                                $('#tmdb_id').val(data.id);
                                $('#is_import').val(1);
                                $('#selectedImage').attr('src', data.thumbnail_url).show();
                                $('#selectedPosterImage').attr('src', data.poster_url).show();
                                $('#selectedPosterTvImage').attr('src', data.poster_url).show();
                                $('#name').val(data.name);
                                // $('#description').val(data.description);
                                tinymce.get('description').setContent(data.description)
                                $('#trailer_url_type').val(data.trailer_url_type).trigger('change');
                                $('#trailer_url').val(data.trailer_url);

                                $('#release_date').val(data.release_date);

                                $('#duration').val(data.duration);

                                $('#thumbnail_url').val(data.thumbnail_url);
                                $('#poster_url').val(data.poster_url);
                                $('#poster_tv_url').val(data.poster_url);


                                $('#video_upload_type').val(data.video_url_type).trigger('change');
                                $('#video_url_input').val(data.video_url);
                                $('#file_url_video').val(data.video_url);


                                var all_genres = data.all_genres;
                                $('#genres').empty().append(
                                    '<option value="">Select Genre</option>');
                                $.each(all_genres, function(index, genre) {
                                    $('#genres').append('<option value="' + genre.id +
                                        '">' + genre.name + '</option>');
                                });
                                $('#genres').val(data.genres).trigger('change');


                                var all_languages = data.all_language;
                                $('#language').empty().append(
                                    '<option value="">Select Language</option>');
                                $.each(all_languages, function(index, language) {
                                    $('#language').append('<option value="' + language
                                        .value + '">' + language.name + '</option>');
                                });
                                $('#language').val(data.language.toLowerCase()).trigger('change');


                                var all_actors = data.all_actors;
                                $('#actors').empty().append(
                                    '<option value="">Select Actors</option>');
                                $.each(all_actors, function(index, actor) {
                                    $('#actors').append('<option value="' + actor.id +
                                        '">' + actor.name + '</option>');
                                });
                                $('#actors').val(data.actors).trigger('change');


                                var all_directors = data.all_directors;
                                $('#directors').empty().append(
                                    '<option value="">Select Directors</option>');
                                $.each(all_directors, function(index, director) {
                                    $('#directors').append('<option value="' + director.id +
                                        '">' + director.name + '</option>');
                                });
                                $('#directors').val(data.directors).trigger('change');


                                if (data.is_restricted) {
                                    $('#is_restricted').prop('checked', true).val(1);
                                } else {
                                    $('#is_restricted').prop('checked', false).val(0);
                                }

                                if (data.thumbnail_url) {

                                    $('#selectedImage').attr('src', data.thumbnail_url).show();
                                }

                                if (data.poster_url) {

                                    $('#selectedPosterImage').attr('src', data.poster_url).show();
                                }
                                if (data.poster_tv_url) {

                                    $('#selectedPosterTvImage').attr('src', data.poster_tv_url).show();
                                }
                                if (data.movie_access === 'paid') {
                                    document.getElementById('paid').checked = true;
                                    showPlanSelection(true);
                                } else {

                                    document.getElementById('free').checked = true;
                                    showPlanSelection(false);
                                }

                                if (data.enable_quality === true) {

                                    $('#enable_quality').prop('checked', true).val(1);
                                } else {

                                    $('#enable_quality').prop('checked', false).val(0);
                                }

                                toggleQualitySection()

                                if (data.enable_quality === true) {


                                    const container = document.getElementById(
                                        'video-inputs-container-parent');
                                    container.innerHTML = ''; // Clear existing content
                                    const uniqueQualities = [];
                                    const seenQualities = new Set();

                                    data.entertainmentStreamContentMappings.forEach(video => {
                                        // Use the correct property name here!
                                        const quality = video.quality || video.video_quality;
                                        if (!seenQualities.has(quality)) {
                                            uniqueQualities.push(video);
                                            seenQualities.add(quality);
                                        }
                                    });

                                    uniqueQualities.forEach((video,
                                        index) => {
                                            const videoInputContainer = document.createElement(
                                                'div');
                                            videoInputContainer.className =
                                                'row video-inputs-container';

                                            videoInputContainer.innerHTML = `
          <div class="col-sm-3 mb-3">
            <label class="form-label" for="video_quality_type_${index}">Video Upload Type</label>
            <select name="video_quality_type[]" id="video_quality_type_${index}" class="form-control select2 video_quality_type">
              <option value="YouTube" ${video.video_quality_type === 'YouTube' ? 'selected' : ''}>YouTube</option>
              <option value="Local" ${video.video_quality_type === 'Local' ? 'selected' : ''}>Local</option>
              <option value="Embed" ${video.video_quality_type === 'Embed' ? 'selected' : ''}>Embed</option>
            </select>
          </div>

          <div class="col-sm-3 mb-3 video-input">
            <label class="form-label" for="video_quality_${index}">Video Quality</label>
            <select name="video_quality[]" id="video_quality_${index}" class="form-control select2 video_quality">
              <option value="1080p" ${video.video_quality === 1080 ? 'selected' : ''}>1080p</option>
              <option value="720p" ${video.video_quality === 720 ? 'selected' : ''}>720p</option>
              <option value="480p" ${video.video_quality === 480 ? 'selected' : ''}>480p</option>
            </select>
          </div>

          <div class="col-sm-3 mb-3 video-url-input quality_video_input">
            <label class="form-control-label" for="quality_video_url_input_${index}">Video URL</label>
            <input type="text" name="quality_video_url_input[]" id="quality_video_url_input_${index}" placeholder="Enter video URL" class="form-control" value="${video.quality_video}">
          </div>

          <div class="col-sm-3 mb-3 d-none video-file-input quality_video_file_input">
            <label class="form-control-label" for="quality_video_${index}">Video File</label>
            <input type="file" name="quality_video[]" id="quality_video_${index}" class="form-control-file" accept="video/*">
          </div>

          <div class="col-sm-12 text-end mb-3">
            <button type="button" class="btn btn-danger remove-video-input">Remove</button>
          </div>
        `;

                                            container.appendChild(videoInputContainer);
                                        });
                                } else {

                                    $('#enable_quality').prop('checked', false).val(0);
                                    $('#enable_quality_section').addClass('d-none');
                                }

                            } else {
                                $('#error_message').text(response.message ||
                                    'Failed to import movie details.');
                            }
                        },
                        error: function(xhr) {

                            $('#loader').hide();
                            $('#import_movie').show();
                            if (xhr.responseJSON && xhr.responseJSON.message) {


                                $('#error_message').text(xhr.responseJSON.message);
                            }
                            if (xhr.responseJSON && xhr.responseJSON.status_message) {

                                $('#error_message').text(xhr.responseJSON.status_message ||
                                    'Failed to import movie details.');

                            } else {
                                $('#error_message').text(
                                    'An error occurred while fetching the movie details.');
                            }
                        }
                    });
                });
            });

      //////////////////////////////////////////generate Discription//////////////////////////////


      $(document).ready(function() {

$('#GenrateDescription').on('click', function(e) {


    e.preventDefault();

    var description = $('#description').val();
    var name = $('#name').val();

    var generate_discription = "{{ route('backend.movies.generate-description') }}";
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
    const iframeMatch = value.match(/^<iframe[^>]+src="([^"]+)"[^>]*><\/iframe>$/i);
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
    ['embedded', 'trailer_embedded'].forEach((id, i) => {
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
                isValid = validateEmbedInput('embedded', 'embed-error');
            }

            if (trailerType === 'Embedded') {
                isValid = validateEmbedInput('trailer_embedded', 'trailer-embed-error') && isValid;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});


            var thumbUrl = $("#thumbnail_url")
            thumbUrl.attr('accept', 'video/*');


        </script>



        <style>
            .position-relative {
                position: relative;
            }

            .position-absolute {
                position: absolute;
            }

            .required {
                color: red;
            }

        </style>

         <!-- Subtitle Functionality -->
    <script>
        // Toggle subtitle section
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
                    <div class="col-md-3 pt-3">
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
    </script>

@endpush
