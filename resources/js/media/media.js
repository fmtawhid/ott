let baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

const exampleModal = document.getElementById('exampleModal');
const mediaContainer = document.getElementById('media-container');

document.addEventListener('DOMContentLoaded', function() {
    let selectedMediaUrl = '';
    let currentImageContainer = '';
    let currentHiddenInput = '';
    let videoInputCounter = 0; // Initialize a counter for dynamic IDs

    function initializeImageSelection(button) {
        button.addEventListener('click', function() {
            currentImageContainer = this.getAttribute('data-image-container');
            currentHiddenInput = this.getAttribute('data-hidden-input');
        });
    }

    function initializeModal() {
        document.querySelectorAll('button[data-bs-target="#exampleModal"]').forEach(function(button) {
            initializeImageSelection(button);
        });
    }

    function selectMedia(mediaUrl, mediaElement) {
        selectedMediaUrl = mediaUrl;

        // Remove active class from all media elements
        document.querySelectorAll('#mediaLibraryContent img, #mediaLibraryContent video').forEach(function(media) {
            media.classList.remove('iq-image');
        });

        // Add active class to the selected media element
        mediaElement.classList.add('iq-image');
    }

    if (document.getElementById('mediaLibraryContent')) {
        document.getElementById('mediaLibraryContent').addEventListener('click', function(event) {

            if (event.target.tagName === 'IMG') {
                var mediaUrl = event.target.src;
                selectMedia(mediaUrl, event.target);
            } else if (event.target.tagName === 'VIDEO') {

             var mediaUrl = event.target.querySelector('source').src;
             //   var mediaUrl = event.target.src;
                if (mediaUrl) {

                    selectMedia(mediaUrl, event.target);
                }
                event.preventDefault();
            }
        });
    }

    if (document.getElementById('mediaSubmitButton')) {
      document.getElementById('mediaSubmitButton').addEventListener('click', function() {
          if (selectedMediaUrl && currentImageContainer && currentHiddenInput) {
              var selectedImageContainer = document.getElementById(currentImageContainer);
              var mediaUrlInput = document.getElementById(currentHiddenInput);

              if (selectedImageContainer) {
                  mediaUrlInput.value = selectedMediaUrl;

                  selectedImageContainer.innerHTML = '';

                  // Check if there's an element with id iq-video-quality

                  if (mediaUrlInput.hasAttribute('data-validation')) {
                    var fileError = document.getElementById('file-error');
                    var videofile = document.querySelector('input[name="video_file_input"]');
                    var vfi = document.querySelector('input[name="image_input4"]');
                      // Only allow video selection
                      if (selectedMediaUrl.endsWith('.mp4') || selectedMediaUrl.endsWith('.avi')) {
                        if(fileError){
                            fileError.style.display = 'none';
                        }
                        if(videofile){
                        videofile.removeAttribute('required');
                        }
                          var video = document.createElement('video');
                          video.src = selectedMediaUrl;
                          video.controls = true;
                          video.classList.add('img-fluid', 'mb-2');
                          video.style.maxWidth = '300px';
                          video.style.maxHeight = '300px';

                          selectedImageContainer.appendChild(video);

                          var crossIcon = document.createElement('span');
                          crossIcon.innerHTML = '&times;';
                          crossIcon.classList.add('remove-media-icon');
                          crossIcon.style.cursor = 'pointer';
                          crossIcon.style.fontSize = '24px';
                          crossIcon.style.position = 'absolute';

                          crossIcon.addEventListener('click', function() {
                              selectedImageContainer.innerHTML = '';
                              mediaUrlInput.value = '';
                              if(videofile){
                              videofile.value='';
                              }
                              if(vfi){
                                vfi.setAttribute('required','required');
                              }

                              if(fileError){
                                fileError.style.display = 'block';
                            }
                          });
                          if(vfi){
                            vfi.removeAttribute('required');
                          }
                          selectedImageContainer.appendChild(crossIcon);
                      } else {
                        if(videofile){
                        videofile.setAttribute('required', 'required');
                        }
                        if(fileError){
                            fileError.style.display = 'block';
                        }

                          // Show error for incorrect media type
                          var errorElement = document.createElement('div');
                          errorElement.classList.add('text-danger');
                          errorElement.textContent = 'Only video files are allowed.';
                          selectedImageContainer.appendChild(errorElement);
                      }
                  } else {

                    if(selectedMediaUrl.endsWith('.png') || selectedMediaUrl.endsWith('.jpg') || selectedMediaUrl.endsWith('.jpeg') || selectedMediaUrl.endsWith('.webp')){
                      // For other cases, default behavior (assuming image upload or other media)
                      var img = document.createElement('img');
                      img.src = selectedMediaUrl;
                      img.classList.add('img-fluid', 'mb-2');
                      img.style.maxWidth = '100px';
                      img.style.maxHeight = '100px';

                      selectedImageContainer.appendChild(img);

                      var crossIcon = document.createElement('span');
                      crossIcon.innerHTML = '&times;';
                      crossIcon.classList.add('remove-media-icon');
                      crossIcon.style.cursor = 'pointer';
                      crossIcon.style.fontSize = '24px';
                      crossIcon.addEventListener('click', function() {
                          selectedImageContainer.innerHTML = '';
                          mediaUrlInput.value = '';
                      });

                      selectedImageContainer.appendChild(crossIcon);
                    } else {
                          var errorElement = document.createElement('div');
                          errorElement.classList.add('text-danger');
                          errorElement.textContent = 'Only image files are allowed.';
                          selectedImageContainer.appendChild(errorElement);

                          var buttonElements = document.querySelectorAll('.input-group-text.form-control');
                          buttonElements.forEach(function(buttonElement) {
                              if (buttonElement) {
                                  buttonElement.innerHTML = '';
                              }
                          });
                       }
                   }

                  $('#exampleModal').modal('hide');
              }
          }
      });
  }

  if (document.getElementById('submitButton')) {

    const submitButton = document.getElementById('submitButton');

    document.getElementById('submitButton').addEventListener('click', function(event) {
        const mediaContainerdata = document.getElementById('media-container');

        event.preventDefault(); // Prevent the default form submission

        submitButton.disabled = true;
        window.uploadedFiles = window.uploadedFiles || [];
        var formData = new FormData();
        var remainingFiles = window.uploadedFiles.filter(file => !file.removed);

        if (remainingFiles.length > 0) {
            document.getElementById('file_url_media').removeAttribute('required');
            document.getElementById('file_url_media-error').style.display = 'none';
            for (var i = 0; i < remainingFiles.length; i++) {
                formData.append('file_url[]', remainingFiles[i].file);
            }

            // Submit the form with remaining files
            var xhr = new XMLHttpRequest();
            xhr.open('POST', `${baseUrl}/app/media-library/store`, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); // Set CSRF token header
            xhr.onloadstart = function() {
                submitButton.innerText = 'Loading...';

            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.uploadedFiles = [];
                    // Trigger the media library tab to refresh
                    document.getElementById('nav-media-library-tab').click();

                    const mediaContainer = document.getElementById('media-container');
                    page = 1; // Reset the page to 1
                    mediaContainer.innerHTML = ''; // Clear the container to load fresh content

                    submitButton.disabled = false;

                    loadPaginatedImages(); // Call the pagination function

                    // Add the scroll event listener after the initial load
                    mediaLibraryContent.addEventListener('scroll', handleScroll);
                    var uploadedImagesCont = document.getElementById('uploadedImages');
                    uploadedImagesCont.innerHTML = '';
                }
            };

            xhr.onloadend = function() {
                submitButton.innerText = 'Save';
            };

            submitButton.disabled = false;

            xhr.send(formData);
        }else{
            document.getElementById('file_url_media').setAttribute('required', 'required');
            document.getElementById('file_url_media-error').style.display = 'block';

            submitButton.innerText = 'Save';
        }

        submitButton.disabled = false;

        if (window.location.href === `${baseUrl}/app/media-library`) {
            window.location.reload();
        }
    });
}

function loadPaginatedImages() {

    const mediaContainer = document.getElementById('media-container');
    const loadingSpinner = document.getElementById('loading-spinner');
    const mediaLibraryContent = document.getElementById('mediaLibraryContent');
    const perPage = 21; // Number of images per page (adjust as needed)

    let isLoading = false;
    let hasMore = true;
    if (isLoading || !hasMore) return; // Prevent duplicate loads

    isLoading = true; // Set loading to true
    fetch(`${baseUrl}/app/media-library/getMediaStore?page=${page}&perPage=${perPage}`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                if (page === 1) {
                    mediaContainer.innerHTML = ''; // Clear existing content only on the first page load
                }

                mediaContainer.insertAdjacentHTML('beforeend', data.html);

                if (data.hasMore) {
                    page++; // Increment page number if more images are available
                } else {
                    hasMore = false; // Set hasMore to false if no more images
                }
            } else {
                console.log("No data received");
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            isLoading = false; // Reset loading status after the fetch completes
        });
}

