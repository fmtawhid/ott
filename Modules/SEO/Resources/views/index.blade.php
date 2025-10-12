@extends('setting::backend.setting.index')

@section('settings-content')

{{-- <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
    <h4 class="mb-0"><i class="fa-solid fa-search"></i>&nbsp;{{__('messages.lbl_seo_settings')}}</h4>
</div> --}}

<div class="d-flex align-items-center justify-content-between">
    <h4 class="mb-0"><i class="fa fa-search fa-lg mr-2"></i>&nbsp;{{__('messages.lbl_seo_settings')}}</h4>
   </div>

  {{ html()->form('POST' ,route('seo.store'))->attribute('enctype', 'multipart/form-data')
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open() }}
        @csrf

<div class="card">
    <div class="card-body">
        <div class="row gy-3">
            <!-- SEO Fields Section -->
            <div>
                <div class="row mb-3">
                    <!-- SEO Image -->
                     <input type="hidden" name="id" value="{{ $seo->id ?? '' }}">
                    <div class="col-md-4 position-relative">
                        
                        {{ html()->hidden('seo_image')->id('seo_image')->value(old('seo_image', $seoData['seo_image'] ?? '')) }}

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
                                ->class('form-control ' . ($errors->has('seo_image') ? 'is-invalid' : ''))
                                ->placeholder(__('placeholder.lbl_image'))
                                ->attribute('aria-label', 'SEO Image')
                                ->attribute('readonly', true)
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerSeo')
                                ->attribute('data-hidden-input', 'seo_image')
                            }}
                        </div>

                        {{-- 👇 Moved this outside input-group --}}
                        <div class="invalid-feedback mt-1" id="seo_image_error" style="display: none;">
                            SEO Image is required
                        </div>

                        <div class="uploaded-image mt-2" id="selectedImageContainerSeo">
                            <img id="selectedSeoImage"
                                src="{{ old('seo_image', $seoData['seo_image'] ?? '') }}"
                                alt="seo-image-preview"
                                class="img-fluid"
                                style="{{ old('seo_image', $seoData['seo_image'] ?? '') ? '' : 'display:none;' }}"
                            />
                        </div>

                        @error('seo_image')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
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
                            <div class="invalid-feedback" id="embed-error">Meta Title is required</div>
                        </div>



                         <div class="form-group mb-3">
                            {!! html()->label(__('messages.lbl_google_site_verification') . ' <span class="required">*</span>', 'google_site_verification')
                                    ->class('form-label')
                                    ->attribute('for', 'google_site_verification') !!}

                            <input type="text" name="google_site_verification" id="google_site_verification" class="form-control @error('google_site_verification') is-invalid @enderror"
                                   value="{{ old('google_site_verification', $seo->google_site_verification ?? '') }}" placeholder="{{ __('placeholder.lbl_google_site_verification') }}" required>
                            @error('google_site_verification')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="embed-error">Google Site Verification is required</div>
                        </div>
                    </div>

                    <!-- Meta Keywords + Canonical URL -->
                    <div class="col-md-4">


                    <div class="form-group mb-3">
                        {!! html()->label(__('messages.lbl_meta_keywords') . ' <span class="required">*</span>', 'meta_keywords_input')
                            ->class('form-label')
                            ->attribute('for', 'meta_keywords_input') !!}

                        <input type="text" id="meta_keywords_input"
                            class="form-control @error('meta_keywords') is-invalid @enderror"
                            placeholder="{{ __('placeholder.lbl_meta_keywords') }}"
                            value="{{ old('meta_keywords', $seo->meta_keywords ?? '') }}" />

                        <div class="invalid-feedback" id="meta_keywords_error" style="display: none;">
                            Meta Keywords are required
                        </div>

                        <div id="meta_keywords_hidden_inputs"></div>
                    </div>



                        <div class="form-group mb-3">
                            {!! html()->label(__('messages.lbl_canonical_url') . ' <span class="required">*</span>', 'canonical_url')
                                ->class('form-label')
                                ->attribute('for', 'canonical_url') !!}

                            <input type="text"
                                name="canonical_url"
                                id="canonical_url"
                                class="form-control @error('canonical_url') is-invalid @enderror"
                                value="{{ old('canonical_url', $seo->canonical_url ?? '') }}"
                                placeholder="{{ __('placeholder.lbl_canonical_url') }}"
                                required>
                            @error('canonical_url')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
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
                                maxlength="200" placeholder="{{ __('placeholder.lbl_short_description') }}" required>{{ old('short_description', $seo->short_description ?? '') }}</textarea>

                        @error('short_description')
                           <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
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

<script src="{{ asset('js/tagify.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/tagify.css') }}">



<script>

