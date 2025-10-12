@extends('backend.layouts.app')

@section('content')
   <x-back-button-component route="backend.tv-channel.index" />
   <p class="text-danger" id="error_message"></p>
  {{--  <form method="POST" id="form" action="{{ route('backend.tv-channel.update', $data->id) }}"
        enctype="multipart/form-data"> --}}
        {{ html()->form('PUT' ,route('backend.tv-channel.update', $data->id))
->attribute('enctype', 'multipart/form-data')
->attribute('data-toggle', 'validator')
->attribute('id', 'form-submit')  // Add the id attribute here
->attribute('novalidate', 'novalidate')  // Disable default browser validation
->class('requires-validation')  // Add the requires-validation class
->open()
}}
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-3 position-relative">
                        {{ html()->label(__('messages.logo'), 'poster')->class('form-label') }}
                        <div class="input-group btn-file-upload">
                            {{ html()->button('<i class="ph ph-image"></i>'.__('messages.lbl_choose_image'))
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainer2')
                                ->attribute('data-hidden-input', 'file_url2')
                            }}

                            {{ html()->text('image_input2')
                                ->class('form-control')
                                ->placeholder('Select Image')
                                ->attribute('aria-label', 'Image Input 2')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainer2')
                                ->attribute('data-hidden-input', 'file_url2')
                                ->attribute('aria-describedby', 'basic-addon1')
                            }}
                        </div>
                        <div class="uploaded-image" id="selectedImageContainer2">
                            @if ($data->poster_url)
                                <img src="{{ $data->poster_url }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                <span class="remove-media-icon"
                                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                                  onclick="removeImage('file_url2', 'remove_image_flag')">×</span>
                            @endif
                        </div>

                        {{ html()->hidden('poster_url')->id('file_url2')->value($data->poster_url) }}
                        {{ html()->hidden('remove_image')->id('remove_image_flag')->value(0) }}
                    </div>
                    <div class="col-md-6 col-lg-3 position-relative">
                        {{ html()->label(__('movie.lbl_poster_tv'), 'poster_tv')->class('form-label') }}
                        <div class="input-group btn-file-upload">
                            {{ html()->button('<i class="ph ph-image"></i>'.__('messages.lbl_choose_image'))
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerTv')
                                ->attribute('data-hidden-input', 'file_urltv')
                            }}

                            {{ html()->text('image_input2')
                                ->class('form-control')
                                ->placeholder('Select Image')
                                ->attribute('aria-label', 'Image Input 2')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerTv')
                                ->attribute('data-hidden-input', 'file_urltv')
                                ->attribute('aria-describedby', 'basic-addon1')
                            }}
                        </div>
                        <div class="uploaded-image" id="selectedImageContainerTv">
                            @if ($data->poster_tv_url)
                                <img src="{{ $data->poster_tv_url }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                <span class="remove-media-icon"
                                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                                  onclick="removeTvImage('file_urltv', 'remove_image_flag_tv')">×</span>
                            @endif
                        </div>

                        {{ html()->hidden('poster_tv_url')->id('file_urltv')->value($data->poster_tv_url) }}
                        {{ html()->hidden('remove_image')->id('remove_image_flag_tv')->value(0) }}
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                {{ html()->label(__('movie.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                                {{ html()->text('name', $data->name)->placeholder(__('placeholder.lbl_movie_name'))->class('form-control')->attribute('required','required') }}
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Name field is required</div>
                            </div>
                            <div class="col-md-6">
                                {{ html()->label(__('livetv.title') . '<span class="text-danger">*</span>', 'category_id')->class('form-label') }}
                                {{ html()->select('category_id', $tvcategory->pluck('name', 'id'), old('category_id', $data->category_id))->class('form-control select2')->id('category_id')->attribute('required','required') }}
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Live Tv field is required</div>
                            </div>
                            <div class="col-md-6">
                                {{ html()->label(__('movie.lbl_movie_access') , 'access')->class('form-label') }}
                                <div class="d-flex align-items-center gap-3">
                                  <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                    <div class="">
                                        <input class="form-check-input" type="radio" name="access" id="paid" value="paid"
                                            onchange="showPlanSelection(this.value === 'paid')"
                                            {{ $data->access == 'paid' ? 'checked' : '' }} checked>
                                        <span class="form-check-label" for="paid">{{__('movie.lbl_paid')}}</span>
                                    </div>
                                 </label>
                                 <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                    <div>
                                        <input class="form-check-input" type="radio" name="access" id="free" value="free"
                                            onchange="showPlanSelection(this.value === 'paid')"
                                            {{ $data->access == 'free' ? 'checked' : '' }}>
                                        <span class="form-check-label" >{{__('movie.lbl_free')}}</span>
                                    </div>
                                </div>
                            </label>
                                @error('movie_access')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 {{ old('access', 'paid') == 'free' ? 'd-none' : '' }}" id="planSelection">
                                {{ html()->label(__('movie.lbl_select_plan'). ' <span class="text-danger">*</span>', 'type')->class('form-label') }}
                                {{ html()->select('plan_id', $plan->pluck('name', 'id')->prepend(__('placeholder.lbl_select_plan'), ''), $data->plan_id)->class('form-control select2')->id('plan_id') }}
                                @error('plan_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Plan field is required</div>
                            </div>
                            <div class="col-md-6" id="thumb_url">
                                {{ html()->label(__('movie.thumb_url'), 'thumb_url')->class('form-label') }}
                                {{ html()->text('thumb_url')->attribute('value', old('thumb_url', $data->thumb_url ))->placeholder(__('movie.thumb_url'))->class('form-control') }}
                                @error('thumb_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            {{ html()->label(__('movie.lbl_description'). '<span class="text-danger"> *</span>', 'description')->class('form-label mb-0') }}
                            <span class="text-primary cursor-pointer" id="GenrateDescription"><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span>
                        </div>

                        {{ html()->textarea('description', $data->description)->class('form-control')->id('description')->placeholder(__('placeholder.lbl_movie_description'))->attribute('required','required') }}
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="desc-error">Description field is required</div>
                    </div>
                    <div id="enable_quality_section" class="col-md-12 enable_quality_section">
                        <div id="video-inputs-container-parent">
                            <div class="row gy-3 video-inputs-container">
                                <div class="col-md-6 col-lg-4">
                                    {{ html()->label(__('movie.type'), 'type')->class('form-label') }}
                                    <div class="d-flex align-items-center gap-3">
                                     <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                        <div >
                                            <input class="form-check-input" type="radio" name="type" id="t_url" value="t_url"
                                                onchange="showStreamtypeSelection('t_url')"
                                                {{ $data->TvChannelStreamContentMappings->type == 't_url' ? 'checked' : '' }}>
                                            <span class="form-check-label">{{__('messages.lbl_url')}}</span>
                                        </div>
                                    </label>
                                        <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="type" id="t_embedded" value="t_embedded"
                                                onchange="showStreamtypeSelection('t_embedded')"
                                                {{ $data->TvChannelStreamContentMappings->type == 't_embedded' ? 'checked' : '' }}>
                                            <span class="form-check-label" >{{__('messages.lbl_embedded')}}</span>
                                        </div>
                                    </label>
                                    </div>
                                    @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-4 {{ $data->TvChannelStreamContentMappings->type == 't_url' ? '' : 'd-none' }}" id="type_url">
                                    {{ html()->label(__('movie.lbl_stream_type') . '<span class="text-danger">*</span>', 'stream_type')->class('form-label') }}
                                    {{ html()->select(
                                        'stream_type',
                                        $url->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                        $data->TvChannelStreamContentMappings->stream_type
                                    )->class('form-control select2')->id('stream_type')->disabled(false) }}
                                    @error('stream_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="invalid-feedback" id="name-error">Stream Type field is required</div>
                                </div>
                                <div class="col-md-6 col-lg-4 {{ $data->TvChannelStreamContentMappings->type == 't_embedded' ? '' : 'd-none' }}" id="type_embedded">
                                    {{ html()->label(__('movie.lbl_stream_type') . '<span class="text-danger">*</span>', 'stream_type')->class('form-label') }}
                                    {{ html()->select(
                                        'stream_type',
                                        $embedded->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                        $data->TvChannelStreamContentMappings->stream_type
                                    )->class('form-control select2')->id('embedded_stream_type')->disabled(true) }}
                                    @error('stream_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="invalid-feedback" id="name-error">Stream Type field is required</div>
                                </div>
                                <div class="col-md-6 col-lg-4 {{ $data->TvChannelStreamContentMappings->type == 't_url' ? '' : 'd-none' }}" id="server_url_section">
                                    {{ html()->label(__('movie.server_url') . '<span class="text-danger">*</span>', 'server_url')->class('form-label') }}
                                    {{ html()->text('server_url', $data->TvChannelStreamContentMappings->server_url)->placeholder(__('movie.server_url'))->class('form-control')->id('server_url') }}
                                    @error('server_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="invalid-feedback" id="name-error">Server Url field is required</div>
                                </div>
                                <div class="col-md-6 col-lg-4 {{ $data->TvChannelStreamContentMappings->type == 't_url' ? '' : 'd-none' }}" id="server_url1">
                                    {{ html()->label(__('movie.server_url1'), 'server_url1')->class('form-label') }}
                                    {{ html()->text('server_url1', $data->TvChannelStreamContentMappings->server_url1)->placeholder(__('movie.server_url1'))->class('form-control') }}
                                </div>
                                <div class="col-md-6 col-lg-4 {{ $data->TvChannelStreamContentMappings->type == 't_embedded' ? '' : 'd-none' }}" id="embedded_textarea">
                                    {{ html()->label(__('movie.embedded') . '<span class="text-danger">*</span>', 'embedded')->class('form-label') }}
                                    {{ html()->textarea('embedded', $data->TvChannelStreamContentMappings->embedded)->class('form-control')->id('embedded')->placeholder(__('movie.embedded')) }}
                                    @error('embedded')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="invalid-feedback" id="name-error">Embedded field is required</div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                                    <div class="d-flex justify-content-between align-items-center form-control">
                                        {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                                        <div class="form-check form-switch">
                                            {{ html()->hidden('status', 0) }}
                                            {{
                                                html()->checkbox('status',$data->status)
                                                    ->class('form-check-input')
                                                    ->id('status')
                                            }}
                                        </div>
                                    </div>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
            {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
        </div>
    </form>

    @include('components.media-modal')
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

        function showPlanSelection(show) {
            var planSelection = document.getElementById('planSelection');
            var planIdSelect = document.getElementById('plan_id');
            if (show) {
                planSelection.classList.remove('d-none');
                planIdSelect.setAttribute('required', 'required');
            } else {
                planSelection.classList.add('d-none');
                planIdSelect.removeAttribute('required');
                planIdSelect.value = "";

            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            var movieAccessPaid = document.getElementById('paid');
            var movieAccessFree = document.getElementById('free');

            if (movieAccessPaid.checked) {
                showPlanSelection(true);
            } else if (movieAccessFree.checked) {
                showPlanSelection(false);
            }
        });

        function showStreamtypeSelection(selectedType) {
    var type_url = document.getElementById('type_url');
    var type_embedded = document.getElementById('type_embedded');
    var server_url = document.getElementById('server_url_section');
    var server_url1 = document.getElementById('server_url1');
    var serverUrl = document.getElementById('server_url');
    var embedded = document.getElementById('embedded');
    var stream_type = document.getElementById('stream_type')
    var embedded_stream_type = document.getElementById('embedded_stream_type')
    var embedded_textarea = document.getElementById('embedded_textarea');
    if (selectedType === 't_url') {
        type_url.classList.remove('d-none');
        type_embedded.classList.add('d-none');
        stream_type.disabled = false;
        embedded_stream_type.disabled = true;
        stream_type.setAttribute('required', 'required');
        embedded_stream_type.removeAttribute('required');
        server_url.classList.remove('d-none');
        server_url1.classList.remove('d-none');
        embedded_textarea.classList.add('d-none');
        serverUrl.setAttribute('required', 'required');
        embedded.removeAttribute('required');
    } else {
        type_url.classList.add('d-none');
        type_embedded.classList.remove('d-none');
        stream_type.disabled = true;
        embedded_stream_type.disabled = false;
        embedded_stream_type.setAttribute('required', 'required');
        stream_type.removeAttribute('required');
        server_url.classList.add('d-none');
        server_url1.classList.add('d-none');
        embedded_textarea.classList.remove('d-none');
        serverUrl.removeAttribute('required');
        embedded.setAttribute('required', 'required');
    }
}

function handleVideoUrlTypeChange(selectedTypeValue) {
    var server_url = document.getElementById('server_url');
    var embedded_textarea = document.getElementById('embedded_textarea');
    var server_url1 = document.getElementById('server_url1');

    if (selectedTypeValue === 'URL' || selectedTypeValue === 'YouTube' || selectedTypeValue === 'HLS' ||  selectedtypeValue === 'Vimeo' || selectedtypeValue === 'x265') {
        server_url.classList.remove('d-none');
        embedded_textarea.classList.add('d-none');
        server_url1.classList.remove('d-none');
    } else if (selectedTypeValue === 'Embedded') {
        server_url.classList.add('d-none');
        embedded_textarea.classList.remove('d-none');
        server_url1.classList.add('d-none');
    } else {
        server_url.classList.add('d-none');
        embedded_textarea.classList.add('d-none');
        server_url1.classList.add('d-none');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var type = document.querySelector('input[name="type"]:checked').value;
    showStreamtypeSelection(type);

    document.querySelectorAll('input[name="type"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            showStreamtypeSelection(this.value);
        });
    });

    document.getElementById('stream_type').addEventListener('change', function() {
        handleVideoUrlTypeChange(this.value);
    });

    document.getElementById('embedded_stream_type').addEventListener('change', function() {
        handleVideoUrlTypeChange(this.value);
    });
    document.querySelector('form').addEventListener('submit', function() {
        var type = document.querySelector('input[name="type"]:checked').value;
        if (type === 't_url') {
            document.getElementById('stream_type').disabled = false;
            document.getElementById('embedded_stream_type').disabled = true;
        } else {
            document.getElementById('stream_type').disabled = true;
            document.getElementById('embedded_stream_type').disabled = false;
        }
    });
});

        $(document).ready(function() {

            function initializeSelect2(section) {
                section.find('select.select2').each(function() {
                    $(this).select2({
                        width: '100%'
                    });
                });
            }

            function destroySelect2(section) {
                section.find('select.select2').each(function() {
                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                });
            }

            $('#stream_type').select2({
                width: '100%'
            });
        });


        $(document).ready(function() {

$('#GenrateDescription').on('click', function(e) {

    e.preventDefault();

    var description = $('#description').val();
    var name = $('#name').val();

    var generate_discription = "{{ route('backend.movies.generate-description') }}";
    generate_discription = generate_discription.replace('amp;', '');

    if (!description && !name) {
        return;
    }

    tinymce.get('description').setContent('Loading...');

    $.ajax({

        url: generate_discription,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            description: description,
            name: name,
        },
        success: function(response) {

            tinymce.get('description').setContent('');

            if (response.success) {

                var data = response.data;

                tinymce.get('description').setContent(data);

            } else {
                $('#error_message').text(response.message ||
                    'Failed to get Description.');
            }
        },
        error: function(xhr) {
            $('#error_message').text('Failed to get Description.');
            tinymce.get('description').setContent('');

            if (xhr.responseJSON && xhr.responseJSON.message) {
                $('#error_message').text(xhr.responseJSON.message);
            } else {
                $('#error_message').text(
                    'An error occurred while fetching the movie details.');
            }
        }
    });
});
});

function removeImage(hiddenInputId, removedFlagId) {
    var container = document.getElementById('selectedImageContainer2');
    var hiddenInput = document.getElementById(hiddenInputId);
    var removedFlag = document.getElementById(removedFlagId);

    container.innerHTML = '';
    hiddenInput.value = '';
    removedFlag.value = 1;
}
function removeTvImage(hiddenInputId, removedFlagId) {
    var container = document.getElementById('selectedImageContainerTv');
    var hiddenInput = document.getElementById(hiddenInputId);
    var removedFlag = document.getElementById(removedFlagId);

    container.innerHTML = '';
    hiddenInput.value = '';
    removedFlag.value = 1;
}
    </script>

    <style>
        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .close-icon {
            top: -13px;
            left: 54px;
            background: rgba(255, 0, 0, 0.6);
            border: none;
            border-radius: 50%;
            color: white;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            line-height: 25px;
        }
    </style>
@endpush

