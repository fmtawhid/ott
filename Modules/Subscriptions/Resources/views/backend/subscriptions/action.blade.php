<div class="d-flex gap-2 align-items-center justify-content-end">
  @if(!$data->trashed())
     {{-- @hasPermission('edit_subscriptions')
      <a class="btn btn-warning-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{ __('messages.edit') }}" href="{{ route('backend.subscriptions.edit', $data->id) }}">
          <i class="ph ph-pencil-simple-line align-middle"></i>
      </a>
      @endhasPermission--}}

      @hasPermission('force_delete_subscriptions')
            <a href="{{route('backend.subscriptions.force_delete', $data->id)}}" id="delete-subscriptions-{{$data->id}}" class="btn btn-danger-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('messages.force_delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash align-middle"></i></a>
            @endhasPermission
  @endif
</div>
