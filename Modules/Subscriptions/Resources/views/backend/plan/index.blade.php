@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('content')
<div class="card-main mb-5">
    <x-backend.section-header>
        <div class="d-flex flex-wrap gap-3">
            <x-backend.quick-action url="{{ route('backend.' . $module_name . '.bulk_action') }}">
                <div class="">
                    <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                        style="width:100%">
                        <option value="">{{ __('messages.no_action') }}</option>

                        <option value="change-status">{{ __('messages.lbl_status') }}</option>
                        @hasPermission('delete_plans')
                        <option value="delete">{{ __('messages.delete') }}</option>
                        @endhasPermission
                        @hasPermission('restore_plans')
                        <option value="restore">{{ __('messages.restore') }}</option>
                        @endhasPermission
                        @hasPermission('force_delete_plans')
                        <option value="permanently-delete">{{ __('messages.permanent_dlt') }}</option>
                        @endhasPermission
                    </select>
                </div>
                <div class="select-status d-none quick-action-field" id="change-status-action">
                    <select name="status" class="form-control select2" id="status" style="width:100%">
                        <option value="" selected>{{ __('messages.select_status') }}</option>
                        <option value="1">{{ __('messages.active') }}</option>
                        <option value="0">{{ __('messages.inactive') }}</option>
                    </select>
                </div>
            </x-backend.quick-action>


            <div>
                <!-- <button type="button" class="btn btn-dark" data-modal="export">
                    <i class="ph ph-export align-middle"></i> {{ __('messages.export') }}
                    </button> -->

            </div>
        </div>

        <x-slot name="toolbar">
            <div>
                <div class="datatable-filter">
                    <select name="column_status" id="column_status" class="select2 form-control"
                        data-filter="select" style="width: 100%">
                        <option value="">{{__('messages.all')}}</option>
                        <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                            {{ __('messages.inactive') }}</option>
                        <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                            {{ __('messages.active') }}</option>
                    </select>
                </div>
            </div>
            <div class="input-group flex-nowrap">
                <span class="input-group-text pe-0" id="addon-wrapping"><i
                        class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control dt-search" placeholder="{{__('placeholder.lbl_search')}}" aria-label="Search"
                    aria-describedby="addon-wrapping">
            </div>

            @hasPermission('add_plans')
            <a href="{{ route('backend.' . $module_name . '.create') }}" class="btn btn-primary d-flex align-items-center gap-1"
                id="add-post-button"> <i class="ph ph-plus-circle"></i>{{__('messages.new')}}</a>
                @endhasPermission

        </x-slot>
    </x-backend.section-header>
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
<x-backend.advance-filter>
    <x-slot name="title">
        <h4 class="mb-0">{{ __('service.lbl_advanced_filter') }}</h4>
    </x-slot>
    <form action="javascript:void(0)" class="datatable-filter">
        <div class="form-group">

            <label class="form-label" for="name">{{ __('users.lbl_name') }}</label>
            <input type="text" name="name" id="name" class="form-control"
                placeholder="">
        </div>

        <div class="form-group">
        <label for="level" class="form-label">{{ __('plan.lbl_level') }}</label>
        <select class="form-control select2" name="level" id="level">
                <option value="">{{ __('Select Level') }}</option>
                @if(isset($plan) && $plan > 0)
                @for($i = 1; $i <= $plan + 1; $i++)
                  <option value="{{ $i }}">{{ 'Level ' . $i }}</option>
                @endfor
               @else
               <option value="1" selected>{{ 'Level 1' }}</option>
               @endif
           </select>
        </div>

        <div class="form-group">
        <label for="level" class="form-label">{{ __('plan.lbl_amount') }}</label>

        <select class="form-control select2" name="price" id="price" required>
        <option value="">{{ __('Select Price') }}</option>
        @for($price = $minPrice; $price <= $maxPrice-50; $price += 50) {{-- Change 10 to the desired step value --}}
            <option value="{{ $price }} - {{ $price + 50}}" {{ old('price') == $price ? 'selected' : '' }}>{{Currency::format($price) }} - {{Currency::format($price + 50)}}</option>
        @endfor
    </select>
   </div>
    </form>
    <button type="reset" class="btn btn-danger" id="reset-filter">{{__('messages.reset')}}</button>
