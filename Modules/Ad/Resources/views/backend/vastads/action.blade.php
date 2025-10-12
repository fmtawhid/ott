<div class="d-flex gap-2 align-items-center justify-content-end">
    @if (!$data->trashed())
        <!-- Edit button -->
        @hasPermission('edit_vastads')
        <a class="btn btn-warning-subtle btn-sm fs-4" href="{{ route('backend.vastads.edit', $data->id) }}" data-bs-toggle="tooltip" title="{{ __('messages.edit') }}">
            <i class="ph ph-pencil-simple-line align-middle"></i>
        </a>
        @endhasPermission

    

        @hasPermission('delete_vastads')
        <!-- Soft Delete (Trash) -->
        <a href="{{ route('backend.vastads.destroy', $data->id) }}" id="delete-vastads-{{ $data->id }}" class="btn btn-secondary-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip" title="{{ __('messages.delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
            <i class="ph ph-trash align-middle"></i>
        </a>
        @endhasPermission
    @else
    @hasPermission('restore_vastads')
        <!-- Restore link -->
        <a class="btn btn-success-subtle btn-sm fs-4 restore-tax" data-confirm-message="{{__('messages.are_you_sure_restore')}}" 
    data-success-message="{{trans('messages.restore_form')}}" href="{{ route('backend.vastads.restore', $data->id) }}" data-bs-toggle="tooltip" title="{{ __('messages.restore') }}">
            <i class="ph ph-arrow-clockwise align-middle"></i>
        </a>
        @endhasPermission
        @hasPermission('force_delete_vastads')

        <!-- Force Delete link -->
        <a href="{{ route('backend.vastads.force_delete', $data->id) }}" id="delete-vastads-{{ $data->id }}" class="btn btn-danger-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip" title="{{ __('messages.force_delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
            <i class="ph ph-trash align-middle"></i>
        </a>
        @endhasPermission
    @endif
    
</div>
