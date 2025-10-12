@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __('messages.coupon_title') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">
                    <div>
                        {{-- <button type="button" class="btn btn-secondary" data-modal="export">
                            <i class="fa-solid fa-download"></i> {{ __('messages.export') }}
                        </button> --}}
                    </div>
                </div>
                <x-slot name="toolbar">
                    <div>
                        <div>
                            <a href="{{ route('backend.coupon.index') }}" class="btn btn-secondary">
                                <i class="fa-solid"></i> {{ __('messages.back') }}
                            </a>
                        </div>
                    </div>
                </x-slot>
            </x-backend.section-header>
            <table id="datatable" class="table table-striped border table-responsive">
            </table>
        </div>
    </div>
    <div data-render="app">
        <form-offcanvas create-title="{{ __('messages.create') }} {{ __($module_title) }}"
            edit-title="{{ __('messages.edit') }} {{ __($module_title) }}">
        </form-offcanvas>
    </div>
@endsection
@push('after-styles')

    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<script src="{{ asset('js/form/index.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
<script type="text/javascript" defer>

    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>
        const columns = [{
                data: 'code',
                name: 'code',
                title: "{{ __('messages.coupon_code') }}",
            },
            {
                data: 'discount',
                name: 'discount',
                title: "{{ __('messages.value') }}"
            },
            @if(auth()->user()->hasRole('admin'))
            {
                data: 'subscription_type',
                name: 'subscription_type',
                title: "{{ __('messages.subscription_type') }}"
            },
           @endif
            {
                data: 'is_expired',
                name: 'is_expired',
                orderable: true,
                searchable: true,
                title: "{{ __('messages.expired') }}",
                width: '5%',

            },

            {
                data: 'updated_at',
                name: 'updated_at',
                title: "{{ __('messages.lbl_update_at') }}",
                orderable: true,
                visible: false,
            },

        ]



        let finalColumns = [
            ...columns,
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.coupon_data", $coupon_id) }}',
                finalColumns,
                advanceFilter: () => {
                    return {}
                }
            });
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
    </script>
@endpush
