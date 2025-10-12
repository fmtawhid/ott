@extends('setting::backend.setting.index')

@section('settings-content')


<div>
   <div class="d-flex align-items-center justify-content-between">
    <h4 class="mb-0"><i class="fa fa-dollar fa-lg mr-2"></i>&nbsp;{{__('setting_sidebar.lbl_currency_setting')}}</h4>
    @hasPermission('add_currency')
    <button class="btn btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#currencyModal" onclick="openModal(0)">
        <i class="ph ph-plus-circle"></i>   {{ __('messages.add_currency') }}
      </button>
      @endhasPermission
   </div>

    <!-- Currency Form Modal -->

  <div class="table-responsive mt-4">
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>{{ __('currency.lbl_ID') }}</th>
          <th>{{ __('currency.lbl_currency_name') }}</th>
          <th>{{ __('currency.lbl_currency_symbol') }}</th>
          <th>{{ __('currency.lbl_currency_code') }}</th>
          <th>{{ __('currency.lbl_is_primary') }}</th>
          <th>{{ __('currency.lbl_action') }}</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($currencies as $currency)
          <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $currency->currency_name }}</td>
            <td>{{ $currency->currency_symbol }}</td>
            <td>{{ $currency->currency_code }}</td>
            <td>
              @if ($currency->is_primary)
                <span class="badge bg-success">Default</span>
              @else
                <span class="badge bg-danger">-</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-2 align-items-center justify-content-end">

                @hasPermission('edit_currency')
                  <button type="button" class="btn btn-warning-subtle btn-sm fs-4" data-bs-toggle="modal" data-bs-target="#currencyModal" onclick="openModal({{ $currency->id }}, '{{ route('backend.currencies.edit', $currency->id) }}')"><i class="ph ph-pencil-simple-line align-middle"></i></button>
                  @endhasPermission
                  {{-- <a href="{{ route('backend.currencies.destroy', $currency->id) }}"
                    id="delete-currencies-{{ $currency->id }}" class="btn btn-danger-subtle btn-sm fs-4"
                    data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}" data-bs-toggle="tooltip"
                    title="{{ __('messages.force_delete') }}" data-confirm="{{ __('messages.are_you_sure?') }}">
                    <i class="ph ph-trash align-middle"></i>
                </a> --}}
                @hasPermission('delete_currency')
                <form action="{{ route('backend.currencies.destroy', $currency->id) }}" method="POST" class="d-inline m-0 delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary-subtle btn-sm fs-4 delete-button" data-bs-toggle="tooltip">
                        <i class="ph ph-trash align-middle"></i>
                    </button>
                </form>
                @endhasPermission
            </td>
          </tr>
        @empty
          <tr class="text-center">
            <td colspan="6" class="py-3">{{ __('messages.data_not_available') }}</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@include('setting::backend.setting.section-pages.Forms.currency-form',['curr_names' => $curr_names])


@endsection

@push('after-scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function openModal(id = 0, editUrl = null) {
    const modalTitle = document.getElementById('currencyModalLabel');
    const form = document.getElementById('currencyForm');
    form.reset();
    clearValidationErrors();
    if (id === 0) {
      modalTitle.innerText = '{{ __('currency.lbl_add') }}';
      form.action = '{{ route('backend.currencies.store') }}';
      form._method.value = 'POST';
    } else {
      modalTitle.innerText = '{{ __('currency.lbl_edit') }}';
      form.action = '{{ route('backend.currencies.update', ':id') }}'.replace(':id', id);
      form.querySelector('input[name="_method"]').value = 'PUT';
      fetch(editUrl)
        .then(response => response.json())
        .then(data => {

          document.getElementById('currencyName').value = data.data.currency_name;
          document.getElementById('currencySymbol').value = data.data.currency_symbol;
          document.getElementById('currencyCode').value = data.data.currency_code;
          document.getElementById('isPrimary').checked = data.data.is_primary;
          document.getElementById('currencyPosition').value = data.data.currency_position;
          document.getElementById('thousandSeparator').value = data.data.thousand_separator;
          document.getElementById('decimalSeparator').value = data.data.decimal_separator;
          document.getElementById('noOfDecimal').value = data.data.no_of_decimal;
        });
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    form.submit();
                }
            });
        });
    });
});



  function clearValidationErrors() {
        const errorElements = document.querySelectorAll('.err');
        errorElements.forEach(element => {
            element.textContent = '';
        });
  }
</script>
