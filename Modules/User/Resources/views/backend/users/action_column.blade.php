<div class="d-flex gap-2 align-items-center justify-content-end">

        <a class="btn btn-warning-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{__('messages.edit')}}" href="{{ route('backend.users.edit', $data->id) }}"> <i
                class="ph ph-pencil-simple-line align-middle"></i></a>

        <a class="btn btn-info-subtle btn-sm fs-4" href="{{ route('backend.users.details', $data->id) }}" data-bs-toggle="tooltip" title="{{ __('messages.details') }}">
            <i class="ph ph-eye align-middle"></i>
        </a>
@if($data->login_type != 'google')
        <a class="btn btn-success-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{__('messages.change_password')}}"  href="{{ route('backend.users.changepassword', $data->id) }}">
            <i class="ph ph-lock align-middle"></i>
        </a>
@endif
         <!-- Soft Delete (Trash) -->
         <a href="{{ route('backend.users.destroy', $data->id) }}"
            id="delete-{{ $module_name }}-{{ $data->id }}" class="btn btn-secondary-subtle btn-sm fs-4" data-type="ajax"
            data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip"
            title="{{ __('messages.delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i
                class="ph ph-trash align-middle"></i></a>


</div>
