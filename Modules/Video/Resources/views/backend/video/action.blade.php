<div class="d-flex gap-2 align-items-center justify-content-end">

    @if (!$data->trashed())
        @hasPermission('edit_videos')
        <a class="btn btn-warning-subtle btn-sm fs-4"  data-bs-toggle="tooltip" title="{{__('messages.edit')}}" href="{{ route('backend.videos.edit', $data->id) }}">
            <i class="ph ph-pencil-simple-line align-middle"></i>
        </a>
        @endhasPermission


        <!-- Download -->
        @if (!empty($data) && $data->download_status == 1)
        <a class="btn btn-indigo-subtle btn-sm fs-4"
            href="{{ route('backend.videos.download-option', $data->id) }}" data-bs-toggle="tooltip"
            title="{{ __('messages.download') }}">
            <i class="ph ph-cloud-arrow-down align-middle"></i>
        </a>
        @endif

        @hasPermission('delete_videos')
        <!-- Soft Delete (Trash) -->
        <a href="{{ route('backend.videos.destroy', $data->id) }}"  id="delete-{{ $module_name }}-{{ $data->id }}" class="btn btn-secondary-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip" title="{{ __('messages.delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
            <i class="ph ph-trash align-middle"></i>
        </a>
        @endhasPermission

        
     
    @else
    @hasPermission('restore_videos')
        <!-- Restore link -->
        <a class="btn btn-success-subtle btn-sm fs-4 restore-tax" data-confirm-message="{{__('messages.are_you_sure_restore')}}" 
   data-success-message="{{__('messages.restore_form',  ['form' => 'Video'])}}" data-bs-toggle="tooltip" title="{{__('messages.restore')}}" href="{{ route('backend.videos.restore', $data->id) }}">
            <i class="ph ph-arrow-clockwise align-middle"></i>
        </a>
        @endhasPermission

        @hasPermission('force_delete_videos')
        <a href="{{ route('backend.videos.force_delete', $data->id) }}"  data-bs-toggle="tooltip"
            title="{{ __('messages.force_delete') }}" id="delete-{{ $module_name }}-{{ $data->id }}" class="btn btn-danger-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip" title="{{ __('messages.delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
            <i class="ph ph-trash align-middle"></i>
        </a>
        @endhasPermission
    @endif

</div>
