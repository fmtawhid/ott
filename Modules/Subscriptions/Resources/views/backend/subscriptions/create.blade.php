@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }} 
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush

@section('content')
<x-back-button-component route="backend.subscriptions.index" />
<div class="card">
    <div class="card-body">

        {{ html()->form('POST', route('backend.subscriptions.store'))
        ->attribute('enctype', 'multipart/form-data')
        ->attribute('data-toggle', 'validator')  // Enable custom validator
        ->attribute('id', 'form-submit')  // Form id to target in JS
        ->class('requires-validation')  // Validation class for Bootstrap Validator
        ->attribute('novalidate', 'novalidate')  // Prevent browser validation
        ->open() }}

      @csrf
        <div class="row gy-3">
            <div class="col-md-6">
                {{ html()->label(__('frontend.admin') . ' <span class="text-danger">*</span>', 'user_id')->class('form-label') }}
                {{ html()->select('user_id', $users->pluck('full_name', 'id')->prepend(__('frontend.select_user'), ''))
                        ->class('form-control select2')
                        ->id('user_id')
                        ->required() }}
                @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                <div class="invalid-feedback">User field is required</div>
            </div>
            <div class="col-md-6">
                {{ html()->label(__('frontend.plans') . ' <span class="text-danger">*</span>', 'plan_id')->class('form-label') }}
                {!! html()->select('plan_id')
                    ->class('form-control select2')
                    ->id('plan_id')
                    ->required()
                    ->html(
                        collect($plans)->map(function ($plan) use ($fixedTax, $percentageTax) {
                            $planAmount = $plan->discount ? $plan->total_price : $plan->price;
                            $selected = old('plan_id') == $plan->id ? 'selected' : '';
                            return "<option value=\"{$plan->id}\" {$selected}
                                        data-price=\"{$planAmount}\"
                                        data-fixed-tax=\"{$fixedTax}\"
                                        data-percentage-tax=\"{$percentageTax}\"
                                        data-currency=\"" . getCurrencySymbolByCurrency(defaultCurrency())  . "\">
                                        {$plan->name} ({$plan->duration_value}-" . str_replace('ly', '', $plan->duration) . ")
                                    </option>";
                        })->prepend('<option value="" disabled selected>' . __('frontend.select_plan') . '</option>')->implode('')
                    )
                !!}
                <div class="invalid-feedback">Plan field is required</div>
            </div>
          
            <div class="col-md-6">
                {{ html()->label(__('frontend.amount'), 'amount')->class('form-label') }}
                <input type="text" id="amount_display" class="form-control" placeholder="{{ __('frontend.enter_amount') }}" value="{{ old('amount_display') }}" readonly>
                <input type="hidden" id="amount" name="amount" value="{{ old('amount') }}" />
            </div>

            <div class="col-md-6">
                {{ html()->label(__('frontend.payment_date') . ' <span class="text-danger">*</span>', 'payment_date')->class('form-label') }}
                {{ html()->date('payment_date')
                        ->value(old('payment_date', \Carbon\Carbon::now()->format('Y-m-d')))
                        ->class('form-control')
                        ->id('payment_date')
                        ->attribute('max', \Carbon\Carbon::now()->format('Y-m-d'))
                        ->required() }}
                @error('payment_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-4">
            {{ html()->submit(__('frontend.submit'))->class('btn btn-primary')->id('submit-button') }}
        </div>

        {{ html()->form()->close() }}
    </div>
</div>
@include('components.media-modal')
<script>
    function removeImage(hiddenInputId, removedFlagId) {
        var container = document.getElementById('selectedImageContainer1');
        var hiddenInput = document.getElementById(hiddenInputId);
        var removedFlag = document.getElementById(removedFlagId);
    
        container.innerHTML = '';
        hiddenInput.value = '';
        removedFlag.value = 1;
    }
    </script>
@endsection

@push('after-scripts')
<script>
   $('#plan_id').change(function () {
    let selected = $(this).find('option:selected');
    
    // Get base price and tax details
    let basePrice = parseFloat(selected.data('price')) || 0;
    let fixedTax = parseFloat(selected.data('fixed-tax')) || 0;
    let percentTax = parseFloat(selected.data('percentage-tax')) || 0;
    let percentTaxAmount = (basePrice * percentTax) / 100;
    let totalAmount = basePrice + fixedTax + percentTaxAmount;
    let currencySymbol = selected.data('currency') || '';
    let formattedAmount = currencySymbol + ' ' + totalAmount.toFixed(2); 
    $('#amount_display').val(formattedAmount); 
    $('#amount').val(totalAmount.toFixed(2)); 
});

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('payment_date');
        if (typeof flatpickr !== 'undefined') {
            flatpickr(input, {
                dateFormat: "Y-m-d",
                altInput: true, 
                altFormat: "d F Y", 
                maxDate: "today",
                onReady: function (selectedDates, dateStr, instance) {
                    if (document.body.classList.contains('dark')) {
                        instance.calendarContainer.classList.add('flatpickr-dark');
                    }
                }
            });
        }
    });

    $('#payment-form').on('submit', function (e) {
    console.log('Form submitted');
});
</script>
@endpush
