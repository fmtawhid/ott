@extends('backend.layouts.app')
@section('content')
<x-back-button-component route="backend.tvshows.index" />
<p class="text-danger" id="error_message"></p>
@if(isenablemodule('enable_tmdb_api')==1)
<div class="d-flex flex-md-row flex-column align-items-end justify-content-between gap-3 mb-3">

    <div class="flex-grow-1 w-100">
        <a class="ph ph-info" data-bs-toggle="tooltip" title="To get a tvshow id, click on icon ." href="https://www.themoviedb.org/tv/63174-lucifer" target="_blank"></a>
        {{ html()->label(__('movie.import_tvshow') , 'tvshow_id')->class('form-label') }}
        {{ html()->text('tvshow_id')->attribute('value', old('tvshow_id'))->placeholder(__('placeholder.lbl_tvshow_id'))->class('form-control') }}
        <span class="text-danger" id="tvshow_id_error"></span>
    </div>
    <div class="flex-shrink-0 d-flex gap-3 align-items-center flex-wrap">
        <div id="loader" style="display: none;">
            <button class="btn btn-md btn-primary">{{__('tvshow.lbl_loading')}}</button>
        </div>
        <button class="btn btn-md btn-primary" id="import_tvshow_id">{{__('tvshow.lbl_import')}}</button>
    </div>
</div>
@endif

