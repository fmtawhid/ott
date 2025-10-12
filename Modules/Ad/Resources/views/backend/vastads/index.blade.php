@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('content')
        <div class="card-body mb-4">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">

                    <x-backend.quick-action url="{{ route('backend.vastads.bulk_action') }}">
                        <div class="">
                            <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                style="width:100%">
                                <option value="">{{ __('messages.no_action') }}</option>
                                <option value="change-status">{{ __('messages.lbl_status') }}</option>
                                @hasPermission('delete_vastads')
                                <option value="delete">{{ __('messages.delete') }}</option>
                                @endhasPermission
                                @hasPermission('restore_vastads')
                                <option value="restore">{{ __('messages.restore') }}</option>
                                @endhasPermission
                                @hasPermission('force_delete_vastads')
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



                      <!--<button type="button" class="btn btn-dark" data-modal="export">-->
                      <!--  <i class="ph ph-export align-middle"></i> {{ __('messages.export') }}-->
                      <!--</button>-->
                </div>
                <x-slot name="toolbar">

                    <div>
                        <!--<div class="datatable-filter">
                            <select name="column_status" id="column_status" class="select2 form-control"
                                data-filter="select" style="width: 100%">
                                <option value="">{{__('messages.all')}}</option>
                                <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                    {{ __('messages.inactive') }}</option>
                                <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                    {{ __('messages.active') }}</option>
                            </select>
                        </div>-->
                    </div>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text pe-0" id="addon-wrapping"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control dt-search" placeholder="{{ __('messages.search') }}..." aria-label="Search"
                            aria-describedby="addon-wrapping">
                    </div>
                       <button class="btn btn-dark d-flex align-items-center gap-1 btn-group" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i class="ph ph-funnel"></i>{{__('messages.advance_filter')}}</button>
                    @hasPermission('add_vastads')
                        <a href="{{ route('backend.vastads.create') }}" class="btn btn-primary d-flex align-items-center gap-1" id="add-post-button"> <i class="ph ph-plus-circle"></i>{{ __('messages.new') }} </a>
                    @endhasPermission
                 </x-slot>
            </x-backend.section-header>
            <table id="datatable" class="table table-responsive">
            </table>
        </div>

    <x-backend.advance-filter>
        <x-slot name="title">
            <h4 class="mb-0">{{ __('messages.advance_filter') }}</h4>
        </x-slot>
        <div class="form-group">
            <div class="form-group datatable-filter">
                <label class="form-label" for="name">{{ __('messages.ad_name') }}</label>
                <input type="text" id="name" name="name" class="form-control" data-filter="text" placeholder="{{ __('messages.enter_name') }}">
            </div>

            <div class="form-group datatable-filter">
                <label class="form-label" for="type">{{ __('messages.type') }}</label>
                <select name="type" id="type" class="form-control select2" data-filter="select">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="pre-roll">{{ __('messages.pre-roll') }}</option>
                    <option value="mid-roll">{{ __('messages.mid-roll') }}</option>
                    <option value="post-roll">{{ __('messages.post-roll') }}</option>
                    <option value="overlay">{{ __('messages.overlay') }}</option>
                </select>
            </div>

            <div class="form-group datatable-filter">
                <label class="form-label" for="target_type">{{ __('messages.target_type') }}</label>
                <select name="target_type" id="target_type" class="form-control select2" data-filter="select">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="video">{{ __('messages.video') }}</option>
                    <option value="movie">{{ __('messages.movie') }}</option>
                    <option value="tvshow">{{ __('messages.tvshow') }}</option>
                    {{-- <option value="channel">{{ __('messages.channel') }}</option> --}}
                </select>
            </div>

            {{-- <div class="form-group datatable-filter">
                <label class="form-label" for="frequency">{{ __('messages.frequency') }}</label>
                <input type="number" id="frequency" name="frequency" class="form-control" data-filter="text" placeholder="{{ __('messages.enter_frequency') }}">
            </div> --}}
        </div>

        <div class="text-end">
            <button type="reset" class="btn btn-dark" id="reset-filter">{{ __('messages.reset') }}</button>
        </div>
    </x-backend.advance-filter>
    @if(session('success'))
        <div class="snackbar" id="snackbar">
            <div class="d-flex justify-content-around align-items-center">
                <p class="mb-0">{{ session('success') }}</p>
                <a href="#" class="dismiss-link text-decoration-none text-success" onclick="dismissSnackbar(event)">Dismiss</a>
            </div>
        </div>
    @endif


    {{-- Reactivate Ad Modal --}}
    <div class="modal fade" id="reactivateAdModal" tabindex="-1" aria-labelledby="reactivateAdModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form id="reactivateAdForm">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="reactivateAdModalLabel">{{ __('messages.reactive_ad') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="reactivateStartDate" class="form-label">{{ __('messages.start_date') }}</label>
                  <input type="text" name="start_date" id="reactivateStartDate" class="form-control datetimepicker" required autocomplete="off" placeholder="{{ __('messages.select_start_date') }}">
                </div>
                <div class="mb-3">
                  <label for="reactivateEndDate" class="form-label">{{ __('messages.end_date') }}</label>
                  <input type="text" name="end_date" id="reactivateEndDate" class="form-control datetimepicker" required autocomplete="off" placeholder="{{ __('messages.select_end_date') }}">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.lbl_cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('messages.save_and_active') }}</button>
              </div>
            </div>
          </form>
        </div>
    </div>
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
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="vastads"  onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            {
                data: 'name',
                name: 'name',
                title: "{{ __('messages.ad_name') }}"
            },
            {
                data: 'type',
                name: 'type',
                title: "{{ __('messages.type') }}"
            },
            // {
            //     data: 'duration',
            //     name: 'duration',
            //     title: "{{ __('messages.lbl_duration') }}"
            // },
            {
                data: 'target_type',
                name: 'target_type',
                title: "{{ __('messages.target_type') }}"
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
            {{-- {
                data: 'enable_skip',
                name: 'enable_skip',
                title: "{{ __('messages.enable_skip') }}"
            }, --}}
            {
                data: 'skip_after',
                name: 'skip_after',
                title: "{{ __('messages.skip_after') }}",
                visible: false
            },
            // {
            //     data: 'frequency',
            //     name: 'frequency',
            //     title: "{{ __('messages.frequency') }}"
            // },
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true,
                title: "{{ __('messages.lbl_status') }}"
            },
            {
              data: 'updated_at',
              name: 'updated_at',
              title: "{{ __('service.lbl_update_at') }}",
              orderable: true,
             visible: false,
           },

        ]


        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('messages.action') }}",
            width: '5%'
        }]

        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            // Initialize select2 for type and target_type
            $('#type, #target_type').select2({
                width: '100%',
                placeholder: "{{ __('messages.select_option') }}"
            });

            initDatatable({
                url: '{{ route("backend.vastads.index_data") }}',
                finalColumns,
                orderColumn: [[ 9, "desc" ]],
                advanceFilter: () => {
                    let filterData = {
                        name: $('#name').val(),
                        type: $('#type').val(),
                        target_type: $('#target_type').val(),
                        // frequency: $('#frequency').val()
                    };
                    return filterData;
                }
            });
        })

        // Handle select2 change events
        $('#type, #target_type').on('select2:select select2:unselect', function(e) {
            window.renderedDataTable.ajax.reload(null, false);
        });

        $('#reset-filter').on('click', function(e) {
            e.preventDefault();
            $('#name').val('');
            $('#type').val('').trigger('change');
            $('#target_type').val('').trigger('change');
            // $('#frequency').val('');
            window.renderedDataTable.ajax.reload(null, false);
        });

        // Add input event listener for text fields
        $('#name, #frequency').on('input', function() {
            window.renderedDataTable.ajax.reload(null, false);
        });

        function resetQuickAction () {
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

        $('#quick-action-type').change(function () {
            resetQuickAction()
        });

        $(document).on('update_quick_action', function() {
            // resetActionButtons()
        })

        let startPicker, endPicker;

        $(document).on('shown.bs.modal', '#reactivateAdModal', function () {
            // Clear input fields
            $('#reactivateStartDate').val('');
            $('#reactivateEndDate').val('');

            // Destroy previous pickers if they exist
            if (startPicker) startPicker.destroy();
            if (endPicker) endPicker.destroy();

            // Reinitialize both flatpickr pickers
            startPicker = flatpickr('#reactivateStartDate', {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    if (endPicker) {
                        endPicker.set('minDate', dateStr);
                    }
                }
            });

            endPicker = flatpickr('#reactivateEndDate', {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                allowInput: true
            });
        });


      $(document).on('change', '.switch-status-change', function(e) {
        var $checkbox = $(this);
        var isChecked = $checkbox.is(':checked');
        var endDate = $checkbox.data('end-date'); // Make sure this is set in the Blade view
        var adId = $checkbox.data('ad-id'); // Make sure this is set in the Blade view
        if (isChecked && endDate && new Date(endDate) < new Date().setHours(0,0,0,0)) {
            e.preventDefault();
            $checkbox.prop('checked', false); // revert toggle
            // Show modal and pass adId
            $('#reactivateAdModal').data('ad-id', adId).modal('show');
        }
      });

      $('#reactivateAdForm').on('submit', function(e) {
        e.preventDefault();
        var adId = $('#reactivateAdModal').data('ad-id');
        var data = $(this).serialize();
        const reactivateUrl = "{{ route('backend.vastads.reactivate', ':id') }}".replace(':id', adId);
        $.ajax({
            url: reactivateUrl,
            method: 'POST',
            data: data,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(response) {
                $('#reactivateAdModal').modal('hide');
                window.renderedDataTable.ajax.reload(null, false);
            },
            error: function(xhr) {
                // Optionally show validation errors
                alert('Error: ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Unknown error'));
            }
        });
      });
    </script>
@endpush
