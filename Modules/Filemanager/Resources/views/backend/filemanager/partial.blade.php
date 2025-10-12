@foreach ($mediaUrls as $media)
    @php
        // যদি media array থাকে (Spatie MediaLibrary)
        if(isset($media['media'][0]['original_url'])) {
            $mediaUrl = $media['media'][0]['original_url'];
        } else {
            // না হলে default file_url ব্যবহার কর
            $mediaUrl = $media['file_url'] ?? $media;
        }

        $isVideo = strpos($mediaUrl, '.mp4') !== false || strpos($mediaUrl, '.webm') !== false;
        $mediaType = $isVideo ? 'video' : 'image';
    @endphp

    <div id="media-images">
        <div class="iq-media-images position-relative">
            @if($mediaType === 'video')
                <video class="img-fluid object-fit-cover" style="width:10rem;height:10rem;" preload="metadata" controlsList="nodownload" controls>
                    <source src="{{ $mediaUrl }}" type="video/mp4">
                </video>
            @else
                <img class="img-fluid object-fit-cover" src="{{ $mediaUrl }}" style="width:10rem;height:10rem;" loading="lazy">
            @endif
            <button class="btn btn-danger position-absolute top-0 start-0 m-2 py-1 px-2 iq-button-delete" onclick="deleteImage('{{ $mediaUrl }}')">
                <i class="ph ph-trash"></i>
            </button>
            <p class="media-title pt-2 mb-0" data-bs-toggle="tooltip" data-bs-title="{{ basename($mediaUrl) }}">{{ basename($mediaUrl) }}</p>
        </div>
    </div>
@endforeach


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
                        mediaContainer.closest('#media-images').remove();
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
                    Swal.fire('Error!', 'There was a problem deleting your media.', 'error');
                }
            });
        }
    });
}
</script>
