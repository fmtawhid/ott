@extends('setting::backend.setting.index')

@section('settings-content')
<div class="container">
    <form method="POST" action="{{ route('backend.notificationtemplates.settings.update') }}" id="notificationForm">
        @csrf
        <div>
            <h3 class="card-title">
                <i class="fa-solid fa-bullhorn"></i>
                {{ __('setting_sidebar.lbl_notification') }}
            </h3>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>{{ __('notification.lbl_type') }}</th>
                        <th>{{ __('notification.template') }}</th>
                        @foreach ($channels as $channel)
                            <th>{{ $channel }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notificationTemplates as $templateIndex => $template)
                        <tr>
                            <td>{{ $template['type'] }}</td>
                            <td>{{ $template['template'] }}</td>
                            @foreach ($channels as $channelKey => $channelName)
                                <td>
                                    <!-- Hidden inputs for template data -->
                                    <input type="hidden" name="templates[{{ $templateIndex }}][id]" value="{{ $template['id'] }}">
                                    <input type="hidden" name="templates[{{ $templateIndex }}][type]" value="{{ $template['type'] }}">
                                    <input type="hidden" name="templates[{{ $templateIndex }}][template]" value="{{ $template['template'] }}">
                                    <input type="hidden" name="templates[{{ $templateIndex }}][is_default]" value="{{ $template['is_default'] }}">

                                    <input type="hidden" name="templates[{{ $templateIndex }}][channels][{{ $channelKey }}]" value="0">

                                    <!-- Checkbox for channel data nested within templates array -->
                                    <input type="checkbox" class="form-check-input"
                                           name="templates[{{ $templateIndex }}][channels][{{ $channelKey }}]"
                                           value="1" {{ isset($template['channels'][$channelKey]) && $template['channels'][$channelKey] == 1 ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-end">
        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
        </div>
    </form>
</div>

@endsection
