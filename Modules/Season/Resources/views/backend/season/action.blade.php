<div class="d-flex gap-2 align-items-center justify-content-end">
    @if(!$data->trashed())
  @hasPermission('edit_seasons')
  <a class="btn btn-warning-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{__('messages.edit')}}" href="{{ route('backend.seasons.edit', $data->id) }}">
      <i class="ph ph-pencil-simple-line align-middle"></i>
  </a>
  @endhasPermission
 <!-- Details button -->
 <a class="btn btn-info-subtle btn-sm fs-4" href="{{ route('backend.seasons.details', $data->id) }}" data-bs-toggle="tooltip" title="{{ __('messages.details') }}">
            <i class="ph ph-eye align-middle"></i>
        </a>
  
      @hasPermission('delete_seasons')
      <!-- Soft Delete (Trash) -->
      <a href="{{ route('backend.seasons.destroy', $data->id) }}" id="delete-locations-{{ $data->id }}" class="btn btn-secondary-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip" title="{{ __('messages.delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
          <i class="ph ph-trash align-middle"></i>
      </a>
      @endhasPermission 
  @else
      <!-- Restore link -->
      @hasPermission('restore_seasons')
      <a class="btn btn-success-subtle btn-sm fs-4 restore-tax" data-confirm-message="{{__('messages.are_you_sure_restore')}}" 
   data-success-message="{{__('messages.restore_form',  ['form' => 'Season'])}}" data-bs-toggle="tooltip" title="{{__('messages.restore')}}" href="{{ route('backend.seasons.restore', $data->id) }}">
          <i class="ph ph-arrow-clockwise align-middle"></i>
      </a>
      @endhasPermission 
      

      <!-- Force Delete link -->
      @hasPermission('force_delete_seasons')
      <a href="{{ route('backend.seasons.force_delete', $data->id) }}" id="delete-locations-{{ $data->id }}" class="btn btn-danger-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip" title="{{ __('messages.force_delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
          <i class="ph ph-trash align-middle"></i>
      </a>
      @endhasPermission
  @endif
</div>

