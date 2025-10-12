<div>
    <div class="d-flex gap-2 align-items-center justify-content-end">
        @hasPermission('edit_service_provider')
            <button type="button" class="btn btn-primary-subtle btn-sm" data-crud-id="{{ $data->id }}"
                title="{{ __('messages.edit') }} " data-bs-toggle="tooltip"> <i class="ph ph-pencil-simple-line align-middle"></i></button>
        @endhasPermission
        @hasPermission('delete_service_provider')
            <a href="{{ route("backend.$module_name.destroy", $data->id) }}"
                id="delete-{{ $module_name }}-{{ $data->id }}" class="btn btn-dark btn-sm fs-4" data-type="ajax"
                data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip"
                title="{{ __('messages.delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i
                    class="fa-solid fa-trash"></i></a>
        @endhasPermission
    </div>
</div>
