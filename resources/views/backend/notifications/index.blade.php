@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection


@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/subscriptions/style.css') }}">
@endpush
@section('content')
<div class="card-main mb-5">

    <table id="datatable" class="table table-responsive">
    </table>
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

@push('after-styles')

    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<script src="{{ asset('js/form/index.js') }}" defer></script>

    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" defer>

const columns = [
            {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="genres"  onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            { data: 'id', name: 'id',title: "{{ __('notification.lbl_id') }}" ,orderable: false, searchable: false, },
            { data: 'type', name: 'type',title: "{{ __('notification.type') }}" ,orderable: false, searchable: false, },
            { data: 'text', name: 'text',title: "{{ __('notification.lbl_text') }}" ,orderable: false, searchable: false, },
            { data: 'customer', name: 'customer',title: "{{ __('notification.lbl_customer') }}" ,orderable: false, searchable: false, },
            { data: 'updated_at', name: 'updated_at',title: "{{ __('messages.update_at') }}" ,orderable: false, searchable: false, },

        ]

        const actionColumn = [
            { data: 'action', name: 'action', orderable: false, searchable: false, title: "{{ __('messages.action') }}" }
        ]


        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {

            $('#name').on('input', function() {
              window.renderedDataTable.ajax.reload(null, false);
             });

            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [
                     
             ],

             advanceFilter: () => {
                return {
                    name: $('#name').val(),

                };
            }
            });

            $('#reset-filter').on('click', function(e) {
            $('#name').val('');

           window.renderedDataTable.ajax.reload(null, false);
          });
        })


    </script>
@endpush
