<div class="d-flex gap-2 align-items-center justify-content-end">
    @if($data)
        <a href="javascript:void(0);" 
           class="btn btn-secondary-subtle btn-sm fs-4 delete-btn" 
           data-bs-toggle="tooltip" 
           title="{{ __('messages.delete') }}"
           data-id="{{ $data->id }}"  
           onclick="deleteNotification(this)">
            <i class="ph ph-trash align-middle"></i>
        </a>
    @endif
</div>


   <script>
   function deleteNotification(element) {
    const id = element.getAttribute('data-id');
    let baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    confirmSwal('{{ __('messages.are_you_sure?') }}').then((result) => {
        if (result.isConfirmed) {
            fetch(`${baseUrl}/notification-remove/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                handleDeleteResponse(data);
            })
            .catch(handleError);
        }
    });
}
// Helper function to handle successful delete response
function handleDeleteResponse(data) {
    if (data.status) {
        Swal.fire({
            title: '{{ __('messages.delete') }}',
            text: data.message,
            icon: 'success'
        }).then(() => {
            location.reload(); // Reload page if the deletion was successful
        });
    } else {
        Swal.fire({
            title: '{{ __('messages.error') }}',
            text: '{{ __('messages.could_not_delete') }}',
            icon: 'error'
        });
    }
}

// Helper function to handle errors
function handleError(error) {
    console.error('Error:', error);
    Swal.fire({
        title: '{{ __('messages.error') }}',
        text: '{{ __('messages.deletion_error_occurred') }}',
        icon: 'error'
    });
}
</script>