</x-backend.advance-filter>
@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush
@push('after-scripts')
<!-- DataTables Core and Extensions -->
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<script src="{{ asset('js/form/index.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>



<script type="text/javascript" defer>
const columns = [
            {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="plan" onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            {
                data: 'name',
                name: 'name',
                title: "{{ __('plan.lbl_name') }}",
                render: function(data, type, row, meta) {
                    return '<h6 class="mb-0">' + data + '</h6>';
                }
            },
            {   data: 'duration',
                name: 'duration',
                title: "{{ __('plan.lbl_duration') }}" 
            },
            { 
                data: 'level',
                name: 'level',
                searchable: true,
                title: "{{ __('plan.lbl_level') }}"  
            },
            { 
                data: 'price',
                name: 'price', 
                title: "{{ __('plan.lbl_amount') }}" 
            },
            { 
                data: 'discount_percentage',
                name: 'discount_percentage',
                title: "{{ __('plan.lbl_discount') }}" 
            },
            { 
                data: 'total_price',
                name: 'total_price', 
                title: "{{ __('plan.lbl_total_price') }}"
            },
            { 
                data: 'status',
                name: 'status',  
                title: "{{ __('plan.lbl_status') }}" ,
               
            },
            {
                data: 'updated_at',
                name: 'updated_at',
                title: "{{ __('messages.update_at') }}",
                orderable: true,
                visible: false,
            }
        ]

        const actionColumn = [
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,  
                width: '5%',
                title: '{{ __('messages.action') }}' }
        ]



       let finalColumns = [
           ...columns,
           ...actionColumn
       ]


   $('#name').on('input', function() {
        window.renderedDataTable.ajax.reload(null, false);
    });
    $('#price').on('input', function() {
        window.renderedDataTable.ajax.reload(null, false);
    });
    $('#level').on('input', function() {
        window.renderedDataTable.ajax.reload(null, false);
    });
    $('#discount_percentage').on('input', function() {
        window.renderedDataTable.ajax.reload(null, false);
    });
    $('#total_price').on('input', function() {
        window.renderedDataTable.ajax.reload(null, false);
    });

document.addEventListener('DOMContentLoaded', (event) => {
    initDatatable({
        url: '{{ route("backend.$module_name.index_data") }}',
        finalColumns,
        orderColumn: [
            [6, "desc"]
        ],
        advanceFilter: () => {
            return {
                name: $('#name').val(),
                price: $('#price').val(),
                level: $('#level').val()
            }
        }
    });
})



$('#reset-filter').on('click', function(e) {
    $('#name').val(''),
    $('#email').val('')
    window.renderedDataTable.ajax.reload(null, false)
})

function resetQuickAction() {
    const actionValue = $('#quick-action-type').val();
    if (actionValue != '') {
        $('#quick-action-apply').removeAttr('disabled');

        if (actionValue == 'change-status') {
            $('.quick-action-field').addClass('d-none');
            $('#change-status-action').removeClass('d-none');
        } else {
            $('.quick-action-field').addClass('d-none');
        }
    } else {
        $('#quick-action-apply').attr('disabled', true);
        $('.quick-action-field').addClass('d-none');
    }
}

$('#quick-action-type').change(function() {
    resetQuickAction()
});

$(document).on('update_quick_action', function() {
    // resetActionButtons()
})
</script>


<script>
function tableReload() {
    $('#datatable').DataTable().ajax.reload();
}
$(document).on('click', '[data-form-delete]', function() {
    const URL = $(this).attr('data-form-delete')
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: URL,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Deleted Successfully!",
                        icon: "success"
                    });
                    tableReload()
                }
            })
        }
    });
});
</script>
@endpush