{{ html()->form('POST' ,route('backend.entertainments.store'))
    ->attribute('enctype', 'multipart/form-data')
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open()
}}
        @csrf
        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h6>{{__('customer.about')}} {{__('season.lbl_tv_shows')}}</h6>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-4 col-lg-4 position-relative">
                        {{ html()->hidden('type', $type)->id('type') }}
                        {{ html()->hidden('tmdb_id', null)->id('tmdb_id') }}
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_thumbnail'), 'thumbnail')->class('form-label') }}
                            <div class="input-group btn-file-upload">
                                {{ html()->button('<i class="ph ph-image"></i> '. __('messages.lbl_choose_image'))
                                    ->class('input-group-text form-control')
                                    ->type('button')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerThumbnail')
                                    ->attribute('data-hidden-input', 'file_url_thumbnail')
                                    ->style('height:13.5rem')
                                }}

                                {{ html()->text('thumbnail_input')
                                    ->class('form-control')
                                    ->placeholder('Select Image')
                                    ->attribute('aria-label', 'Thumbnail Image')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerThumbnail')
                                    ->attribute('data-hidden-input', 'file_url_thumbnail')
                                }}
                            </div>

                            <div class="uploaded-image" id="selectedImageContainerThumbnail">
                                    <img id="selectedImage"
                                        src="{{ old('thumbnail_url', isset($data) ? $data->thumbnail_url : '') }}"
                                        alt="feature-image" class="img-fluid mb-2"
                                        style="{{ old('thumbnail_url', isset($data) ? $data->thumbnail_url : '') ? '' : 'display:none;' }}"/>
                            </div>
                            {{ html()->hidden('thumbnail_url')->id('file_url_thumbnail')->value(old('thumbnail_url', isset($data) ? $data->thumbnail_url : '')) }}
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_poster'), 'poster')->class('form-label form-control-label') }}
                            <div class="input-group btn-file-upload mb-3">
                                {{ html()->button('<i class="ph ph-image"></i>'. __('messages.lbl_choose_image'))
                                    ->class('input-group-text form-control')
                                    ->type('button')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerPoster')
                                    ->attribute('data-hidden-input', 'file_url_poster')
                                    ->style('height:13.5rem')
                                }}

                                {{ html()->text('poster_input')
                                    ->class('form-control')
                                    ->placeholder('Select Image')
                                    ->attribute('aria-label', 'Poster Image')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerPoster')
                                    ->attribute('data-hidden-input', 'file_url_poster')
                                }}
                            </div>


                            <div class="uploaded-image" id="selectedImageContainerPoster">
                                <img id="selectedPosterImage"
                                    src="{{ old('poster_url', isset($data) ? $data->poster_url : '') }}" alt="feature-image"
                                    class="img-fluid mb-2 avatar-80 "
                                    style="{{ old('poster_url', isset($data) ? $data->poster_url : '') ? '' : 'display:none;' }}" />
                            </div>
                            {{ html()->hidden('poster_url')->id('file_url_poster')->value(old('poster_url', isset($data) ? $data->poster_url : '')) }}
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_poster_tv'), 'poster_tv')->class('form-label form-control-label') }}
                            <div class="input-group btn-file-upload mb-3">
                                {{ html()->button('<i class="ph ph-image"></i>'. __('messages.lbl_choose_image'))
                                    ->class('input-group-text form-control')
                                    ->type('button')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerPostertv')
                                    ->attribute('data-hidden-input', 'file_url_poster_tv')
                                    ->style('height:13.5rem')
                                }}

                                {{ html()->text('poster_input')
                                    ->class('form-control')
                                    ->placeholder('Select Image')
                                    ->attribute('aria-label', 'Poster Image')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerPostertv')
                                    ->attribute('data-hidden-input', 'file_url_poster_tv')
                                }}
                            </div>


                            <div class="uploaded-image" id="selectedImageContainerPostertv">
                                <img id="selectedPosterTvImage"
                                    src="{{ old('poster_tv_url', isset($data) ? $data->poster_tv_url : '') }}" alt="feature-image"
                                    class="img-fluid mb-2 avatar-80 "
                                    style="{{ old('poster_tv_url', isset($data) ? $data->poster_tv_url : '') ? '' : 'display:none;' }}" />
                            </div>
                            {{ html()->hidden('poster_tv_url')->id('file_url_poster_tv')->value(old('poster_tv_url', isset($data) ? $data->poster_tv_url : '')) }}
                        </div>
                    </div>
                    <div class="row gy-3">
                        <div class="col-md-4 col-lg-4 mb-3">
                            {{ html()->label(__('movie.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label form-control-label') }}
                                {{ html()->text('name')->attribute('value', old('name'))->placeholder(__('placeholder.lbl_movie_name'))->class('form-control')->attribute('required','required') }}
                                <span class="text-danger" id="error_msg"></span>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Name field is required</div>
                        </div>
                        <!-- <div class="col-md-4 col-lg-4 mb-3">
                            {{ html()->label(__('movie.lbl_trailer_url_type'). ' <span class="text-danger">*</span>', 'type')->class('form-label') }}
                            {{ html()->select(
                                    'trailer_url_type',
                                    $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_type'), ''),
                                    old('trailer_url_type', ''), // Set '' as the default value
                                )->class('form-control select2')->id('trailer_url_type') }}
                            @error('trailer_url_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="name-error">Trailer Type field is required</div>
                        </div>
                        <div class="col-md-4 col-lg-4 d-none" id="url_input">
                            {{ html()->label(__('movie.lbl_trailer_url'). ' <span class="text-danger">*</span>', 'trailer_url')->class('form-label form-control-label') }}
                            {{ html()->text('trailer_url')->attribute('value', old('trailer_url'))->placeholder(__('placeholder.lbl_trailer_url'))->class('form-control') }}
                            @error('trailer_url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="trailer-url-error">Video URL field is required</div>
                            <div class="invalid-feedback" id="trailer-pattern-error" style="display:none;">
                                Please enter a valid URL starting with http:// or https://.
                            </div>
                        </div> -->
                        {{-- Always save type = hls --}}

                        {{-- Always keep only HLS type for trailer_url_type --}}
                        {{ html()->hidden('trailer_url_type', 'HLS')->id('trailer_url_type') }}
                        
                        {{-- Show only the HLS URL input --}}
                        <div class="mb-3">
                            {{ html()->label(__('movie.lbl_trailer_url'). ' <span class="text-danger">*</span>', 'trailer_url')->class('form-label form-control-label') }}
                            {{ html()->text('trailer_url')
                                ->attribute('value', old('trailer_url'))
                                ->placeholder(__('placeholder.lbl_trailer_url'))
                                ->class('form-control')
                                ->required() }}
                            @error('trailer_url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="trailer-url-error">Video URL field is required</div>
                        </div>
                        <!-- <div class="col-md-4 col-lg-4 d-none" id="embed_input">
                            {{ html()->label(__('movie.lbl_embed_code'). ' <span class="text-danger">*</span>', 'trailer_url_embedded')->class('form-label form-control-label') }}
                            {{ html()->textarea('trailer_embedded')
                                ->attribute('value', old('trailer_embedded'))
                                ->placeholder('<iframe ...></iframe>')
                                ->class('form-control')
                                ->rows(4) }}
                            @error('trailer_embedded')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="trailer-iframe-error">Iframe embed code is required</div>
                        </div> -->
                        <div class="col-md-4 col-lg-4 position-relative d-none" id="url_file_input">
                            {{ html()->label(__('movie.lbl_trailer_video'). ' <span class="text-danger">*</span>', 'trailer_video')->class('form-label form-control-label') }}

                            <div class="input-group btn-video-link-upload">
                                {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-image"></i>')
                                    ->class('input-group-text form-control')
                                    ->type('button')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainertailerurl')
                                    ->attribute('data-hidden-input', 'file_url_trailer')
                                }}

                                {{ html()->text('trailer_input')
                                    ->class('form-control')
                                    ->placeholder('Select Image')
                                    ->attribute('aria-label', 'Trailer Image')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainertailerurl')
                                    ->attribute('data-hidden-input', 'file_url_trailer')
                                }}
                            </div>
                            <div class="mt-3" id="selectedImageContainertailerurl">
                                @if(old('trailer_url', isset($data) ? $data->trailer_url : ''))
                                    <img src="{{ old('trailer_url', isset($data) ? $data->trailer_url : '') }}" class="img-fluid avatar-150">
                                @endif
                            </div>

                            {{ html()->hidden('trailer_video')->id('file_url_trailer')->value(old('trailer_url', isset($data) ? $data->trailer_url : ''))->attribute('data-validation', 'iq_video_quality') }}
                            @error('trailer_video')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="trailer-file-error">Video File field is required</div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            {{ html()->label(__('movie.lbl_description'). '<span class="text-danger"> *</span>', 'description')->class('form-label mb-0') }}
                            <!--<span class="text-primary cursor-pointer" id="GenrateDescription" ><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span>-->
                        </div>
                        {{ html()->textarea('description', old('description'))->class('form-control')->id('description')->placeholder(__('placeholder.lbl_movie_description'))->rows(4)->attribute('required','required') }}
                        <span class="text-danger" id="error_msg"></span>
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
                                    <input class="form-check-input" type="radio" name="movie_access" id="paid" value="paid"
                                        onchange="showPlanSelection(this.value === 'paid')"
                                        {{ old('movie_access') == 'paid' ? 'checked' : '' }} checked>
                                    <span class="form-check-label" for="paid">{{__('movie.lbl_paid')}}</span>
                                </div>
                            </label>

                            <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                <div>
                                    <input class="form-check-input" type="radio" name="movie_access" id="free" value="free"
                                        onchange="showPlanSelection(this.value === 'paid')"
                                        {{ old('movie_access') == 'free' ? 'checked' : '' }}>
                                    <span class="form-check-label" for="free">{{__('movie.lbl_free')}}</span>
                                </div>

                            </label>

                                <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                    <div>
                                        <input class="form-check-input" type="radio" name="movie_access" id="pay-per-view" value="pay-per-view"
                                            onchange="showPlanSelection(this.value === 'pay-per-view')"
                                            {{ old('movie_access') == 'pay-per-view' ? 'checked' : '' }} >
                                        <span class="form-check-label" for="pay-per-view">{{__('messages.lbl_pay_per_view')}}</span>
                                    </div>
                                </label>
                            @error('movie_access')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 row g-3 mt-2 {{ old('movie_access') == 'pay-per-view' ? '' : 'd-none' }}" id="payPerViewFields">
                        <div class="col-md-4">
                            {{ html()->label(__('messages.lbl_price') . '<span class="text-danger">*</span>', 'price')->class('form-label')->for('price') }}
                            {{ html()->number('price', old('price'))->class('form-control')->attribute('placeholder', __('messages.enter_price'))->required() }}
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="invalid-feedback" id="price-error">Price field is required</div>
                        <div class="col-md-4">
                            {{ html()->label(__('messages.purchase_type'), 'access_duration')->class('form-label') }}
                            {{ html()->select('purchase_type', [
                                    '' => __('messages.lbl_select_purchase_type'),
                                    'rental' => __('messages.lbl_rental'),
                                    'onetime' => __('messages.lbl_one_time_purchase')
                                ], old('purchase_type', 'rental'))
                                ->id('purchase_type')
                                ->class('form-control select2')
                                ->attributes(['onchange' => 'toggleAccessDuration(this.value)'])
                            }}
                        </div>
                        <div class="col-md-4 d-none" id="accessDurationWrapper">
                            {{ html()->label(__('messages.lbl_access_duration') . __('messages.lbl_in_days'), 'access_duration')->class('form-label') }}
                            {{ html()->number('access_duration', old('access_duration'))->class('form-control')->attribute('pattern', '[0-9]*')->attribute('oninput', 'this.value = this.value.replace(/[^0-9]/g, "")')->attribute('placeholder', __('messages.access_duration')) }}
                            @error('access_duration') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-4">
                            {{ html()->label(__('messages.lbl_discount') . ' (%)', 'discount')->class('form-label') }}
                            {{ html()->number('discount', old('discount'))->class('form-control')->attribute('placeholder', __('messages.enter_discount'))->attribute('min', 1)->attribute('max', 99) }}
                            @error('discount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            {{ html()->label(__('messages.lbl_total_price'), 'total_amount')->class('form-label') }}
                            {{ html()->text('total_amount', null)->class('form-control')->attribute('disabled', true)->id('total_amount') }}
                        </div>
                        <div class="col-md-4">
                            {{ html()->label(__('messages.lbl_available_for') . __('messages.lbl_in_days'), 'available_for')->class('form-label') }}
                            {{ html()->number('available_for', old('available_for'))->class('form-control')->attribute('pattern', '[0-9]*')->attribute('oninput', 'this.value = this.value.replace(/[^0-9]/g, "")')->attribute('placeholder', __('messages.available_for')) }}
                            @error('available_for') <span class="text-danger">{{ $message }}</span> @enderror
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
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
                        {{ html()->select('language', $movie_language->pluck('name', 'value')->prepend(__('placeholder.lbl_select_language'), ''), old('language'))->class('form-control select2')->id('language')->attribute('required','required') }}
                        @error('language')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Language field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_genres') . '<span class="text-danger">*</span>', 'genres')->class('form-label') }}
                        {{ html()->select('genres[]', $genres->pluck('name', 'id')->prepend(__('placeholder.lbl_select_genre'), ''), old('genres'))->class('form-control select2')->id('genres')->multiple()->attribute('required','required') }}
                        @error('genres')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Genres field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_countries'), 'countries')->class('form-label') }}
                        {{ html()->select('countries[]', $countries->pluck('name', 'id')->prepend(__('placeholder.lbl_select_country'), ''), old('countries'))->class('form-control select2')->id('countries')->multiple() }}
                        @error('countries')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="countries-error">Countries field is required</div>
                    </div>


                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_imdb_rating') . ' <span class="text-danger">*</span>', 'IMDb_rating')->class('form-label') }}
                        {{ html()->text('IMDb_rating')
                                ->attribute('value', old('IMDb_rating'))
                                ->placeholder(__('movie.lbl_imdb_rating'))
                                ->class('form-control')}}
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
                        {{ html()->label(__('movie.lbl_duration').'<span class="text-danger">*</span>' , 'duration')->class('form-label') }}
                        {{ html()->time('duration')->attribute('value', old('duration'))->placeholder(__('movie.lbl_duration'))->class('form-control min-datetimepicker-time')->attribute('required','required')->id('duration') }}
                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="duration-error">Duration field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_release_date').'<span class="text-danger">*</span>', 'release_date')->class('form-label') }}
                        {{ html()->date('release_date')->attribute('value', old('release_date'))->placeholder(__('movie.lbl_release_date'))->class('form-control datetimepicker')->attribute('required','required')->id('release_date') }}
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

                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('movie.lbl_actor_director') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        {{ html()->label(__('movie.lbl_actors') . '<span class="text-danger">*</span>', 'actors')->class('form-label') }}
                        {{ html()->select('actors[]', $actors->pluck('name', 'id'), old('actors'))->class('form-control select2')->id('actors')->multiple()->attribute('required','required') }}
                        @error('actors')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Actors field is required</div>
                    </div>
                    <div class="col-md-6">
                        {{ html()->label(__('movie.lbl_directors') . '<span class="text-danger">*</span>', 'directors')->class('form-label') }}
                        {{ html()->select('directors[]', $directors->pluck('name', 'id'), old('directors'))->class('form-control select2')->id('directors')->multiple()->attribute('required','required') }}
                        @error('directors')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Directors field is required</div>
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


                            <div class="invalid-feedback" id="meta_title_error" style="display: none;">Meta Title is required</div>


                               @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="form-group mb-3">
                            {!! html()->label(__('messages.lbl_google_site_verification') . ' <span class="required">*</span>', 'google_site_verification')
                                    ->class('form-label')
                                    ->attribute('for', 'google_site_verification') !!}
                            <input type="text" name="google_site_verification" id="google_site_verification" class="form-control @error('google_site_verification') is-invalid @enderror"
                                   value="{{ old('google_site_verification', $seo->google_site_verification ?? '') }}" placeholder="{{ __('placeholder.lbl_google_site_verification') }}" >
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
                                   value="{{ old('canonical_url', $seo->canonical_url ?? '') }}" placeholder="{{ __('placeholder.lbl_canonical_url') }}" >
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
        placeholder: "{{ __('movie.lbl_genres') }}",  // Set the placeholder text here
        allowClear: true  // Allows clearing the selection
    });

    $('#countries').select2({
    width: '100%',
    placeholder: "{{ __('movie.lbl_countries') }}",  // Set the placeholder text here
    allowClear: true  // Allows clearing the selection
});


    $('#actors').select2({
        width: '100%',
        placeholder: "{{ __('movie.lbl_actors') }}",  // Set the placeholder text here
        allowClear: true  // Allows clearing the selection
    });

    $('#directors').select2({
        width: '100%',
        placeholder: "{{ __('movie.lbl_directors') }}",  // Set the placeholder text here
        allowClear: true  // Allows clearing the selection
    });
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
                    var EmbedInput = document.getElementById('embed_input');
                    var trailerfile = document.querySelector('input[name="trailer_video"]');
                    var trailerfileError = document.getElementById('trailer-file-error');
                    var urlError = document.getElementById('trailer-url-error');
                    var URLInputField = document.querySelector('input[name="trailer_url"]');
                    var IframeField = document.querySelector('textarea[name="trailer_embedded"]');

                    // Hide all inputs first
                    FileInput.classList.add('d-none');
                    URLInput.classList.add('d-none');
                    EmbedInput.classList.add('d-none');

                    // Remove all required attributes
                    if (URLInputField) URLInputField.removeAttribute('required');
                    if (trailerfile) trailerfile.removeAttribute('required');
                    if (IframeField) IframeField.removeAttribute('required');

                    if (selectedValue === 'Local') {
                        FileInput.classList.remove('d-none');
                        if (trailerfile) trailerfile.setAttribute('required', 'required');
                    } else if (selectedValue === 'Embedded') {
                        EmbedInput.classList.remove('d-none');
                        if (IframeField) IframeField.setAttribute('required', 'required');
                    } else if (selectedValue === 'URL' || selectedValue === 'YouTube' || selectedValue === 'HLS' ||
                               selectedValue === 'x265' || selectedValue === 'Vimeo') {
                        URLInput.classList.remove('d-none');
                        if (URLInputField) URLInputField.setAttribute('required', 'required');
                        validateTrailerUrlInput();
                    }
                }
                function validateTrailerUrlInput() {
                    var URLInput = document.querySelector('input[name="trailer_url"]');
                    var urlPatternError = document.getElementById('trailer-pattern-error');
                    selectedValue = document.getElementById('trailer_url_type').value;
                    if (selectedValue === 'YouTube') {
                        urlPattern = /^(https?:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/;
                        urlPatternError.innerText = '';
                        urlPatternError.innerText='Trailer URL field Is Required Please enter a valid Youtube URL'
                    } else if (selectedValue === 'Vimeo') {
                        urlPattern = /^(https?:\/\/)?(www\.)?(vimeo\.com\/(channels\/[a-zA-Z0-9]+\/|groups\/[^/]+\/videos\/)?\d+)(\/.*)?$/;
                        urlPatternError.innerText = '';
                        urlPatternError.innerText='Please enter a valid Vimeo URL'
                    } else {
                        // General URL pattern for other types
                        urlPattern = /^https?:\/\/.+$/;
                         urlPatternError.innerText='Please enter a valid URL'
                    }
                        if (!urlPattern.test(URLInput.value)) {
                            urlPatternError.style.display = 'block';
                            return false;
                        } else {
                            urlPatternError.style.display = 'none';
                            return true;
                        }
                    }
                var initialSelectedValue = document.getElementById('trailer_url_type').value;
                handleTrailerUrlTypeChange(initialSelectedValue);
                $('#trailer_url_type').change(function() {
                    var selectedValue = $(this).val();
                    handleTrailerUrlTypeChange(selectedValue);
                });

                var URLInput = document.querySelector('input[name="trailer_url"]');
                if (URLInput) {
                    URLInput.addEventListener('input', function() {


                        validateTrailerUrlInput();
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

                if (!selectedAccess) return;

                const value = selectedAccess.value;

                // Handle visibility and required attributes
                if (value === 'paid') {
                    planSelection.classList.remove('d-none');
                    payPerViewFields.classList.add('d-none');
                    planIdSelect.setAttribute('required', 'required');
                    priceInput.removeAttribute('required');
                    releaseDateField.classList.remove('d-none');
                    releaseDateInput.setAttribute('required', 'required');
                } else if (value === 'pay-per-view') {
                    planSelection.classList.add('d-none');
                    payPerViewFields.classList.remove('d-none');
                    planIdSelect.removeAttribute('required');
                    priceInput.setAttribute('required', 'required');
                    releaseDateField.classList.add('d-none');
                    releaseDateInput.removeAttribute('required');
                } else {
                    planSelection.classList.add('d-none');
                    payPerViewFields.classList.add('d-none');
                    planIdSelect.removeAttribute('required');
                    priceInput.removeAttribute('required');
                    releaseDateField.classList.remove('d-none');
                    releaseDateInput.setAttribute('required', 'required');
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
                accessDuration.classList.toggle('d-none', value !== 'rental');
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



   $(document).ready(function() {

     $('#import_tvshow_id').on('click', function(e) {
        e.preventDefault();

        var tvshowID = $('#tvshow_id').val();
        $('#tvshow_id_error').text('');
        $('#error_message').text('');

        var baseUrl = "{{ env('APP_URL') }}";
        var url = baseUrl + '/app/tvshows/import-tvshow/' + tvshowID;

        if (!tvshowID) {
            $('#tvshow_id_error').text('TV show is required.');
            return;
        }

        $('#loader').show();
        $('#import_tvshow_id').hide();

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {

                $('#loader').hide();
                $('#import_tvshow_id').show();

                if(response.success){

                 var data = response.data;
                 $('#tmdb_id').val(data.id);
                 $('#selectedImage').attr('src', data.thumbnail_url).show();
                 $('#selectedPosterImage').attr('src', data.poster_url).show();
                 $('#selectedPosterTvImage').attr('src', data.poster_url).show();
                 $('#name').val(data.name);
                 $('#description').val(data.description);
                 $('#trailer_url_type').val(data.trailer_url_type).trigger('change');
                 $('#trailer_url').val(data.trailer_url);
                 $('#release_date').val(data.release_date);
                 $('#duration').val(data.duration);
                 $('#file_url_thumbnail').val(data.thumbnail_url);
                 $('#file_url_poster').val(data.poster_url);
                 $('#file_url_poster_tv').val(data.poster_url);
                 var all_genres = data.all_genres;

                 $('#genres').empty().append('<option value="">Select Genre</option>');
                 $.each(all_genres, function(index, genre) {

                     $('#genres').append('<option value="' + genre.id + '">' + genre.name + '</option>');
                 });
                 $('#genres').val(data.genres).trigger('change');

                 var all_languages = data.all_language;

                 $('#language').empty().append('<option value="">Select Language</option>');
                 $.each(all_languages, function(index, language) {
                     $('#language').append('<option value="' + language.value + '">' + language.name + '</option>');
                 });
                 $('#language').val(data.language.toLowerCase()).trigger('change');


                 var all_actors = data.all_actors;
                 $('#actors').empty().append('<option value="">Select Actors</option>');
                 $.each(all_actors, function(index, actor) {
                     $('#actors').append('<option value="' + actor.id + '">' + actor.name + '</option>');
                 });
                 $('#actors').val(data.actors).trigger('change');


                 var all_directors = data.all_directors;
                 $('#directors').empty().append('<option value="">Select Directors</option>');
                 $.each(all_directors, function(index, director) {
                     $('#directors').append('<option value="' + director.id + '">' + director.name + '</option>');
                 });
                 $('#directors').val(data.directors).trigger('change');


                 if(data.is_restricted) {
                        $('#is_restricted').prop('checked', true).val(1);
                    } else {
                        $('#is_restricted').prop('checked', false).val(0);
                    }

                    if(data.thumbnail_url){

                        $('#selectedImage').attr('src', data.thumbnail_url).show();
                    }

                    if(data.poster_url) {

                        $('#selectedPosterImage').attr('src', data.poster_url).show();
                    }
                    if(data.poster_tv_url) {

                        $('#selectedPosterTvImage').attr('src', data.poster_tv_url).show();
                    }
                    if (data.movie_access === 'paid') {
                      document.getElementById('paid').checked = true;
                      showPlanSelection(true);
                    } else {

                      document.getElementById('free').checked = true;
                      showPlanSelection(false);
                    }

                } else {
                    $('#error_message').text(response.message || 'Failed to import movie details.');
                }
            },
            error: function(xhr) {
                $('#import_tvshow_id').show();
                $('#loader').hide();
                $('#import_movie').show();
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
    // Live validation for embed input
    const trailerEmbedInput = document.getElementById('trailer_embedded');
    if (trailerEmbedInput) {
        trailerEmbedInput.addEventListener('input', () => validateEmbedInput('trailer_embedded', 'trailer-embed-error'));
    }

    // Form validation
    const form = document.getElementById('form-submit');
    if (form) {
        form.addEventListener('submit', function (e) {
            const trailerType = document.getElementById('trailer_url_type')?.value;
            let isValid = true;

            if (trailerType === 'Embedded') {
                isValid = validateEmbedInput('trailer_embedded', 'trailer-embed-error');
            }

            if (!isValid) {
                e.preventDefault();
            }
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

            .required {
                color: red;
            }

        </style>
    @endpush
