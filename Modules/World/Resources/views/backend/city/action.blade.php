<div class="d-flex gap-2 align-items-center justify-content-end">
  @if(!$data->trashed())
  @hasPermission('edit_city')
       <a  class="btn btn-primary" href="{{ route('backend.city.edit', $data->id) }}"> <i class="ph ph-pencil-simple-line align-middle"></i></a>

  @endhasPermission
  
  <!-- Soft Delete (Trash) -->
  @hasPermission('delete_city')
  <a class="mr-3 delete-tax" href="{{ route('backend.city.destroy', $data->id) }}">
      <i class="ph ph-trash align-middle"></i>
  </a>
  @endhasPermission
@else
  <!-- Restore link -->
  @haspermission('restore_city')
  <a class="btn btn-info btn-sm fs-4" href="{{ route('backend.city.restore', $data->id) }}">
      <i class="ph ph-arrow-clockwise align-middle"></i>
  </a>
  @endhasPermission
  @haspermission('force_delete_city')
  <!-- Force Delete link -->
  <a class="force-delete-tax" href="{{ route('backend.city.force_delete', $data->id) }}">
      <i class="ph ph-trash align-middle"></i>
  </a>
  @endhasPermission
@endif

</div>

