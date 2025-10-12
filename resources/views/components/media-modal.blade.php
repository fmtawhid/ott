<!-- Modal -->
<div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('placeholder.lbl_image')}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bd-example">
                    <nav>
                        <div class="mb-3 nav nav-underline nav-tabs justify-content-between p-0 border-bottom rounded-0 bg-transparent" id="nav-tab" role="tablist">
                            <div class="d-flex align-items-center gap-3">
                                <button class="nav-link rounded-0 d-flex align-items-center" id="nav-upload-files-tab" data-bs-toggle="tab" data-bs-target="#nav-upload" type="button" role="tab" aria-controls="nav-upload" aria-selected="true">{{__('messages.upload_file')}}</button>
                                <button class="nav-link  rounded-0 active" id="nav-media-library-tab" data-bs-toggle="tab" data-bs-target="#nav-media" type="button" role="tab" aria-controls="nav-media" aria-selected="false">{{__('messages.media_library')}}</button>
                            </div>
                            <div class="media-search py-2" id="media-search-container">
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

                        <div class="card m-0 bg-transparent">
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
                                    ->style('display: none;')
                                    ->required()
                                }}
                            </div>
                            <div class="uploaded-image" id="selectedImageContainerThumbnail">
                                @if(old('file_url', isset($data) ? $data->file_url : ''))
                                    <img src="{{ old('file_url', isset($data) ? $data->file_url : '') }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                @endif
                            </div>
                            <div id="uploadedImages" class="my-3"></div>
                            <div class="invalid-feedback text-center" id="file_url_media-error">File field is required</div>
                        </div>

                            <div class="text-end">
                                {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submitButton')->attribute('disabled') }}
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="nav-media" role="tabpanel" aria-labelledby="nav-media-library-tab"  style="position: relative;">
                            <div class="row">

                            {{-- <div class="media-search py-2">
                                         <input type="text" id="media-search" class="form-control" placeholder="Search media...">
                                     </div> --}}
                                <div class="col-md-12 d-flex justify-content-center gap-5 flex-wrap media-scroll" id="mediaLibraryContent">
                                    <div class="text-center">
                                        <h6 id="no_data" class="d-none text-center">{{__('messages.no_data_available')}}</h6>
                                    </div>

                                   <div class="d-flex gap-5 flex-wrap justify-content-center" id="media-container">

                                   </div>
                                   <div id="loading-spinner" class="text-center mt-3" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">{{__('season.lbl_loading')}}</span>
                                        </div>
                                    </div>

                                </div>




                            </div>
                            <div class="text-end">
                            {{ html()->button(__('messages.save'))->class('btn btn-md btn-primary mt-2')->id('mediaSubmitButton') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     var baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

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

// function deleteImage(url) {
//     Swal.fire({
//         title: "Are you sure you want to delete?",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, delete it!",
//         customClass: {
//             popup: 'swal2-modal-custom'  // Add a custom class to the SweetAlert popup
//         }
//     })
//     .then((result) => {
//         if (result.isConfirmed) {
//             fetch(`${baseUrl}/app/media-library/destroy`, {
//                 method: 'DELETE',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
//                 },
//                 body: JSON.stringify({ url: url })
//             })
//             .then(response => response.json())
//             .then(data => {
//                 if (data.success) {
//                     const imgElement = document.querySelector(`img[src="${url}"]`);
//                     if (imgElement) {
//                         imgElement.parentElement.remove();
//                     }

//                    Swal.fire({
//                         title: 'Deleted!',
//                         text: 'Your image has been deleted.',
//                         icon: 'success',
//                         showConfirmButton: false,
//                         timer: 1500,
//                         timerProgressBar: true
//                     });

//                 } else {
//                     Swal.fire(
//                         'Error!',
//                         'There was a problem deleting your image.',
//                         'error'
//                     );
//                 }
//             });
//         }
//     });
// }


document.getElementById('file_url_media').addEventListener('change', function() {
    const fileInput = document.getElementById('file_url_media');
    const submitButton = document.getElementById('submitButton');
    const fileError = document.getElementById('file_url_media-error');
    if (fileInput && submitButton) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileInput.removeAttribute('required');
                fileError.style.display = 'none';
                submitButton.removeAttribute('disabled');
            } else {
                fileInput.setAttribute('required', 'required');
                fileError.style.display = 'block';
                submitButton.setAttribute('disabled', 'disabled');
            }
        });
        if (fileInput.files.length > 0) {
            submitButton.removeAttribute('disabled');
            fileError.style.display = 'none';
        } else {
            submitButton.setAttribute('disabled', 'disabled');
            fileError.style.display = 'block';
        }
    }
});

</script>

<style>
    .swal2-modal-custom {
    z-index: 9999 !important; /* Make sure it's higher than Bootstrap's modal (1050) */
}
</style>






