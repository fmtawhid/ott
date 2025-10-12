@extends('setting::backend.setting.index')

@section('settings-content')
<div class="col-md-12 mb-3 d-flex justify-content-between">
    <h5><i class="fa-solid fa-database"></i> {{ __('setting_sidebar.lbl_storage') }}</h5>
</div>

<form method="POST" action="{{ route('backend.setting.store') }}" id="settings-form">
    @csrf

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="local">{{ __('settings.lbl_local_storage') }}</label>
            <input type="hidden" value="0" name="local">
            <div class="form-check form-switch m-0">
                <input class="form-check-input storage-checkbox" value="1" name="local" id="local" type="checkbox"
                    {{ old('local', $settings['local'] ?? 1) == 1 ? 'checked' : '' }} />
            </div>
        </div>
    </div>

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="s3">{{ __('settings.lbl_s3_storage') }}</label>
            <input type="hidden" value="0" name="s3">
            <div class="form-check form-switch m-0">
                <input class="form-check-input storage-checkbox" value="1" name="s3" id="s3" type="checkbox"
                    {{ old('s3', $settings['s3'] ?? 0) == 1 ? 'checked' : '' }} />
            </div>
        </div>
    </div>

    <div id="aws-s3-fields" style="display: none;">
        <div class="form-group">
            <label for="aws_access_key">{{ __('settings.lbl_aws_id') }} <span class="text-danger">*</span></label>
            <input type="text" name="aws_access_key" id="aws_access_key" class="form-control"
                value="{{ old('aws_access_key', $settings['aws_access_key'] ?? '') }}">
            <div class="invalid-feedback" id="aws_access_key_error">AWS Access Key is required.</div>
        </div>
        <div class="form-group">
            <label for="aws_secret_key">{{ __('settings.lbl_aws_secret_key') }} <span class="text-danger">*</span></label>
            <input type="text" name="aws_secret_key" id="aws_secret_key" class="form-control"
                value="{{ old('aws_secret_key', $settings['aws_secret_key'] ?? '') }}">
            <div class="invalid-feedback" id="aws_secret_key_error">AWS Secret Key is required.</div>
        </div>
        <div class="form-group">
            <label for="aws_region">{{ __('settings.lbl_aws_region') }} <span class="text-danger">*</span></label>
            <input type="text" name="aws_region" id="aws_region" class="form-control"
                value="{{ old('aws_region', $settings['aws_region'] ?? '') }}">
            <div class="invalid-feedback" id="aws_region_error">AWS Region is required.</div>
        </div>
        <div class="form-group">
            <label for="aws_bucket">{{ __('settings.lbl_aws_bucket') }} <span class="text-danger">*</span></label>
            <input type="text" name="aws_bucket" id="aws_bucket" class="form-control"
                value="{{ old('aws_bucket', $settings['aws_bucket'] ?? '') }}">
            <div class="invalid-feedback" id="aws_bucket_error">AWS Bucket is required.</div>
        </div>
        <div class="form-group">
            <label for="aws_path_style">{{ __('settings.lbl_aws_endpoint') }} <span class="text-danger">*</span></label>
            <select name="aws_path_style" id="aws_path_style" class="form-control">
                <option value="false" {{ old('aws_path_style', $settings['aws_path_style'] ?? 'false') == 'false' ? 'selected' : '' }}>False</option>
                <option value="true" {{ old('aws_path_style', $settings['aws_path_style'] ?? 'false') == 'true' ? 'selected' : '' }}>True</option>
            </select>
            <div class="invalid-feedback" id="aws_path_style_error">AWS Endpoint is required.</div>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
    </div>
</form>
@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const localCheckbox = document.getElementById('local');
    const s3Checkbox = document.getElementById('s3');
    const awsS3Fields = document.getElementById('aws-s3-fields');
    const awsAccessKey = document.getElementById('aws_access_key');
    const awsSecretKey = document.getElementById('aws_secret_key');
    const awsRegion = document.getElementById('aws_region');
    const awsBucket = document.getElementById('aws_bucket');
    const awsPathStyle = document.getElementById('aws_path_style');

    function updateStorageSettings() {
        if (s3Checkbox.checked) {
            awsS3Fields.style.display = 'block';
            awsAccessKey.setAttribute('required', 'required');
            awsSecretKey.setAttribute('required', 'required');
            awsRegion.setAttribute('required', 'required');
            awsBucket.setAttribute('required', 'required');
            awsPathStyle.setAttribute('required', 'required');
            validateFields();
        } else {
            awsS3Fields.style.display = 'none';
            awsAccessKey.removeAttribute('required');
            awsSecretKey.removeAttribute('required');
            awsRegion.removeAttribute('required');
            awsBucket.removeAttribute('required');
            awsPathStyle.removeAttribute('required');
            clearErrors();
        }
    }

    function handleCheckboxChange() {
        if (localCheckbox.checked) {
            s3Checkbox.checked = false;
            awsS3Fields.style.display = 'none';
            clearErrors();
        } else {
            s3Checkbox.checked = true; // Automatically check the S3 checkbox when Local is unchecked
        }
        updateStorageSettings();
    }

    function handleS3CheckboxChange() {
        if (s3Checkbox.checked) {
            localCheckbox.checked = false;
        } else {
            localCheckbox.checked = true; // Automatically check the Local checkbox when S3 is unchecked
        }
        updateStorageSettings();
    }
    function validateFields() {
        let isValid = true;

        function validateField(field, errorElementId) {
            const errorElement = document.getElementById(errorElementId);
            if (!field.value.trim()) {
                errorElement.style.display = 'block';
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                errorElement.style.display = 'none';
                field.classList.remove('is-invalid');
            }
        }

        validateField(awsAccessKey, 'aws_access_key_error');
        validateField(awsSecretKey, 'aws_secret_key_error');
        validateField(awsRegion, 'aws_region_error');
        validateField(awsBucket, 'aws_bucket_error');
        validateField(awsPathStyle, 'aws_path_style_error');

        return isValid;
    }

    function clearErrors() {
        ['aws_access_key_error', 'aws_secret_key_error', 'aws_region_error', 'aws_bucket_error', 'aws_path_style_error'].forEach(function(id) {
            document.getElementById(id).style.display = 'none';
        });
        [awsAccessKey, awsSecretKey, awsRegion, awsBucket, awsPathStyle].forEach(function(field) {
            field.classList.remove('is-invalid');
        });
    }

    updateStorageSettings();

    localCheckbox.addEventListener('change', handleCheckboxChange);
    s3Checkbox.addEventListener('change', handleS3CheckboxChange);

    [awsAccessKey, awsSecretKey, awsRegion, awsBucket, awsPathStyle].forEach(function(field) {
        field.addEventListener('blur', validateFields);
    });

    document.getElementById('settings-form').addEventListener('submit', function(event) {
        if (s3Checkbox.checked && !validateFields()) {
            event.preventDefault();
        }
    });
});
</script>

@endpush
