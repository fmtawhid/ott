<div class="modal fade" id="currencyModal" tabindex="-1" aria-labelledby="currencyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="currencyModalLabel">{{ __('currency.lbl_add') }}</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="currencyForm" action="{{ route('backend.currencies.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST">


             <div class="form-group">
              <label for="currencyName" class="form-label">{{ __('currency.lbl_currency_name') }} <span class="text-danger">*</span></label>
              <select id="currencyName" name="currency_name" class="form-control" required>
                <option value="">Select Currency</option>
                @foreach ($curr_names as $curr)
                  <option value="{{ $curr['currency_name'] }}">{{ $curr['currency_name'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="currencySymbol" class="form-label">{{ __('currency.lbl_currency_symbol') }} <span class="text-danger">*</span></label>
              <input type="text" name="currency_symbol" placeholder="{{ __('currency.lbl_currency_symbol') }}" id="currencySymbol" class="form-control " value="{{ old('currency_symbol') }}" required>
              @error('currency_symbol')
                <span class=" err text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label for="currencyCode" class="form-label">{{ __('currency.lbl_currency_code') }} <span class="text-danger">*</span></label>
              <input type="text" name="currency_code" placeholder="{{ __('currency.lbl_currency_code') }}" id="currencyCode" class="form-control " value="{{ old('currency_code') }}" required>
              @error('currency_code')
                <span class="err text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <div class="d-flex justify-content-between align-items-center">
                <label for="isPrimary" class="form-label">{{ __('currency.lbl_is_primary') }}</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_primary" id="isPrimary" value="1">
                </div>
              </div>
            </div>
            <h6><b>{{ __('currency.currency_format') }}</b></h6>
            <div class="form-group">
              <label for="currencyPosition" class="form-label">{{ __('currency.lbl_currency_position') }}</label>
              <select name="currency_position" id="currencyPosition" class="form-control">
                <option value="left">Left</option>
                <option value="right">Right</option>
                <option value="left_with_space">Left With Space</option>
                <option value="right_with_space">Right With Space</option>
              </select>
            </div>
            <div class="form-group">
              <label for="thousandSeparator" class="form-label">{{ __('currency.lbl_thousand_separatorn') }} <span class="text-danger">*</span></label>
              <input type="text" name="thousand_separator" placeholder="{{ __('currency.lbl_thousand_separatorn') }}" id="thousandSeparator" class="form-control" value="{{ old('thousand_separator') }}" required>
              @error('thousand_separator')
                <span class="err text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label for="decimalSeparator" class="form-label">{{ __('currency.lbl_decimal_separator') }} <span class="text-danger">*</span></label>
              <input type="text" name="decimal_separator" placeholder="{{ __('currency.lbl_decimal_separator') }}" id="decimalSeparator" class="form-control" value="{{ old('decimal_separator') }}" required>
              @error('decimal_separator')
                <span class="err text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label for="noOfDecimal" class="form-label">{{ __('currency.lbl_number_of_decimals') }} <span class="text-danger">*</span></label>
              <input type="number" name="no_of_decimal" placeholder="{{ __('currency.lbl_number_of_decimals') }}" id="noOfDecimal" class="form-control" value="{{ old('no_of_decimal') }}" required>
              @error('no_of_decimal')
                <span class="err text-danger">{{ $message }}</span>
              @enderror
            </div>
          </form>
        </div>
        <div class="border-top">
          <div class="d-grid d-md-flex gap-3 p-3">
            <button type="submit" form="currencyForm" class="btn btn-primary d-block">
              {{ __('messages.save') }}
            </button>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#currencyName').on('change', function() {
        var currencyName = $(this).val();

        if(currencyName) {
            $.ajax({
                url: '{{ route("backend.currencies.getCurrencyData") }}',
                type: 'GET',
                data: {currency_name: currencyName},
                success: function(data) {
                    $('#currencySymbol').val(data.currency_symbol);
                    $('#currencyCode').val(data.currency_code);
                }
            });
        }else{

            $('#currencySymbol').val('');
            $('#currencyCode').val('');

        }
    });
});
</script>
