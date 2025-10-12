@extends('frontend::layouts.master')
@section('content')
<div class="page-title">
        <h4 class="m-0 text-center">{{__('frontend.membership')}}</h4>
</div>
<div class="section-spacing">
  <div class="container">
    <div class="upgrade-plan d-flex flex-wrap gap-3 align-items-center justify-content-between rounded p-4 bg-warning-subtle border border-warning">
        <div class="d-flex justify-content-center align-items-center gap-4">
            <i class="ph ph-crown text-warning"></i>
            <div>
                @if($activeSubscriptions)
                    <h6 class="super-plan">{{ $activeSubscriptions->name }}</h6>
                    <p class="mb-0 text-body">{{__('frontend.expiring_on')}} {{ \Carbon\Carbon::parse($activeSubscriptions->end_date)->format('d F, Y') }}</p>
                @else
                    <h6 class="super-plan">{{__('frontend.no_active_plan')}}</h6>
                    <p class="mb-0 text-body">{{__('frontend.not_active_subscription')}}</p>
                @endif
            </div>
        </div>
        <div class="d-flex gap-3">
            @if($activeSubscriptions)
                <a href="{{ route('subscriptionPlan') }}" class="btn btn-light">{{__('frontend.upgrade')}}</a>
            @else
                <a href="{{ route('subscriptionPlan') }}" class="btn btn-light">{{__('frontend.subscribe')}}</a>
            @endif
        </div>
    </div>
    <div class="section-spacing-bottom px-0">

      <h5 class="main-title text-capitalize mb-2">{{__('frontend.payment_history')}} </h5>
        <div class="table-responsive">
          <table class="table payment-history table-borderless">
            <thead class="table-dark">
              <tr>
                <th class="text-white">{{__('frontend.date')}}</th>
                <th class="text-white">{{__('frontend.plan')}}</th>
                <th class="text-white">{{__('dashboard.duration')}}</th>
                <th class="text-white">{{__('frontend.expiry_date')}}</th>
                <th class="text-white">{{__('frontend.amount')}}</th>
                <th class="text-white">{{__('frontend.coupon_discount')}}</th>
                <th class="text-white">{{__('frontend.tax')}}</th>
                <th class="text-white">{{__('frontend.total')}}</th>
                <th class="text-white">{{__('frontend.payment_method')}}</th>
                <th class="text-white">{{__('frontend.status')}}</th>
                <th class="text-white">{{__('frontend.invoice')}}</th>
              </tr>
            </thead>
            <tbody class="payment-info">
                @if($subscriptions->isEmpty())
                <tr>
                    <td colspan="11" class="text-center text-white fw-bold">
                        {{ __('frontend.subscription_history_not_found') }} <!-- You can customize this message -->
                    </td>
                </tr>
            @else
                <tbody class="payment-info">
                    @foreach($subscriptions as $subscription)
                    @php
                        $amount = $subscription->amount ?? 0;
                        $discount = $subscription->discount_percentage ?? 0;
                        $total = $amount - ($amount * $discount / 100);
                    @endphp
                    <tr>
                        <td>{{ $subscription->is_manual == 1 ? (optional($subscription->start_date) ? \Carbon\Carbon::parse($subscription->start_date)->format('d/m/Y') : '--') : (optional($subscription->subscription_transaction?->created_at) ? \Carbon\Carbon::parse($subscription->subscription_transaction->created_at)->format('d/m/Y'): '--') }}</td>
                        <td class="fw-bold text-white">{{ $subscription->name }}</td>
                        <td class="fw-bold text-white">{{ $subscription->duration }} {{ $subscription->type }}</td>
                        <td class="fw-bold text-white">{{ \Carbon\Carbon::parse($subscription->end_date)->format('d/m/Y') }}</td>
                        <td class="fw-bold text-white">{{ Currency::format($total) }}</td>
                        <td class="fw-bold text-white">{{ Currency::format($subscription->coupon_discount) }}</td>
                        <td class="fw-bold text-white">{{ Currency::format($subscription->tax_amount) }}</td>
                        <td class="fw-bold text-white">{{ Currency::format($subscription->total_amount) }}</td>
                        <td class="fw-bold text-white">{{ ucfirst($subscription->subscription_transaction->payment_type ?? '-') }}</td>
                        <td class="fw-bold text-white">{{ ucfirst($subscription->status ?? '-') }}</td>
                        <td class="fw-bold"><a  href="{{route('downloadinvoice', ['id' => $subscription->id])}}">{{__('frontend.download_invoice')}}</a></td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </tbody>
          </table>
        </div>
    </div>
  </div>
</div>

@endsection
