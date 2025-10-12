@extends ('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection



@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> <span class="text-capitalize">{{ $module_title }}</span> <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ __($module_title) }}" />

                <div class="btn-group">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-target="#module-dropdown-01" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu" id="module-dropdown-01">
                        <li>
                            <a class="dropdown-item" href='{{ route("backend.$module_name.trashed") }}'>
                                <i class="fas fa-eye-slash"></i> View trash
                            </a>
                        </li>
                    </ul>
                </div>
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover ">
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">

                </div>
            </div>
            <div class="col-5">
                <div class="float-end">

                </div>
            </div>
        </div>
    </div>
</div>
<div data-render="app">
    <staff-slot-mapping-form-offcanvas></staff-slot-mapping-form-offcanvas>
</div>
@if(session('success'))
<div class="snackbar" id="snackbar">
    <div class="d-flex justify-content-around align-items-center">
        <p class="mb-0">{{ session('success') }}</p>
        <a href="#" class="dismiss-link text-decoration-none text-success" onclick="dismissSnackbar(event)">Dismiss</a>
    </div>
</div>
@endif
@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>


<script type="text/javascript">
    window.renderedDataTable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.$module_name.index_data", $roleBaseList ?? "all") }}',
        drawCallback: function() {
            if(laravel !== undefined) {
                window.laravel.initialize();
            }
        },
        columns: [{
                data: 'id',
                name: 'id',
                title: '#'
            },

            {
                data: 'email',
                name: 'email',
                title: 'E-mail'
            },
            {
                data: 'status',
                name: 'status',
                title: 'Status'
            },
            {
                data: 'user_roles',
                name: 'user_roles',
                title: 'Roles'
            },
            {
                data: 'action',
                name: 'action',
                title: 'Actions',
                class: 'text-end',
                orderable: false,
                searchable: false
            }
        ]
    });
</script>
@endpush
