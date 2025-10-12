@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.episodes.index" />

{{ html()->form('POST', route('backend.episodes.store-downloads', $data->id))->attribute('data-toggle', 'validator')->open() }}
@csrf

<div class="tab-pane fade show active" id="nav-download_url" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
    <div id="download_status_section" class="download_status_section">
        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('movie.lbl_download_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6">
                        {{ html()->label(__('movie.lbl_video_download_type'), 'download_type')->class('form-label') }}
                        {{ html()->select(
                                'download_type',
                                $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                old('download_type', $data->download_type ?? '')
                            )->class('form-control select2')->id('download_type') }}
                        @error('download_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        {{ html()->label(__('movie.download_url'), 'download_url')->class('form-label') }}
                        {{ html()->text('download_url', old('download_url', $data->download_url ?? ''))->placeholder(__('placeholder.download_url'))->class('form-control') }}
                        @error('download_url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('movie.lbl_download_quality_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center form-control">
                            <label for="enable_download_quality" class="form-label mb-0">{{ __('messages.lbl_qaulity_info_message') }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="enable_download_quality" value="0">
                                <input type="checkbox" name="enable_download_quality" id="enable_download_quality" class="form-check-input" value="1" onchange="toggleDownloadQualitySection()"
                                    {{ old('enable_download_quality', $data->enable_download_quality ?? 0) == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        @error('enable_download_quality')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="download_quality_status_section" class="col-md-12 download_quality_status_section {{ old('enable_download_quality', $data->enable_download_quality ?? 0) == 1 ? '' : 'd-none' }}">
                        <div id="video-inputs-container-parent">
                            @if(!empty($data->episodeDownloadMappings) && count($data->episodeDownloadMappings) > 0)
                                @foreach($data->episodeDownloadMappings as $mapping)
                                    <div class="row gy-3 video-inputs-container">
                                        <div class="col-md-6 col-lg-4">
                                            {{ html()->label(__('movie.lbl_quality_video_download_type'), 'quality_video_download_type')->class('form-label') }}
                                            {{ html()->select(
                                                    'quality_video_download_type[]',
                                                    $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                                    old('quality_video_download_type', $mapping->type ?? '')
                                                )->class('form-control select2')->id('quality_video_download_type') }}
                                            @error('quality_video_download_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-lg-4 video-input">
                                            {{ html()->label(__('movie.lbl_video_download_quality'), 'video_download_quality')->class('form-label') }}
                                            {{ html()->select(
                                                    'video_download_quality[]',
                                                    $video_quality->pluck('name', 'value')->prepend(__('placeholder.lbl_select_quality'), ''), 
                                                    old('video_download_quality', $mapping->quality)
                                                )->class('form-control select2')->id('video_download_quality') }}
                                        </div>

                                        <div class="col-md-6 col-lg-4 video-url-input">
                                            {{ html()->label(__('movie.download_quality_video_url'), 'download_quality_video_url')->class('form-label') }}
                                            {{ html()->text('download_quality_video_url[]', old('download_quality_video_url[]', $mapping->url ?? ''))->placeholder(__('placeholder.download_quality_video_url'))->class('form-control') }}
                                        </div>

                                        <div class="col-md-12 text-end mb-3">
                                            <button type="button" class="btn btn-secondary-subtle btn-sm fs-4 remove-video-input d-none"><i class="ph ph-trash align-middle"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row video-inputs-container">
                                    <div class="col-md-6 col-lg-4">
                                        {{ html()->label(__('movie.lbl_quality_video_download_type'), 'quality_video_download_type')->class('form-label') }}
                                        {{ html()->select(
                                                'quality_video_download_type[]',
                                                $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                                old('quality_video_download_type', '')
                                            )->class('form-control select2')->id('quality_video_download_type') }}
                                        @error('quality_video_download_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-lg-4 video-input">
                                        {{ html()->label(__('movie.lbl_video_download_quality'), 'video_download_quality')->class('form-label') }}
                                        {{ html()->select(
                                                'video_download_quality[]',
                                                $video_quality->pluck('name', 'value')->prepend(__('placeholder.lbl_select_quality'), '')
                                            )->class('form-control select2')->id('video_download_quality') }}
                                    </div>

                                    <div class="col-md-6 col-lg-4 video-url-input">
                                        {{ html()->label(__('movie.download_quality_video_url'), 'download_quality_video_url')->class('form-label') }}
                                        {{ html()->text('download_quality_video_url[]')->placeholder(__('placeholder.download_quality_video_url'))->class('form-control') }}
                                    </div>

                                    <div class="col-md-12 text-end mb-3">
                                        <button type="button" class="btn btn-secondary-subtle btn-sm fs-4 remove-video-input d-none"><i class="ph ph-trash align-middle"></i></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <a id="add_more_video" class="btn btn-sm btn-primary"><i class="ph ph-plus-circle"></i> {{ __('episode.lbl_add_more') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
    </div>

{{ html()->form()->close() }}

@endsection

@push('after-scripts')
    <script>
        function toggleDownloadQualitySection() {
            var enableQualityCheckbox = document.getElementById('enable_download_quality');
            var enableQualitySection = document.getElementById('download_quality_status_section');

            if (enableQualityCheckbox.checked) {
                enableQualitySection.classList.remove('d-none');
            } else {
                enableQualitySection.classList.add('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleDownloadQualitySection();
        });

        $(document).ready(function() {
            function initializeSelect2(section) {
                section.find('select.select2').each(function() {
                    $(this).select2({
                        width: '100%'
                    });
                });
            }

            $('#download_type, #video_download_quality').select2({ width: '100%' });

            $(document).on('click', '.remove-video-input', function() {
                $(this).closest('.video-inputs-container').remove();
            });
        });
    </script>
@endpush
