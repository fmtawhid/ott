@extends('frontend::layouts.master')
@section('content')
<div>
    <div class="page-title">
        <h4 class="m-0 text-center">{{__('frontend.account_setting')}}</h4>
    </div>
    <div class="section-spacing-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-1 d-lg-block d-none"></div>
                <div class="col-lg-12">
                    <div class="upgrade-plan d-flex flex-wrap gap-3 align-items-center justify-content-between rounded p-4 bg-warning-subtle border border-warning">
                            @if(!empty($subscriptions))

                                    <div class="d-flex justify-content-center align-items-center gap-4">
                                        <i class="ph ph-crown text-warning"></i>
                                        <div>
                                            <h6 class="super-plan">{{ $subscriptions['name'] }}</h6>
                                            <p class="mb-0 text-body">{{__('frontend.expiring_on')}}  {{ \Carbon\Carbon::parse($subscriptions['end_date'])->format('d M, Y') ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('subscriptionPlan') }}" class="btn btn-light">{{__('frontend.upgrade')}}</a>
                                        <button type="button" class="btn btn-primary"  data-subscription-id="{{ $subscriptions->id }}" data-bs-toggle="modal" data-bs-target="#CancleSubscriptionModal">{{__('frontend.cancel')}}</button>
                                    </div>

                            @else
                            <div class="d-flex gap-3">
                                    <h6 class="super-plan">{{__('frontend.not_active_subscription')}}</h6>
                                    <p class="mb-0 text-body">{{__('frontend.no_subscription')}}</p>
                            </div>
                            @endif
                    </div>
                </div>
                <div class="col-lg-1 d-lg-block d-none"></div>
            </div>
            <!-- Register Mobile Number -->
            <div class="mb-5">
                <h5 class="main-title text-capitalize mb-2">{{__('frontend.register_mobile_number')}}:</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <p class="mb-1">
                                    <strong>{{__('frontend.mobile')}}:</strong> {{ $user->mobile ?? 'Not Registered' }}
                                </p>
                            </div>
                            <a class="btn btn-warning-subtle btn-sm fs-4" href="{{ route('edit-profile') }}" data-bs-toggle="tooltip" title="{{ __('frontend.edit') }}">
                                <i class="ph ph-pencil-simple-line align-middle" style="font-size: 16px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Device -->
            <div class="mb-5">
                <h5 class="main-title text-capitalize mb-2">{{__('frontend.your_device')}}</h5>

                @if($your_device)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center gap-4 account-setting-content">
                            <div>
                                <h6 class="mb-1">{{ $your_device->device_name ?? 'Unknown Device' }}</h6>
                                <small>{{__('frontend.last_used')}}: {{ \Carbon\Carbon::parse($your_device->updated_at)->format('l, d F Y') }}</small>
                            </div>
                            <form action="{{ route('user-logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">{{__('frontend.logout')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <p class="text-muted">{{__('frontend.no_current_device')}}</p>
                @endif
            </div>

            <!-- Other Devices -->
            <div class="section-spacing-bottom px-0">
                <h5 class="main-title text-capitalize mb-2">{{__('frontend.other_devices')}}</h5>

                @forelse($other_devices as $device)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center gap-4 account-setting-content">
                            <div>
                                <h6 class="mb-1">{{ $device->device_name ?? 'No Device' }}</h6>
                                <small>{{__('frontend.last_used')}}: {{ \Carbon\Carbon::parse($device->updated_at)->format('l, d F Y') }}</small>
                            </div>
                            <form action="{{ route('device-logout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="device_id" value="{{ $device->device_id }}">
                                <button type="submit" class="btn btn-link p-0">{{__('frontend.logout')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">{{__('frontend.no_other_devices')}}</p>
                @endforelse
            </div>
            <div class="text-end mt-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">{{__('frontend.delete_account')}}</button>
            </div>
            <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-acoount-card">
                    <div class="modal-content position-relative">
                        <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
                        <i class="ph ph-x text-white fw-bold align-middle"></i>
                        </button>
                    <div class="modal-body modal-acoount-info text-center">
                        <img src="{{ asset('img/web-img/remove_icon.png') }}" alt="delete image">
                        <h4 class="mt-5 pt-4">{{__('frontend.permanent_delete')}}</h4>
                        <p class="pb-4 mb-0">{{__('frontend.permanent_deleted')}}</p>
                        <div class="d-flex justify-content-center gap-3 mt-4 pt-3">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('frontend.cancel')}}</button>
                            <button type="button" class="btn btn-primary" onclick="proceedToDeleteAccount()">{{__('frontend.proceed')}}</button>

                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="proceedAccountModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered successfully-acoount-card">
                    <div class="modal-content position-relative" style="background-image: url('../img/web-img/successfully_deleted.png');  background-repeat: no-repeat; background-size: cover;">
                    <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
                        <i class="ph ph-x text-white fw-bold align-middle"></i>
                        </button>
                    <div class="modal-body successfully-info text-center">
                        <div class="modal-icon-check m-auto fw-bold text-center">
                            <i class="ph ph-check text-white"></i>
                        </div>
                        <h5 class="mt-5 pt-3">{{__('frontend.success')}}</h5>
                        <p class="pb-4 mb-0">{{__('frontend.success_content')}}</p>
                    </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="CancleSubscriptionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-acoount-card">
                    <div class="modal-content position-relative">
                        <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
                        <i class="ph ph-x text-white fw-bold align-middle"></i>
                        </button>
                    <div class="modal-body modal-acoount-info text-center">
                        <h6 class="mt-3 pt-2">{{__('frontend.cancle_subscription')}}</h6>
                        <div class="d-flex justify-content-center gap-3 mt-4 pt-3">
                            <button type="button" class=" btn btn-dark" data-bs-dismiss="modal">{{__('frontend.cancel')}}</button>
                            <button type="button" class="btn btn-primary" onclick="cancelSubscription()">{{__('frontend.proceed')}}</button>

                        </div>
                    </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script src="{{ asset('js/form/index.js') }}" defer></script>
<script>

let baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');

function cancelSubscription() {

    const subscriptionId = document.querySelector('[data-bs-target="#CancleSubscriptionModal"]').getAttribute('data-subscription-id');

        fetch(`${baseUrl}/cancel-subscription`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: subscriptionId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.successSnackbar('Your subscription has been canceled.');
                location.reload();
            } else {

            }
        })
        .catch(error => {
            console.error('Error:', error);

        });

}
function proceedToDeleteAccount() {
        fetch(`${baseUrl}/api/delete-account`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                $('#deleteAccountModal').modal('hide');

                $('#proceedAccountModal').modal('show');

                // Redirect after 3 seconds
                setTimeout(function() {
                    window.location.href = '{{ route('login') }}';
                }, 3000);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
        });
    }

</script>

@endsection
