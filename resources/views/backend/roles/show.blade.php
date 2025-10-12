@extends ('backend.layouts.app')

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
                <x-backend.buttons.return-back />
                <x-buttons.edit route='{!!route("backend.$module_name.edit", $$module_name_singular)!!}' title="{{ __('messages.edit') }} " class="ms-1" />
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.name") }}</th>
                            <td>{{ $$module_name_singular->name }}</td>
                        </tr>

                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.permissions") }}</th>
                            <td>
                                @if($$module_name_singular->permissions()->count() > 0)
                                <ul>
                                    @foreach ($$module_name_singular->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.created_at") }}</th>
                            <td>{{ $$module_name_singular->created_at }}<br><small>({{ $$module_name_singular->created_at->diffForHumans() }})</small></td>
                        </tr>

                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.updated_at") }}</th>
                            <td>{{ $$module_name_singular->updated_at }}<br /><small>({{ $$module_name_singular->updated_at->diffForHumans() }})</small></td>
                        </tr>

                    </table>
                </div>
                <!--table-responsive-->
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-end text-muted">
                    Updated: {{$$module_name_singular->updated_at->diffForHumans()}},
                    Created at: {{$$module_name_singular->created_at->isoFormat('LLLL')}}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
