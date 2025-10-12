@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.banners.index" />

{{ html()->form('POST', route('backend.banners.store'))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')
    ->class('requires-validation')
    ->attribute('novalidate', 'novalidate')
    ->open() }}
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-6 col-lg-4">
                    <div class="position-relative">
                        {{ html()->label(__('banner.title'), 'poster')->class('form-label') }}
                        <div class="input-group btn-file-upload">
                            {{ html()->button('<i class="ph ph-image"></i>' . __('messages.lbl_choose_image'))
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerPoster')
                                ->attribute('data-hidden-input', 'poster_url')
                                ->style('height:13.6rem') }}

                            {{ html()->text('poster_input')->class('form-control')->placeholder('placeholder.lbl_image')->attribute('aria-label', 'Poster Image') }}

                            {{ html()->hidden('poster_url')->id('poster_url')->value(old('poster_url', isset($data) ? $data->poster_url : '')) }}
                            {{ html()->hidden('remove_image')->id('remove_image_flag2')->value(0) }}

                        </div>
                        <div class="uploaded-image" id="selectedImageContainerPoster">
                            @if(old('poster_url', isset($data) ? $data->poster_url : ''))
                                <img src="{{ old('poster_url', isset($data) ? $data->poster_url : '') }}" class="img-fluid avatar-150">
                            @endif
                        </div>
                        <small class="text-danger">Note: Recommended banner image size is 428 × 530 pixels.</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="position-relative">
                        {{ html()->label(__('banner.lbl_web_banner'), 'file_url')->class('form-label') }}
                        <div class="input-group btn-file-upload">
                            {{ html()->button('<i class="ph ph-image"></i>' . __('messages.lbl_choose_image'))
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerThumbnail')
                                ->attribute('data-hidden-input', 'file_url_image')
                                ->style('height:13.6rem') }}

                            {{ html()->text('thumbnail_input')
                                ->class('form-control')
                                ->placeholder(__('placeholder.lbl_image'))
                                ->attribute('aria-label', 'Thumbnail Image') }}

                            {{ html()->hidden('file_url')->id('file_url_image')->value(old('file_url', isset($data) ? $data->file_url : '')) }}
                            {{ html()->hidden('remove_image')->id('remove_image_flag1')->value(0) }}
                        </div>
                        <div class="uploaded-image" id="selectedImageContainerThumbnail">
                            @if(old('file_url', isset($data) ? $data->file_url : ''))
                                <img src="{{ old('file_url', isset($data) ? $data->file_url : '') }}" class="img-fluid avatar-150">
                             @endif
                        </div>
                        <small class="text-danger">Note: Recommended banner image size is 1024 × 500 pixels.</small>
                    </div>
                </div>


                <div class="col-md-6 col-lg-4">
                    <div class="position-relative">
                        {{ html()->label(__('banner.lbl_tv_banner'), 'poster_tv')->class('form-label') }}
                        <div class="input-group btn-file-upload">
                            {{ html()->button('<i class="ph ph-image"></i>' . __('messages.lbl_choose_image'))
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerPosterTv')
                                ->attribute('data-hidden-input', 'poster_tv_url')
                                ->style('height:13.6rem') }}

                            {{ html()->text('poster_input')->class('form-control')->placeholder('placeholder.lbl_image')->attribute('aria-label', 'Poster Image') }}

                            {{ html()->hidden('poster_tv_url')->id('poster_tv_url')->value(old('poster_tv_url', isset($data) ? $data->poster_tv_url : '')) }}
                            {{ html()->hidden('remove_image')->id('remove_image_flag3')->value(0) }}

                        </div>
                        <div class="uploaded-image" id="selectedImageContainerPosterTv">
                            @if(old('poster_tv_url', isset($data) ? $data->poster_tv_url : ''))
                                <img src="{{ old('poster_tv_url', isset($data) ? $data->poster_tv_url : '') }}" class="img-fluid avatar-150">
                            @endif
                        </div>
                        <small class="text-danger">Note: Recommended banner image size is 1024 × 500 pixels.</small>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-md-4 col-lg-4 mt-3">
                        {{ html()->label(__('banner.lbl_type') . '<span class="text-danger">*</span>', 'type')->class('form-label') }}
                        {{ html()->select('type', ['' => __('placeholder.lbl_select_type')] + $types, old('type'))->class('form-control select2')->id('type')->attribute('required','required') }}
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Type field is required</div>
                    </div>
                    {{ html()->hidden('type_id')->id('type_id') }}
                    {{ html()->hidden('type_name')->id('type_name') }}
                    <div class="col-md-4 col-lg-4 mt-3">
                        {{ html()->label(__('banner.lbl_name') . '<span class="text-danger">*</span>', 'name')->class('form-label') }}
                        {{ html()->select('name_id', ['' => __('messages.select_name')] + [], old('name_id'))->class('form-control select2')->id('name_id')->attribute('required','required') }}
                        @error('name_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Name field is required</div>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-md-4 col-lg-4 mt-3">
                        {{ html()->label(__('banner.lbl_banner_for') . '<span class="text-danger">*</span>', 'banner_for')->class('form-label') }}
                        {{ html()->select('banner_for', [
                            '' => __('placeholder.lbl_select_banner_for'),
                            'home' => 'Home',
                            'movie' => 'Movie',
                            'tv_show' => 'TV Show',
                            'video' => 'Video'
                        ], old('banner_for'))->class('form-control select2')->id('banner_for')->attribute('required','required') }}
                        @error('banner_for')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="banner-for-error">Banner for field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4  mt-3">

                    {{-- <div class="col-md-4 col-lg-4 mt-3"> --}}
                        {{ html()->label(__('banner.lbl_status'), 'status')->class('form-label') }}
                        <div class="d-flex justify-content-between form-control">
                            {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                            <div class="form-check form-switch">
                                {{ html()->hidden('status', 0) }}
                                {{ html()->checkbox('status', old('status', 1))->class('form-check-input')->id('status')->value(1) }}
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-grid d-sm-flex justify-content-sm-end gap-3">
        {{ html()->submit(__('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
    </div>
    {{ html()->form()->close() }}

    @include('components.media-modal')
@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function readURL(input, imgElement) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imgElement.attr('src', e.target.result).show();
                    $('#removeImageBtn').removeClass('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#file_url').change(function() {
            readURL(this, $('#selectedImage'));
        });

        $('#removeImageBtn').click(function() {
            $('#selectedImage').attr('src', '').hide();
            $('#file_url').val('');
            $(this).addClass('d-none');
        });
    });

    function getNames(type, selectedNameId = "") {
        var get_names_list = "{{ route('backend.banners.index_list', ['type' => ':type']) }}".replace(':type', type);

        $.ajax({
            url: get_names_list,
            success: function(result) {
                var formattedResult = [{ id: '', text: "{{ __('messages.select_name') }}" }]; // Default option

                var names = result.map(function(item) {
                    return {
                        id: item.id,
                        text: item.name,
                        thumbnail_url: item.thumbnail_url,
                        poster_url: item.poster_url,
                        poster_tv_url: item.poster_tv_url
                    };
                });

                formattedResult = formattedResult.concat(names); // Append fetched names

                $('#name_id').select2({
                    width: '100%',
                    data: formattedResult
                });

                if (selectedNameId != "") {
                    $('#name_id').val(selectedNameId).trigger('change');
                }
            }
        });
    }

    $(document).ready(function() {
        $('#type').change(function() {
            var type = $(this).val();
            var typeName = $('#type option:selected').text();

            if (type) {
                $('#type_id').val(type);
                $('#type_name').val(typeName);

                $('#name_id').empty();
                getNames(type);
            } else {
                $('#name_id').empty();
            }
        });

        $('#name_id').change(function() {
            var selectedNameId = $(this).val();
            var selectedNameText = $('#name_id option:selected').text();

            if (selectedNameId) {
                $('#type_id').val(selectedNameId);
                $('#type_name').val(selectedNameText);
            } else {
                $('#type_id').val('');
                $('#type_name').val('');
            }
        });

        $('#name_id').change(function() {
            var selectedOption = $('#name_id').select2('data')[0];
            console.log(selectedOption);
            if (selectedOption) {
                var thumbnailUrl = selectedOption.thumbnail_url;
                var posterUrl = selectedOption.poster_url;
                var posterTvUrl = selectedOption.poster_tv_url;


                if (thumbnailUrl) {
                    $('#file_url_image').val(thumbnailUrl);
                    $('#selectedImageContainerThumbnail').html(`
          <div style="position: relative; display: inline-block;">
            <img src="${thumbnailUrl}" class="img-fluid avatar-150">
            <span class="remove-media-icon"
                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                  onclick="removeImage('selectedImageContainerThumbnail', 'file_url_image', 'remove_image_flag1')">×</span>
          </div>
        `);
                } else {
                    $('#selectedImageContainerThumbnail').html('');
                    $('#file_url_image').val('');
                }

                if (posterUrl) {
                    $('#poster_url').val(posterUrl);
                    $('#selectedImageContainerPoster').html(`
          <div style="position: relative; display: inline-block;">
            <img src="${posterUrl}" class="img-fluid avatar-150">
            <span class="remove-media-icon"
                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                  onclick="removeImage('selectedImageContainerPoster', 'poster_url', 'remove_image_flag2')">×</span>
          </div>
            `);
                } else {
                    $('#selectedImageContainerPoster').html('');
                    $('#poster_url').val('');
                }
                if (posterTvUrl) {
                    $('#poster_tv_url').val(posterTvUrl);
                    $('#selectedImageContainerPosterTv').html(`
          <div style="position: relative; display: inline-block;">
            <img src="${posterTvUrl}" class="img-fluid avatar-150">
            <span class="remove-media-icon"
                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                  onclick="removeTvImage('selectedImageContainerPosterTv', 'poster_tv_url', 'remove_image_flag3')">×</span>
          </div>
        `);
                } else {
                    $('#selectedImageContainerPosterTv').html('');
                    $('#poster_tv_url').val('');
                }
            }
        });
    });
    function removeImage(containerId, hiddenInputId, removedFlagId) {
      var container = document.getElementById(containerId);
      var hiddenInput = document.getElementById(hiddenInputId);
      var removedFlag = document.getElementById(removedFlagId);

      container.innerHTML = '';
      hiddenInput.value = '';
      removedFlag.value = 1;
    }

    window.removeImage = removeImage;

    function removeTvImage(containerId, hiddenInputId, removedFlagId) {
      var container = document.getElementById(containerId);
      var hiddenInput = document.getElementById(hiddenInputId);
      var removedFlag = document.getElementById(removedFlagId);

      container.innerHTML = '';
      hiddenInput.value = '';
      removedFlag.value = 1;
    }

    window.removeTvImage = removeTvImage;

    $('#removeImageBtn1').click(function () {
      removeImage('selectedImageContainerThumbnail', 'file_url_image', 'remove_image_flag1');
    });

    $('#removeImageBtn2').click(function () {
      removeImage('selectedImageContainerPoster', 'poster_url', 'remove_image_flag2');
    });

    $('#type').change(function () {
    let selectedType = $(this).val();

    let options = {
        home: 'Home',
    };

    if (selectedType === 'movie') {
        options.movie = 'Movie';
    } else if (selectedType === 'tvshow') {
        options.tv_show = 'TV Show';
    } else if (selectedType === 'video') {
        options.video = 'Video';
    }

    let $bannerFor = $('#banner_for');
    $bannerFor.empty();

    $bannerFor.append(new Option("{{ __('placeholder.lbl_select_banner_for') }}", ""));

    $.each(options, function (value, text) {
        $bannerFor.append(new Option(text, value));
    });

    $bannerFor.trigger('change');
});

</script>
@endpush

