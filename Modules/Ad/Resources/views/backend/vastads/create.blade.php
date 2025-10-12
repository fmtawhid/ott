@extends('backend.layouts.app')
@section('title') {{ __($module_title) }} @endsection
@section('content')
<x-back-button-component route="backend.vastads.index" />
<style>
    .multi-select-box span.select2-selection.select2-selection--multiple{
        height: 100px!important;
        overflow: auto!important;
    }

</style>
    {{ html()->form('POST' ,route('backend.vastads.store'))
        ->attribute('id', 'form-submit')
        ->attribute('enctype', 'multipart/form-data')
        ->attribute('data-toggle', 'validator')
        ->class('requires-validation')
        ->open()
    }}

    @csrf
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.ad_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                        {{ html()->text('name')
                                ->attribute('value', old('name'))
                                ->placeholder(__('messages.enter_name'))
                                ->class('form-control')
                                ->attribute('maxlength', 100)
                                 }}

                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">{{ __('messages.ad_name_required') }}</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label">
                            {!! __('messages.type') !!} <span class="text-danger">*</span>
                            <span
                                tabindex="0"
                                data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                title="{{ __('messages.info_vast_ads') }}"
                                style="cursor: pointer;"
                            >
                                <i class="fas fa-info-circle"></i>
                            </span>
                        </label>
                        {{ html()->select('type', [
                            'pre-roll' => 'Pre-roll',
                            'mid-roll' => 'Mid-roll',
                            'post-roll' => 'Post-roll',
                            'overlay' => 'Overlay',
                        ], old('type'))
                            ->class('form-control select2')
                            ->id('type')
                            ->placeholder(__('messages.select_type')) }}

                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="type-error">{{ __('messages.ad_type_required') }}</div>
                    </div>

                     <div class="col-md-6 col-lg-4">
                        <label class="form-label">
                            {!! __('messages.ad_url') !!} <span class="text-danger">*</span>
                            <span
                                tabindex="0"
                                data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                title="{{ __('messages.info_vast_ads_url') }}"
                                style="cursor: pointer;"
                            >
                                <i class="fas fa-info-circle"></i>
                            </span>
                        </label>
                        {{ html()->text('url')
                                ->attribute('value', old('url'))
                                ->placeholder(__('messages.enter_url'))
                                ->class('form-control')
                               }}

                        @error('url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="url-error">{{ __('messages.invalid_url') }}</div>
                    </div>

                    {{-- <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.ad_duration') . ' <span class="text-danger">*</span>', 'duration')->class('form-label') }}
                        {{ html()->time('duration')
                                ->attribute('value', old('duration'))
                                ->placeholder(__('messages.enter_duration'))
                                ->class('form-control  min-datetimepicker-time')
                                ->id('durationInput')
                                 }}

                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="duration-error">{{ __('messages.ad_duration_required') }}</div>
                    </div> --}}

                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.start_date') . ' <span class="text-danger">*</span>', 'start_date')->class('form-label') }}
                        {{ html()->text('start_date')
                                ->attribute('value', old('start_date'))
                                ->placeholder(__('messages.start_date'))
                                ->class('form-control datetimepicker')
                                ->id('startDateInput')
                                ->attribute('readonly', 'readonly')
                                ->attribute('required', 'required')
                        }}

                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="start-date-error" style="display: none;">{{ __('messages.start_date_required') }}</div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.end_date') . ' <span class="text-danger">*</span>', 'end_date')->class('form-label') }}
                        {{ html()->text('end_date')
                                ->attribute('value', old('end_date'))
                                ->placeholder(__('messages.end_date'))
                                ->class('form-control datetimepicker')
                                ->id('endDateInput')
                                ->attribute('readonly', 'readonly')
                                ->attribute('required', 'required')
                        }}

                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="end-date-error">{{ __('messages.end_date_required') }}</div>
                        <div class="invalid-feedback" id="date-range-error" style="display: none;">{{ __('messages.end_date_after_start_date') }}</div>
                    </div>

                    {{-- <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.enable_skip'), 'enable_skip')->class('form-label') }}
                        <div class="d-flex align-items-center justify-content-between form-control">
                            <div class="form-check form-switch">
                                {{ html()->hidden('enable_skip', 0) }}
                                {{ html()->checkbox('enable_skip', old('enable_skip', 0) == 1, 1)
                                    ->class('form-check-input')
                                    ->id('enableToggle') }}

                            </div>
                        </div>
                        @error('enable_skip')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>

                    <div class="col-md-6 col-lg-4" id="skipAfterContainer" style="display: {{ old('enable_skip', 0) == 1 ? 'block' : 'none' }}">
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
                    {{-- <div class="col-md-6 col-lg-4">
                      {{ html()->label(__('messages.frequency') . '<span class="text-danger">*</span>', 'frequency')->class('form-label') }}

                        {{ html()->number('frequency')
                            ->value(old('frequency'))
                            ->placeholder(__('messages.enter_frequency'))
                            ->class('form-control')
                            }}

                        @error('frequency')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div class="invalid-feedback" id="frequency-error">{{ __('messages.frequency_required') }}</div>
                    </div> --}}

                                        <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.target_type') . '<span class="text-danger">*</span>', 'target_type')->class('form-label') }}

                        {{ html()->select('target_type', [
                               'video' => 'Video',
                                'movie' => 'Movie',
                                'tvshow' => 'TV Show',
                                // 'channel' => 'Channel',
                        ], old('target_type'))
                            ->class('form-control select2')
                            ->id('target_type')
                            ->placeholder(__('messages.select_target_type')) }}
                         @error('target_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      <div class="invalid-feedback" id="target-type-error">{{ __('messages.target_type_required') }}</div>
                    </div>

                    <div class="col-md-6 col-lg-4 multi-select-box">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0" for="target_selection">{{ __('messages.target_selection') }} <span class="text-danger">*</span></label>

                            <div class="form-check m-0">
                                <input type="hidden" name="is_enable" value="0">
                                <input type="checkbox" class="form-check-input" id="select-all-targets" name="is_enable" value="1"
                                   onchange="this.checked ? this.value = 1 : this.value = 0">
                                <label class="form-check-label ms-1" for="select-all-targets">{{ __('messages.select_all') }}</label>
                            </div>
                        </div>

                         {{ html()->select('target_selection[]', [], old('target_selection', []))
                                ->class('form-control select2')
                                ->id('target_selection')
                                ->multiple()
                                ->attribute('data-placeholder', __('messages.select_target_selection')) }}
                        @error('target_selection')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div class="invalid-feedback" id="target-selection-error">{{ __('messages.target_selection_required') }}</div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('messages.lbl_status'), 'status')->class('form-label') }}
                        <div class="d-flex align-items-center justify-content-between form-control">
                            <span id="status-label" class="form-label mb-0 text-body">
                                {{ old('status', true) == 1 ? __('messages.active') : __('messages.inactive') }}
                            </span>
                            <div class="form-check form-switch">
                                {{ html()->hidden('status', 0) }}
                                {{
                                    html()->checkbox('status',old('status', true))
                                        ->class('form-check-input')
                                        ->id('status')
                                }}
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

    {{ html()->form()->close() }}

    <div id="form-loader" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(255,255,255,0.7); z-index:9999; align-items:center; justify-content:center;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

@include('components.media-modal')
@endsection
@push('after-scripts')
<script>
    // Define validateUrl function in global scope
    function validateUrl(url) {
        url = url.trim();
        try {
            const parsed = new URL(url);
            // Allow only http/https and .xml extension
            return (parsed.protocol === 'http:' || parsed.protocol === 'https:') && parsed.pathname.endsWith('.xml');
        } catch (e) {
            return false;
        }
    }

    // Define validateDates function
    function validateDates() {
        const startDateInput = document.getElementById('startDateInput');
        const endDateInput = document.getElementById('endDateInput');
        const dateRangeError = document.getElementById('date-range-error');
        const startDateError = document.getElementById('start-date-error');
        const endDateError = document.getElementById('end-date-error');

        const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
        const endDate = endDateInput.value ? new Date(endDateInput.value) : null;

        // Reset error states and visual feedback
        dateRangeError.style.display = 'none';
        startDateError.style.display = 'none';
        endDateError.style.display = 'none';
        $(startDateInput).removeClass('is-invalid');
        $(endDateInput).removeClass('is-invalid');

        let isValid = true;

        // Validate required fields
        if (!startDate) {
            startDateError.style.display = 'block';
            $(startDateInput).addClass('is-invalid');
            isValid = false;
        }

        if (!endDate) {
            endDateError.style.display = 'block';
            $(endDateInput).addClass('is-invalid');
            isValid = false;
        }

        // Only validate date range if both dates are provided
        if (startDate && endDate && startDate >= endDate) {
            dateRangeError.style.display = 'block';
            $(endDateInput).addClass('is-invalid');
            isValid = false;
        }

        return isValid;
    }

    // Define validateForm function
    function validateForm() {
        let isValid = true;

        // Reset all error states
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide();

        // Validate name
        const name = $('#name').val().trim();
        if (!name) {
            $('#name').addClass('is-invalid');
            $('#name-error').show();
            isValid = false;
        } else if (name.length > 100) {
            $('#name').addClass('is-invalid');
            $('#name-error').text('{{ __('messages.ad_name_maxlength') }}').show();
            isValid = false;
        } else {
            $('#name-error').text('{{ __('messages.ad_name_required') }}');
        }

        // Validate type
        const type = $('#type').val();
        if (!type) {
            $('#type').addClass('is-invalid');
            $('#type-error').show();
            isValid = false;
        }

        // Validate URL
        const url = $('#url').val().trim();
        if (!url) {
            $('#url').addClass('is-invalid');
            $('#url-error').show();
            isValid = false;
        } else if (!validateUrl(url)) {
            $('#url').addClass('is-invalid');
            $('#url-error').show();
            isValid = false;
        }

        // Validate duration
        // const duration = $('#durationInput').val();
        // if (!duration) {
        //     $('#durationInput').addClass('is-invalid');
        //     $('#duration-error').show();
        //     isValid = false;
        // }

        // Validate target type
        const targetType = $('#target_type').val();
        if (!targetType) {
            $('#target_type').addClass('is-invalid');
            $('#target-type-error').show();
            isValid = false;
        }

        // Validate target selection
        const targetSelection = $('#target_selection').val();
        if (!targetSelection || targetSelection.length === 0) {
            $('#target_selection').addClass('is-invalid');
            $('#target-selection-error').show();
            isValid = false;
        }

        // // Validate frequency
        // const frequency = $('#frequency').val();
        // if (!frequency) {
        //     $('#frequency').addClass('is-invalid');
        //     $('#frequency-error').show();
        //     isValid = false;
        // } else if (!Number.isInteger(Number(frequency))) {
        //     $('#frequency').addClass('is-invalid');
        //     $('#frequency-error').text('{{ __("messages.frequency_integer") }}').show();
        //     isValid = false;
        // }

        // Validate dates
        if (!validateDates()) {
            isValid = false;
        }

        // Validate skip after if enable_skip is checked
        const enableSkip = $('#enableToggle').prop('checked');
        if (enableSkip) {
            const skipAfter = $('#skipAfterInput').val();
            const duration = $('#durationInput').val();
            if (!skipAfter) {
                $('#skipAfterInput').addClass('is-invalid');
                $('#skip-after-error').show();
                isValid = false;
            }
            // else if (skipAfter && duration) {
            //     const toSeconds = time => {
            //         const [min, sec] = time.split(':').map(Number);
            //         return min * 60 + sec;
            //     };
            //     if (toSeconds(skipAfter) >= toSeconds(duration)) {
            //         $('#skipAfterInput').addClass('is-invalid');
            //         $('#skip-after-error').show();
            //         isValid = false;
            //     }
            // }
        }

        return isValid;
    }

    $(document).ready(function() {
        // Initialize select2 for type dropdown
        const typeSelect = $('#type');
        typeSelect.select2({
            width: '100%',
            placeholder: "{{ __('messages.select_type') }}"
        });

        // Initialize select2 for target selection
        const targetSelectionSelect = $('#target_selection');
        targetSelectionSelect.select2({
            width: '100%',
            placeholder: "{{ __('messages.select_target_selection') }}"
        });

        // Initialize flatpickr for time inputs
        flatpickr('.min-datetimepicker-time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            // onChange: function(selectedDates, dateStr, instance) {
            //     if (instance.element.id === 'durationInput') {
            //         $('#durationInput').removeClass('is-invalid');
            //         $('#duration-error').hide();

            //         if (!dateStr) {
            //             $('#durationInput').addClass('is-invalid');
            //             $('#duration-error').show();
            //         }
            //     }
            // }
        });

        // Initialize flatpickr for date inputs
        flatpickr('.datetimepicker', {
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                if (instance.element.name === 'start_date') {
                    // Update end date min date when start date changes
                    const endDatePicker = document.querySelector('input[name="end_date"]')._flatpickr;
                    endDatePicker.set('minDate', dateStr);
                }
                // Trigger validation after date selection
                validateDates();
            }
        });

        // Handle select all checkbox
        $('#select-all-targets').on('change', function() {
            const isChecked = $(this).prop('checked');
            const targetSelect = $('#target_selection');

            if (isChecked) {
                // Get all available options
                const availableOptions = targetSelect.find('option').map(function() {
                    return $(this).val();
                }).get();

                // Select all options and trigger change
                targetSelect.val(availableOptions).trigger('change');

                // Update the select2 dropdown to show all selected options
                targetSelect.select2('destroy').select2({
                    width: '100%',
                    placeholder: "{{ __('messages.select_target_selection') }}",
                    allowClear: true
                }).val(availableOptions).trigger('change');
            } else {
                // Clear all selections
                targetSelect.val(null).trigger('change');

                // Update the select2 dropdown
                targetSelect.select2('destroy').select2({
                    width: '100%',
                    placeholder: "{{ __('messages.select_target_selection') }}",
                    allowClear: true
                });
            }
        });

        // Handle target_selection changes
        $('#target_selection').on('change', function() {
            const totalOptions = $(this).find('option').length;
            const selectedOptions = $(this).val() ? $(this).val().length : 0;

            // Update select all checkbox based on selections
            $('#select-all-targets').prop('checked', totalOptions > 0 && totalOptions === selectedOptions);

            // Remove invalid state if selections are made
            if (selectedOptions > 0) {
                $(this).removeClass('is-invalid');
                $('#target-selection-error').hide();
            } else {
                $(this).addClass('is-invalid');
                $('#target-selection-error').show();
            }
        });

        // Handle target_type change
        $('#target_type').on('change', function() {
            const selectedType = $(this).val();
            const oldSelections = @json(old('target_selection', []));

            // Remove validation error for target type if selected
            if (selectedType) {
                $(this).removeClass('is-invalid');
                $('#target-type-error').hide();
            }

            $('#target_selection').empty().prop('disabled', true).trigger('change');
            $('#select-all-targets').prop('checked', false);

            if (selectedType) {
                $.ajax({
                    url: '{{ route("backend.vastads.get-target-selection") }}',
                    type: 'GET',
                    data: { type: selectedType },
                    success: function(data) {
                        if (data.length > 0) {
                            const options = data.map(item => new Option(item.text, item.id, false, false));
                            $('#target_selection').append(options).prop('disabled', false).trigger('change');
                            if (oldSelections && oldSelections.length > 0) {
                                $('#target_selection').val(oldSelections).trigger('change');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        // Handle enable skip toggle
        $('#enableToggle').on('change', function() {
            $('#skipAfterContainer').toggle(this.checked);
        });

        // // Handle duration input
        // $('#durationInput').on('change', function() {
        //     const duration = $(this).val();
        //     $(this).removeClass('is-invalid');
        //     $('#duration-error').hide();

        //     if (!duration) {
        //         $(this).addClass('is-invalid');
        //         $('#duration-error').show();
        //     }
        // });

        // Handle target selection opening
        $('#target_selection').on('select2:opening', function(e) {
            const type = $('#target_type').val();
            if (!type) {
                e.preventDefault();
                $('#target-type-error').show();
            } else {
                $('#target-type-error').hide();
            }
        });

        // Handle form submission
        $('#form-submit').on('submit', function(e) {
            e.preventDefault();

            if (validateForm()) {
                this.submit();
            } else {
                const firstError = $('.is-invalid').first();
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                }
            }
        });

        // Show loader on form submit if validation passes
        $('#form-submit').on('submit', function(e) {
            if (validateForm()) {
                // $('#form-loader').show();
            }
        });

        // Real-time validation for input fields
        $('#name, #url, #frequency').on('input', function() {
            const field = $(this);
            field.removeClass('is-invalid');
            const errorId = field.attr('id') + '-error';
            $('#' + errorId).hide();

            if (field.val().trim() === '') {
                field.addClass('is-invalid');
                $('#' + errorId).show();
            } else if (field.attr('id') === 'url' && !validateUrl(field.val())) {
                field.addClass('is-invalid');
                $('#' + errorId).show();
            }
            //  else if (field.attr('id') === 'frequency' && !Number.isInteger(Number(field.val()))) {
            //     field.addClass('is-invalid');
            //     $('#' + errorId).text('{{ __("messages.frequency_integer") }}').show();
            // }
        });

        // Real-time validation for date fields
        $('#startDateInput, #endDateInput').on('change', function() {
            validateDates();
        });

        // Real-time validation for select fields
        $('#type, #target_type').on('change', function() {
            const field = $(this);
            field.removeClass('is-invalid');
            const errorId = field.attr('id') + '-error';
            $('#' + errorId).hide();

            if (!field.val()) {
                field.addClass('is-invalid');
                $('#' + errorId).show();
            }
        });

        // Real-time validation for target selection
        $('#target_selection').on('change', function() {
            const field = $(this);
            field.removeClass('is-invalid');
            $('#target-selection-error').hide();

            if (!field.val() || field.val().length === 0) {
                field.addClass('is-invalid');
                $('#target-selection-error').show();
            }
        });

        // Initialize with old target type if exists
        const oldTargetType = @json(old('target_type'));
        if (oldTargetType) {
            $('#target_type').val(oldTargetType).trigger('change');
        }

        // Update status label on switch change
        $(document).on('change', '#status', function() {
            console.log($(this).is(':checked'));
            let label = $(this).is(':checked') ? '{{ __("messages.active") }}' : '{{ __("messages.inactive") }}';
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
</script>
@endpush