// Scroll event handler to trigger loading more images
function handleScroll() {

    // Check if the user has scrolled to the bottom of the mediaLibraryContent container
    if (mediaLibraryContent.scrollTop + mediaLibraryContent.clientHeight >= mediaLibraryContent.scrollHeight - 100) {
        loadPaginatedImages(); // Load more images when the user scrolls to the bottom
    }
}

if(exampleModal){
exampleModal.addEventListener('hidden.bs.modal', function () {
    mediaLibraryContent.removeEventListener('scroll', handleScroll);
});
}

function handleVideoQualityTypeChange(section) {
    section.find('.video_quality_type').on('change', function() {
        var selectedType = $(this).val();
        var QualityVideoFileInput = section.find('.quality_video_file_input');
        var QualityVideoURLInput = section.find('.quality_video_input');
        var qualityVideoInput = section.find('input[name="quality_video[]"]');
        var qualityVideoURLInput = section.find('input[name="quality_video_url_input[]"]');
        if (selectedType === 'Local') {
            QualityVideoFileInput.removeClass('d-none');
            QualityVideoURLInput.addClass('d-none');
            qualityVideoInput.val(qualityVideoInput.val()).trigger('change');
            qualityVideoURLInput.val('').trigger('change');
        } else {
            QualityVideoFileInput.addClass('d-none');
            QualityVideoURLInput.removeClass('d-none');
            qualityVideoURLInput.val(qualityVideoURLInput.val()).trigger('change');
            qualityVideoInput.val('').trigger('change');
        }
    }).trigger('change');
}
    function destroySelect2(section) {
        section.find('select.select2').each(function() {
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            }
        });
    }

    function initializeSelect2(section) {
        section.find('select.select2').each(function() {
            $(this).select2({
                width: '100%'
            });
        });
    }
    function initializeFormState() {
        // Handle the initial visibility of input fields based on current values
        $('.video-inputs-container').each(function() {
            handleVideoQualityTypeChange($(this));
        });
    }
    $('#add_more_video').click(function() {
        var originalSection = $('.video-inputs-container').first();
        destroySelect2(originalSection);

        var newSection = originalSection.clone();
        videoInputCounter++; // Increment the counter

        newSection.find('input, select').each(function() {
            var idAttr = $(this).attr('id');
            if (idAttr) {
                $(this).attr('id', idAttr + videoInputCounter);
            }

            var nameAttr = $(this).attr('name');
            if (nameAttr) {
                $(this).attr('name', nameAttr + videoInputCounter);
            }

            $(this).val('').trigger('change');
        });

        newSection.find('.remove-video-input').removeClass('d-none');

        newSection.find('[data-image-container]').each(function() {
            var dataAttr = $(this).attr('data-image-container');
            $(this).attr('data-image-container', dataAttr + videoInputCounter);
        });

        newSection.find('[data-hidden-input]').each(function() {
            var dataAttr = $(this).attr('data-hidden-input');
            $(this).attr('data-hidden-input', dataAttr + videoInputCounter);
        });

        newSection.find('.img-fluid').remove();
        newSection.find('.remove-media-icon').remove();
        newSection.find('input[type="hidden"]').val('');

        newSection.find('div[id]').each(function() {
            var idAttr = $(this).attr('id');
            if (idAttr) {
                $(this).attr('id', idAttr + videoInputCounter);
            }
        });

        $('#video-inputs-container-parent').append(newSection);

        initializeSelect2(newSection);
        handleVideoQualityTypeChange(newSection);
        initializeModal();
        initializeSelect2(originalSection);
    });

    $(document).on('click', '.remove-video-input', function() {
        $(this).closest('.video-inputs-container').remove();
    });
    initializeFormState();
    initializeModal();
    initializeSelect2($(document));
});




  if(document.getElementById('file_url_media')){
    document.getElementById('file_url_media').addEventListener('change', function() {
        var fileInput = document.getElementById('file_url_media');
        var uploadedImagesContainer = document.getElementById('uploadedImages');
        var chunkSize = 1024 * 1024 * 30; // 100 MB chunk size (adjust as necessary)
        var uploadedFiles = [];

        // Clear previously uploaded images and reset progress
        uploadedImagesContainer.innerHTML = '';

        if (fileInput.files.length > 0) {
            for (var i = 0; i < fileInput.files.length; i++) {
                var file = fileInput.files[i];
                var start = 0;
                var end = Math.min(chunkSize, file.size);
                var index = 0;

                if (file.type.startsWith('video/')) {
                    var video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.currentTime = 1; // Capture frame at 1 second

                    video.addEventListener('loadeddata', function() {
                        var canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        var ctx = canvas.getContext('2d');
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        var img = document.createElement('img');
                        img.src = canvas.toDataURL('image/jpeg');
                        img.classList.add('img-fluid', 'iq-uploaded-image');
                        img.style.width = '150px'; // Adjust size as needed
                        img.style.height = '100px';

                        // Create progress bar
                        var progressBar = document.createElement('div');
                        progressBar.classList.add('progress', 'mb-3', 'iq-progress');
                        progressBar.style.visibility = 'hidden'; // Change visibility to hidden initially
                        progressBar.innerHTML = `
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        `;

                        // Create close icon
                        var closeButton = document.createElement('div');
                        closeButton.classList.add('iq-uploaded-image-close');
                        closeButton.innerHTML = '&times;';
                        closeButton.addEventListener('click', function() {
                            uploadedFiles[index].removed = true; // Mark file as removed
                            this.parentNode.remove(); // Remove image on close icon click
                            checkAndClearFileInput();
                        });

                        // Append image, progress bar, and close icon
                        var imageContainer = document.createElement('div');
                        imageContainer.classList.add('iq-uploaded-image-container');
                        imageContainer.appendChild(img);
                        imageContainer.appendChild(progressBar);
                        imageContainer.appendChild(closeButton);
                        uploadedImagesContainer.appendChild(imageContainer);

                        // Track the uploaded file
                        uploadedFiles.push({ file: file, removed: false, progressBar: progressBar.querySelector('.progress-bar') });

                        uploadChunk(file, index, start, end, chunkSize, uploadedFiles, progressBar); // Pass progressBar to uploadChunk
                    });
                } else {
                    var reader = new FileReader();
                    reader.onload = (function(file, index) {
                        return function(e) {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('img-fluid', 'iq-uploaded-image');
                            img.style.width = '150px'; // Adjust size as needed
                            img.style.height = '100px';

                            // Create progress bar
                            var progressBar = document.createElement('div');
                            progressBar.classList.add('progress', 'my-3', 'iq-progress');
                            progressBar.style.visibility = 'hidden'; // Change visibility to hidden initially
                            progressBar.innerHTML = `
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            `;

                            // Create close icon
                            var closeButton = document.createElement('div');
                            closeButton.classList.add('iq-uploaded-image-close');
                            closeButton.innerHTML = '&times;';
                            closeButton.addEventListener('click', function() {
                                uploadedFiles[index].removed = true; // Mark file as removed
                                this.parentNode.remove(); // Remove image on close icon click
                                checkAndClearFileInput();
                            });

                            // Append image, progress bar, and close icon
                            var imageContainer = document.createElement('div');
                            imageContainer.classList.add('iq-uploaded-image-container');
                            imageContainer.appendChild(img);
                            imageContainer.appendChild(progressBar);
                            imageContainer.appendChild(closeButton);
                            uploadedImagesContainer.appendChild(imageContainer);

                            // Track the uploaded file
                            uploadedFiles.push({ file: file, removed: false, progressBar: progressBar.querySelector('.progress-bar') });

                            uploadChunk(file, index, start, end, chunkSize, uploadedFiles, progressBar); // Pass progressBar to uploadChunk
                        };
                    })(file, i);

                    reader.readAsDataURL(file);
                }
            }
        }

        // Track the uploaded files globally
        window.uploadedFiles = uploadedFiles;
        function checkAndClearFileInput() {
            // If all files are removed
            if (uploadedFiles.every(file => file.removed)) {
                fileInput.value = null; // Clear the file input
                uploadedFiles.length = 0; // Clear the uploadedFiles array
                document.getElementById('file_url_media').setAttribute('required', 'required');
                document.getElementById('file_url_media-error').style.display = 'block';
            }
        }
    });
  }

  function uploadChunk(file, index, start, end, chunkSize, uploadedFiles, progressBar) { // Added progressBar parameter
    var chunk = file.slice(start, end);
    var formData = new FormData();
    formData.append('file_chunk', chunk);
    formData.append('index', index);
    formData.append('total_chunks', Math.ceil(file.size / chunkSize));
    formData.append('file_name', file.name);

    // AJAX request to upload chunk
    var xhr = new XMLHttpRequest();

    // Track upload progress
    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            var percentComplete = (e.loaded / e.total) * 100;
            uploadedFiles[index].progressBar.style.width = percentComplete + '%';
            progressBar.style.visibility = 'visible'; // Make progress bar visible during upload
        }
    });

    xhr.open('POST', `${baseUrl}/app/media-library/upload`, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); // Set CSRF token header

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                if (end < file.size) {
                    start = end;
                    end = Math.min(start + chunkSize, file.size);
                    uploadChunk(file, index, start, end, chunkSize, uploadedFiles, progressBar); // Pass progressBar to uploadChunk
                } else {
                    uploadedFiles[index].progressBar.style.width = '100%';
                    progressBar.style.visibility = 'hidden'; // Hide progress bar after completion
                }
            }
        }
    };

    xhr.send(formData);
  }

