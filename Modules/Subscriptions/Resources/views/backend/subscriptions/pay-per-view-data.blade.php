@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@section('content')
<div class="card-main mb-5">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">
                    {{-- @if(auth()->user()->can('edit_'.$module_name) || auth()->user()->can('delete_'.$module_name))
                    <x-backend.quick-action url="{{ route('backend.' . $module_name . '.bulk_action') }}">
                        <div class="">
                            <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                style="width:100%">
                                <option value="">{{ __('messages.no_action') }}</option>
                                @hasPermission('force_delete_'.$module_name)
                                <option value="permanently-delete">{{ __('messages.delete') }}</option>
                                @endhasPermission
                            </select>
                        </div>
                        <div class="select-status d-none quick-action-field" id="change-status-action">
                            <select name="status" class="form-control select2" id="status" style="width:100%">
                                <option value="1" selected>{{ __('messages.active') }}</option>
                                <option value="0">{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </x-backend.quick-action>
                    @endif --}}
                    <button type="button" class="btn btn-dark" data-modal="export">
                    <i class="ph ph-export align-middle"></i> {{ __('messages.export') }}
                </button>
                    {{-- <div class="flex-grow-1">
                        <select id="plan-filter" class="form-select select2">
                            <option value="">{{ __('messages.select_plan') }}</option>
                            <!-- Populate plans dynamically -->
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="flex-grow-1">
                        <input type="text" name="date_range" id="date_range" value=""
                            class="form-control dashboard-date-range"
                            placeholder="{{ __('messages.select_date_range') }} " />
                    </div>
                    <div class="d-flex gap-1">
                        <button id="filter-btn" class="btn btn-primary">{{ __('messages.filter') }}</button>
                        <button id="reset-btn" class="btn btn-primary" style="display: none;">{{ __('messages.reset') }}</button>
                    </div>
                </div>
                <x-slot name="toolbar">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text pe-0" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control dt-search" placeholder="{{ __('placeholder.lbl_search') }}" aria-label="Search" aria-describedby="addon-wrapping">
                    </div>

                </x-slot>
            </x-backend.section-header>
            <table id="datatable" class="table table-responsive">
            </table>

</div>
    @if (session('success'))
        <div class="snackbar" id="snackbar">
            <div class="d-flex justify-content-around align-items-center">
                <p class="mb-0">{{ session('success') }}</p>
                <a href="#" class="dismiss-link text-decoration-none text-success"
                    onclick="dismissSnackbar(event)">Dismiss</a>
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
            // {
            //     name: 'check',
            //     data: 'check',
            //     title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="subscriptions"  onclick="selectAllTable(this)">',
            //     width: '0%',
            //     exportable: false,
            //     orderable: false,
            //     searchable: false,
            // },
            {
                data: 'user_id',
                name: 'user_id',
                title: "{{ __('messages.user') }}"
            },
            {
                data: 'name',
                name: 'name',
                title: "{{ __('messages.lbl_content') }}"
            },

            {
                data: 'duration',
                name: 'duration',
                title: "{{ __('dashboard.duration') }}"
            },

            {
                data: 'payment_method',
                name: 'payment_method',
                title: "{{ __('messages.payment_method') }}"
            },

            {
                data: 'start_date',
                name: 'start_date',
                title: "{{ __('messages.start_date') }}"
            },
            {
                data: 'end_date',
                name: 'end_date',
                title: "{{ __('messages.end_date') }}"
            },
            {
                data: 'amount',
                name: 'amount',
                title: "{{ __('messages.price') }}",
            },
            {
                data: 'coupon_discount',
                name: 'coupon_discount',
                title: "{{ __('frontend.discount') }}"
            },

            {
                data: 'total_amount',
                name: 'total_amount',
                title: "{{ __('messages.total_amount') }}"
            },
            // {
            //     data: 'status',
            //     name: 'status',
            //     title: "{{ __('messages.lbl_status') }}",
            //     // render: function (data, type, row) {
            //     //     let capitalizedData = data.charAt(0).toUpperCase() + data.slice(1);
            //     //     let className = data == 'active' ? 'badge bg-success-subtle p-2' : 'badge bg-danger-subtle p-2';
            //     //     return '<span class="' + className + '">' + capitalizedData + '</span>';
            //     // }
            // },
            {
                data: 'updated_at',
                name: 'updated_at',
                title: "{{ __('messages.update_at') }}",
                orderable: true,
                visible: false,
            }
        ];

        // const actionColumn = [{
        //     data: 'action',
        //     name: 'action',
        //     orderable: false,
        //     searchable: false,
        //     title: "{{ __('messages.lbl_action') }}",
        //     width: '5%'
        // }]


        const finalColumns = [...columns, ];

        document.addEventListener('DOMContentLoaded', (event) => {

            initDatatable({
                url: '{{ route("backend.pay-per-view-history-data") }}',
                finalColumns,
                orderColumn: [
                    [9, "desc"]
                ],
                search: {
                    selector: '.dt-search',
                    smart: true
                }
                

            });
        });

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
        //resetActionButtons()
      });

    $('#filter-btn').on('click', function() {
        const planId = $('#plan-filter').val();
        const dateRange = $('input[name="date_range"]').val();
        $('#datatable').DataTable().settings()[0].ajax.data = {
            date_range: dateRange
        };
        $('#datatable').DataTable().ajax.reload();
        $('#reset-btn').show();
    });

    $('#reset-btn').on('click', function() {
        $('#plan-filter').val('').trigger('change');
        $('input[name="date_range"]').val('');
        const fp = $('#date_range').get(0)?._flatpickr;
        if (fp) fp.clear();
        $('#datatable').DataTable().settings()[0].ajax.data = {
            date_range: ''
        };
        $('#datatable').DataTable().ajax.reload();
        $('#reset-btn').hide();
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('#date_range', {
            dateFormat: "Y-m-d",
            mode: "range",
        });

    });

</script>
@endpush
