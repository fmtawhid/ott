@extends('backend.layouts.app')
@section('content')
    <a href="{{ route('backend.castcrew.index', ['type' => $type]) }}" class="btn btn-link d-inline-flex align-items-center gap-1 p-0 mb-3 fs-3"><i class="ph ph-caret-double-left"></i>{{__('messages.back')}}</a>

    <p class="text-danger" id="error_message"></p>

    {{ html()->form('PUT' ,route('backend.castcrew.update', $cast->id))
    ->attribute('enctype', 'multipart/form-data')
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->open()
    }}

    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-6 col-lg-4 position-relative">
                    <div class="input-group btn-file-upload">
                        {{ html()->button('<i class="ph ph-image"></i>'. __('messages.lbl_choose_image'))
                            ->class('input-group-text form-control')
                            ->type('button')
                            ->attribute('data-bs-toggle', 'modal')
                            ->attribute('data-bs-target', '#exampleModal')
                            ->attribute('data-image-container', 'selectedImageContainer1')
                            ->attribute('data-hidden-input', 'file_url1')
                        }}

                        {{ html()->text('image_input1')
                            ->class('form-control')
                            ->placeholder('Select Image')
                            ->attribute('aria-label', 'Image Input 1')
                            ->attribute('data-bs-toggle', 'modal')
                            ->attribute('data-bs-target', '#exampleModal')
                            ->attribute('data-image-container', 'selectedImageContainer1')
                            ->attribute('data-hidden-input', 'file_url1')
                            ->attribute('aria-describedby', 'basic-addon1')
                        }}
                    </div>
        
                    <div class="uploaded-image" id="selectedImageContainer1">
                        @if ($cast->file_url)
                            <img src="{{ $cast->file_url }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                            <span class="remove-media-icon" 
                                  style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;" 
                                  onclick="removeImage('file_url1', 'remove_image_flag')">×</span>
                    
                        @endif  
                    </div>
                    {{ html()->hidden('file_url')->id('file_url1')->value($cast->file_url) }}
                    {{ html()->hidden('remove_image')->id('remove_image_flag')->value(0) }}
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="mb-3">
                        {{ html()->label(__('castcrew.lbl_name') . '<span class="text-danger">*</span>', 'name')->class('form-label')}}
                        {{
                        html()->text('name', $cast->name)
                            ->class('form-control')
                            ->id('name')
                            ->placeholder(__('placeholder.lbl_cast_name'))
                            ->attribute('required','required')
                        }}
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Name field is required</div>
                    </div>
                    <div>
                        {{ html()->label(__('castcrew.lbl_designation') , 'designation')->class('form-label')}}
                        {{
                        html()->text('designation', $cast->designation)
                            ->class('form-control')
                            ->id('designation')
                            ->placeholder(__('placeholder.lbl_cast_designation'))
                        }}
                        @error('designation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3 d-none">
                        {{ html()->label(__('castcrew.lbl_type') . '<span class="text-danger">*</span>', 'type')->class('form-label') }}
                        {{
                                    html()->select('type', [
                                            '' => 'Select Type',
                                            'actor' => 'Actor',
                                            'director' => 'Director',
                                        ], $cast->type)
                                        ->class('form-control select2')
                                        ->id('type')

                                }}
                        @error('type')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="mb-3">
                        {{ html()->label(__('castcrew.lbl_dob') . '<span class="text-danger">*</span>', 'dob')->class('form-label')}}
                        {{
                        html()->date('dob', $cast->dob)
                            ->class('form-control datetimepicker')
                            ->id('dob')
                            ->placeholder(__('placeholder.lbl_user_date_of_birth'))
                            ->attribute('required','required')
                        }}
                        @error('dob')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="dob-error">Date Of Birth field is required</div>
                    </div>
                    <div>
                        {{ html()->label(__('castcrew.lbl_birth_place') . '<span class="text-danger">*</span>', 'name')->class('form-label')}}
                        {{
                        html()->text('place_of_birth', $cast->place_of_birth)
                            ->class('form-control')
                            ->id('place_of_birth')
                            ->placeholder(__('placeholder.lbl_cast_place_of_birth'))
                            ->attribute('required','required')
                        }}
                        @error('place_of_birth')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Birth Place field is required</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        {{ html()->label(__('castcrew.lbl_bio') . ' <span class="text-danger">*</span>', 'bio')->class('form-label') }}
                        <!--<span class="text-primary cursor-pointer" id="GenrateshortDescription" ><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span>-->
                    </div>
                    {{
                    html()->textarea('bio', $cast->bio)
                        ->class('form-control')
                        ->id('bio')
                        ->placeholder(__('placeholder.lbl_cast_bio'))
                        ->rows('6')
                        ->attribute('required','required')
                    }}
                    @error('bio')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="name-error">Bio field is required</div>
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
<script>

document.addEventListener('DOMContentLoaded', function () {

flatpickr('.datetimepicker', {
    dateFormat: "Y-m-d", // Format for date (e.g., 2024-08-21)
   
});
});

    $(document).ready(function() {

    $('#GenrateshortDescription').on('click', function(e) {

        e.preventDefault();

        var description = $('#bio').val();
        var name = $('#name').val();
        var place_of_birth = $('#place_of_birth').val();
        var dob = $('#dob').val();

        if (!description && !name) {
             return;
         }

        var generate_discription = "{{ route('backend.castcrew.generate-bio') }}";
            generate_discription = generate_discription.replace('amp;', '');

        if(!description){

            var prompt = `Generate a biography for an actor with the following details:
                          Name: ${name},
                          Place of Birth: ${place_of_birth},
                          Date of Birth: ${dob}.`;
        }else{

            var prompt = `Expand on the existing biography for an actor with the following details:
                      Name: ${name},
                      Place of Birth: ${place_of_birth},
                      Date of Birth: ${dob}.
                      Existing Description: ${description}.`;

        }

         $('#bio').text('Loading...')

      $.ajax({

           url: generate_discription,
           type: 'POST',
           headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           data: {
                   prompt: prompt,
                 },
           success: function(response) {

               $('#bio').text('')

                if(response.success){

                 var data = response.data;
                 $('#bio').html(data)

                } else {
                    $('#error_message').text(response.message || 'Failed to get Description.');
                }
            },
           error: function(xhr) {
             $('#error_message').text('Failed to get Description.');
             $('#bio').text('');
               if (xhr.responseJSON && xhr.responseJSON.message) {
                   $('#error_message').text(xhr.responseJSON.message);
               } else {
                   $('#error_message').text('An error occurred while fetching the movie details.');
               }
            }
        });
      });
    });

    function removeImage(hiddenInputId, removedFlagId) {
        var container = document.getElementById('selectedImageContainer1');
        var hiddenInput = document.getElementById(hiddenInputId);
        var removedFlag = document.getElementById(removedFlagId);

        container.innerHTML = '';
        hiddenInput.value = '';
        removedFlag.value = 1;
    }

    </script>


@endpush
