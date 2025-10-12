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

    {{ html()->form('POST', route('backend.customads.store'))->attribute('id', 'form-submit')->attribute('enctype', 'multipart/form-data')->attribute('novalidate', 'novalidate')->class('requires-validation')->open() }}

    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.ad_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                    {{ html()->text('name')->attribute('value', old('name'))->placeholder(__('messages.enter_name'))->class('form-control') }}
                    {{-- /*->attribute('maxlength', 100) */ --}}
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
                            old('type'),
                        )->class('form-control select2')->id('type')->placeholder(__('messages.select_type')) }}
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
                            old('url_type'),
                        )->class('form-control select2')->placeholder(__('messages.select_type')) }}

                    @error('url_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="invalid-feedback" id="url-type-error">{{ __('messages.url_type_required') }}</div>
                </div>
                <div class="col-md-6 col-lg-4 position-relative" id="local_image_upload_section">
                    {{ html()->label(__('messages.image'), 'Image')->class('form-label') }}
                    <div class="input-group btn-file-upload">
                        {{ html()->button(__('<i class="ph ph-image"></i>' . __('messages.lbl_choose_image')))->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerThumbnail')->attribute('data-hidden-input', 'file_url_image') }}

                        {{ html()->text('thumbnail_input')->class('form-control')->placeholder(__('placeholder.lbl_image'))->attribute('aria-label', 'Thumbnail Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerThumbnail') }}
                    </div>
                    <div class="uploaded-image" id="selectedImageContainerThumbnail">
                        @if (old('file_url', isset($data) ? $data->file_url : ''))
                            <img src="{{ old('file_url', isset($data) ? $data->file_url : '') }}" class="img-fluid mb-2"
                                style="max-width: 100px; max-height: 100px;">
                        @endif
                    </div>
                </div>
                {{ html()->hidden('file_url')->id('file_url_image')->value(old('file_url', isset($data) ? $data->file_url : '')) }}

                <div id="image-size-note" class="form-text text-warning" style="display:none;">
                    {{ __('Please upload a 1000x600 size Image.') }}
                </div>

                <div class="col-mb-6 col-lg-4 d-none" id="video_file_input_section">
                    {{ html()->label(__('movie.video_file_input') . '<span class="text-danger">*</span>', 'video_file')->class('form-label') }}

                    <div class="input-group btn-video-link-upload mb-3">
                        {{ html()->button(__('placeholder.lbl_select_file') . '<i class="ph ph-upload"></i>')->class('input-group-text form-control')->type('button')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerVideourl')->attribute('data-hidden-input', 'file_url_video') }}

                        {{ html()->text('video_file_input')->class('form-control')->placeholder('Select Image')->attribute('aria-label', 'Video Image')->attribute('data-bs-toggle', 'modal')->attribute('data-bs-target', '#exampleModal')->attribute('data-image-container', 'selectedImageContainerVideourl')->attribute('data-hidden-input', 'file_url_video') }}
                    </div>

                    <div class="mt-3" id="selectedImageContainerVideourl">
                        @if (old('video_file_input'))
                            <img src="{{ old('video_file_input') }}" class="img-fluid mb-2"
                                style="max-width: 100px; max-height: 100px;">
                        @endif
                    </div>

                    {{ html()->hidden('video_file_input')->id('file_url_video')->value(old('video_file_input'))->attribute('data-validation', 'iq_video_quality') }}
                    @error('media')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="file-error">Video File field is required</div>
                </div>
                {{-- URL textbox (shown when "URL" is selected) --}}
                <div class="col-md-6 col-lg-4 d-none" id="url_input_section">
                    <label for="media_url">{{ __('messages.lbl_url') }} <span class="text-danger">*</span></label>
                    <input type="text" name="media_url" class="form-control"
                        placeholder="https://example.com/video.mp4" />

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
                            old('placement'),
                        )->class('form-control select2')->placeholder(__('messages.select_placement')) }}

                    @error('placement')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="invalid-feedback" id="placement-error">{{ __('messages.placement_required') }}</div>
                </div>


                {{-- Redirect URL --}}
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.redirect_url'), 'redirect_url')->class('form-label') }}
                    {{ html()->text('redirect_url')->placeholder('https://example.com/vast/tag?id=12345')->attribute('value', old('redirect_url'))->class('form-control') }}

                </div>

                {{-- <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.ad_duration') . ' <span class="text-danger">*</span>', 'duration')->class('form-label') }}
                        {{ html()->time('duration')
                            ->placeholder('eg. 30')
                            ->attribute('value', old('duration'))
                            ->class('form-control  min-datetimepicker-time')
                            ->id('durationInput')
                             }}
                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback"  id="duration-error" >{{ __('messages.duration_required') }}</div>
                    </div> --}}

                {{-- <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.enable_skip'), 'enable_skip')->class('form-label') }}
                        <div class="d-flex align-items-center justify-content-between form-control">
                            <div class="form-check form-switch">
                                {{ html()->hidden('skip_enabled', 0) }} 
                                {{ html()->checkbox('skip_enabled', old('skip_enabled', 0) == 1)
                                    ->class('form-check-input')
                                    ->id('enableToggle') }}
                            </div>
                        </div>
                        @error('skip_enabled')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 col-lg-4" id="skipAfterContainer" style="display: {{ old('enable', 0) == 1 ? 'block' : 'none' }}">
                        {{ html()->label(__('messages.lbl_skip_after'), 'skip_after')->class('form-label') }}

                         {{ html()->time('skip_after')
                                ->attribute('value', old('skip_after'))
                                ->placeholder(__('messages.enter_skip_after'))
                                ->class('form-control  min-datetimepicker-time')
                                ->id('skipAfterInput')
                             }}

                        @error('skip_after')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                       <div class="invalid-feedback"  id="skip-after-error" style="display: none;">{{ __('messages.skip_after_less_duration') }}</div>
                    </div> --}}

                {{-- Start of Target Fields Wrapper --}}
                {{-- <div id="target-fields-wrapper"> --}}
                <div class="col-md-6 col-lg-4 target-fields-wrapper">
                    {{ html()->label(__('messages.target_content_type') . '<span class="text-danger">*</span>', 'frequency')->class('form-label') }}
                    {{ html()->select(
                            'target_content_type',
                            [
                                'video' => 'Video',
                                'movie' => 'Movie',
                                'tvshow' => 'TV Show',
                                // 'channel' => 'Channel',
                            ],
                            old('target_content_type', []),
                        )->class('form-control select2')->id('target_content_type')->placeholder(__('messages.select_target_content_type')) }}
                    @error('target_content_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="target-content-type-error">
                        {{ __('messages.target_content_type_required') }}</div>
                </div>

                <div class="col-md-6 col-lg-4 target-fields-wrapper multi-select-box">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0" for="target_selection">{{ __('messages.target_categories') }} <span
                                class="text-danger">*</span></label>
                        <div class="form-check m-0">
                            <input type="hidden" name="is_enable" value="0">
                            <input type="checkbox" class="form-check-input" id="select-all-targets" name="is_enable"
                                value="1" onchange="this.checked ? this.value = 1 : this.value = 0">
                            <label class="form-check-label ms-1"
                                for="select-all-targets">{{ __('messages.select_all') }}</label>
                        </div>
                    </div>
                    {{ html()->select('target_categories[]', [], old('target_categories', []))->class('form-control select2')->id('target_categories')->multiple()->attribute('data-placeholder', __('messages.select_target_categories')) }}
                    @error('target_categories')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="target-categories-error">
                        {{ __('messages.target_categories_required') }}</div>
                </div>
                {{-- </div> --}}
                {{-- End of Target Fields Wrapper --}}

                {{-- Start Date --}}
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.start_date') . ' <span class="text-danger">*</span>', 'start_date')->class('form-label') }}
                    {{ html()->text('start_date')->class('form-control datetimepicker')->placeholder('YYYY-MM-DD')->attribute('value', old('start_date'))->attribute('autocomplete', 'off') }}
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="start-date-error">{{ __('messages.start_date_required') }}</div>
                </div>

                {{-- End Date --}}
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.end_date') . ' <span class="text-danger">*</span>', 'end_date')->class('form-label') }}
                    {{ html()->text('end_date')->class('form-control datetimepicker')->placeholder('YYYY-MM-DD')->attribute('value', old('end_date'))->attribute('autocomplete', 'off') }}
                    @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="end-date-error">{{ __('messages.end_date_required') }}</div>
                </div>

                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.lbl_status'), 'status')->class('form-label') }}
                    <div class="d-flex align-items-center justify-content-between form-control">
                        <span id="status-label" class="form-label mb-0 text-body">
                            {{ old('status', true) == 1 ? __('messages.active') : __('messages.inactive') }}
                        </span>
                        <div class="form-check form-switch">
                            {{ html()->hidden('status', 0) }}
                            {{ html()->checkbox('status', old('status', true))->class('form-check-input')->id('status') }}
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
        {{ html()->button(trans('messages.save'))->type('submit')->class('btn btn-md btn-primary float-right')->id('submit-button') }}
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
                        maxlength: "{{ __('Please enter less than 100 characters') }}"
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
                    $('#submit-button').text('Loading...');
                    var startDate = new Date($('input[name="start_date"]').val());
                    var endDate = new Date($('input[name="end_date"]').val());

                    if (endDate < startDate) {
                        $('#end-date-error').text("{{ __('messages.end_date_greater') }}").show();
                        return false;
                    }

                    // Skip/duration validation
                    const enableSkip = document.getElementById('enableToggle') ? document.getElementById(
                        'enableToggle').checked : false;
                    const skipAfter = document.getElementById('skipAfterInput') ? document.getElementById(
                        'skipAfterInput').value : '';
                    const duration = document.getElementById('durationInput') ? document.getElementById(
                        'durationInput').value : '';
                    if (enableSkip && skipAfter && duration) {
                        const toSeconds = time => {
                            const [min, sec] = time.split(':').map(Number);
                            return min * 60 + sec;
                        };
                        if (toSeconds(skipAfter) >= toSeconds(duration)) {
                            document.getElementById('skip-after-error').style.display = 'block';
                            return false;
                        } else {
                            document.getElementById('skip-after-error').style.display = 'none';
                        }
                    } else {
                        if (document.getElementById('skip-after-error')) {
                            document.getElementById('skip-after-error').style.display = 'none';
                        }
                    }

                    // If all validations pass, submit the form
                    this.submit();
                } else {
                    // Scroll to first error
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
                const totalOptions = $(this).find('option').length;
                const selectedOptions = $(this).val() ? $(this).val().length : 0;

                // Update select all checkbox based on selections
                $('#select-all-targets').prop('checked', totalOptions > 0 && totalOptions ===
                    selectedOptions);

                // Trigger validation
                $(this).valid();
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

            // Handle select all checkbox
            $('#select-all-targets').on('change', function() {
                const isChecked = $(this).prop('checked');
                const targetSelect = $('#target_categories');

                if (isChecked) {
                    // Select all available options
                    const availableOptions = targetSelect.find('option').map(function() {
                        return $(this).val();
                    }).get();
                    targetSelect.val(availableOptions).trigger('change');
                } else {
                    // Deselect all options
                    targetSelect.val(null).trigger('change');
                }
            });

            $('#target_content_type').on('change', function() {
                var selectedType = $(this).val();
                var oldSelections = @json(old('target_categories', []));

                // Trigger validation for target_content_type
                $(this).valid();

                $('#target_categories').empty().prop('disabled', true).trigger('change');
                $('#select-all-targets').prop('checked', false);

                if (selectedType) {
                    $.ajax({
                        url: '{{ route('backend.customads.get-target-categories') }}',
                        type: 'GET',
                        data: {
                            type: selectedType
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                let options = data.map(item => new Option(item.text, item.id,
                                    false, false));
                                $('#target_categories').append(options).prop('disabled', false)
                                    .trigger('change');
                                if (oldSelections && oldSelections.length > 0) {
                                    $('#target_categories').val(oldSelections).trigger(
                                        'change');
                                }
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
            var oldTargetType = @json(old('target_content_type'));
            if (oldTargetType) {
                $('#target_content_type').val(oldTargetType).trigger('change');
            }

            // Add this block for placement-based show/hide and validation
            function toggleTargetFields() {
                var placement = $('#placement').val();
                if (placement === 'home_page') {
                    $('.target-fields-wrapper').hide();
                    // Remove required rules
                    $('#target_content_type').rules('remove', 'required');
                    $('#target_categories').rules('remove', 'required');
                    // Clear validation messages
                    $('#target_content_type').removeClass('is-invalid').addClass('is-valid');
                    $('#target_categories').removeClass('is-invalid').addClass('is-valid');
                    $('.invalid-feedback').hide();
                } else {
                    $('.target-fields-wrapper').show();
                    // Add required rules
                    $('#target_content_type').rules('add', {
                        required: true,
                        messages: {
                            required: "{{ __('messages.target_content_type_required') }}"
                        }
                    });
                    $('#target_categories').rules('add', {
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

            // Add input event for Ad Name maxlength
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

        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('enableToggle');
            const skipContainer = document.getElementById('skipAfterContainer');
            const skipAfterInput = document.querySelector('input[name="skip_after"]');
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
        });

        $(document).ready(function() {
            const fileSection = $('#video_file_input_section');
            const urlSection = $('#url_input_section');
            const localImageSection = $('#local_image_upload_section');
            const urlTypeSelect = $('select[name="url_type"]');
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

                // Reset all
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
            typeSelect.on('change', toggleFields);
        });

        function removeThumbnail(hiddenInputId, removedFlagId) {
            var container = document.getElementById('selectedImageContainer1');
            var hiddenInput = document.getElementById(hiddenInputId);
            var removedFlag = document.getElementById(removedFlagId);

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
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    if (instance.element.name === 'start_date') {
                        // Update end date min date when start date changes
                        const endDatePicker = document.querySelector('input[name="end_date"]')
                            ._flatpickr;
                        endDatePicker.set('minDate', dateStr);
                    }
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
