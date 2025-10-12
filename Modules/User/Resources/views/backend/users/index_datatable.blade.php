@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('content')
<div class="card-main mb-5">
        <x-backend.section-header>
        @if($type == null )
            <div class="d-flex flex-wrap gap-3">

                <x-backend.quick-action url="{{ route('backend.' . $module_name . '.bulk_action') }}">
                    <div class="">
                        <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                            style="width:100%">
                            <option value="">{{ __('messages.no_action') }}</option>

                            <option value="change-status">{{ __('messages.lbl_status') }}</option>

                            <option value="permanently-delete">{{ __('messages.delete') }}</option>
                            <!-- <option value="restore">{{ __('messages.restore') }}</option>
                            <option value="permanently-delete">{{ __('messages.permanent_dlt') }}</option> -->
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
                    <button type="button" class="btn btn-dark" data-modal="export">
                        <i class="ph ph-export align-middle"></i> {{ __('messages.export') }}
                    </button>

                </div>
            </div>

                        @endif
            <x-slot name="toolbar">
            @if($type=='soon-to-expire')
            <button id="send-email-btn" class="btn btn-primary">{{ __('messages.send_reminder') }}</button>
          @endif
          @if($type == null )
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
                @endif
                <div class="input-group flex-nowrap">
                    <span class="input-group-text pe-0" id="addon-wrapping"><i
                            class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control dt-search" placeholder="{{ __('messages.search') }}..." aria-label="Search"
                        aria-describedby="addon-wrapping">
                </div>
                @if($type == null )
                <a href="{{ route('backend.' . $module_name . '.create') }}" class="btn btn-primary d-flex align-items-center gap-1"
                    id="add-post-button"> <i class="ph ph-plus-circle"></i>{{__('messages.new')}}</a>
                @endif

            </x-slot>
        </x-backend.section-header>
        <table id="datatable" class="table table-responsive">
        </table>
</div>
<!-- Success Message Container -->
<div id="success-message" class="alert alert-success" style="display: none; text-align: center; width: auto; position: fixed; top: 0; right: 0; margin: 50px;">
  <strong>{{__('messages.mail_success')}}</strong> {{__('messages.mail_send')}}
</div>

<!-- <x-backend.advance-filter>
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
            <label class="form-label" for="email">{{ __('users.lbl_email') }}</label>
            <input type="text" name="email" id="email" class="form-control"
                placeholder="">

        </div>
    </form>
    <button type="reset" class="btn btn-danger" id="reset-filter">{{__('messages.reset')}}</button>
</x-backend.advance-filter> -->

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
@push('after-scripts')
<!-- DataTables Core and Extensions -->
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<script src="{{ asset('js/form/index.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>



<script type="text/javascript" defer>
const columns = [{
        name: 'check',
        data: 'check',
        title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="users" onclick="selectAllTable(this)">',
        width: '0%',
        exportable: false,
        orderable: false,
        searchable: false,
    },

    {
        data: 'name',
        name: 'name',
        title: "{{ __('users.lbl_user') }}"
    },
    {
        data: 'mobile',
        name: 'mobile',
        title: "{{ __('users.lbl_contact_number') }}"
    },
    {
        data: 'gender',
        name: 'gender',
        title: "{{ __('users.lbl_gender') }}"
    },

    {
        data: 'status',
        name: 'status',
        orderable: true,
        searchable: true,
        title: "{{ __('users.lbl_status') }}"
    },
    {
        data: 'updated_at',
        name: 'updated_at',
        title: "{{ __('users.lbl_update_at') }}",
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
]
if (!('{{ $type }}')) {
        finalColumns = [...finalColumns, ...actionColumn];
    }

    if (('{{ $type }}' == 'soon-to-expire')) {
      finalColumns.push({
          name: 'expire_date',
          data: 'expire_date',
          title: "{{ __('messages.end_date') }}",
          orderable: false,
          searchable: false,
      });
    }


document.addEventListener('DOMContentLoaded', (event) => {
    initDatatable({
        url: '{{ route("backend.users.index_data",['type' => $type]) }}',
        finalColumns,
        orderColumn: [
            [5, "desc"]
        ],
       
    });
    const datatable = $('#datatable').DataTable();

      datatable.on('draw', function () {
          const rowCount = datatable.rows().count();

          if (rowCount === 0) {
              document.getElementById('send-email-btn').style.display = 'none';
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

$(document).on('update_quick_action', function() {
     resetActionButtons()
})



function showMessage(message) {
            Snackbar.show({
                text: message,
                pos: 'bottom-left'
            });
        }
        $(document).ready(function() {
          $('#send-email-btn').click(function() {
              const confirmationMessage = "{{__('messages.sure_to_send_email')}}";
              confirmSwal(confirmationMessage).then((result) => {
                  if (result.isConfirmed) {
                      sendEmail();
                  }
              });
          });

          function sendEmail() {

              var csrfToken = $('meta[name="csrf-token"]').attr('content');
              $.ajax({
                  url: '{{ route("backend.send.email") }}',
                  type: 'POST',
                  data: {
                      _token: csrfToken
                  },
                  success: function(response) {
                      showMessage(response.message);
                  },
                  error: function(xhr, status, error) {
                      console.log('Failed to send emails' + error);
                  }
              });
          }
        });
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
