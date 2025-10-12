<div class="text-end">
    <button type='button' data-slot-module="{{$data->id}}"  data-slot-target='#slot-form-offcanvas' data-slot-event='staff_slot_assign' class='btn btn-secondary btn-icon btn-sm'data-bs-toggle="tooltip" data-bs-title="{{__('Available Slots')}}" ><i class="fa-solid fa-calendar-days"></i></button>
    <a href="{{route('backend.users.show', $data)}}" class="btn btn-success btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="{{__('labels.backend.show')}}"><i class="fa-solid fa-eye"></i></a>
    <a href="{{route('backend.users.edit', $data)}}" class="btn btn-primary btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="{{__('labels.backend.edit')}}"><i class="ph ph-pencil-simple-line align-middle"></i></a>
    <a href="{{route('backend.users.changePassword', $data)}}" class="btn btn-info btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="{{__('labels.backend.changePassword')}}"><i class="fas fa-key"></i></a>

    @if ($data->status != 2 && $data->id != 1)
    <a href="{{route('backend.users.block', $data)}}" class="btn btn-danger btn-icon btn-sm" data-method="PATCH" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" data-bs-title="{{__('labels.backend.block')}}" data-confirm="{{ __('messages.are_you_sure?') }}"><i class="fas fa-ban"></i></a>
    @endif

    @if ($data->status == 2)
    <a href="{{route('backend.users.unblock', $data)}}" class="btn btn-info btn-icon btn-sm" data-method="PATCH" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" data-bs-title="{{__('labels.backend.unblock')}}" data-confirm="{{ __('messages.are_you_sure?') }}"><i class="fas fa-check"></i></a>
    @endif

    @if ($data->id != 1)
    <a href="{{route('backend.users.destroy', $data)}}" class="btn btn-danger btn-icon btn-sm" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" data-bs-title="{{__('labels.backend.delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash align-middle"></i></a>
    @endif

    @if ($data->email_verified_at == null)
    <a href="{{route('backend.users.emailConfirmationResend', $data->id)}}" class="btn btn-primary btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="@lang('send_confirmation_email')"><i class="fas fa-envelope"></i></a>
    @endif
</div>
