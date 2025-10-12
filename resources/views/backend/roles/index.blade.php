@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection



@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ __($module_title) }}" />
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.name") }}</th>
                            <th>{{ __("labels.backend.$module_name.fields.permissions") }}</th>
                            <th class="text-end">{{ __("labels.backend.action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($$module_name as $module_name_singular)
                        <tr>
                            <td>
                                <strong>
                                    {{ $module_name_singular->name }}
                                </strong>
                            </td>
                            <td>
                                @foreach ($module_name_singular->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                                @endforeach
                            </td>
                            <td class="text-end">
                                @can('edit_'.$module_name)
                                <x-buttons.edit route='{!!route("backend.$module_name.edit", $module_name_singular)!!}' title="{{ __('messages.edit') }} " small="true" />
                                @endcan
                                <x-buttons.show route='{!!route("backend.$module_name.show", $module_name_singular)!!}' title="{{__('Show')}} {{ __($module_title) }}" small="true" />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $$module_name->total() !!} {{ __('labels.backend.total') }}
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $$module_name->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
