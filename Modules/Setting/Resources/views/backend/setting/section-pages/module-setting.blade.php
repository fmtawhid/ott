@extends('setting::backend.setting.index')

@section('settings-content')


<div class="col-md-12 mb-3 d-flex justify-content-between">
    <h5><i class="fa-solid fa-sliders"></i> {{ __('setting_sidebar.lbl_module-setting') }}</h5>

</div>

    <form method="POST" action="{{ route('backend.setting.store') }}" id="payment-settings-form">
        @csrf

        {{-- cash --}}
        <div class="form-group border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label m-0" for="movie">{{ __('movie.title') }}</label>
                <input type="hidden" value="0" name="movie">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input toggle-input" data-toggle-target="#movie-fields" value="1"
                        name="movie" id="movie" type="checkbox"
                        {{ old('movie', $settings['movie'] ?? 0) == 1 ? 'checked' : '' }} />
                </div>
            </div>
        </div>
        <div class="form-group border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label m-0" for="tvshow">{{ __('movie.tvshows') }}</label>
                <input type="hidden" value="0" name="tvshow">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input toggle-input" data-toggle-target="#tvshow-fields" value="1"
                        name="tvshow" id="tvshow" type="checkbox"
                        {{ old('tvshow', $settings['tvshow'] ?? 0) == 1 ? 'checked' : '' }} />
                </div>
            </div>
        </div>
        <div class="form-group border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label m-0" for="livetv">{{ __('livetv.title-livetv') }}</label>
                <input type="hidden" value="0" name="livetv">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input toggle-input" data-toggle-target="#livetv-fields" value="1"
                        name="livetv" id="livetv" type="checkbox"
                        {{ old('livetv', $settings['livetv'] ?? 0) == 1 ? 'checked' : '' }} />
                </div>
            </div>
        </div>

        <div class="form-group border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label m-0" for="video">{{ __('video.title') }}</label>
                <input type="hidden" value="0" name="video">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input toggle-input" data-toggle-target="#video-fields" value="1"
                        name="video" id="video" type="checkbox"
                        {{ old('video', $settings['video'] ?? 0) == 1 ? 'checked' : '' }} />
                </div>
            </div>
        </div>


    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="enable_tmdb_api">{{ __('messages.lbl_tmdb_Api') }}</label>

            <input type="hidden" value="0" name="enable_tmdb_api">
            <div class="form-check form-switch m-0">
                {{ html()->checkbox('enable_tmdb_api', old('enable_tmdb_api', $settings['enable_tmdb_api'] ?? 0) == 1, 1)
                    ->class('form-check-input')
                    ->id('category-enable_tmdb_api')
                    ->attribute('onclick', 'toggleTmdbApi()') }}
            </div>
        </div>
    </div>

    <div id="tmdb_api_key-field" class="ps-3" style="display: {{ old('tmdb_api_key', $settings['enable_tmdb_api'] ?? 0) == 1 ? 'block' : 'none' }};">
        <div class="form-group border-bottom pb-3">
            <label class="form-label" for="category-tmdb_api_key">{{ __('messages.lbl_tmdb_key') }}</label>
            {{ html()->text('tmdb_api_key', old('tmdb_api_key', $settings['tmdb_api_key'] ?? ''))
                ->class('form-control')
                ->id('tmdb_api_key')
                }}
            @error('tmdb_api_key')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label class="form-label m-0" for="video">{{ __('setting_sidebar.lbl_seo') }}</label>
            <input type="hidden" value="0" name="video"> <!-- Default value to prevent null/empty values -->
            <div class="form-check form-switch m-0">
                <input class="form-check-input toggle-input" data-toggle-target="#video-fields" value="1"
                    name="video" id="video" type="checkbox"
                    {{ old('video', $settings->video ?? 0) == 1 ? 'checked' : '' }} />
            </div>
        </div>
    </div>



        <div class="text-end">
        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
        </div>
    </form>

@endsection

@push('after-scripts')

<script>


    function toggleTmdbApi() {
    const TMDBapiEnabled = document.getElementById('category-enable_tmdb_api').checked;
    document.getElementById('tmdb_api_key-field').style.display = TMDBapiEnabled ? 'block' : 'none';

    const input = document.getElementById('tmdb_api_key');
    if (TMDBapiEnabled) {
        input.disabled = false;
    } else {
        input.disabled = true;
    }
}

    document.addEventListener('DOMContentLoaded', function() {

        toggleTmdbApi();

    });

</script>
@endpush