/////////////////////////////////////////  set image /////////////////////////////////////////

document.addEventListener('DOMContentLoaded', function() {
    // const mediaContainer = document.getElementById('media-container');
    const loadingSpinner = document.getElementById('loading-spinner');
    const mediaLibraryContent = document.getElementById('mediaLibraryContent');
    const searchInput = document.getElementById('media-search');
    const noData = document.getElementById('no_data');
    let page = 1;
    let isLoading = false;
    let hasMore = true;
    let searchQuery = ''; // Variable to store the search query
    let issearch=0; // Variable to hold the debounce timeout ID
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content'); // Adjust if necessary
    let noAvailableMessageShown = false; // Flag to prevent multiple "No Available" messages

    function loadImages(query = '') {


      if (isLoading || (!hasMore  &&  query == '' && issearch==0) ) return;

        isLoading = true;
        loadingSpinner.style.display = 'block';

        fetch(`${baseUrl}/app/media-library/getMediaStore?page=${page}&query=${encodeURIComponent(query)}`)
            .then(response => {

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {

               // clearNoAvailableMessage();

                if (data.html) {

                    noData.classList.add('d-none');
                    if(issearch==1){
                      mediaContainer.innerHTML = '';
                    }

                    mediaContainer.insertAdjacentHTML('beforeend', data.html);
                    page++;
                    noAvailableMessageShown = false; // Reset flag if new images are loaded

                    issearch.value=0;


                } else {

                    issearch.value=0;
                    mediaContainer.innerHTML = '';
                    noData.classList.remove('d-none');

                    $('#no_data').text('No data available');
                }

                hasMore = data.hasMore;
            })
            .catch(error => {
                console.error('Error loading images:', error);
            })
            .finally(() => {
                isLoading = false;
                loadingSpinner.style.display = 'none';
            });
    }

    function onScroll() {

        if (mediaLibraryContent.scrollTop + mediaLibraryContent.clientHeight >= mediaLibraryContent.scrollHeight - 100) {
            loadImages(searchQuery);
        }
    }

    function handleSearchInput() {
        searchQuery = searchInput.value;

        page = 1;
        mediaContainer.innerHTML = '';

      loadImages(searchQuery);

    }
    if(searchInput){
      searchInput.addEventListener('input', function() {
        issearch.value=1;
        handleSearchInput()
    });

    }

    const clearSearchButton = document.getElementById('clear-search');

    function toggleClearButtonVisibility() {
        if (searchInput) {
        if (searchInput.value.length > 0) {
            clearSearchButton.classList.remove('d-none'); // Show the button
        } else {
            clearSearchButton.classList.add('d-none'); // Hide the button
        }
        }
    }
    if (searchInput) {
    // Add event listener for input changes
    searchInput.addEventListener('input', toggleClearButtonVisibility);
    }
    // Add event listener for clear button
    if (clearSearchButton) {
    clearSearchButton.addEventListener('click', function() {
        searchInput.value = ''; // Clear the input field
        toggleClearButtonVisibility(); // Update button visibility
        page = 1; // Reset page number
        searchQuery = ''; // Reset search query
        isLoading = false;
        hasMore = true;
        issearch.value=0;
        mediaContainer.innerHTML = '';
       loadImages(searchQuery);
    });
    }
    // Initialize the visibility on page load
    toggleClearButtonVisibility();


    if(exampleModal){

        exampleModal.addEventListener('shown.bs.modal', function () {
            if (mediaContainer.children.length === 0) {
                loadImages(searchQuery); // Load images based on the search query if present
            }
            mediaLibraryContent.addEventListener('scroll', onScroll);
        });

        exampleModal.addEventListener('hidden.bs.modal', function () {
            mediaLibraryContent.removeEventListener('scroll', onScroll);
        });

        if (mediaContainer.children.length === 0) {
            loadImages(searchQuery);
        }

    }

});


document.addEventListener('DOMContentLoaded', function() {
  const uploadButton = document.getElementById('nav-upload-files-tab');
  const libraryButton = document.getElementById('nav-media-library-tab');
  const searchContainer = document.getElementById('media-search-container');

  if(libraryButton){

  // Function to toggle the search container visibility
  function toggleSearchVisibility() {

      if (libraryButton.classList.contains('active')) {
        if(searchContainer){
          searchContainer.style.display = 'block';
         }
      } else {
        if(searchContainer){

          searchContainer.style.display = 'none';

        }

      }


    }

  // Initial toggle based on the active tab
  toggleSearchVisibility();

  // Add event listeners to toggle the visibility on tab change
  uploadButton.addEventListener('click', toggleSearchVisibility);
  libraryButton.addEventListener('click', toggleSearchVisibility);

}
});






