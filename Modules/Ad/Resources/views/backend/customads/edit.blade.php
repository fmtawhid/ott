@extends('backend.layouts.app')
@section('title')
    {{ __($module_title) }}
@endsection
@section('content')
    <x-back-button-component route="backend.customads.index" />
    <style>
        .multi-select-box span.select2-selection.select2-selection--multiple {
            height: 100px !important;
            overflow: auto !important;
        }
    </style>
    {{ html()->form('PUT', route('backend.customads.update', $data->id))->attribute('id', 'form-submit')->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')->class('requires-validation')->open() }}

    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.ad_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                    {{ html()->text('name')->attribute('value', old('name', $data->name))->placeholder(__('messages.enter_name'))->class('form-control') }}
                    {{-- // /*->attribute('maxlength', 100) */ --}}

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">{{ __('messages.ad_name_required') }}</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.type') . '<span class="text-danger">*</span>', 'type')->class('form-label') }}

                    {{ html()->select(
                            'type',
                            [
                                'video' => 'Video',
                                'image' => 'Image',
                            ],
                            old('type', $data->type ?? nul),
                        )->class('form-control select2')->id('type') }}

                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="invalid-feedback" id="type-error">{{ __('messages.ad_type_required') }}</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.url_type') . '<span class="text-danger">*</span>', 'url_type')->class('form-label') }}

                    {{ html()->select(
                            'url_type',
                            [
                                'local' => 'Local',
                                'url' => 'URL',
                            ],
                            old('url_type', $data->url_type ?? nul),
                        )->class('form-control select2')->placeholder(__('messages.select_type')) }}

                    @error('url_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="invalid-feedback" id="placement-error">{{ __('messages.url_type_required') }}</div>
                </div>
                <div class="col-md-6 col-lg-4 position-relative" id="local_image_upload_section">
                    {{ html()->label(__('messages.image'), 'Image')->class('form-label') }}
                    <div class="input-group btn-file-upload">
                        {{ html()->button(__('<i class="ph ph-image"></i>' . __('messages.lbl_choose_image')))->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainer1')->attribute('data-hidden-input', 'file_url1') }}

                        {{ html()->text('image_input1')->class('form-control')->placeholder(__('placeholder.lbl_image'))->attribute('aria-label', 'Image Input 1')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainer1')->attribute('data-hidden-input', 'file_url1')->attribute('aria-describedby', 'basic-addon1') }}
                    </div>

                    <div class="mb-3 uploaded-image" id="selectedImageContainer1">
                        @if ($data->file_url)
                            <img src="{{ $data->file_url }}" class="img-fluid mb-2"
                                style="max-width: 100px; max-height: 100px;">
                            <span class="remove-media-icon"
                                style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                                onclick="removeThumbnail('file_url1', 'remove_image_flag')">×</span>
                        @endif
                    </div>
                    {{ html()->hidden('file_url')->id('file_url1')->value($data->file_url) }}
                    {{ html()->hidden('remove_image')->id('remove_image_flag')->value(0) }}

                    <div id="image-size-note" class="form-text text-warning" style="display:none;">
                        {{ __('Please upload a 1000x600 size Image.') }}
                    </div>

                </div>

                <div class="col-md-6 col-lg-4 d-none" id="video_file_input_section">
                    {{ html()->label(__('messages.lbl_media_video'), 'video_file')->class('form-label') }}
                    <div class="mb-3" id="selectedImageContainer4">
                        @if (Str::endsWith($data->video_url_input, ['.jpeg', '.jpg', '.png', '.gif']))
                            <img class="img-fluid" src="{{ $data->video_url_input }}" style="width: 10rem; height: 10rem;">
                        @else
                            <video width="400" controls="controls" preload="metadata">
                                <source src="{{ $data->video_url_input }}" type="video/mp4">
                            </video>
                        @endif
                    </div>

                    <div class="input-group btn-video-link-upload mb-3">
                        {{ html()->button(__('placeholder.lbl_select_file') . '<i class="ph ph-upload"></i>')->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainer4')->attribute('data-hidden-input', 'file_url4') }}

                        {{ html()->text('image_input4')->class('form-control')->placeholder(__('placeholder.lbl_select_file'))->attribute('aria-label', 'Image Input 3')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainer4')->attribute('data-hidden-input', 'file_url4') }}
                    </div>

                    {{ html()->hidden('video_file_input')->id('file_url4')->value($data->video_url_input)->attribute('data-validation', 'iq_video_quality') }}

                    @error('video')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="file-error">Video File field is required</div>
                </div>
                {{-- URL textbox (shown when "URL" is selected) --}}
                <div class="col-md-6 col-lg-4 d-none" id="url_input_section">
                    <label for="media_url">{{ __('messages.lbl_url') }} <span class="text-danger">*</span></label>
                    <input type="text" name="media_url" class="form-control"
                        value="{{ old('media_url', $data->url_type === 'url' ? $data->media : '') }}" placeholder="https://example.com/video.mp4" />
                    <div class="invalid-feedback" id="media-url-error">{{ __('messages.invalid_url') }}</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.placement') . '<span class="text-danger">*</span>', 'placement')->class('form-label') }}

                    {{ html()->select(
                            'placement',
                            [
                                'home_page' => 'Home Page',
                                'player' => 'Player',
                                'banner' => 'Banner',
                                // 'header' => 'Header',
                                // 'sidebar' => 'Sidebar',
                                // 'before_login' => 'Before Login',
                            ],
                            old('placement', $data->placement ?? null),
                        )->class('form-control select2') }}

                    @error('placement')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="invalid-feedback" id="placement-error">{{ __('messages.placement_required') }}</div>
                </div>


                {{-- Redirect URL --}}
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.redirect_url'), 'redirect_url')->class('form-label') }}
                    {{ html()->text('redirect_url')->placeholder('https://example.com/vast/tag?id=12345')->value(old('redirect_url', $data->redirect_url ?? ''))->class('form-control') }}
                </div>

                {{-- Ad Duration (seconds) --}}
                {{-- <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.ad_duration') . ' <span class="text-danger">*</span>', 'duration')->class('form-label') }}
                        {{ html()->time('duration')
                            ->placeholder('eg. 30')
                            ->value(old('duration', $data->duration ?? ''))
                            ->class('form-control  min-datetimepicker-time')
                            ->id('durationInput')
                             }}
                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback"  id="duration-error" >{{ __('messages.duration_required') }}</div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.enable_skip'), 'enable_skip')->class('form-label') }}
                        <div class="d-flex align-items-center justify-content-between form-control">
                            <div class="form-check form-switch">
                                {{ html()->hidden('skip_enabled', 0) }}
                                {{ html()->checkbox('skip_enabled', old('skip_enabled', $data->skip_enabled))
                                    ->class('form-check-input')
                                    ->id('enableToggle') }}

                            </div>
                        </div>
                        @error('skip_enabled')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}
                {{-- @php
                        $enableSkip = old('skip_enabled', $data->skip_enabled ?? 0);
                    @endphp --}}
                {{-- <div class="col-md-6 col-lg-4" id="skipAfterContainer" style="display: {{ old('enable', 0) == 1 ? 'block' : 'none' }}">
                        {{ html()->label(__('messages.lbl_skip_after'), 'skip_after')->class('form-label') }}

                         {{ html()->time('skip_after')
                                ->value(old('skip_after', $data->skip_after ?? ''))
                                ->placeholder(__('messages.enter_skip_after'))
                                ->class('form-control  min-datetimepicker-time')
                                ->id('skipAfterInput')
                             }}

                        @error('skip_after')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback"  id="skip-after-error" style="display: none;">{{ __('messages.skip_after_less_duration') }}</div>


                    </div> --}}
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.target_content_type') . '<span class="text-danger">*</span>', 'frequency')->class('form-label') }}

                    {{ html()->select(
                            'target_content_type',
                            [
                                'video' => 'Video',
                                'movie' => 'Movie',
                                'tvshow' => 'TV Show',
                                // 'channel' => 'Channel',
                            ],
                            old('target_type', $data->target_content_type ?? []),
                        )->class('form-control select2')->id('target_content_type')->placeholder(__('messages.select_target_content_type'))->class('form-control') }}

                    @error('target_content_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="invalid-feedback" id="target-content-type-error">
                        {{ __('messages.target_content_type_required') }}</div>
                </div>

                <div class="col-md-6 col-lg-4 multi-select-box">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        {!! html()->label(__('messages.target_categories') . ' <span class="text-danger">*</span>', 'target_categories')->class('form-label mb-0') !!}

                        <div class="form-check m-0">
                            {{-- <input type="checkbox" class="form-check-input" id="select-all-targets" name="is_enable" value="{{ $data->is_enable ? '1' : '0' }}" onchange="this.value = this.checked ? 1 : 0" {{ $data->is_enable ? 'checked' : '' }}> --}}
                            <input type="checkbox" class="form-check-input" id="select-all-targets"
                                {{ is_array(old('target_categories', $data->target_categories ?? [])) && count(old('target_categories', $data->target_categories ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label ms-1"
                                for="select-all-targets">{{ __('messages.select_all') }}</label>
                        </div>
                    </div>
                    {{ html()->select('target_categories[]', $targetCategoriesOptions, old('target_categories', $data->target_categories ?? []))->class('form-control select2')->id('target_categories')->multiple()->attribute('data-placeholder', __('messages.select_target_categories')) }}

                    @error('target_categories')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="invalid-feedback" id="target-categories-error">
                        {{ __('messages.target_categories_required') }}</div>
                </div>

                {{-- Start Date --}}
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.start_date') . ' <span class="text-danger">*</span>', 'start_date')->class('form-label') }}
                    {{ html()->text('start_date')->class('form-control datetimepicker')->placeholder('YYYY-MM-DD')->attribute('value', old('start_date', $data->start_date ?? ''))->attribute('autocomplete', 'off') }}
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="start-date-error">{{ __('messages.start_date_required') }}</div>
                </div>

                {{-- End Date --}}
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.end_date') . ' <span class="text-danger">*</span>', 'end_date')->class('form-label') }}
                    {{ html()->text('end_date')->class('form-control datetimepicker')->placeholder('YYYY-MM-DD')->attribute('value', old('end_date', $data->end_date ?? ''))->attribute('autocomplete', 'off') }}
                    @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="end-date-error">{{ __('messages.end_date_required') }}</div>
                </div>

                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.lbl_status'), 'status')->class('form-label') }}
                    <div class="d-flex align-items-center justify-content-between form-control">
                        <span id="status-label" class="form-label mb-0 text-body">
                            {{ old('status', $data->status ?? 1) == 1 ? __('messages.active') : __('messages.inactive') }}
                        </span>
                        <div class="form-check form-switch">
                            {{ html()->hidden('status', 0) }}
                            {{ html()->checkbox('status', old('status', $data->status ?? 1) == 1)->class('form-check-input')->id('status') }}
                        </div>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
        {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
    </div>
    </div>
    {{ html()->form()->close() }}

    @include('components.media-modal')
@endsection
@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            const fileSection = $('#video_file_input_section');
            const urlSection = $('#url_input_section');
            const localImageSection = $('#local_image_upload_section');
            const urlTypeSelect = $('#url_type');
            const typeSelect = $('select[name="type"]');
            const mediaUrlInput = $('input[name="media_url"]');

            function validateUrl(url) {
                const urlPattern =
                    /^(https?:\/\/)([\w\-]+\.)*[\w\-]{2,}(\.[a-z]{2,})(\/[\w\-._~:/?#[\]@!$&'()*+,;=]*)?$/i;
                return urlPattern.test(url.trim());
            }

            function toggleFields() {
                const type = typeSelect.val();
                const urlType = urlTypeSelect.val();
                fileSection.addClass('d-none');
                urlSection.addClass('d-none');
                localImageSection.addClass('d-none');

                if (type === 'video') {
                    if (urlType === 'local') {
                        fileSection.removeClass('d-none');
                    } else if (urlType === 'url') {
                        urlSection.removeClass('d-none');
                    }
                } else if (type === 'image') {
                    if (urlType === 'local') {
                        localImageSection.removeClass('d-none');
                    } else if (urlType === 'url') {
                        urlSection.removeClass('d-none');
                    }
                }
            }

            mediaUrlInput.on('input', function() {
                const url = $(this).val();
                if (url && !validateUrl(url)) {
                    $(this).addClass('is-invalid');
                    $('#media-url-error').show();
                } else {
                    $(this).removeClass('is-invalid');
                    $('#media-url-error').hide();
                }
            });

            toggleFields();
            urlTypeSelect.on('change', toggleFields);
        });

        $(document).ready(function() {
            const targetCategories = $('#target_categories');
            const targetContentType = $('#target_content_type');
            const selectAll = $('#select-all-targets');

            // Initialize Select2 if present
            if (targetCategories.hasClass('select2')) {
                targetCategories.select2();
            }

            const oldSelections = @json(old('target_categories', $data->target_categories ?? []));
            const isEnable = {{ $data->is_enable ?? 0 }};
            const oldType = @json(old('target_content_type', $data->target_content_type ?? null));

            // Function to update "Select All" checkbox
            function updateSelectAllState() {
                const allOptions = targetCategories.find('option:not(:disabled)');
                const selected = targetCategories.val() || [];
                selectAll.prop('checked', allOptions.length && selected.length === allOptions.length);
            }

            // Select All checkbox behavior
            selectAll.on('change', function() {
                if (this.checked) {
                    const allValues = targetCategories.find('option').map(function() {
                        return $(this).val();
                    }).get();
                    targetCategories.val(allValues).trigger('change');
                } else {
                    targetCategories.val([]).trigger('change');
                }
            });

            // Update checkbox state when target category changes
            targetCategories.on('change', function() {
                updateSelectAllState();

                // Trigger validation
                $(this).valid();
            });

            // Load target categories based on selected content type
            targetContentType.on('change', function() {
                const selectedType = $(this).val();

                // Trigger validation for target_content_type
                $(this).valid();

                targetCategories.empty().prop('disabled', true).trigger('change');

                if (selectedType) {
                    $.ajax({
                        url: '{{ route('backend.customads.get-target-categories') }}',
                        type: 'GET',
                        data: {
                            type: selectedType
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                const options = data.map(item => new Option(item.text, item.id,
                                    false, false));
                                targetCategories.append(options).prop('disabled', false)
                                    .trigger('change');

                                if (isEnable === 1) {
                                    const allValues = targetCategories.find('option').map(
                                        function() {
                                            return $(this).val();
                                        }).get();
                                    targetCategories.val(allValues).trigger('change');
                                    selectAll.prop('checked', true);
                                } else if (oldSelections.length > 0) {
                                    targetCategories.val(oldSelections).trigger('change');
                                }

                                updateSelectAllState();
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Trigger initial load if old type is available
            if (oldType) {
                targetContentType.val(oldType).trigger('change');
            }
        });
        // document.getElementById('form-submit').addEventListener('submit', function(e) {
        //     var isValid = true;
        //     const enableSkip = document.getElementById('enableToggle').checked;
        //     const skipAfter = document.getElementById('skipAfterInput').value;
        //     const duration = document.getElementById('durationInput').value;

        //     if (enableSkip && skipAfter && duration) {
        //         const toSeconds = time => {
        //             const [min, sec] = time.split(':').map(Number);
        //             return min * 60 + sec;
        //         };

        //         if (toSeconds(skipAfter) >= toSeconds(duration)) {
        //             document.getElementById('skip-after-error').style.display = 'block';
        //             isValid = false;
        //         }
        //     }

        //     if (!isValid) {
        //         e.preventDefault();
        //         return false;
        //     }
        // });
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('enableToggle');
            const skipContainer = document.getElementById('skipAfterContainer');
            const skipAfterInput = document.querySelector('input[name="skip_after"]');

            // Only execute if the toggle element exists (since it's commented out in HTML)
            if (toggle && skipContainer && skipAfterInput) {
                if (!toggle.checked) {
                    skipAfterInput.value = '';
                }

                function toggleSkip() {
                    if (toggle.checked) {
                        skipContainer.style.display = 'block';
                        skipAfterInput.setAttribute('required', 'required');
                    } else {
                        skipContainer.style.display = 'none';
                        skipAfterInput.removeAttribute('required');
                        skipAfterInput.classList.remove('is-invalid');
                    }
                }
                toggleSkip();
                toggle.addEventListener('change', toggleSkip);
            }
        });

        function removeThumbnail(hiddenInputId, removedFlagId) {
            const container = document.getElementById('selectedImageContainer1');
            const hiddenInput = document.getElementById(hiddenInputId);
            const removedFlag = document.getElementById(removedFlagId);

            container.innerHTML = '';
            hiddenInput.value = '';
            removedFlag.value = 1;
        }
        $('#target_categories').on('select2:opening', function(e) {
            const targetType = $('#target_content_type').val();
            if (!targetType) {
                e.preventDefault();
                $('#target-content-type-error').show();
            } else {
                $('#target-content-type-error').hide();
            }
        });
        $('#url_type').on('select2:opening', function(e) {
            const Type = $('#type').val();
            if (!Type) {
                e.preventDefault();
                $('#type-error').show();
            } else {
                $('#type-error').hide();
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
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

        $(document).ready(function() {
            // Initialize Select2
            $('#type, #url_type, #target_content_type, #placement').select2({
                width: '100%',
                placeholder: function() {
                    return $(this).data('placeholder');
                },
            });

            // Initialize validation
            var validator = $("#form-submit").validate({
                ignore: [], // Don't ignore hidden fields
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    type: {
                        required: true
                    },
                    url_type: {
                        required: true
                    },
                    placement: {
                        required: true
                    },
                    target_content_type: {
                        required: true
                    },
                    target_categories: {
                        required: true
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    },
                    media_url: {
                        required: function() {
                            return $('select[name="url_type"]').val() === 'url';
                        },
                        url: true
                    }
                },
                messages: {
                    name: {
                        required: "{{ __('messages.ad_name_required') }}",
                        maxlength: "{{ __('Please enter Less than 100 characters') }}"
                    },
                    type: "{{ __('messages.ad_type_required') }}",
                    url_type: "{{ __('messages.url_type_required') }}",
                    placement: "{{ __('messages.placement_required') }}",
                    target_content_type: "{{ __('messages.target_content_type_required') }}",
                    target_categories: "{{ __('messages.target_categories_required') }}",
                    start_date: "{{ __('messages.start_date_required') }}",
                    end_date: "{{ __('messages.end_date_required') }}",
                    media_url: {
                        required: "{{ __('messages.media_url_required') }}",
                        url: "{{ __('messages.invalid_url') }}"
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                validClass: 'valid-feedback',
                highlight: function(element, errorClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container').find('.select2-selection').addClass(
                            'is-invalid').removeClass('is-valid');
                    }
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container').find('.select2-selection').removeClass(
                            'is-invalid').addClass('is-valid');
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                    // Remove any existing invalid-feedback divs
                    element.siblings('.invalid-feedback').not(error).remove();
                }
            });

            // Handle form submission
            $("#form-submit").on('submit', function(e) {
                e.preventDefault();

                if ($(this).valid()) {
                    // Additional validation for dates
                    $('#submit-button').prop('disabled', true).addClass('loading');
                    $('#submit-button').text('{{ trans('messages.save') }}...');
                    var startDate = new Date($('input[name="start_date"]').val());
                    var endDate = new Date($('input[name="end_date"]').val());

                    if (endDate < startDate) {
                        $('#end-date-error').text("{{ __('messages.end_date_greater') }}").show();
                        $('#submit-button').prop('disabled', false).removeClass('loading');
                        $('#submit-button').text('{{ trans('messages.save') }}');
                        return false;
                    }

                    // If all validations pass, submit the form
                    $(this).data('submitted', true);
                    this.submit();
                } else {
                    // Reset button state and scroll to first error
                    $('#submit-button').prop('disabled', false).removeClass('loading');
                    $('#submit-button').text('{{ trans('messages.save') }}');
                    var firstError = $('.is-invalid:first');
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                }
            });

            // Additional event handlers for Select2
            $('#type, #url_type, #target_content_type, #placement').on('change', function() {
                $(this).valid(); // Trigger validation on change
            });

            // Handle target_categories change
            $('#target_categories').on('change', function() {
                $(this).valid(); // Trigger validation on change
            });

            // Initialize datepicker
            flatpickr('.datetimepicker', {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    if (instance.element.name === 'start_date') {
                        // Update end date min date when start date changes
                        const endDatePicker = document.querySelector('input[name="end_date"]')
                            ._flatpickr;
                        endDatePicker.set('minDate', dateStr);
                    }
                    // Trigger validation after date selection
                    $(instance.element).valid();
                }
            });

            // Placement-based show/hide and validation for target fields
            function toggleTargetFields() {
                var placement = $('#placement').val();
                var targetContentType = $('#target_content_type');
                var targetCategories = $('#target_categories');
                var targetContentTypeWrapper = targetContentType.closest('.col-md-6.col-lg-4');
                var targetCategoriesWrapper = targetCategories.closest('.col-md-6.col-lg-4');
                if (placement === 'home_page') {
                    targetContentTypeWrapper.hide();
                    targetCategoriesWrapper.hide();
                    // Remove required rules
                    targetContentType.rules('remove', 'required');
                    targetCategories.rules('remove', 'required');
                    // Clear validation messages
                    targetContentType.removeClass('is-invalid').addClass('is-valid');
                    targetCategories.removeClass('is-invalid').addClass('is-valid');
                    $('.invalid-feedback').hide();
                } else {
                    targetContentTypeWrapper.show();
                    targetCategoriesWrapper.show();
                    // Add required rules
                    targetContentType.rules('add', {
                        required: true,
                        messages: {
                            required: "{{ __('messages.target_content_type_required') }}"
                        }
                    });
                    targetCategories.rules('add', {
                        required: true,
                        messages: {
                            required: "{{ __('messages.target_categories_required') }}"
                        }
                    });
                }
            }
            toggleTargetFields();
            $('#placement').on('change', function() {
                toggleTargetFields();
            });

            // Update status label on switch change
            $(document).on('change', '#status', function() {
                console.log($(this).is(':checked'));
                let label = $(this).is(':checked') ? '{{ __('messages.active') }}' :
                    '{{ __('messages.inactive') }}';
                $('#status-label').text(label);
            });

            $('input[name="name"]').on('input', function() {
                if ($(this).val().length >= 100) {
                    $('#name-error').text('Please enter Less than 100 characters.').show();
                    $(this).addClass('is-invalid');
                } else {
                    $('#name-error').hide();
                    $(this).removeClass('is-invalid');
                }
            });

        });

        function toggleImageNote() {
            if ($('#type').val() === 'image' && $('#url_type').val() === 'local') {
                $('#image-size-note').show();
            } else {
                $('#image-size-note').hide();
            }
        }
        $('#type, #url_type').on('change', toggleImageNote);
        toggleImageNote();
    </script>
@endpush
