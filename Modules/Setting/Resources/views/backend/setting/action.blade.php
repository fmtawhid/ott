<div class="d-flex gap-2 align-items-center justify-content-end">
  @hasPermission('edit_setting')
       <a  class="btn btn-primary" href="{{ route('backend.settings.edit', $data->id) }}"> <i class="ph ph-pencil-simple-line align-middle"></i></a>

  @endhasPermission
  @if(!$data->trashed())
  @hasPermission('delete_setting')
  <!-- Soft Delete (Trash) -->
  <a class="mr-3 delete-tax" href="{{ route('backend.settings.destroy', $data->id) }}">
      <i class="ph ph-trash align-middle"></i>
  </a>
  @endhasPermission
@else
  <!-- Restore link -->
  @haspermission('restore_setting')
  <a class="btn btn-info btn-sm fs-4" href="{{ route('backend.settings.restore', $data->id) }}">
      <i class="ph ph-arrow-clockwise align-middle"></i>
  </a>
  @endhasPermission
  @haspermission('force_delete_setting')
  <!-- Force Delete link -->
  <a class="force-delete-tax" href="{{ route('backend.settings.force_delete', $data->id) }}">
      <i class="ph ph-trash align-middle"></i>
  </a>
  @endhasPermission
@endif
</div>

