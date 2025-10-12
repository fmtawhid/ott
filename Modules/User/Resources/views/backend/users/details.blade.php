@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.users.index" />
<div class="card">
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-3">
                <div class="poster">

                    <img src="{{ setBaseUrlWithFileName($data->file_url)  }}" alt="{{ $data->first_name }}" class="img-fluid w-100 rounded">
                </div>
            </div>
            <div class="col-md-9">
                <div class="details">
                    <h1 class="mb-4">{{ $data->first_name ?? '--' }} {{ $data->last_name ?? '--' }}</h1>
                    <div class="d-flex align-items-center gap-3 gap-xl-5 flex-wrap">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="m-0">{{ __('users.lbl_email') }} :</h6>
                            <p class="mb-0">{{  $data->email ?? '--'  }}</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="m-0">{{ __('users.lbl_contact_number') }} :</h6>
                            <p class="mb-0">{{ $data->mobile ?? '--' }}</p>
                        </div>
                    </div>
                    <hr class="my-5 border-bottom-0">
                    <div class="user-info">
                        <div class="d-flex align-items-center gap-3 gap-xl-5 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0">{{ __('users.lbl_gender') }} :</h6>
                                <p class="mb-0">{{ $data->gender ? ucfirst($data->gender) : '--' }}</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0">{{ __('users.lbl_date_of_birth') }} :</h6>
                                <p class="mb-0">
                                    {{ $data->date_of_birth ? formatDate(date('Y-m-d', strtotime($data->date_of_birth))) : '--' }}
                                </p>

                            </div>
                        </div>
                    </div>
                    <hr class="my-5 border-bottom-0">
                    <div class="address">
                        <h5>{{ __('users.lbl_address') }}</h5>
                        <p>{{ $data->address ?? '--' }}</p>
                    </div>
                    <hr class="my-5 border-bottom-0">
                </div>
            </div>

        <div class="subscription-details">
    <h5 class="mb-3">{{ __('users.lbl_subscription_details') }}</h5>
    <div class="table-responsive">
        <table class="table">
            <thead class="text-primary">
                <tr>
                    <th>{{ __('dashboard.plan') }}</th>
                    <th>{{ __('users.date') }}</th>
                    <th>{{ __('dashboard.amount') }}</th>
                       <th>{{__('frontend.tax')}}</th>
                <th>{{__('frontend.total')}}</th> <!-- NEW -->
                    <th>{{ __('dashboard.duration') }}</th>
                    <th>{{ __('dashboard.payment_method') }}</th>
                    <th>{{ __('dashboard.txn_id') }}</th>
                    <th>{{ __('dashboard.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($data->subscriptiondata && $data->subscriptiondata->isNotEmpty())
                    @foreach($data->subscriptiondata as $subscription)
                        <tr>
                            <td>{{ $subscription->name ?? '--' }}</td>
                            <td>{{ $subscription->start_date ? formatDate(date('Y-m-d', strtotime($subscription->start_date))) : '--' }}</td>
                            <td>{{ Currency::format($subscription->amount) ?? '--' }}</td>
                            <td>{{ Currency::format($subscription->tax_amount) ?? '--' }}</td> <!-- NEW -->
                            <td>{{ Currency::format($subscription->total_amount) ?? '--' }}</td> <!-- NEW -->
                            <td>{{ $subscription->duration ?? '--' }} {{ ucfirst($subscription->type) ?? '--' }}</td>
                            <td>{{ ucfirst(optional($subscription->subscription_transaction)->payment_type) ?? '--' }}</td>
                            <td>{{ optional($subscription->subscription_transaction)->transaction_id ?? '--' }}</td>
                            <td>{{ ucfirst($subscription->status ?? '--') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">{{ __('messages.no_data_available') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

        </div>
    </div>
</div>

@endsection
