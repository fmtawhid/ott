

@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.genres.index" />
{{ html()->form('POST', route('backend.genres.store'))
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
            <div class="col-md-12 col-xl-3 position-relative">
                {{ html()->label(__('messages.image'), 'Image')->class('form-label')}}
                <div class="input-group btn-file-upload">
                    {{ html()->button(__('<i class="ph ph-image"></i>'. __('messages.lbl_choose_image')))
                        ->class('input-group-text form-control')
                        ->type('button')
                        ->attribute('data-bs-toggle', 'modal')
                        ->attribute('data-bs-target', '#exampleModal')
                        ->attribute('data-image-container', 'selectedImageContainerThumbnail')
                        ->attribute('data-hidden-input', 'file_url_image')
                    }}

                    {{ html()->text('thumbnail_input')
                        ->class('form-control')
                        ->placeholder(__('placeholder.lbl_image'))
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
            </div>
            {{ html()->hidden('file_url')->id('file_url_image')->value(old('file_url', isset($data) ? $data->file_url : '')) }}
            <div class="col-xl-9">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-6">
                        <div class="mb-3">
                            {{ html()->label(__('messages.name') . ' <span class="text-danger">*</span>', 'name')->class('form-label')}}
                            {{ html()->text('name', old('name'))
                                ->class('form-control')
                                ->id('name')
                                ->placeholder(__('placeholder.lbl_genre_name'))
                                ->attribute('required', 'required')
                            }}
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback" id="name-error">Name field is required</div>
                        </div>
                        <div>
                            {{ html()->label(__('messages.lbl_status'), 'status')->class('form-label') }}
                            <div class="d-flex justify-content-between align-items-center form-control">
                                {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0') }}
                                <div class="form-check form-switch">
                                    {{ html()->hidden('status', 0) }}
                                    {{ html()->checkbox('status', old('status', 1))
                                        ->class('form-check-input')
                                        ->id('status')
                                        ->value(1)
                                    }}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        {{ html()->label(__('messages.description') . ' <span class="text-danger"> *</span>', 'description')->class('form-label') }}
                        {{ html()->textarea('description', old('description'))
                            ->class('form-control')
                            ->id('description')
                            ->placeholder(__('placeholder.lbl_genre_description'))
                            ->rows('5')
                            ->attribute('required', 'required')
                        }}
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="description-error">Description field is required</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-grid d-sm-flex justify-content-sm-end gap-3">

    {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}

</div>

{{ html()->form()->close() }}

@include('components.media-modal')

@endsection
