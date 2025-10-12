@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ __($module_title) }}
                </h4>
                <div class="small text-medium-emphasis">@lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])</div>
            </div>
            <div class="btn-toolbar d-block" role="toolbar" aria-label="Toolbar with buttons">
                @hasPermission('add_backup')
                <a href="{{ route("backend.$module_name.create") }}" class="btn btn-outline-success m-1" data-bs-toggle="tooltip" title="Create New"><i class="fas fa-plus-circle"></i> @lang("Create new :module_name", ['module_name'=>Str::title($module_name)])</a>
                @endhasPermission
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">

                @if (count($backups))
                <table id="datatable" class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                @lang('File')
                            </th>
                            <th>
                                @lang('Size')
                            </th>
                            <th>
                                @lang('Date')
                            </th>
                            <th>
                                @lang('Age')
                            </th>
                            <th class="text-end">
                                @lang('Action')
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($backups as $key => $backup)
                        <tr>
                            <td>
                                {{ ++$key }}
                            </td>
                            <td>
                                {{ $backup['file_name'] }}
                            </td>
                            <td>
                                {{ $backup['file_size'] }}
                            </td>
                            <td>
                                {{ $backup['date_created'] }}
                            </td>
                            <td>
                                {{ $backup['date_ago'] }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route("backend.$module_name.download", $backup['file_name']) }}" class="btn btn-primary m-1 btn-sm" data-bs-toggle="tooltip" title="@lang('Download File')"><i class="fas fa-cloud-download-alt"></i>&nbsp;@lang('Download')</a>
                                @hasPermission('delete_backup')
                                <a href="{{ route("backend.$module_name.delete", $backup['file_name']) }}" class="btn btn-danger m-1 btn-sm" data-bs-toggle="tooltip" title="@lang('Delete File')"><i class="fas fa-trash"></i>&nbsp;@lang('Delete')</a>
                                @endhasPermission
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center">
                    <h4>@lang('There are no backups')</h4>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