function validateSeoImage() {
    const seoImageValue = document.getElementById('seo_image').value.trim();
    const selectedSeoImage = document.getElementById('selectedSeoImage');
    const errorDiv = document.getElementById('seo_image_error');

    // Condition: No hidden value AND no visible image
    const noImageSelected = !seoImageValue && (!selectedSeoImage.src || selectedSeoImage.style.display === 'none');

    if (noImageSelected) {
        errorDiv.style.display = 'block';
        return false;
    } else {
        errorDiv.style.display = 'none';
        return true;
    }
}

document.getElementById('form-submit').addEventListener('submit', function (e) {
    let isValid = true;
    // SEO Image validation
    if (!validateSeoImage()) {
        e.preventDefault(); // stop form submit
    }
    // Meta Keywords validation
    const hiddenInputsContainer = document.getElementById('meta_keywords_hidden_inputs');
    const errorMsg = document.getElementById('meta_keywords_error');
    const tagifyInput = document.getElementById('meta_keywords_input');
    const tagifyWrapper = tagifyInput.closest('.tagify');

    const keywordInputs = hiddenInputsContainer.querySelectorAll('input[name="meta_keywords[]"]');

    if (tagifyInput.value === '') {
        if (keywordInputs.length === 0) {
            isValid = false;

            // Show error message
            errorMsg.style.display = 'block';

            // Add visual error indication to Tagify input
            if (tagifyWrapper) {
                tagifyWrapper.classList.add('is-invalid');
            }
        } else {
            const tagifyInputValue = tagifyInput.value;
            const keywordValues = tagifyInputValue.map(item => item.value);
            document.getElementById('meta_keywords_input').value = JSON.stringify(keywordValues);
            // Hide error if input is valid
            errorMsg.style.display = 'none';
            if (tagifyWrapper) {
                tagifyWrapper.classList.remove('is-invalid');
            }
        }
    }else {

        errorMsg.style.display = 'none';
        if (tagifyWrapper) {
            tagifyWrapper.classList.remove('is-invalid');
        }
    }

    if (!isValid) {
        e.preventDefault();
        e.stopPropagation();
    }
});



document.addEventListener("DOMContentLoaded", function () {
    // Meta Title & Description Count
    const metaTitleInput = document.getElementById('meta_title');
    const metaTitleCharCountDisplay = document.getElementById('meta-title-char-count');
    const metaDescriptionInput = document.getElementById('short_description');
    const metaDescriptionCharCountDisplay = document.getElementById('meta-description-char-count');

    function updateCharCount(inputField, charCountDisplay, limit) {
        const currentLength = inputField.value.length;
        charCountDisplay.textContent = `${currentLength}/${limit}`;
        charCountDisplay.style.color = currentLength > limit ? 'red' : 'green';
        inputField.addEventListener('input', function () {
            const currentLength = inputField.value.length;
            charCountDisplay.textContent = `${currentLength}/${limit}`;
            charCountDisplay.style.color = currentLength > limit ? 'red' : 'green';
        });
    }

    if (metaTitleInput && metaTitleCharCountDisplay) {
        updateCharCount(metaTitleInput, metaTitleCharCountDisplay, 100);
    }
    if (metaDescriptionInput && metaDescriptionCharCountDisplay) {
        updateCharCount(metaDescriptionInput, metaDescriptionCharCountDisplay, 200);
    }

    // Meta Keywords with Tagify
    const input = document.querySelector('#meta_keywords_input');
    const hiddenContainer = document.getElementById('meta_keywords_hidden_inputs');

    if (input) {
        const tagify = new Tagify(input, {
            delimiters: ",",
            dropdown: { enabled: 0 },
            transformTag: function (tagData) {
                return tagData.value;
            }
        });

        // Function to sync hidden inputs
        function syncHiddenInputs() {
            if (!hiddenContainer) return;
            hiddenContainer.innerHTML = '';
            tagify.value.forEach(item => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'meta_keywords[]';
                const keywordValue = typeof item === 'string' ? item : (item.value || item);
                hiddenInput.value = keywordValue;
                hiddenContainer.appendChild(hiddenInput);
            });
        }

        // Run once on page load so old values are included
        syncHiddenInputs();

        // Update on Tagify events
        tagify.on('add', syncHiddenInputs);
        tagify.on('remove', syncHiddenInputs);
        tagify.on('change', syncHiddenInputs);

        // Restore old values if validation failed previously
        @if (old('meta_keywords'))
            tagify.addTags(@json(old('meta_keywords')));
            syncHiddenInputs();
        @endif

        // Extra safety: ensure hidden inputs exist before form submit
        document.getElementById('form-submit').addEventListener('submit', function () {
            syncHiddenInputs();
        });
    }
});

</script>


<style>
    .required {
                color: red;
            }


</style>

@endpush
