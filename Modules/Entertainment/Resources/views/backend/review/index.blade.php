@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('content')
    <div class="card-main mb-5">

            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">

                <x-backend.quick-action url="{{ route('backend.reviews.bulk_action') }}">
                    <div class="">
                        <select name="action_type" class="form-control select2 col-12" id="quick-action-type" style="width:100%">
                            <option value="">{{ __('messages.no_action') }}</option>
                            <option value="delete">{{ __('messages.delete') }}</option>
                            <option value="restore">{{ __('messages.restore') }}</option>
                            <option value="permanently-delete">{{ __('messages.permanent_dlt') }}</option>
                        </select>
                    </div>
                    <div class="select-status d-none quick-action-field" id="change-status-action">
                        <select name="status" class="form-control select2" id="status" style="width:100%">
                            <option value="1" selected>{{ __('messages.active') }}</option>
                            <option value="0">{{ __('messages.inactive') }}</option>
                        </select>
                    </div>
                </x-backend.quick-action>
            </div>



                <x-slot name="toolbar">

                <div class="input-group flex-nowrap">
                    <span class="input-group-text pe-0" id="addon-wrapping"><i
                            class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control dt-search" placeholder="{{ __('placeholder.lbl_search') }}" aria-label="Search"
                        aria-describedby="addon-wrapping">
                </div>

                </x-slot>

            </x-backend.section-header>

            <table id="datatable" class="table table-responsive">
            </table>


    </div>


    {{-- card END --}}

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


{{-- DATATABLE SECTION --}}
@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <!-- DataTables Core and Extensions -->
    <script src="{{ asset('js/form-modal/index.js') }}" defer></script>
    <script src="{{ asset('js/form/index.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>


    <script type="text/javascript" defer>
        const columns = [{
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="review" onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            {
                data: 'updated_at',
                name: 'updated_at',
                title: "{{ __('review.lbl_update_at') }}",
                orderable: true,
                searchable: false,
                visible: false,
            },
            {
                data: 'user_id',
                name: 'user_id',
                title: "{{ __('users.lbl_user') }}",
                orderable: true,
                searchable: true,
            },

            {
                data: 'type',
                name: 'type',
                title: "{{ __('review.lbl_type') }}",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    if (data === 'Tvshow') {
                        return 'TV Show';
                    } else {
                        return data; // Display the original type if it's not 'tvshow'
                    }
                }
            },

            {

             data: 'review',
             name: 'review',
             title: "{{ __('review.lbl_review') }}",
             className: "description-column",
             render: function(data, type, row) {
                 // Check if data is null or undefined
                 if (data === null || data === undefined || data === '') {
                     return '<span class="custom-span-class">--</span>';
                 }
                 return '<span class="custom-span-class">' + data + '</span>';
             },
             orderable: true,
             searchable: true,
             },


            {
                data: 'rating',
                name: 'rating',
                title: "{{ __('review.lbl_rating') }}",
                render: function(data, type, row) {
                    let stars = '';
                    for (let i = 1; i <= 5; i++) {
                        stars +=
                        `<span class="star ${i <= data ? 'filled' : ''}"><i class="ph ph-fill ph-star"></i></span>`;
                    }
                    return `<div class="star-rating">${stars}</div>`;
                },
                orderable: true,
                searchable: true,
            },

        ]

        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('review.lbl_action') }}",
            width: '10%'
        }]


        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        // SHOW ALL PAGES DATA IN TABLE FORM
        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.reviews.index_data") }}',
                finalColumns,
                orderColumn: [
                    [1, "desc"]
                ],
                advanceFilter: () => {
                    return {
                        name: $('#name').val()
                    }
                }
            });
        });


        $('#reset-filter').on('click', function(e) {
            $('#name').val(''),
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
@endpush
<style>
    .star-rating {
        display: flex;
    }

    .star {
        font-size: 1.2rem;
        color: var(--bs-border-color);
        /* Default color for empty stars */
        margin-right: 2px;
    }

    .star.filled {
        color: var(--bs-warning);
        /* Color for filled stars */
    }
</style>
