<!-- <div class="d-flex gap-2 align-items-center">
    <a href="{{ route('backend.coupon.coupons-view', ['id' => $data->id]) }}" class="btn btn-secondary btn-sm" data-type="ajax"
        data-bs-toggle="tooltip" title="{{ __('messages.coupon_view') }}"> <i class="fa-solid fa-table"></i></a>

    {{-- <button type="button" class="btn btn-primary btn-sm" data-crud-id="{{ $data->id }}"
        title="{{ __('messages.edit') }} " data-bs-toggle="tooltip"> <i class="fa-solid fa-pen-clip"></i></button> --}}
        <a href="{{ route('backend.coupon.edit', $data->id) }}" class="btn btn-primary btn-sm" title="{{ __('messages.edit') }}">
            <i class="fa-solid fa-pen-clip"></i>
        </a>
        
    <a href="{{ route("backend.$module_name.destroy", $data->id) }}" id="delete-{{ $module_name }}-{{ $data->id }}"
        class="btn btn-danger btn-sm" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}"
        data-bs-toggle="tooltip" title="{{ __('messages.delete') }}"
        data-confirm="{{ __('messages.are_you_sure?', ['module' => __('promotion.singular_title'), 'name' => $data->name]) }}">
        <i class="fa-solid fa-trash"></i></a>

</div> -->


<div class="d-flex gap-2 align-items-center justify-content-end">

    @if(!$data->trashed())
        @hasPermission('edit_coupon')
        <a  class="btn btn-warning-subtle btn-sm fs-4" data-bs-toggle="tooltip" title="{{__('messages.edit')}}" href="{{ route('backend.coupon.edit', $data->id) }}"> <i class="ph ph-pencil-simple-line align-middle"></i></a>
        @endhasPermission

        @hasPermission('delete_coupon')
        <a href="{{ route("backend.$module_name.destroy", $data->id) }}" id="delete-locations-{{$data->id}}" class="btn btn-secondary-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('messages.delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash align-middle"></i></a>
        @endhasPermission
    @else
    @hasPermission('restore_coupon')
        <a class="btn btn-success-subtle btn-sm fs-4 restore-tax" data-confirm-message="{{__('messages.are_you_sure_restore')}}"
    data-success-message="{{__('messages.restore_form',  ['form' => 'Coupon'])}}" data-bs-toggle="tooltip" title="{{__('messages.restore')}}" href="{{ route('backend.coupon.restore', $data->id) }}">
            <i class="ph ph-arrow-clockwise align-middle"></i>
        </a>
        @endhasPermission
        @hasPermission('force_delete_coupon')
        <a href="{{route('backend.coupon.force_delete', $data->id)}}" id="delete-locations-{{$data->id}}" class="btn btn-danger-subtle btn-sm fs-4" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('messages.force_delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash align-middle"></i></a>
        @endhasPermission
    @endif
</div>

