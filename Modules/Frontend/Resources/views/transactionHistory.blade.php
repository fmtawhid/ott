@extends('frontend::layouts.master')
@section('content')
<div class="page-title">
        <h4 class="m-0 text-center">{{__('frontend.pay_per_view_transactions')}}</h4>
</div>
<div class="section-spacing">
  <div class="container">
    <div class="section-spacing-bottom px-0">
        <div class="table-responsive">
          <table class="table payment-history table-borderless">
            <thead class="table-dark">
              <tr>
                <th class="text-white">{{__('frontend.date')}}</th>
                <th class="text-white">{{__('frontend.content')}}</th>
                <th class="text-white">{{__('frontend.type')}}</th>
                <th class="text-white">{{__('frontend.expiry_date')}}</th>
                <th class="text-white">{{__('frontend.price')}}</th>
                <th class="text-white">{{__('frontend.discount')}}</th>
                <th class="text-white">{{__('frontend.total')}}</th>
              </tr>
            </thead>
            <tbody class="payment-info">
                @if($payPerViews->isEmpty())
                <tr>
                    <td colspan="7" class="text-center text-white fw-bold">
                        {{ __('frontend.pay_per_view_history_not_found') }}
                    </td>
                </tr>
            @else
                @foreach($payPerViews as $ppv)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($ppv->created_at)->format('d/m/Y') }}</td>
                    <td class="fw-bold text-white">
                        @if($ppv->type == 'movie')
                            {{ $ppv->movie->name ?? '-' }}
                        @elseif($ppv->type == 'episode')
                            {{ $ppv->episode->name ?? '-' }}
                        @elseif($ppv->type == 'video')
                            {{ $ppv->video->name ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="fw-bold text-white">{{ ucfirst($ppv->type) }}</td>
                    <td class="fw-bold text-white">{{ \Carbon\Carbon::parse($ppv->view_expiry_date)->format('d/m/Y') }}</td>
                    <td class="fw-bold text-white">{{ Currency::format($ppv->content_price) }}</td>
                    <td class="fw-bold text-white">{{ $ppv->discount_percentage }}%</td>
                    <td class="fw-bold text-white">{{ Currency::format($ppv->price) }}</td>
                </tr>
                @endforeach
            @endif
            </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
@endsection 