@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="bd-example">
                <nav>
                    <div class="mb-3 nav nav-underline nav-tabs justify-content-between p-0 border-bottom rounded-0" id="nav-tab" role="tablist">
                        <div class="d-flex align-items-center gap-3">
                            @can('add_media')
                            <button class="nav-link d-flex align-items-center rounded-0" id="nav-upload-files-tab" data-bs-toggle="tab" data-bs-target="#nav-upload" type="button" role="tab" aria-controls="nav-upload" aria-selected="true">{{__('messages.upload_media')}}</button>
                            @endcan
                            @can('view_media')
                            <button class="nav-link rounded-0 active" id="nav-media-library-tab" data-bs-toggle="tab" data-bs-target="#nav-media" type="button" role="tab" aria-controls="nav-media" aria-selected="false">{{__('messages.view_library')}}</button>
                            @endcan
                        </div>
                        <div class="media-search py-2 " id="media-search-containers">
                            <div class="d-flex">
                                <input type="text" id="media-search" class="form-control" placeholder="{{__('messages.search_media')}}">
                                <button class="btn text-danger close-icon d-none px-2" type="button" id="clear-search">
                                    <i class="ph ph-x"></i> <!-- Change this icon to your desired close icon -->
                                </button>
                            </div>

                        </div>
                    </div>
                </nav>
                <div class="tab-content iq-tab-fade-up" id="nav-tab-content">
                    <div class="tab-pane fade" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-files-tab">
                        {{ html()->form('POST', route('backend.media-library.store-data'))->id('form-submit')->attribute('enctype', 'multipart/form-data')
                            ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')
                            ->open() }}
                        @csrf
                        <div class="col-12">
                            <div class="text-center mb-3">

                                <div class="input-group btn-file-upload">
                                    {{ html()->button(__('<i class="ph ph-image"></i>'. __('messages.lbl_choose_image')))
                                        ->class('input-group-text form-control')
                                        ->type('button')
                                        ->attribute('onclick', "document.getElementById('file_url_media').click()")
                                        ->style('height:16rem')
                                    }}
                                    {{ html()->file('file_url[]')
                                        ->id('file_url_media')
                                        ->class('form-control')
                                        ->attribute('accept', '.jpeg, .jpg, .png, .gif, .mov, .mp4, .avi')
                                        ->attribute('multiple', true)
                                        ->attribute('required', true)
                                        ->style('display: none;')
                                        ->required()
                                    }}
                                </div>
                                <div class="uploaded-image" id="selectedImageContainerThumbnail">
                                    @if(old('file_url', isset($data) ? $data->file_url : ''))
                                        <img src="{{ old('file_url', isset($data) ? $data->file_url : '') }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                    @endif
                                </div>
                                <div class="invalid-feedback" id="file_url_media-error">File field is required</div>
                            </div>
                        </div>
                            <div id="uploadedImages" class="mb-3"></div>
                            <div class="text-end">
                                {{ html()->submit(trans('messages.upload'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}

                            </div>

                        {{ html()->form()->close() }}
                    </div>
                    <div class="tab-pane fade show active" id="nav-media" role="tabpanel" aria-labelledby="nav-media-library-tab" style="position: relative;">
                        <div class="media-scroll pe-3">
                         <h6 id="no_data" class="text-center"></h6>
                            <div class="d-flex gap-5 flex-wrap justify-content-center" id="media-container">

                                @include('filemanager::backend.filemanager.partial', ['mediaUrls' => $mediaUrls, 'is_media'=>1])
                            </div>
                        </div>

                        <div id="loading-spinner" class="text-center mt-3" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">{{__('season.lbl_loading')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @if(session('success'))
        <div class="snackbar" id="snackbar">
            <div class="d-flex justify-content-around align-items-center">
                <p class="mb-0">{{ session('success') }}</p>
                <a href="#" class="dismiss-link text-decoration-none text-success" onclick="dismissSnackbar(event)">Dismiss</a>
            </div>
        </div>
    @endif
@endsection

@push('after-scripts')
<script src="{{ asset('js/form/index.js') }}" defer></script>
<script>
    let baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let page = 1;
    let loading = false;
    let hasMore = @json($hasMore);


    function deleteImage(url) {
    Swal.fire({
        title: "Are you sure you want to delete?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        reverseButtons: true,
    })
    .then((result) => {
        if (result.isConfirmed) {
            fetch(`${baseUrl}/app/media-library/destroy`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ url: url })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const mediaContainer = document.querySelector(`img[src="${url}"], video source[src="${url}"]`);
                    if (mediaContainer) {
                        mediaContainer.closest('#media-images').remove(); // Remove the parent div of the media
                    }
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Your media has been deleted.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'There was a problem deleting your media.',
                        'error'
                    );
                }
            });
        }
    });
}

    // $(window).scroll(function() {

    //     if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && !loading && hasMore) {
    //         page++;
    //         loadMedia($('#media-search').val(), page);
    //     }
    // });
    const mediaScrollContainer = $('.media-scroll');

