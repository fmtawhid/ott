<div class="d-flex gap-2 align-items-center justify-content-end">
  @hasPermission('edit_filemanagers')
       <a  class="btn btn-primary" href="{{ route('backend.media-library.edit', $data->id) }}"> <i class="ph ph-pencil-simple-line align-middle"></i></a>

  @endhasPermission
  @if(!$data->trashed())
  @hasPermission('delete_filemanagers')
  <!-- Soft Delete (Trash) -->
  <a class="mr-3 delete-tax" href="{{ route('backend.media-library.destroy', $data->id) }}">
      <i class="ph ph-trash align-middle"></i>
  </a>
  @endhasPermission
@else
  <!-- Restore link -->
  @haspermission('restore_filemanagers')
  <a class="btn btn-info btn-sm fs-4" href="{{ route('backend.media-library.restore', $data->id) }}">
      <i class="ph ph-arrow-clockwise align-middle"></i>
  </a>
  @endhasPermission
  @hasPermission('force_delete_filemanagers')
  <!-- Force Delete link -->
  <a class="force-delete-tax" href="{{ route('backend.media-library.force_delete', $data->id) }}">
      <i class="ph ph-trash align-middle"></i>
  </a>
  @endhasPermission
@endif

</div>

