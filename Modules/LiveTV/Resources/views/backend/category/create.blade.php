@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.tv-category.index" />

<p class="text-danger" id="error_message"></p>
{{ html()->form('POST' ,route('backend.tv-category.store'))->attribute('enctype', 'multipart/form-data')
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open() }}
  
      @csrf
      <div class="card">
            <div class="card-body"> 
                <div class="row gy-3">
                    <div class="col-md-6 position-relative">                   
                        <div class="input-group btn-file-upload">
                            {{ html()->button('<i class="ph ph-image"></i>'.__('messages.lbl_choose_image'))
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerThumbnail')
                                ->attribute('data-hidden-input', 'file_url_image')
                            }}

                            {{ html()->text('thumbnail_input')
                                ->class('form-control')
                                ->placeholder('Select Image')
                                ->attribute('aria-label', 'Thumbnail Image')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainerThumbnail')
                            }}
                        </div>
                        <div class="uploaded-image" id="selectedImageContainerThumbnail">
                            @if(old('file_url', isset($data) ? $data->file_url : ''))
                                <img src="{{ old('file_url', isset($data) ? $data->file_url : '') }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                            @endif
                        </div>

                        {{ html()->hidden('file_url')->id('file_url_image')->value(old('file_url', isset($data) ? $data->file_url : '')) }}
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            {{ html()->label(__('plan.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                            {{ html()->text('name')
                                        ->attribute('value', old('name'))  ->placeholder(__('placeholder.lbl_plan_name'))
                                        ->class('form-control')
                                        ->attribute('required','required')
                                    }}
                            <span class="text-danger" id="error_msg"></span>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="name-error">Name field is required</div>
                        </div>
                        <div>
                            {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                            <div class="d-flex justify-content-between align-items-center form-control">
                                {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                                <div class="form-check form-switch">
                                    {{ html()->hidden('status', 1) }}
                                    {{
                                        html()->checkbox('status',old('status', true))
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

                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            {{ html()->label(__('movie.lbl_description'). '<span class="text-danger"> *</span>', 'description')->class('form-label mb-0') }}  
                            <span class="text-primary cursor-pointer" id="GenrateDescription" ><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span>
                        </div>
                                               
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

    <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5 text">     
        {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
    </div>

{{ html()->form()->close() }}
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


$(document).ready(function() {

$('#GenrateDescription').on('click', function(e) {

    e.preventDefault();

    var description = $('#description').val();
    var name = $('#name').val();

    var generate_discription = "{{ route('backend.movies.generate-description') }}";
        generate_discription = generate_discription.replace('amp;', '');

    if (!description && !name) {  
        $('#error_msg').text('Name field is required'); 
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

            if(response.success){
 
             var data = response.data;
 
             tinymce.get('description').setContent(data);
 
            } else {
                $('#error_message').text(response.message || 'Failed to get Description.');
            }
        },
       error: function(xhr) {
         $('#error_message').text('Failed to get Description.');
         tinymce.get('description').setContent('');
         
           if (xhr.responseJSON && xhr.responseJSON.message) {
               $('#error_message').text(xhr.responseJSON.message);
           } else {
               $('#error_message').text('An error occurred while fetching the movie details.');
           }
        }
    });
 });
});

</script>


@endpush
