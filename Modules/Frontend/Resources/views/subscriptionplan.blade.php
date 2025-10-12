@extends('frontend::layouts.master')

@section('content')
<div class="section-spacing-bottom">
    <div class="container" id="payment-container">
        <div class="page-title">
            <h4 class="m-0 text-center">{{ __('frontend.subscription_plan') }}</h4>
        </div>
        <div class="">
            <div class="upgrade-plan d-flex flex-wrap gap-3 align-items-center justify-content-between rounded p-4 bg-warning-subtle border border-warning">
                <div class="d-flex justify-content-center align-items-center gap-4">
                    <i class="ph ph-crown text-warning"></i>
                    <div>
                        @if(!empty($activeSubscriptions))
                            <h6 class="super-plan">{{ $activeSubscriptions->name }}</h6>
                            <p class="mb-0 text-body">{{__('frontend.expiring_on')}} {{ \Carbon\Carbon::parse($activeSubscriptions->end_date)->format('d F, Y') }}</p>
                        @else
                            <h6 class="super-plan">{{__('frontend.no_active_plan')}}</h6>
                            <p class="mb-0 text-body">{{__('frontend.not_active_subscription')}}</p>
                        @endif
                    </div>
                </div>
                    <div class="d-flex gap-3">
                        @if(!empty($activeSubscriptions))
                            <button class="btn btn-light subscription-btn">{{ __('frontend.upgrade') }}</button>
                        @else
                            <button class="btn btn-light subscription-btn">{{ __('frontend.subscribe') }}</button>
                        @endif
                    </div>
            </div>
            <div class="row gy-4 row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3">
                <!-- Subscription Plan Basic -->
                @foreach($plans as $plan)
                <div class="col">
                    <div class="subscription-plan-wrapper {{ $plan->id == $currentPlanId ? 'active' : '' }} rounded">
                        <div class="subscription-plan-header">
                            <p class="subscription-name text-uppercase">{{ $plan->name }}</p>
                            @if($plan->discount == 1)
                            <div class="discount-offer">{{$plan->discount_percentage}} % off</div>
                            @endif
                            <p class="subscription-price mb-3">
                                @if($plan->discount == 1)
                                <s class="text-body">{{ Currency::format($plan->price) }}/</s>
                                {{ Currency::format($plan->total_price) }}
                                @else
                                {{ Currency::format($plan->price) }}
                                @endif
                                <span class="subscription-price-desc">/ {{ $plan->duration_value }} {{ $plan->duration }}</span>
                            </p>
                            <p class="line-count-3"> {!! $plan->description !!} </p>
                        </div>
                        <div class="readmore-wrapper">
                            <ul class="list-inline subscription-details">
                                @foreach ($plan->planLimitation as $limitation)
                                    @php
                                        // Set the default icon class for disabled state
                                        $iconClass = 'ph-x-circle text-danger';

                                        // Determine icon class based on specific conditions
                                        if ($limitation->limitation_value) {
                                            $iconClass = 'ph-check-circle text-success'; // Show check for enabled limitations
                                        } elseif ($limitation->limitation_slug === 'device-limit' && $limitation->limit == 0) {
                                            $iconClass = 'ph-check-circle text-success'; // Show check for 1 mobile device
                                        } elseif ($limitation->limitation_slug === 'profile-limit' && $limitation->limit == 0) {
                                            $iconClass = 'ph-check-circle text-success'; // Show check for profile limit
                                        }
                                    @endphp

                                    <li class="list-desc d-flex align-items-start gap-3 mb-2">
                                        <i class="ph {{ $iconClass }} align-middle"></i>
                                        <span class="font-size-16 text-white">
                                            @switch($limitation->limitation_slug)
                                                @case('video-cast')
                                                    Video Casting is {{ $limitation->limitation_value ? 'enabled' : 'not available' }}.
                                                    @break

                                                @case('ads')
                                                    Ads will {{ $limitation->limitation_value ? 'be shown' : 'not be shown' }}.
                                                    @break

                                                @case('device-limit')
                                                    You can use {{ $limitation->limit == 0 ? '**only 1 mobile device**' : "up to {$limitation->limit} device(s)" }} simultaneously.
                                                    @break

                                                @case('download-status')
                                                    Download resolutions:
                                                    @php
                                                        $availableQualities = [];
                                                        $notAvailableQualities = [];
                                                    @endphp

                                                    @foreach (json_decode($limitation->limit, true) as $quality => $available)
                                                        @if($available == 1)
                                                            @php
                                                                $availableQualities[] = strtoupper($quality);
                                                            @endphp
                                                        @else
                                                            @php
                                                                $notAvailableQualities[] = strtoupper($quality);
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    <ul class="sub-limits ps-0 mt-1">
                                                        @if (!empty($availableQualities))
                                                            <li class="d-flex align-items-center gap-2 mb-2">
                                                                <i class="ph ph-check-circle text-success"></i>
                                                                {{ implode('/', $availableQualities) }}
                                                            </li>
                                                        @endif

                                                        @if (!empty($notAvailableQualities))
                                                            <li class="d-flex align-items-center gap-2 mb-2">
                                                                <i class="ph ph-x-circle text-danger"></i>
                                                                {{ implode('/', $notAvailableQualities) }}
                                                            </li>
                                                        @endif
                                                    </ul>
                                                @break

                                                @case('supported-device-type')
                                                    @php
                                                        $supportedDevices = json_decode($limitation->limit, true);
                                                        $supportedDevicesList = [];
                                                    @endphp

                                                    @foreach ($supportedDevices as $device => $supported)
                                                        @if ($supported == 1)
                                                            @php
                                                                $supportedDevicesList[] = strtolower($device);  // Convert device names to lowercase
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    @if (!empty($supportedDevicesList))
                                                        <div class="d-flex align-items-center gap-2 mb-2">
                                                            Supported on: {{ implode(', ', $supportedDevicesList) }}.
                                                        </div>
                                                    @else
                                                        <div class="d-flex align-items-center gap-2">
                                                            Only Mobile is supported for this plan.
                                                        </div>
                                                    @endif
                                                @break



                                                @case('profile-limit')
                                                    You can create up to {{ $limitation->limit == 0 ? 1 : $limitation->limit }} profiles on this plan for different users.
                                                    @break

                                                @default
                                                        {{ ucwords(str_replace('-', ' ', $limitation->limitation_slug)) }}: {{ $limitation->limitation_value ? 'Enabled' : 'Disabled' }}
                                            @endswitch
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <button type="button"
                                class="rounded btn btn-{{ $plan->id == $currentPlanId ? 'primary' : 'dark' }} subscription-btn"
                                data-plan-id="{{ $plan->id }}"
                                data-plan-name="{{ $plan->name }}">
                            {{ $plan->id == $currentPlanId ? 'Renew Plan' : 'Choose Plan' }}
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


$(document).ready(function() {

    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
    $('.subscription-btn').on('click', function() {
        var planId = $(this).data('plan-id');
        var planName = $(this).data('plan-name');

        $.ajax({
            url: `${baseUrl}/select-plan`, // Your route to handle plan selection
            method: 'POST',
            data: {
                plan_id: planId,
                plan_name: planName,
                _token: '{{ csrf_token() }}' // CSRF token for security
            },
            success: function(response) {
                $('#payment-container').empty();
                $('#payment-container').html(response.view); // Inject the view into a container
            },
            error: function(xhr) {
                if (xhr.status === 419) {
                    // Token mismatch error, redirect to login page
                    window.location.href = `${baseUrl}/login`;
                } else {
                    // Handle other errors
                    alert('An error occurred while selecting the plan.');
                }
            }
        });
    });
});
</script>
@endsection
