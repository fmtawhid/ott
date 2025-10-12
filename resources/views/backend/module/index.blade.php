@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@push('after-styles')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
          <x-backend.section-header>
            <div>

            </div>
            <x-slot name="toolbar">

              <div class="input-group flex-nowrap">
                <span class="input-group-text pe-0" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control dt-search" placeholder="{{ __('messages.search') }}..." aria-label="Search" aria-describedby="addon-wrapping">
              </div>

                <x-buttons.offcanvas target='#form-offcanvas' title="{{ __('messages.create') }}  {{ __($module_title) }}">{{ __('messages.create') }}  {{ __($module_title) }}</x-buttons.offcanvas>

            </x-slot>
          </x-backend.section-header>
          <table id="datatable" class="table table-responsive">
          </table>
        </div>
    </div>

    <div data-render="app">
        <module-form-offcanvas
            create-title="{{ __('messages.create') }} {{ __('messages.new') }} {{ __($module_title) }}"
            edit-title="{{ __('messages.edit') }} {{ __($module_title) }}"
             >
        </module-form-offcanvas>

    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')

    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>



const columns = [
             {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                width: '5%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            { data: 'module_name', name: 'module_name', title: "{{ __('page.lbl_name') }}" },
        ]

        const actionColumn = [
            { data: 'action', name: 'action', orderable: false, searchable: false, title: "{{ __('page.lbl_action') }}",  width: '5%', }
        ]

        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
            })
        })



    </script>
@endpush
