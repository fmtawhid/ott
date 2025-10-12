<div class="d-flex gap-2 align-items-center justify-content-end">

    <!-- Soft Delete (Trash) -->
    @if(!$data->trashed())

    @hasPermission('edit_tvshows')
    <a  class="btn btn-warning-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{__('messages.edit')}}" href="{{ route('backend.tvshows.edit', $data->id) }}"> <i class="ph ph-pencil-simple-line align-middle"></i></a>
    @endhasPermission
    <a class="btn btn-info-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{__('messages.details')}}"  href="{{ route('backend.entertainments.details', $data->id) }}" >
        <i class="ph ph-eye align-middle"></i>
    </a>

    @hasPermission('delete_tvshows')
  <a href="{{route("backend.entertainments.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="btn btn-secondary-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('messages.delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash align-middle"></i></a>
  @endhasPermission
@else
    @hasPermission('restore_tvshows')
    <!-- Restore link -->
    <a class="btn btn-success-subtle btn-sm fs-4 restore-tax" data-confirm-message="{{__('messages.are_you_sure_restore')}}"
    data-success-message="{{__('messages.restore_form',  ['form' => 'TV Show'])}}" data-bs-toggle="tooltip" title="{{__('messages.restore')}}" href="{{ route('backend.entertainments.restore', $data->id) }}">
        <i class="ph ph-arrow-clockwise align-middle"></i>
    </a>
    @endhasPermission

    @hasPermission('force_delete_tvshows')
    <!-- Force Delete link -->
    <a href="{{route("backend.entertainments.force_delete", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="btn btn-danger-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('messages.force_delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash align-middle"></i></a>
    @endhasPermission
  @endif

</div>

