@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.banners.index" />
{{ html()->form('PUT', route('backend.banners.update', $banner->id))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open() }}
@csrf
<div class="card">
    <div class="card-body">
        <div class="row gy-3">
          <div class="col-md-6 col-lg-4">
            <div class="position-relative">
                {{ html()->label(__('banner.title'), 'poster')->class('form-label') }}
                <div class="input-group btn-file-upload">
                    {{ html()->button('<i class="ph ph-image"></i> ' . __('messages.lbl_choose_image'))
                        ->class('input-group-text form-control')
                        ->type('button')
                        ->attribute('data-bs-toggle', 'modal')
                        ->attribute('data-bs-target', '#exampleModal')
                        ->attribute('data-image-container', 'selectedImageContainer2')
                        ->attribute('data-hidden-input', 'file_url2')
                        ->style('height:13.6rem')
                    }}

                    {{ html()->text('image_input2')
                        ->class('form-control')
                        ->placeholder('Select Image')
                        ->attribute('aria-label', 'Image Input 2')
                        ->attribute('data-bs-toggle', 'modal')
                        ->attribute('data-bs-target', '#exampleModal')
                        ->attribute('data-image-container', 'selectedImageContainer2')
                        ->attribute('data-hidden-input', 'file_url2')
                        ->attribute('aria-describedby', 'basic-addon1')
                    }}
                </div>
                <div class="uploaded-image" id="selectedImageContainer2">
                    @if ($banner->poster_url)
                        <img src="{{ $banner->poster_url }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                        <span class="remove-media-icon"
                              style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                              onclick="removeImage('selectedImageContainer2', 'file_url2', 'remove_image_flag2')">×</span>
                    @endif
                </div>
                {{ html()->hidden('poster_url')->id('file_url2')->value($banner->poster_url) }}
                {{ html()->hidden('remove_image')->id('remove_image_flag2')->value(0) }}
            </div>
            <small class="text-danger">Note: Recommended banner image size is 428 × 530 pixels.</small>
        </div>

            <div class="col-md-6 col-lg-4">
                <div class="position-relative">
                    {{ html()->label(__('banner.lbl_web_banner'), 'file_url')->class('form-label') }}
                    <div class="input-group btn-file-upload">
                        {{ html()->button('<i class="ph ph-image"></i> ' . __('messages.lbl_choose_image'))
                            ->class('input-group-text form-control')
                            ->type('button')
                            ->attribute('data-bs-toggle', 'modal')
                            ->attribute('data-bs-target', '#exampleModal')
                            ->attribute('data-image-container', 'selectedImageContainer1')
                            ->attribute('data-hidden-input', 'file_url1')
                            ->style('height:13.6rem')
                        }}

                        {{ html()->text('image_input1')
                            ->class('form-control')
                            ->placeholder('Select Image')
                            ->attribute('aria-label', 'Image Input 1')
                            ->attribute('data-bs-toggle', 'modal')
                            ->attribute('data-bs-target', '#exampleModal')
                            ->attribute('data-image-container', 'selectedImageContainer1')
                            ->attribute('data-hidden-input', 'file_url1')
                            ->attribute('aria-describedby', 'basic-addon1')
                        }}
                    </div>
                    <div class="uploaded-image" id="selectedImageContainer1">
                        @if ($banner->file_url)
                            <img src="{{ $banner->file_url }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                            <span class="remove-media-icon"
                                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                                  onclick="removeImage('selectedImageContainer1', 'file_url1', 'remove_image_flag1')">×</span>
                        @endif
                    </div>
                    {{ html()->hidden('file_url')->id('file_url1')->value($banner->file_url) }}
                    {{ html()->hidden('remove_image')->id('remove_image_flag1')->value(0) }}
                </div>
                <small class="text-danger">Note: Recommended banner image size is 1024 × 500 pixels.</small>
            </div>


            <div class="col-md-6 col-lg-4">
                <div class="position-relative">
                    {{ html()->label(__('banner.lbl_tv_banner'), 'poster_tv')->class('form-label') }}
                    <div class="input-group btn-file-upload">
                        {{ html()->button('<i class="ph ph-image"></i> ' . __('messages.lbl_choose_image'))
                            ->class('input-group-text form-control')
                            ->type('button')
                            ->attribute('data-bs-toggle', 'modal')
                            ->attribute('data-bs-target', '#exampleModal')
                            ->attribute('data-image-container', 'selectedImageContainerTv')
                            ->attribute('data-hidden-input', 'file_urltv')
                            ->style('height:13.6rem')
                        }}

                        {{ html()->text('image_input2')
                            ->class('form-control')
                            ->placeholder('Select Image')
                            ->attribute('aria-label', 'Image Input 2')
                            ->attribute('data-bs-toggle', 'modal')
                            ->attribute('data-bs-target', '#exampleModal')
                            ->attribute('data-image-container', 'selectedImageContainerTv')
                            ->attribute('data-hidden-input', 'file_urltv')
                            ->attribute('aria-describedby', 'basic-addon1')
                        }}
                    </div>
                    <div class="uploaded-image" id="selectedImageContainerTv">
                        @if ($banner->poster_tv_url)
                            <img src="{{ $banner->poster_tv_url }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                            <span class="remove-media-icon"
                                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                                  onclick="removeTvImage('selectedImageContainerTv', 'file_urltv', 'remove_image_flag_tv')">×</span>
                        @endif
                    </div>
                    {{ html()->hidden('poster_tv_url')->id('file_urltv')->value($banner->poster_tv_url) }}
                    {{ html()->hidden('remove_image')->id('remove_image_flag_tv')->value(0) }}
                </div>
                <small class="text-danger">Note: Recommended banner image size is 1024 × 500 pixels.</small>
            </div>

                <div class="row gy-3">
                    <div class="col-md-4 col-lg-4 mt-3">
                        {{ html()->label(__('banner.lbl_type') . '<span class="text-danger">*</span>', 'type')->class('form-label') }}
                        {{ html()->select('type', $types, old('type', $banner->type))->class('form-control select2')->id('type')->attribute('required','required') }}
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Type field is required</div>
                    </div>
                    {{ html()->hidden('type_id', old('type_id', $banner->type_id))->id('type_id') }}
                    {{ html()->hidden('type_name', old('type_name', $banner->type_name))->id('type_name') }}
                    <div class="col-md-4 col-lg-4 mt-3">
                        {{ html()->label(__('banner.lbl_name') . '<span class="text-danger">*</span>', 'name')->class('form-label') }}
                        {{ html()->select('name_id',$names[$banner->type], old('name_id', $banner->type_id))->class('form-control select2')->id('name_id')->attribute('required','required') }}
                        @error('name_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Name field is required</div>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('banner.lbl_banner_for') . '<span class="text-danger">*</span>', 'banner_for')->class('form-label') }}
                        {{ html()->select('banner_for', [
                            '' => __('placeholder.lbl_select_banner_for'),
                            'home' => 'Home',
                            'movie' => 'Movie',
                            'tv_show' => 'TV Show',
                            'video' => 'Video'
                        ], old('banner_for', $banner->banner_for))->class('form-control select2')->id('banner_for')->attribute('required','required') }}
                        @error('banner_for')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="banner-for-error">Banner for field is required</div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                            {{ html()->label(__('banner.lbl_status'), 'status')->class('form-label') }}
                            <div class="d-flex justify-content-between align-items-center form-control">
                               {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                                <div class="form-check form-switch">
                                    {{ html()->hidden('status', 0) }}
                                    {{ html()->checkbox('status', old('status', $banner->status))->class('form-check-input')->id('status')->value(1) }}
                                </div>
                            </div>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
  document.addEventListener('DOMContentLoaded', function () {
    async function getNames(type, selectedNameId = "") {
      var get_names_list = "{{ route('backend.banners.index_list', ['type' => ':type']) }}".replace(':type', type);

      const response = await fetch(get_names_list);
      const result = await response.json();

      var formattedResult = [{ id: '', text: "{{ __('messages.select_name') }}" }];

      var names = result.map(function(item) {
        return {
          id: item.id,
          text: item.name,
          thumbnail_url: item.thumbnail_url,
          poster_url: item.poster_url,
          poster_tv_url: item.poster_tv_url
        };
      });

      formattedResult = formattedResult.concat(names);

      $('#name_id').select2({
        width: '100%',
        data: formattedResult
      });

      if (selectedNameId) {
        $('#name_id').val(selectedNameId).trigger('change');
      }
    }

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

    $('#name_id').change(function () {
      var selectedNameId = $(this).val();

      if (selectedNameId) {
        $('#name_id').off('change'); // Temporarily unbind the change event
        getNames( $('#type').val(),selectedNameId).then(() => {
          $('#name_id').on('change', arguments.callee); // Rebind the change event
          var selectedNameId = $(this).val();



          var selectedOption = $('#name_id').select2('data')[0];
        var posterUrl = selectedOption.poster_url;
        var thumbnailUrl = selectedOption.thumbnail_url;
        var posterTvUrl = selectedOption.poster_tv_url;

        $('#name_id').val(selectedOption.id);
        $('#type_id').val(selectedOption.id);
        $('#type_name').val(selectedOption.text);


        if (thumbnailUrl) {
          $('#file_url1').val(thumbnailUrl);
          $('#selectedImageContainer1').html(`
          <div style="position: relative; display: inline-block;">
            <img src="${thumbnailUrl}" class="img-fluid avatar-150">
            <span class="remove-media-icon"
                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                  onclick="removeImage('selectedImageContainer1', 'file_url1', 'remove_image_flag1')">×</span>
          </div>
        `);
          $('#removeImageBtn1').removeClass('d-none');
        } else {
          $('#selectedImageContainer1').html('');
          $('#file_url1').val('');
          $('#removeImageBtn1').addClass('d-none');
        }

        if (posterTvUrl) {
          $('#file_urltv').val(posterTvUrl);
          $('#selectedImageContainerTv').html(`
          <div style="position: relative; display: inline-block;">
            <img src="${posterTvUrl}" class="img-fluid avatar-150">
            <span class="remove-media-icon"
                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                  onclick="removeTvImage('selectedImageContainerTv', 'file_urltv', 'remove_image_flag3')">×</span>
          </div>
        `);
          $('#removeImageBtn3').removeClass('d-none');
        } else {
          $('#selectedImageContainerTv').html('');
          $('#file_urltv').val('');
          $('#removeImageBtn3').addClass('d-none');
        }

        if (posterUrl) {
          $('#file_url2').val(posterUrl);
          $('#selectedImageContainer2').html(`
          <div style="position: relative; display: inline-block;">
            <img src="${posterUrl}" class="img-fluid avatar-150">
            <span class="remove-media-icon"
                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                  onclick="removeImage('selectedImageContainer2', 'file_url2', 'remove_image_flag2')">×</span>
          </div>
        `);
          $('#removeImageBtn2').removeClass('d-none');
        } else {
          $('#selectedImageContainer2').html('');
          $('#file_url2').val('');
          $('#removeImageBtn2').addClass('d-none');
        }
        });

      }
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
      removeImage('selectedImageContainer1', 'file_url1', 'remove_image_flag1');
    });

    $('#removeImageBtn2').click(function () {
      removeImage('selectedImageContainer2', 'file_url2', 'remove_image_flag2');
    });
  });
  function populateBannerFor(selectedType, selectedValue = '') {
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
        let option = new Option(text, value, false, value === selectedValue);
        $bannerFor.append(option);
    });

    $bannerFor.trigger('change');
}

$(document).ready(function () {
    $('#type').change(function () {
        let selectedType = $(this).val();
        populateBannerFor(selectedType);
    });

    let initialType = $('#type').val();
    let initialBannerFor = '{{ old("banner_for", $banner->banner_for ?? "") }}';
    populateBannerFor(initialType, initialBannerFor);
});


</script>
@endpush
