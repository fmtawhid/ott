@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection



@section('content')
<div class="table-content mb-5">

        <x-backend.section-header>
            <div class="d-flex flex-wrap gap-3">
              @if(auth()->user()->can('edit_notification_template') || auth()->user()->can('delete_notification_template'))
              {{-- <x-backend.quick-action url="{{route('backend.notificationtemplates.bulk_action')}}">
                <div class="">
                  <select name="action_type" class="form-control select2 col-12" id="quick-action-type" style="width:100%">
                      <option value="">{{ __('messages.no_action') }}</option>
                      @can('edit_notification_template')
                      <option value="change-status">{{ __('messages.lbl_status') }}</option>
                      @endcan
                      @can('delete_notification_template')
                      <option value="delete">{{ __('messages.delete') }}</option>
                      @endcan
                  </select>
                </div>
                <div class="select-status d-none quick-action-field" id="change-status-action">
                    <select name="status" class="form-control select2" id="status" style="width:100%">
                        <option value="" selected>{{ __('messages.select_status') }}</option>
                      <option value="1">{{ __('messages.active') }}</option>
                      <option value="0">{{ __('messages.inactive') }}</option>
                    </select>
                </div>
              </x-backend.quick-action> --}}
              @endif
              {{-- <div>
                <button type="button" class="btn btn-dark" data-modal="export">
                <i class="ph ph-export align-middle"></i> {{ __('messages.export') }}
                </button>

              </div> --}}
            </div>
            <x-slot name="toolbar">
              <div>
                {{-- <div class="datatable-filter">
                  <select name="column_status" id="column_status" class="select2 form-control" data-filter="select" style="width: 100%">
                    <option value="">{{__('messages.all')}}</option>
                    <option value="0" {{$filter['status'] == '0' ? "selected" : ''}}>{{ __('messages.inactive') }}</option>
                    <option value="1" {{$filter['status'] == '1' ? "selected" : ''}}>{{ __('messages.active') }}</option>
                  </select>
                </div> --}}
              </div>
              <div class="input-group flex-nowrap">
                <span class="input-group-text pe-0" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control dt-search" placeholder="{{ __('messages.search') }}..." aria-label="Search" aria-describedby="addon-wrapping">
              </div>
             {{-- @hasPermission('add_notification_template')
                <a href='{{ route("backend.notification-templates.create") }}' class="btn btn-primary d-flex align-items-center gap-1" title="{{__('Create')}}  {{ __($module_title) }}"><i class="ph ph-plus-circle"></i>{{ __('messages.new') }}</a>
              @endhasPermission --}}
            </x-slot>
      </x-backend.section-header>
        <table id="datatable" class="table table-responsive">
        </table>

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
<script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
<script src="{{ asset('js/form/index.js') }}" defer></script>
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>



<script type="text/javascript" defer>
        const columns = [
            // {
            //     name: 'check',
            //     data: 'check',
            //     title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
            //     width: '0%',
            //     exportable: false,
            //     orderable: false,
            //     searchable: false,
            // },
            { data: 'label', name: 'label', title: "{{ __('notification.lbl_label') }}", className:"notification-lbl-white" },
            // { data: 'type', name: 'type', title: "{{ __('notification.lbl_type') }}" },
            // { data: 'status', name: 'status', orderable: false, searchable: true, title: "{{ __('notification.lbl_status') }}"  },
        ]

        const actionColumn = [
            { data: 'action', name: 'action', orderable: false, searchable: false, title: "{{ __('notification.lbl_action') }}"  }
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

</script>
@endpush
