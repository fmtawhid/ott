@extends('backend.layouts.app')
@section('content')
<x-back-button-component route="backend.plans.index" />
{{ html()->form('PUT' ,route('backend.plans.update', $data->id))
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
                                ->attribute('value', $data->name)  ->placeholder(__('placeholder.lbl_plan_name'))
                                ->class('form-control')
                                ->attribute('required','required')
                            }}
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Name field is required</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('plan.lbl_level') . '<span class="text-danger">*</span>', 'level')->class('form-label') }}
                    {{
                    html()->select('level',
                        isset($plan) && $plan > 0
                            ? collect(range(1, $plan + 1))->mapWithKeys(fn($i) => [$i => 'Level ' . $i])->prepend(__('Select Level'), '')->toArray()
                            : ['1' => 'Level 1'],
                        old('level', $data->level ?? '')
                    )->class('form-control select2')->id('level')->attribute('placeholder', __('placeholder.lbl_plan_level'))->attribute('required','required')
                    }}
                    @error('level')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Level field is required</div>
                </div>
                <div class="col-md-6 col-lg-4">
                    {{ html()->label(__('plan.lbl_duration') . '<span class="text-danger">*</span>', 'duration')->class('form-label') }}
                    {{
                                html()->select('duration', [
                                        '' => __('messages.lbl_select_duration'),
                                        'week' => 'Week',
                                        'month' => 'Month',
                                        'year' => 'Year'
                                    ], $data->duration)
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
                            html()->input('number', 'duration_value', $data->duration_value)
                                ->class('form-control')
                                ->id('duration_value')
                                ->attribute('placeholder', __('placeholder.lbl_plan_duration_value'))
                                ->attribute('oninput', "this.value = Math.abs(this.value)")
                                // ->attribute('min', '1')
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
                        html()->input('number', 'price', $data->price)
                            ->class('form-control')
                            ->id('price')
                            ->attribute('step', '1')
                            ->attribute('placeholder', __('placeholder.lbl_plan_price'))
                            ->attribute('oninput', "this.value = Math.abs(this.value)")
                            // ->attribute('min', '0')
                            ->attribute('required','required')
                    }}
                    @error('price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Price field is required</div>
                </div>
                <!-- Discount Toggle -->
            <div class="col-md-6 col-lg-4">
                {{ html()->label(__('plan.lbl_discount'), 'discount')->class('form-label') }}
                <div class="d-flex align-items-center justify-content-between form-control">
                    {{ html()->label(__('messages.active'), 'discount')->class('form-label mb-0 text-body') }}
                    <div class="form-check form-switch">
                        {{ html()->hidden('discount', 0) }}
                        {{
                            html()->checkbox('discount', old('discount', $data->discount))
                                ->class('form-check-input')
                                ->id('discount-toggle')
                        }}
                    </div>
                </div>
                @error('discount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @if($purchaseMethodEnabled)

            <div class="col-md-6 col-lg-4">
                {{ html()->label(__('messages.lbl_android_identifier') . '<span class="text-danger">*</span>', 'android_identifier')->class('form-label') }}
                    {{
                        html()->text('android_identifier', old('android_identifier', $data->android_identifier ?? ''))
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
                        html()->text('apple_identifier', old('apple_identifier', $data->apple_identifier ?? ''))
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
                <div class="d-flex justify-content-between align-items-center form-control">
                    {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                    <div class="form-check form-switch">
                        {{ html()->hidden('status', 0) }}
                        {{
                                html()->checkbox('status',$data->status )
                                    ->class('form-check-input')
                                    ->id('status')
                            }}
                    </div>
                </div>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6 col-lg-4 discount-section {{ $data->discount ? '' : 'd-none' }}" id="discountPercentageSection">
                {{ html()->label(__('plan.lbl_discount_percentage') . '<span class="text-danger">*</span>', 'discount_percentage')->class('form-label') }}
                {{
                    html()->input('number', 'discount_percentage', old('discount_percentage', $data->discount_percentage ?? 0))
                        ->class('form-control')
                        ->id('discount_percentage')
                        ->attribute('min', '0')
                        ->attribute('max', '99')
                        ->attribute('placeholder', __('plan.enter_discount_percentage'))
                }}
                @error('discount_percentage')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div id="discount-error" class="invalid-feedback" style="display: none;">Discount percentage is required</div>
                <div id="discount-max-error" class="invalid-feedback" style="display: none;">Discount percentage cannot exceed 99%  and must be a positive number.</div>
            </div>

            <div class="col-md-6 col-lg-4 discount-section {{ $data->discount ? '' : 'd-none' }}" id="totalPriceSection">
                {{ html()->label(__('plan.lbl_total_price'), 'total_price')->class('form-label') }}
                {{
                    html()->input('number', 'total_price', old('total_price', $data->total_price))
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
                    {{ html()->textarea('description', $data->description)
                                ->placeholder(__('placeholder.lbl_plan_limit_description'))
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
                    <div class="col-md-6 ">
                        <label for="{{ $planLimit->limitation_slug }}" class="form-label">{{ $planLimit->limitation_data->title ?? '' }}</label>
                        <div class="d-flex align-items-center justify-content-between form-control">
                            <label for="{{ $planLimit->limitation_slug }}" class="form-label mb-0 text-body">{{ __('messages.lbl_on') }}</label>

                            <div class="form-check form-switch">
                                <input type="hidden" name="limits[{{ $planLimit->id }}][planlimitation_id]" value="{{ $planLimit->planlimitation_id }}">
                                <input type="hidden" name="limits[{{ $planLimit->id }}][limitation_slug]" value="{{ $planLimit->limitation_slug }}">
                                <input type="hidden" name="limits[{{ $planLimit->id }}][value]" value="0">
                                <input type="checkbox" name="limits[{{ $planLimit->id }}][value]" id="{{ $planLimit->limitation_slug }}" class="form-check-input" value="1" {{ old("limits.{$planLimit->id}.value", $planLimit->limitation_value) ? 'checked' : '' }} onchange="toggleQualitySection()">
                            </div>
                        </div>
                        @error("limits.{$planLimit->id}.value")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>


                    @if($planLimit->limitation_slug == 'device-limit')
                        <div class="col-md-6" id="deviceLimitInput">
                            {{ html()->label(__('plan.lbl_device_limit'), 'device_limit_value')->class('form-label') }}
                            {{
                                html()->input('number', 'device_limit_value', old('device_limit_value', $planLimit->limit))
                                    ->class('form-control')
                                    ->id('device_limit_value')
                                    ->attribute('placeholder', __('placeholder.lbl_device_limit'))
                                    ->attribute('value', $planLimit->limit ?? '0')
                            }}
                            @error('device_limit_value')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="device-limit-error">Device Limit field is required</div>
                        </div>
                    @endif

                    @if($planLimit->limitation_slug == 'download-status')
                     <div class="row gy-4 d-none" id="DownloadStatus">
                        <label class="form-label">{{ __('messages.lbl_quality_option') }}</label>
                        @php
                            $downloadOptions = json_decode($planLimit->limit, true) ?? [];
                        @endphp
                        @foreach($downloadoptions as $option)
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-between form-control">
                                <label for="{{ $option->value }}" class="form-label">{{ $option->name }}</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="download_options[{{ $option->value }}]" value="0">
                                    <input type="checkbox" name="download_options[{{ $option->value }}]" id="{{ $option->value }}" class="form-check-input" value="1" {{ (isset($downloadOptions[$option->value]) && $downloadOptions[$option->value] == "1") ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

                @if($planLimit->limitation_slug == 'profile-limit')
                    <div class="col-md-6" id="profileLimitInput">
                        {{ html()->label(__('plan.lbl_profile_limit'), 'profile_limit_value')->class('form-label') }}
                        {{
                            html()->input('number', 'profile_limit_value', old('profile_limit_value', $planLimit->limit))
                                ->class('form-control')
                                ->id('profile_limit_value')
                                ->attribute('placeholder', __('placeholder.lbl_device_limit'))
                                ->attribute('value', $planLimit->limit ?? '0')
                        }}
                        @error('profile_limit_value')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="profile-limit-error">Profile Limit field is required</div>
                    </div>
                @endif

               @if($planLimit->limitation_slug =='supported-device-type')
                    <div class="col-md-6" id="supportedDeviceTypeInput">
                        <label class="form-label">{{ __('plan.lbl_supported_device_type_options') }}</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['tablet', 'laptop', 'mobile','tv'] as $option)
                                <div class="form-check form-check-inline">
                                    <input type="hidden" name="supported_device_types[{{ $option }}]" value="0">
                                    <input type="checkbox" name="supported_device_types[{{ $option }}]" id="{{ $option }}" value="1" {{ isset($limits['supported-device-type'][$option]) && $limits['supported-device-type'][$option] ? 'checked' : '' }} class="form-check-input">
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
              deviceLimitInput.setAttribute('required', 'required');
             } else {

               enableQualitySection.classList.add('d-none');
               deviceLimitInput.removeAttribute('min');
               deviceLimitInput.removeAttribute('required');
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

            if (checkbox && checkbox.checked) {
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


        $(document).ready(function() {
            const $discountToggle = $('#discount-toggle');
            const $discountPercentageSection = $('#discountPercentageSection');
            const $totalPriceSection = $('#totalPriceSection');
            const $discountPercentageInput = $('#discount_percentage');
            const $priceInput = $('#price');
            const $totalPriceInput = $('#total_price');
            const $form = $('#form-submit');
            const $discountError = $('#discount-error'); // Error for invalid percentage
            const $discountMaxError = $('#discount-max-error'); // Error for max percentage

            function updateSections() {
                const price = parseFloat($priceInput.val()) || 0;

                if ($discountToggle.is(':checked')) {
                    $discountPercentageSection.removeClass('d-none');
                    $totalPriceSection.removeClass('d-none');
                    $discountPercentageInput.prop('required', true);
                } else {
                    $discountPercentageSection.addClass('d-none');
                    $totalPriceSection.addClass('d-none');
                    $discountPercentageInput.prop('required', false);

                    $discountPercentageInput.val(0);  // Set discount to 0 when off
                    $totalPriceInput.val(price.toFixed(2)); // Reset total price to match price when discount is off
                }
            }

            $discountToggle.change(updateSections);
            updateSections();

            $discountPercentageInput.on('input', function() {
                const price = parseFloat($priceInput.val()) || 0;
                let discountPercentage = parseFloat($(this).val()) || 0;

                // Prevent negative input
                if (discountPercentage < 0) {
                    $(this).val(0);
                    discountPercentage = 0;
                }

                // Check if discount exceeds 99%
                if (discountPercentage > 99) {
                    discountPercentage = 0;
                    $(this).val(discountPercentage);
                    $discountMaxError.show();
                } else {
                    $discountMaxError.hide();
                }

                // Validate if discount percentage is empty or less than 1
                if (discountPercentage < 1 && discountPercentage > 0) {
                    $(this).addClass('is-invalid');
                    $discountError.show();
                } else {
                    $(this).removeClass('is-invalid'); // Remove invalid class if valid
                    $discountError.hide(); // Hide validation message
                }

                const discountAmount = (price * discountPercentage) / 100;
                const totalPrice = price - discountAmount;
                $totalPriceInput.val(totalPrice.toFixed(2));
            });

            $form.on('submit', function(e) {
                // Check if discount is active and percentage is empty
                if ($discountToggle.is(':checked') && !$discountPercentageInput.val()) {
                    e.preventDefault();
                    $discountError.show();
                }
            });

            // Handle price input change to recalculate total price if discount is active
            $priceInput.on('input', function() {
                const price = parseFloat($(this).val()) || 0;
                const discountPercentage = parseFloat($discountPercentageInput.val()) || 0;
                const discountAmount = (price * discountPercentage) / 100;
                const totalPrice = $discountToggle.is(':checked') ? (price - discountAmount) : price;
                $totalPriceInput.val(totalPrice.toFixed(2));
            });
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

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form-submit');
            const deviceLimitInput = document.getElementById('device_limit_value');
            const deviceLimitError = document.getElementById('device-limit-error');
            const submitButton = document.getElementById('submit-button');

            form.addEventListener('submit', function(e) {
                if (deviceLimitInput && deviceLimitInput.hasAttribute('required')) {
                    const value = parseInt(deviceLimitInput.value);

                    if (isNaN(value) || value < 1) {
                        e.preventDefault();
                        deviceLimitInput.classList.add('is-invalid');
                        deviceLimitError.style.display = 'block';
                        submitButton.disabled = false;
                        return false;
                    } else {
                        deviceLimitInput.classList.remove('is-invalid');
                        deviceLimitError.style.display = 'none';
                    }
                }
            });


            deviceLimitInput.addEventListener('input', function() {
                const value = parseInt(this.value);
                if (this.hasAttribute('required')) {
                    if (isNaN(value) || value < 1) {
                        this.classList.add('is-invalid');
                        deviceLimitError.style.display = 'block';
                    } else {
                        this.classList.remove('is-invalid');
                        deviceLimitError.style.display = 'none';
                    }
                }
            });


            deviceLimitInput.addEventListener('keypress', function(e) {
                if (e.key === '-' || e.key === '+') {
                    e.preventDefault();
                }
            });
        });
   </script>

@endpush
