@extends('backend.layouts.app')
@section('content')
<x-back-button-component route="backend.plans.index" />
{{ html()->form('POST' ,route('backend.plans.store'))
->attribute('data-toggle', 'validator')
->attribute('id', 'form-submit')  // Add the id attribute here
->class('requires-validation')  // Add the requires-validation class
->attribute('novalidate', 'novalidate')  // Disable default browser validation
->open()
}}
    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('plan.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                    {{ html()->text('name')
                                ->attribute('value', old('name'))  ->placeholder(__('placeholder.lbl_plan_name'))
                                ->class('form-control')
                                ->attribute('required','required')
                            }}
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Name field is required</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('plan.lbl_duration') . '<span class="text-danger">*</span>', 'duration')->class('form-label') }}
                        {{
                            html()->select('duration', [
                                    '' => __('messages.lbl_select_duration'),
                                    'week' => 'Week',
                                    'month' => 'Month',
                                    'year' => 'Year'
                                ], old('duration'))
                                ->class('form-control select2')
                                ->id('duration')
                                ->attribute('placeholder', __('placeholder.lbl_plan_duration_type'))
                                ->attribute('required','required')
                        }}
                    @error('duration')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Duration field is required</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('plan.lbl_duration_value') . '<span class="text-danger">*</span>', 'duration_value')->class('form-label') }}
                    {{
                            html()->input('number', 'duration_value', old('duration_value'))
                                ->class('form-control')
                                ->id('duration_value')
                                ->attribute('placeholder', __('placeholder.lbl_plan_duration_value'))
                                ->attribute('oninput', "this.value = Math.abs(this.value)")
                                ->attribute('required','required')
                        }}
                    @error('duration_value')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Duration Value field is required</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('plan.lbl_amount') . '<span class="text-danger">*</span>', 'price')->class('form-label') }}
                    {{
                        html()->input('number', 'price', old('price'))
                            ->class('form-control')
                            ->id('price')
                            ->attribute('step', '0.01')
                            ->attribute('placeholder', __('placeholder.lbl_plan_price'))
                            ->attribute('oninput', "this.value = Math.abs(this.value)")
                            ->attribute('required','required')
                    }}
                    @error('price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Price field is required</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('plan.lbl_discount'), 'discount')->class('form-label') }}
                    <div class="d-flex align-items-center justify-content-between form-control">
                        {{ html()->label(__('messages.active'), 'discount')->class('form-label mb-0 text-body') }}
                        <div class="form-check form-switch">
                            {{ html()->hidden('discount', 0) }}
                            {{
                                html()->checkbox('discount',old('discount', false))
                                    ->class('form-check-input')
                                    ->id('discount-toggle')
                            }}
                        </div>
                        @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if($purchaseMethodEnabled)
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.lbl_android_identifier') . '<span class="text-danger">*</span>', 'android_identifier')->class('form-label') }}
                        {{
                            html()->text('android_identifier', old('android_identifier'))
                                ->class('form-control')
                                ->id('android_identifier')
                                ->attribute('placeholder', __('messages.lbl_android_identifier'))
                                ->attribute('required','required')
                        }}
                    @error('android_identifier')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="android_identifier-error">Android Identifier field is required</div>
                </div>

                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('messages.lbl_apple_identifier') . '<span class="text-danger">*</span>', 'apple_identifier')->class('form-label') }}
                        {{
                            html()->text('apple_identifier', old('apple_identifier'))
                                ->class('form-control')
                                ->id('apple_identifier')
                                ->attribute('placeholder', __('messages.lbl_apple_identifier'))
                                ->attribute('required','required')
                        }}
                    @error('apple_identifier')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="apple_identifier-error">Apple Identifier field is required</div>
                </div>
                @endif

                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                    <div class="d-flex align-items-center justify-content-between form-control">
                        {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                        <div class="form-check form-switch">
                            {{ html()->hidden('status', 1) }}
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

                <!-- Discount Percentage (shown when discount is enabled) -->
                <div class="col-md-6 col-lg-4 d-none" id="discountPercentageSection">
                    {{ html()->label(__('plan.lbl_discount_percentage') . '<span class="text-danger">*</span>', 'discount_percentage')->class('form-label') }}
                    {{
                        html()->input('number', 'discount_percentage', old('discount_percentage'))
                            ->class('form-control')
                            ->id('discount_percentage')
                            ->attribute('min', '0')
                            ->attribute('max', '99')
                            ->attribute('placeholder', __('plan.enter_discount_percentage'))
                    }}
                    @error('discount_percentage')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="discount-error">Discount percentage is required</div>
                    <div class="invalid-feedback" id="discount-max-error" style="display: none;"> Discount percentage cannot exceed 99% and must be a positive number</div>
                </div>

                <!-- Total Price (automatically calculated) -->
                <div class="col-md-6 col-lg-4 d-none" id="totalPriceSection">
                    {{ html()->label(__('plan.lbl_total_price'), 'total_price')->class('form-label') }}
                    {{
                        html()->input('number', 'total_price', old('total_price'))
                            ->class('form-control')
                            ->id('total_price')
                            ->attribute('step', '0.01')
                            ->attribute('placeholder', __('plan.lbl_total_price'))
                            ->attribute('readonly', 'readonly')
                    }}
                    @error('total_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="total-price-error">Total price field is required</div>
                </div>

                <div class="col-md-12">
                    {{ html()->label(__('plan.lbl_description') . '<span class="text-danger">*</span>', 'description')->class('form-label') }}
                    {{ html()->textarea('description')
                                ->attribute('value', old('description'))  ->placeholder(__('placeholder.lbl_plan_limit_description'))
                                ->class('form-control')
                                ->attribute('required','required')
                            }}
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="desc-error">Description field is required</div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($planLimits))
        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('plan.lbl_plan_limits') }}</h5>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                @foreach($planLimits as $planLimit)
                    <div class="col-md-6">
                        <label for="{{ $planLimit->slug }}" class="form-label">{{ $planLimit->title }}</label>
                        <div class="d-flex align-items-center justify-content-between form-control">
                            <label for="{{ $planLimit->slug }}" class="form-label mb-0 text-body">{{ __('messages.lbl_on') }}</label>
                            <div class="form-check form-switch ">
                                <input type="hidden" name="limits[{{ $planLimit->id }}][planlimitation_id]" value="{{ $planLimit->id }}">
                                <input type="hidden" name="limits[{{ $planLimit->id }}][limitation_slug]" value="{{ $planLimit->slug }}">
                                <input type="hidden" name="limits[{{ $planLimit->id }}][value]" value="0">
                                <input type="checkbox" name="limits[{{ $planLimit->id }}][value]" id="{{ $planLimit->slug }}" class="form-check-input" value="1" {{ old($planLimit->slug, false) ? 'checked' : '' }} onchange="toggleQualitySection()">
                            </div>
                            @error($planLimit->slug )
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if($planLimit->slug=='device-limit')
                            <div class="col-md-6 d-none" id="deviceLimitInput">
                                {{ html()->label(__('plan.lbl_device_limit'), 'device_limit_value')->class('form-label') }}
                                {{
                                    html()->input('number', 'device_limit_value', old('device_limit_value'))
                                        ->class('form-control')
                                        ->id('device_limit_value')
                                        ->attribute('placeholder', __('placeholder.lbl_device_limit'))
                                        ->attribute('value', '0')
                                        ->attribute('min', '1')
                                }}
                                @error('device_limit_value')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Device Limit field is required</div>
                            </div>
                    @endif

                    @if($planLimit->slug=='profile-limit')
                    <div class="col-md-6 d-none" id="profileLimitInput">
                        {{ html()->label(__('plan.lbl_profile_limit'), 'profile_limit_value')->class('form-label') }}
                        {{
                            html()->input('number', 'profile_limit_value', old('profile_limit_value'))
                                ->class('form-control')
                                ->id('profile_limit_value')
                                ->attribute('placeholder', __('placeholder.lbl_device_limit'))
                                ->attribute('value', '0')
                                ->attribute('min', '1')
                        }}
                        @error('profile_limit_value')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Profile Limit field is required</div>
                    </div>
                @endif

                    @if($planLimit->slug=='download-status')
                        <div class="row gy-4 d-none" id="DownloadStatus">

                            <label class="form-label">{{ __('messages.lbl_quality_option') }}</label>

                            @foreach($downloadoptions as $option)
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center justify-content-between form-control">
                                        <label for="{{ $option->value }}" class="form-label mb-0">{{ $option->name }}</label>
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="download_options[{{ $option->value }}]" value="0">
                                            <input type="checkbox" name="download_options[{{ $option->value }}]" id="{{ $option->value }}" class="form-check-input" value="1" {{ old($option->value, false) ? 'checked' : '' }} onchange="toggleQualitySection()">
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    @endif
                    @if($planLimit->slug == 'supported-device-type')
                        <div class="col-md-6 d-none" id="supportedDeviceTypeInput">
                            <label class="form-label">{{ __('plan.lbl_supported_device_type_options') }}</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach(['tablet', 'laptop', 'mobile','tv'] as $option)
                                    <div class="form-check form-check-inline">
                                        <input type="hidden" name="supported_device_types[{{ $option }}]" value="0">
                                        <input type="checkbox" name="supported_device_types[{{ $option }}]" id="{{ $option }}" value="1" {{ old('supported_device_types.'.$option, false) ? 'checked' : '' }} class="form-check-input">
                                        <label for="{{ $option }}">{{ ucfirst($option) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">

        {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
    </div>
{{ html()->form()->close() }}

@endsection
@push('after-scripts')
      <script>

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

          function toggleQualitySection() {

             var enableQualityCheckbox = document.getElementById('device-limit');
             var enableQualitySection = document.getElementById('deviceLimitInput');
             const deviceLimitInput = document.getElementById('device_limit_value');
             if (enableQualityCheckbox.checked) {

              enableQualitySection.classList.remove('d-none');
              deviceLimitInput.setAttribute('min', '1');
             } else {

               enableQualitySection.classList.add('d-none');
               deviceLimitInput.removeAttribute('min');
             }
             }
             document.addEventListener('DOMContentLoaded', function () {
             toggleQualitySection();
        });

        function toggleDownloadSection() {


            var enableDownloadCheckbox = document.getElementById('download-status');
            var enableDownloadSection = document.getElementById('DownloadStatus');

            if (enableDownloadCheckbox.checked) {
                enableDownloadSection.classList.remove('d-none');
            } else {
                enableDownloadSection.classList.add('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var enableDownloadCheckbox = document.getElementById('download-status');

              toggleDownloadSection();

            enableDownloadCheckbox.addEventListener('change', toggleDownloadSection);
        });

        function toggleSupportedDeviceTypeSection() {
            const checkbox = document.getElementById('supported-device-type');
            const section = document.getElementById('supportedDeviceTypeInput');

            if (checkbox.checked) {
                section.classList.remove('d-none');
            } else {
                section.classList.add('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('supported-device-type');

            toggleSupportedDeviceTypeSection();

            checkbox.addEventListener('change', toggleSupportedDeviceTypeSection);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const discountToggle = document.getElementById('discount-toggle');
            const discountPercentageSection = document.getElementById('discountPercentageSection');
            const totalPriceSection = document.getElementById('totalPriceSection');
            const priceInput = document.getElementById('price');
            const discountPercentageInput = document.getElementById('discount_percentage');
            const totalPriceInput = document.getElementById('total_price');
            const discountError = document.getElementById('discount-error');
            const discountMaxError = document.getElementById('discount-max-error');
            const submitButton = document.getElementById('submit-button');
            const form = document.querySelector('form');

            function toggleDiscountFields() {
                if (discountToggle.checked) {
                    discountPercentageSection.classList.remove('d-none');
                    totalPriceSection.classList.remove('d-none');
                    discountPercentageInput.setAttribute('required', 'required');
                } else {
                    discountPercentageSection.classList.add('d-none');
                    totalPriceSection.classList.add('d-none');
                    discountPercentageInput.removeAttribute('required');
                    discountPercentageInput.value = ''; // Clear the discount percentage input
                    totalPriceInput.value = priceInput.value; // Set total price to the original price
                    hideValidationErrors();
                }
            }

            function calculateTotalPrice() {
                const price = parseFloat(priceInput.value) || 0;
                const discountPercentage = parseFloat(discountPercentageInput.value);

                hideValidationErrors(); // Clear validation errors before checking

                if (discountToggle.checked) {
                    // Check if discount percentage is empty
                    if (isNaN(discountPercentageInput.value) || discountPercentageInput.value.trim() === '') {
                        discountError.style.display = 'block'; // Show required error
                        return false; // Prevent further calculation and return false
                    }

                    // Check for negative or invalid discount percentage
                    if (discountPercentage < 0 || discountPercentage > 99) {
                        discountMaxError.style.display = 'block'; // Show validation error for exceeding limit or negative values
                        return false; // Prevent further calculation and return false
                    }

                    // Calculate the total price if discount is valid
                    if (discountPercentage >= 0 && discountPercentage <= 99) {
                        const discountAmount = price * (discountPercentage / 100);
                        const totalPrice = price - discountAmount;
                        totalPriceInput.value = totalPrice.toFixed(2);
                    } else {
                        totalPriceInput.value = price.toFixed(2);
                    }
                } else {
                    totalPriceInput.value = price.toFixed(2);
                }

                return true; // Valid case returns true
            }

            function hideValidationErrors() {
                discountError.style.display = 'none';
                discountMaxError.style.display = 'none';
            }

            // Add validation on submit button click
            submitButton.addEventListener('click', function (event) {
                const isValid = calculateTotalPrice();

                if (!isValid) {
                    event.preventDefault(); // Prevent form submission if validation fails
                }
            });

            discountToggle.addEventListener('change', toggleDiscountFields);
            discountPercentageInput.addEventListener('input', calculateTotalPrice);
            priceInput.addEventListener('input', calculateTotalPrice);

            toggleDiscountFields();
        });

        function toggleProfileSection() {
        var enableProfileCheckbox = document.getElementById('profile-limit');
        var enableProfileSection = document.getElementById('profileLimitInput');
        const profileLimitInput = document.getElementById('profile_limit_value');
            if (enableProfileCheckbox.checked) {
                enableProfileSection.classList.remove('d-none');
                profileLimitInput.setAttribute('min', '1');
                profileLimitInput.setAttribute('required', 'required');
            } else {
                enableProfileSection.classList.add('d-none');
                profileLimitInput.removeAttribute('min');
                profileLimitInput.removeAttribute('required');

            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleProfileSection();
        });

        document.getElementById('profile-limit').addEventListener('change', toggleProfileSection);

   </script>
@endpush


