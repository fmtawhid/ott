@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} 
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush

@section('content')
<x-back-button-component route="backend.subscriptions.index" />
<div class="card">
    <div class="card-body">

        {{ html()->modelForm($subscription, 'PUT', route('backend.subscriptions.update', $subscription->id))
            ->attribute('enctype', 'multipart/form-data')
            ->attribute('data-toggle', 'validator')
            ->attribute('id', 'form-submit')
            ->class('requires-validation')
            ->attribute('novalidate', 'novalidate')
            ->open() }}

        @csrf

        <div class="row gy-3">
            <div class="col-md-6">
                {{ html()->label(__('frontend.admin') . ' <span class="text-danger">*</span>', 'user_id')->class('form-label') }}
                {{ html()->select('user_id', $users->pluck('full_name', 'id')->prepend(__('frontend.select_user'), ''), $subscription->user_id)
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
                        collect($plans)->map(function ($plan) use ($subscription) {
                            $selected = $subscription->plan_id == $plan->id ? 'selected' : '';
                            return "<option value=\"{$plan->id}\" {$selected}
                                        data-price=\"{$plan->total_price}\"
                                        data-formatted-price=\"" . \Currency::format($plan->total_price) . "\"
                                        data-currency=\"" . defaultCurrency() . "\">
                                        {$plan->name} ({$plan->duration_value}-" . str_replace('ly', '', $plan->duration) . ")
                                    </option>";
                        })->prepend('<option value="" disabled>' . __('frontend.select_plan') . '</option>')->implode('')
                    )
                !!}
                @error('plan_id') <span class="text-danger">{{ $message }}</span> @enderror
                <div class="invalid-feedback">Plan field is required</div>
            </div>

            <div class="col-md-6">
                {{ html()->label(__('frontend.amount'), 'amount')->class('form-label') }}
                <input type="text" id="amount_display" class="form-control" placeholder="{{ __('frontend.enter_amount') }}" value="{{ old('amount_display', $subscription->amount_display) }}" readonly>
                <input type="hidden" id="amount" name="amount" value="{{ old('amount', $subscription->amount) }}" />
            </div>

            <div class="col-md-6">
                {{ html()->label(__('frontend.payment_date') . ' <span class="text-danger">*</span>', 'payment_date')->class('form-label') }}
                {{ html()->date('payment_date')
                        ->value(old('payment_date', \Carbon\Carbon::parse($subscription->payment_date)->format('Y-m-d')))
                        ->class('form-control')
                        ->id('payment_date')
                        ->attribute('max', \Carbon\Carbon::now()->format('Y-m-d'))
                        ->required() }}
                @error('payment_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-4">
            {{ html()->submit(__('frontend.submit'))->class('btn btn-primary') }}
        </div>

        {{ html()->form()->close() }}
    </div>
</div>

@include('components.media-modal')
<script>
    function removeImage(hiddenInputId, removedFlagId) {
        var container = document.getElementById('selectedImageContainerThumbnail'); // update ID if different
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
        $('#amount_display').val(selected.data('formatted-price'));
        $('#amount').val(selected.data('price'));
    });

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('payment_date');
        if (typeof flatpickr !== 'undefined') {
            flatpickr(input, {
                dateFormat: "Y-m-d",
                maxDate: "today",
                onReady: function (selectedDates, dateStr, instance) {
                    if (document.body.classList.contains('dark')) {
                        instance.calendarContainer.classList.add('flatpickr-dark');
                    }
                }
            });
        }
    });
</script>
@endpush
