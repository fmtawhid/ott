@extends ('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection



@section('content')
    <div class="card">
        <div class="card-body">

            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i> {{ $module_title }} <small
                    class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="subtitle">
                    @lang(':module_name Management Dashboard', ['module_name' => Str::title($module_name)])
                </x-slot>
                <x-slot name="toolbar">
                    <x-backend.buttons.return-back />
                    <a href='{{ route("backend.notification-templates.index") }}' class="btn btn-secondary" data-bs-toggle="tooltip"
                        title="{{ __($module_name) }} List"><i class="fas fa-list"></i> List</a>
                </x-slot>
            </x-backend.section-header>

            <div class="row mt-4">
                <div class="col">
                    <table id="datatable" class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Updated At
                                </th>
                                <th>
                                    Created By
                                </th>
                                <th class="text-end">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($$module_name as $module_name_singular)
                                <tr>
                                    <td>
                                        {{ $module_name_singular->id }}
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $module_name_singular->name }}
                                        </strong>
                                    </td>
                                    <td>
                                        {{ $module_name_singular->updated_at->isoFormat('llll') }}
                                    </td>
                                    <td>
                                        {{ $module_name_singular->created_by }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route("backend.$module_name.restore", $module_name_singular) }}"
                                            class="btn btn-warning btn-sm" data-method="PATCH"
                                            data-token="{{ csrf_token() }}" data-bs-toggle="tooltip"
                                            title="{{ __('labels.backend.restore') }}"><i class='fas fa-undo'></i>
                                            {{ __('labels.backend.restore') }}</a>
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
                        Total {{ $$module_name->total() }} {{ __($module_name) }}
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

@push('after-scripts-end')
@endpush
