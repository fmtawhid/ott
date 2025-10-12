<div class="d-flex gap-3 align-items-center">
  @hasPermission('edit_notification_template')
    <a href="{{route("backend.notification-templates.edit", $data->id)}}" class="btn btn-warning-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{ __('messages.edit') }} "> <i class="ph ph-pencil-simple-line"></i></a>
  @endhasPermission


</div>
