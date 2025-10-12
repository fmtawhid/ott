@extends('setting::backend.setting.index')

@section('settings-content')
<form method="POST" action="{{ route('backend.setting.store') }}">
    @csrf

    <div class="card">
        <div class="card-header p-0 mb-4">
            <h4><i class="fa-solid fa-screwdriver-wrench"></i> {{ __('setting_sidebar.lbl_misc_setting') }} </h4>
        </div>
        <div class="card-body p-0">
            <div class="row gy-3">
                <div class="col-md-4">
                    {{ html()->label(__('messages.lbl_google_analytics'))->class('form-label') }}
                    {{ html()->text('google_analytics')
                        ->class('form-control')
                        ->placeholder(__('messages.lbl_google_analytics'))
                        ->value(old('google_analytics', $settings['google_analytics'] ?? '')) }}
                    @error('google_analytics')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    {{ html()->label(__('setting_language_page.lbl_language'))->class('form-label') }}
                    {{ html()->select('default_language')
                        ->options(array_column($languages, 'name', 'id'))
                        ->class('form-control select2')
                        ->value(old('default_language', $settings['default_language'] ?? '')) }}
                    @error('default_language')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

               <div class="col-md-4">
                    {{ html()->label(__('setting_language_page.lbl_timezone'))->class('form-label') }}
                    {{ html()->select('default_time_zone')
                        ->options(array_column($timezones, 'text', 'id'))
                        ->class('form-control select2')
                        ->value(old('default_time_zone', $settings['default_time_zone'] ?? '')) }}
                    @error('default_time_zone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>





                  {{-- <div class="col-md-4">
                    {{ html()->label(__('setting_language_page.lbl_storage_options'))->class('form-label') }}
                    {{ html()->select('disc_type')
                        ->options([
                            'local' => 'local',
                            's3' => 's3',
                        ])
                        ->class('form-control select2')
                        ->value(old('disc_type', $settings['disc_type'] ?? '')) }}
                    @error('disc_type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}

            </div>

        </div>
        <div class="text-end mt-3">
            {{ html()->button(__('messages.save'))
                ->type('submit')
                ->class('btn btn-primary') }}
        </div>
    </div>
</form>

@endsection

