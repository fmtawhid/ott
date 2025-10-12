<div class="text-center">
    @can('edit_'.$module_name)
    <x-buttons.edit route='{!!route("backend.$module_name.edit", $data)!!}' title="{{ __('messages.edit') }} " small="true" />
    @endcan
    <x-buttons.show route='{!!route("backend.$module_name.show", $data)!!}' title="{{__('Show')}} {{ __($module_title) }}" small="true" />
</div>
