@extends('setting::backend.setting.index')

@section('settings-content')
<form method="POST" action="{{ route('backend.setting.store') }}">
    @csrf
    <div>
        <h3><i class="fa-solid fa-sliders"></i> {{ __('setting_sidebar.lbl_integration') }} </h3>
    </div>

    {{-- Google Login --}}
    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="is_google_login">{{ __('setting_integration_page.lbl_google_login') }}</label>
            <input type="hidden" value="0" name="is_google_login">
            <div class="form-check form-switch m-0">
                <input class="form-check-input toggle-input" data-toggle-target="#google-key-field" value="1" name="is_google_login" id="is_google_login" type="checkbox" {{ old('is_google_login', $data['is_google_login'] ?? 0) == 1 ? 'checked' : '' }} />
            </div>
        </div>
    </div>
    <div id="google-key-field" class="{{ old('is_google_login', $data['is_google_login'] ?? 0) == 1 ? '' : 'd-none' }}">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="google_secretkey" id="google_secretkey" class="form-control @error('google_secretkey') is-invalid @enderror" value="{{ old('google_secretkey', $data['google_secretkey'] ?? '') }}" placeholder="{{ __('setting_integration_page.lbl_secret_key') }}" {{ old('is_google_login', $data['is_google_login'] ?? 0) == 1 ? '' : 'disabled' }}>
                @error('google_secretkey')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <input type="text" name="google_publickey" id="google_publickey" class="form-control @error('google_publickey') is-invalid @enderror" value="{{ old('google_publickey', $data['google_publickey'] ?? '') }}" placeholder="{{ __('setting_integration_page.lbl_public_key') }}" {{ old('is_google_login', $data['is_google_login'] ?? 0) == 1 ? '' : 'disabled' }}>
                @error('google_publickey')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    {{-- OneSignal Notification --}}
    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="is_one_signal_notification">OneSignal Notification</label>
            <input type="hidden" value="0" name="is_one_signal_notification">
            <div class="form-check form-switch m-0">
                <input class="form-check-input toggle-input" data-toggle-target="#oneSignalSection" value="1" name="is_one_signal_notification" id="is_one_signal_notification" type="checkbox" {{ old('is_one_signal_notification', $data['is_one_signal_notification'] ?? 0) == 1 ? 'checked' : '' }} />
            </div>
        </div>
    </div>
    <div id="oneSignalSection" class="{{ old('is_one_signal_notification', $data['is_one_signal_notification'] ?? 0) == 1 ? '' : 'd-none' }}">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control @error('onesignal_app_id') is-invalid @enderror" name="onesignal_app_id" id="onesignal_app_id" value="{{ old('onesignal_app_id', $data['onesignal_app_id'] ?? '') }}" placeholder="OneSignal App ID" {{ old('is_one_signal_notification', $data['is_one_signal_notification'] ?? 0) == 1 ? '' : 'disabled' }}>
                @error('onesignal_app_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control @error('onesignal_rest_api_key') is-invalid @enderror" name="onesignal_rest_api_key" id="onesignal_rest_api_key" value="{{ old('onesignal_rest_api_key', $data['onesignal_rest_api_key'] ?? '') }}" placeholder="OneSignal REST API Key" {{ old('is_one_signal_notification', $data['is_one_signal_notification'] ?? 0) == 1 ? '' : 'disabled' }}>
                @error('onesignal_rest_api_key')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control @error('onesignal_channel_id') is-invalid @enderror" name="onesignal_channel_id" id="onesignal_channel_id" value="{{ old('onesignal_channel_id', $data['onesignal_channel_id'] ?? '') }}" placeholder="OneSignal Channel ID" {{ old('is_one_signal_notification', $data['is_one_signal_notification'] ?? 0) == 1 ? '' : 'disabled' }}>
                @error('onesignal_channel_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    {{-- Custom Webhook Notification --}}
    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="is_custom_webhook_notification">Custom Webhook Notification</label>
            <input type="hidden" value="0" name="is_custom_webhook_notification">
            <div class="form-check form-switch m-0">
                <input class="form-check-input toggle-input" data-toggle-target="#customWebhookSection" value="1" name="is_custom_webhook_notification" id="is_custom_webhook_notification" type="checkbox" {{ old('is_custom_webhook_notification', $data['is_custom_webhook_notification'] ?? 0) == 1 ? 'checked' : '' }} />
            </div>
        </div>
    </div>
    <div id="customWebhookSection" class="{{ old('is_custom_webhook_notification', $data['is_custom_webhook_notification'] ?? 0) == 1 ? '' : 'd-none' }}">
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control @error('custom_webhook_content_key') is-invalid @enderror" name="custom_webhook_content_key" id="custom_webhook_content_key" value="{{ old('custom_webhook_content_key', $data['custom_webhook_content_key'] ?? '') }}" placeholder="Custom Webhook Content Key" {{ old('is_custom_webhook_notification', $data['is_custom_webhook_notification'] ?? 0) == 1 ? '' : 'disabled' }}>
                @error('custom_webhook_content_key')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control @error('custom_webhook_url') is-invalid @enderror" name="custom_webhook_url" id="custom_webhook_url" value="{{ old('custom_webhook_url', $data['custom_webhook_url'] ?? '') }}" placeholder="Custom Webhook URL" {{ old('is_custom_webhook_notification', $data['is_custom_webhook_notification'] ?? 0) == 1 ? '' : 'disabled' }}>
                @error('custom_webhook_url')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    {{-- Google Map Key --}}
    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="is_map_key">Google Map Key</label>
            <input type="hidden" value="0" name="is_map_key">
            <div class="form-check form-switch m-0">
                <input class="form-check-input toggle-input" data-toggle-target="#googleMapSection" value="1" name="is_map_key" id="is_map_key" type="checkbox" {{ old('is_map_key', $data['is_map_key'] ?? 0) == 1 ? 'checked' : '' }} />
            </div>
        </div>
    </div>
    <div id="googleMapSection" class="{{ old('is_map_key', $data['is_map_key'] ?? 0) == 1 ? '' : 'd-none' }}">
        <input type="text" class="form-control @error('google_maps_key') is-invalid @enderror" name="google_maps_key" id="google_maps_key" value="{{ old('google_maps_key', $data['google_maps_key'] ?? '') }}" placeholder="Google Maps Key" {{ old('is_map_key', $data['is_map_key'] ?? 0)== 1 ? '' : 'disabled' }}>
        @error('google_maps_key')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
        {{-- Application Links --}}
<div class="form-group border-bottom pb-3">
    <div class="d-flex justify-content-between align-items-center">
        <label class="form-label m-0" for="is_application_link">Application Links</label>
        <input type="hidden" value="0" name="is_application_link">
        <div class="form-check form-switch m-0">
            <input class="form-check-input toggle-input" data-toggle-target="#applicationLinksSection" value="1" name="is_application_link" id="is_application_link" type="checkbox" {{ old('is_application_link', $data['is_application_link'] ?? 0) == 1 ? 'checked' : '' }} />
        </div>
    </div>
</div>
<div id="applicationLinksSection" class="{{ old('is_application_link', $data['is_application_link'] ?? 0) == 1 ? '' : 'd-none' }}">
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control @error('customer_app_app_store') is-invalid @enderror" name="customer_app_app_store" id="ios_url" value="{{ old('customer_app_app_store', $data['customer_app_app_store'] ?? '') }}" placeholder="iOS URL" {{ old('is_application_link', $data['is_application_link'] ?? 0) == 1 ? '' : 'disabled' }}>
            @error('customer_app_app_store')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control @error('customer_app_play_store') is-invalid @enderror" name="customer_app_play_store" id="android_url" value="{{ old('android_url', $data['customer_app_play_store'] ?? '') }}" placeholder="Android URL" {{ old('is_application_link', $data['is_application_link'] ?? 0) == 1 ? '' : 'disabled' }}>
            @error('customer_app_play_store')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<!-- Force Update for Customer App Section -->
<div class="form-group border-bottom pb-3">
    <div class="d-flex justify-content-between align-items-center">
        <label class="form-label m-0" for="isForceUpdate">Force Update for Customer App</label>
        <input type="hidden" value="0" name="isForceUpdate">
        <div class="form-check form-switch m-0">
             <input class="form-check-input toggle-input" data-toggle-target="#force-update-field" value="1" name="isForceUpdate" id="isForceUpdate" type="checkbox" {{ old('isForceUpdate', $data['isForceUpdate'] ?? 0) == 1 ? 'checked' : '' }} />

            </div>
</div>
</div>
<div id="force-update-field" class="{{ old('isForceUpdate', $data['isForceUpdate'] ?? 0) == 1 ? '' : 'd-none' }}">
    <div class="row">
        <div class="col-md-6">
        <input class="form-control" id="app_version" name="version_code" type="text" value="{{ old('version_code', $data['version_code'] ?? '') }}" placeholder="Enter the App Version for Force Update" {{ old('isForceUpdate', $data['isForceUpdate'] ?? 0) == 1 ? '' : 'disabled' }} />
        @error('version_code')
                <span class="text-danger">{{ $message }}</span>
            @enderror
    </div>
</div>
</div>
    {{-- Submission --}}
    <div class=" mt-3">
        <button class="btn btn-primary w-sm" type="submit">{{ __('messages.save') }}</button>
    </div>
</form>
@endsection
@push('after-scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to toggle visibility based on checkbox state
    function toggleSection(checkbox) {
        const targetId = checkbox.getAttribute('data-toggle-target');
        const targetElement = document.querySelector(targetId);
        if (checkbox.checked) {
            targetElement.classList.remove('d-none');
            targetElement.querySelectorAll('input[type=text]').forEach(function(input) {
                input.removeAttribute('disabled');
            });
        } else {
            targetElement.classList.add('d-none');
            targetElement.querySelectorAll('input[type=text]').forEach(function(input) {
                input.setAttribute('disabled', 'disabled');
            });
        }
    }

    // Initialize the toggles based on the current state of the checkboxes
    document.querySelectorAll('.toggle-input').forEach(function (checkbox) {
        toggleSection(checkbox);
    });

    // Add event listeners to handle the toggles dynamically
    document.querySelectorAll('.toggle-input').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            toggleSection(checkbox);
        });
    });
});

</script>
@endpush
