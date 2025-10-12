<div class="d-flex gap-2 align-items-center justify-content-end">
  @if(!$data->trashed())
      
       <a  class="copy-url btn btn-success-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{__('messages.copy')}}" href="{{ route('backend.copyurl',$data->slug) }}" onclick="copyURL(event)"> <i class="ph ph-clipboard align-middle"></i></a>
       @hasPermission('edit_page')
       <a  class="btn btn-warning-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{__('messages.edit')}}" href="{{ route('backend.pages.edit', $data->id) }}"> <i class="ph ph-pencil-simple-line align-middle"></i></a>
       @endhasPermission
  
  <!-- Soft Delete (Trash) -->
  @hasPermission('delete_page')
  <a href="{{ route('backend.pages.destroy', $data->id) }}" id="delete-{{ $module_name }}-{{ $data->id }}" class="btn btn-secondary-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip" title="{{ __('messages.delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
            <i class="ph ph-trash align-middle"></i>
        </a>
        @endhasPermission
@else
@hasPermission('restore_page')
  <!-- Restore link -->
  <a class="btn btn-success-subtle btn-sm fs-4 restore-tax" data-bs-toggle="tooltip" title="{{__('messages.restore')}}" href="{{ route('backend.pages.restore', $data->id) }}" data-confirm-message="{{__('messages.are_you_sure_restore')}}" 
   data-success-message="{{trans('messages.restore_form',  ['form' => 'Page'])}}">
      <i class="ph ph-arrow-clockwise align-middle"></i>
  </a>
  @endhasPermission
  @hasPermission('force_delete_page')
    <!-- Force Delete link -->
  <a href="{{ route('backend.pages.force_delete', $data->id) }}" id="delete-{{ $module_name }}-{{ $data->id }}" class="btn btn-danger-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip" title="{{ __('messages.force_delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
              <i class="ph ph-trash align-middle"></i>
          </a>
        @endhasPermission
@endif

</div>

