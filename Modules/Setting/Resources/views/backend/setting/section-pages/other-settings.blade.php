@extends('setting::backend.setting.index')

@section('settings-content')
<form method="POST" action="{{ route('backend.setting.store') }}">
    @csrf

    <div>
        <h4><i class="fa-solid fa-sliders"></i> {{ __('setting_integration_page.app_configuration') }} </h4>
    </div>

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <input type="hidden" value="0" name="is_event">
            <label class="form-label m-0" for="category-enable_event">Enable Event</label>
            <div class="form-check form-switch m-0">
                <input type="checkbox" class="form-check-input" id="category-enable_event" name="is_event" value="1" {{ isset($settings['is_event']) && $settings['is_event'] == 1 ? 'checked' : '' }}>
            </div>
        </div>
    </div>

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="category-enable_blog">{{ __('setting_integration_page.lbl_enable_blog') }}</label>
            <input type="hidden" value="0" name="is_blog">
            <div class="form-check form-switch m-0">
                {{ html()->checkbox('is_blog', old('is_blog', $settings['is_blog'] ?? 0) == 1, 1)
                    ->class('form-check-input')
                    ->id('category-enable_blog') }}
            </div>
        </div>
    </div>

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="category-enable_user_push_notification">{{ __('setting_integration_page.lbl_enable_user_push_notification') }}</label>
            <input type="hidden" value="0" name="is_user_push_notification">
            <div class="form-check form-switch m-0">
                {{ html()->checkbox('is_user_push_notification', old('is_user_push_notification', $settings['is_user_push_notification'] ?? 0) == 1, 1)
                    ->class('form-check-input')
                    ->id('category-enable_user_push_notification') }}
            </div>
        </div>
    </div>

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="category-enable_provider_push_notification">{{ __('setting_integration_page.lbl_enable_provider_push_notification') }}</label>
            <input type="hidden" value="0" name="is_provider_push_notification">
            <div class="form-check form-switch m-0">
                {{ html()->checkbox('is_provider_push_notification', old('is_provider_push_notification', $settings['is_provider_push_notification'] ?? 0) == 1, 1)
                    ->class('form-check-input')
                    ->id('category-enable_provider_push_notification') }}
            </div>
        </div>
    </div>

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="category-enable_chat_gpt">{{ __('setting_integration_page.lbl_enable_chat_gpt') }}</label>
            <input type="hidden" value="0" name="enable_chat_gpt">
            <div class="form-check form-switch m-0">
                {{ html()->checkbox('enable_chat_gpt', old('enable_chat_gpt', $settings['enable_chat_gpt'] ?? 0) == 1, 1)
                    ->class('form-check-input')
                    ->id('category-enable_chat_gpt')
                    ->attribute('onclick', 'toggleChatGptFields()') }}
            </div>
        </div>
    </div>

    <div id="chatgpt-fields" style="display: {{ old('enable_chat_gpt', $settings['enable_chat_gpt'] ?? 0) == 1 ? 'block' : 'none' }};">
        <div class="form-group border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label m-0" for="category-test_without_key">{{ __('setting_integration_page.lbl_test_without_key') }}</label>
                <input type="hidden" value="0" name="test_without_key">
                <div class="form-check form-switch m-0">
                    {{ html()->checkbox('test_without_key', old('test_without_key', $settings['test_without_key'] ?? 1) == 1, 1)
                        ->class('form-check-input')
                        ->id('category-test_without_key')
                        ->attribute('onclick', 'toggleTestKeyField()') }}
                </div>
            </div>
        </div>

        <div id="chatgpt-key-field" style="display: {{ old('test_without_key', $settings['test_without_key'] ?? 1) == 0 ? 'block' : 'none' }};">
            <div class="form-group border-bottom pb-3">
                <label for="category-chatgpt_key">{{ __('setting_integration_page.key') }}</label>
                {{ html()->text('chatgpt_key', old('chatgpt_key', $settings['chatgpt_key'] ?? ''))
                    ->class('form-control')
                    ->id('chatgpt_key') }}
                @error('chatgpt_key')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="category-firebase_notification">{{ __('setting_integration_page.lbl_firebase_notification') }}</label>

            <input type="hidden" value="0" name="firebase_notification">
            <div class="form-check form-switch m-0">
                {{ html()->checkbox('firebase_notification', old('firebase_notification', $settings['firebase_notification'] ?? 0) == 1, 1)
                    ->class('form-check-input')
                    ->id('category-firebase_notification')
                    ->attribute('onclick', 'toggleFirebaseKeyField()') }}
            </div>
        </div>
    </div>

    <div id="firebase-key-field" style="display: {{ old('firebase_notification', $settings['firebase_notification'] ?? 0) == 1 ? 'block' : 'none' }};">
        <div class="form-group border-bottom pb-3">
            <label for="category-firebase_key">{{ __('setting_integration_page.lbl_firebase_key') }}</label>
            {{ html()->text('firebase_key', old('firebase_key', $settings['firebase_key'] ?? ''))
                ->class('form-control')
                ->id('firebase_key')
                }}
            @error('firebase_key')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group border-bottom pb-3">
        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
    </div>
</form>
@endsection

@push('after-scripts')
<script>
    function toggleChatGptFields() {
        const chatGptEnabled = document.getElementById('category-enable_chat_gpt').checked;
        document.getElementById('chatgpt-fields').style.display = chatGptEnabled ? 'block' : 'none';
    }

    function toggleTestKeyField() {
        const testWithoutKeyEnabled = document.getElementById('category-test_without_key').checked;

   document.getElementById('chatgpt-key-field').style.display = testWithoutKeyEnabled ? 'none' : 'block';
   const input = document.getElementById('chatgpt_key');
    if (testWithoutKeyEnabled) {
        input.disabled = true;

    } else {
        input.disabled = false;
    }

    }

    function toggleFirebaseKeyField() {
    const firebaseNotificationEnabled = document.getElementById('category-firebase_notification').checked;
    document.getElementById('firebase-key-field').style.display = firebaseNotificationEnabled ? 'block' : 'none';

    const input = document.getElementById('firebase_key');
    if (firebaseNotificationEnabled) {
        input.disabled = false;
    } else {
        input.disabled = true;
    }
}

    // Initialize the state of the fields when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        toggleChatGptFields();
        toggleTestKeyField();
        toggleFirebaseKeyField();

    });

</script>
@endpush