mediaScrollContainer.scroll(function() {
    // Calculate the scroll position inside the container
    if (mediaScrollContainer.scrollTop() + mediaScrollContainer.innerHeight() >= mediaScrollContainer[0].scrollHeight - 100 && !loading && hasMore) {
        page++;
        loadMedia($('#media-search').val(), page);
    }
});

    function loadMedia(query = '', page = 1) {

        const noData = document.getElementById('no_data');

        loading = true;
        $('#loading-spinner').show();

        $.ajax({
            url: '{{ route('backend.media-library.index') }}',
            method: 'GET',
            data: { query: query, page: page },
            success: function(response) {
                if (page === 1) {

                   if(response.html) {

                    $('#media-container').html(response.html);

                    $('#no_data').text('');


                    }else{
                        $('#media-container').html('');

                        $('#no_data').text('No data available');

                    }

                } else {
                    $('#media-container').append(response.html);

                }
                hasMore = response.hasMore;
                $('#loading-spinner').hide();
                loading = false;
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr);
                $('#loading-spinner').hide();
                loading = false;
            }
        });
    }

    document.getElementById('file_url_media').addEventListener('change', function() {
    const saveButton = document.getElementById('submit-button');
    var fileError = document.getElementById('file_url_media-error');
    if (this.files.length > 0) {
        document.getElementById('file_url_media').removeAttribute('required');
        fileError.style.display = 'block';
        saveButton.removeAttribute('disabled');
    } else {
        document.getElementById('file_url_media').setAttribute('required', 'required');
        fileError.style.display = 'block';
        saveButton.setAttribute('disabled', 'disabled');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const uploadButton = document.getElementById('nav-upload-files-tab');
    const libraryButton = document.getElementById('nav-media-library-tab');
    const searchContainer = document.getElementById('media-search-containers');


    // Function to toggle the search container visibility
    function toggleSearchVisibility() {
        if (uploadButton.classList.contains('active')) {
            searchContainer.style.display = 'none'; // Show the search bar
        } else {
            searchContainer.style.display = 'block'; // Hide the search bar
        }
    }

    // Initial toggle based on the active tab
    toggleSearchVisibility();
   // Add event listeners to toggle the visibility on tab change
   uploadButton.addEventListener('click', toggleSearchVisibility);
    libraryButton.addEventListener('click', toggleSearchVisibility);





});
document.addEventListener('DOMContentLoaded', function() {

    const clearSearchButton = document.getElementById('clear-search');
    const mediaSearchInput = document.getElementById('media-search');


    function toggleClearButtonVisibility() {
        if (mediaSearchInput.value.length > 0) {
            clearSearchButton.classList.remove('d-none'); // Show the button
        } else {
            clearSearchButton.classList.add('d-none'); // Hide the button
            loadMedia();
        }
    }

    // Add event listener for input changes
    mediaSearchInput.addEventListener('input', toggleClearButtonVisibility);

    // Add event listener for clear button
    clearSearchButton.addEventListener('click', function() {
        mediaSearchInput.value = ''; // Clear the input field
        toggleClearButtonVisibility(); // Update the button visibility
        $('#media-search').trigger('input'); // Trigger input event to refresh search results
    });

    // Initialize the visibility on page load
    toggleClearButtonVisibility();


});
</script>
@endpush
<style>
     .close-icon {

            background: rgba(255, 0, 0, 0.6);
            border: none;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
        }
</style>
