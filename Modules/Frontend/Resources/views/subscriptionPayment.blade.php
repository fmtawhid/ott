<div class="section-spacing-bottom">
    <div class="container">
        <a href="{{route('subscriptionPlan')}}" class="text-decoration-none text-white flex-none"><i class="ph ph-caret-left"></i><span class="font-size-18 fw-medium">{{__('frontend.back_to_subscription_plan')}}</span></a>
        <div class="mt-5">
            <div class="row">
                <div class="col-lg-3">

                    <form id="plan-form">
                        @foreach ($plans as $plan)
                            <div class="col-12 mb-4">
                                <label class="form-check stripe-payment-form p-4 position-relative rounded" for="{{ strtolower($plan->name) }}">
                                    @if($plan->discount>0)

                                    <input type="radio" id="{{ strtolower($plan->id) }}" name="plan_name" value="{{ $plan->id }}" data-amount="{{ $plan->total_price }}" class="form-check-input payment-radio-btn">
                                    @else

                                    <input type="radio" id="{{ strtolower($plan->id) }}" name="plan_name" value="{{ $plan->id }}" data-amount="{{ $plan->price }}" class="form-check-input payment-radio-btn">
                                    @endif
                                    <span class="form-check-label">
                                        <span class="text-uppercase fw-medium d-block mb-2">{{ $plan->name }}</span>
                                        @if($plan->discount>0)
                                        <span class="h4">   {{ Currency::format($plan->total_price) }}  <del> {{  Currency::format($plan->price) }}</del><span class="font-size-14 text-body">/ {{ $plan->duration_value }} {{ $plan->duration }} </span></span>
                                        @else
                                        <span class="h4"> {{ Currency::format($plan->price) }} <span class="font-size-14 text-body">/ {{ $plan->duration_value }}  {{ $plan->duration }}</span></span>
                                        @endif
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </form>
                </div>
                <div class="col-lg-9 mt-lg-0 mt-5">
                    <form action="{{ route('process-payment') }}" method="POST" id="payment-form">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="selected-plan-id" name="plan_id">
                            <input type="hidden" id="selected-price" name="price">
                            <input type="hidden" id="selected-promotion-id" name="promotion_id">
                            <label class="form-label" for="payment-method">{{ __('frontend.choose_payment_method') }}:</label>
                            <select id="payment-method" name="payment_method" class="form-select">
                                <option value="" disabled>{{ __('frontend.select_payment_method') }}</option>
                                @php
                                    $payment_methods = [
                                        'str_payment_method' => 'sslcommerz',
                                        'razor_payment_method' => 'razorpay',
                                        'paystack_payment_method' => 'paystack',
                                        'paypal_payment_method' => 'paypal',
                                        'flutterwave_payment_method' => 'flutterwave',
                                        'cinet_payment_method' => 'cinet',
                                        'sadad_payment_method' => 'sadad',
                                        'airtel_payment_method' => 'airtel',
                                        'phonepe_payment_method' => 'phonepe',
                                        'midtrans_payment_method' => 'midtrans'
                                    ];
                                @endphp
                                @foreach ($payment_methods as $setting => $method)
                                    @if (setting($setting) == 1)
                                        <option value="{{ $method }}" {{ $method == 'sslcommerz' ? 'selected' : '' }}>
                                            {{ __('' . $method) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                        </div>

                        <div class="mt-4">
                        <div class="available-coupons rounded p-3 {{ isset($promotions) && $promotions->isNotEmpty() ? '' : 'd-none' }}" id="promotional_section">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @if(isset($promotions) && count($promotions) > 2)
                            <h6 class="font-size-18 mb-0">{{ __('frontend.available_coupons') }}</h6>
                            <a href="javascript:void(0);"
                            class="text-primary view-all-coupons"
                            data-bs-toggle="modal"
                            data-bs-target="#all-coupons"
                            style="display: block;">  <!-- Initially hidden -->
                                {{ __('messages.view_all') }}
                            </a>
                                @endif
                            </div>

                            <div class="coupon-search coupan-list mb-3">
                                <input type="text"
                                    id="coupon-search"
                                    class="form-control coupons-card"
                                    placeholder="{{ __('frontend.search_coupon_code') }}">
                            </div>
                            
                            <div class="row flex-wrap coupan-list" id="promotional_id">
                                @foreach ($promotions as $key => $promotion)
                                    @if($key < 2)
                                        <div class="col-md-6 mb-2 promotion-item" data-code="{{ $promotion->code }}">
                                            <label class="form-check-label rounded coupons-card d-flex justify-content-between align-items-start gap-3 p-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <input class="form-check-input coupon-radio"
                                                        type="radio"
                                                        name="coupon_id"
                                                        id="coupon_id_{{ $promotion->id }}"
                                                        value="{{ $promotion->id }}">
                                                    <div>
                                                        @if($promotion->discount_type == 'percentage')
                                                            <p class="mb-2 font-size-14">{{ __('frontend.get_extra') }} {{ $promotion->discount }}% {{ __('frontend.off') }}</p>
                                                        @else
                                                            <p class="mb-2 font-size-14">{{ __('frontend.get_extra') }} {{ Currency::format($promotion->discount) }} {{ __('frontend.off') }}</p>
                                                        @endif
                                                        <div class="d-flex align-items-center gap-2">
                                                            <p class="mb-0 font-size-14">{{ __('frontend.use_code') }}:</p>
                                                            <h6 class="mb-0">{{ $promotion->code }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="font-size-14 coupons-status">{{ __('frontend.apply') }}</span>
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- View All Coupons Modal -->
                        <div class="modal fade" data-bs-backdrop="false" id="all-coupons" tabindex="-1" role="dialog" aria-labelledby="couponModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('frontend.available_coupons') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" id="all-coupons-list">
                                            @foreach($promotions as $promotion)
                                                <div class="col-md-12 mb-3 promotion-item" data-code="{{ $promotion->code }}">
                                                    <label class="form-check-label rounded coupons-card d-flex justify-content-between align-items-start gap-3 p-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <input class="form-check-input coupon-radio"
                                                                type="radio"
                                                                name="modal_coupon_id"
                                                                id="modal_coupon_{{ $promotion->id }}"
                                                                value="{{ $promotion->id }}">
                                                            <div>
                                                                @if($promotion->discount_type == 'percentage')
                                                                    <p class="mb-2 font-size-14">{{ __('frontend.get_extra') }} {{ $promotion->discount }}% {{ __('frontend.off') }}</p>
                                                                @else
                                                                    <p class="mb-2 font-size-14">{{ __('frontend.get_extra') }} {{ Currency::format($promotion->discount) }} {{ __('frontend.off') }}</p>
                                                                @endif
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <p class="mb-0 font-size-14">{{ __('frontend.use_code') }}:</p>
                                                                    <h6 class="mb-0">{{ $promotion->code }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="font-size-14 coupons-status text-primary">{{ __('frontend.apply') }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="payment-detail rounded">
                            <h6 class="font-size-18">{{__('frontend.payment_details')}}</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>

                                        <tr>
                                            <td>{{__('frontend.price')}}</td>
                                            <td><h6 class="font-size-18 text-end mb-0" id="price"></h6></td>
                                        </tr>

                                        <tr id="discount_class" class="d-none">
                                            <td class="d-flex gap-2">coupon discount<h6 id="discount_data"></h6></td>
                                            <td><h6 class="font-size-18 text-end mb-0" id="discount"></h6></td>
                                        </tr>

                                        <tr id="subtotal_class" class="d-none">
                                            <td>{{__('frontend.subtotal')}}</td>
                                            <td><h6 class="font-size-18 text-end mb-0" id="subtotal"></h6></td>
                                        </tr>
                                        <tr id="tax_tr">
                                            <td><p>{{__('frontend.tax')}}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-end gap-2">
                                                    <span><i class="ph ph-info" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#appliedTax"></i></span>

                                                    <h6 class="font-size-18 text-end text-primary mb-0" id="tax"></h6>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td>{{__('frontend.total')}}</td>
                                            <td><h6 class="font-size-18 text-end mb-0" id="total"></h6></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <div class="d-flex justify-content-between gap-3">
                                        <h6>{{__('frontend.total_payment')}}</h6>
                                        <div class="d-flex justify-content-center align-items-center gap-3">
                                            <h5 class="mb-0" id="total-payment"></h5>
                                            <small><del id="old-price"></del></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex justify-content-end">
                                <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <i class="ph ph-lock-key text-primary"></i>
                                        <p class="mb-0">{{__('frontend.payment_secure')}}</p>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{__('frontend.proceed_payment')}}</button>


                                   <div class="modal fade" id="appliedTax" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <div class="ph-circle-check text-primary font-size-140"></div>
                                                    <h5 class="font-size-28 mb-4">Applied Taxes</h5>

                                                    <div id="applied_tax">


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center d-none">
                                        <div class="ph-circle-check text-primary font-size-140"></div>
                                        <h5 class="font-size-28 mb-4">{{__('frontend.thanks_for_payment')}}</h5>
                                        <p>{{__('frontend.payment_success')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">
                    <div class="modal-header justify-content-center">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="errorModalMessage"></p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn" style="background-color: #dc3545; color: #fff;" data-bs-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script src="https://checkout.flutterwave.com/v3.js"></script>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
        <script>

window.baseUrl = '{{ url("/") }}';
function createTaxTable(taxes) {
        let tableHtml = '<table class="table"><tbody>';
        taxes.forEach(function(tax) {
            tableHtml += '<tr>';
            if (tax.type.toLowerCase() === 'percentage') {
                tableHtml += `<td>${tax.name} (${tax.value}%)</td>`;
            } else {
                tableHtml += `<td>${tax.name} (${formatCurrencyvalue(tax.value)})</td>`;
            }
            tableHtml += `<td>${formatCurrencyvalue(tax.tax_amount)}</td>`;
            tableHtml += '</tr>';
        });
        tableHtml += '</tbody></table>';
        $('#applied_tax').html(tableHtml);
    }

    function updatePaymentDetails(planId, promotionId = null) {
        const data = {
            plan_id: planId,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        if (promotionId) {
            data.promotion_id = promotionId;
        }

        $.ajax({
            url: `${baseUrl}/get-payment-details`,
            method: 'POST',
            data: data,
            success: function(response) {
                $('#price').text(formatCurrencyvalue(response.total_price));
                let subtotal = response.subtotal;
                if (response.promotion_discount_amount && response.promotion_discount_amount > 0) {
                    subtotal -= response.promotion_discount_amount;
                    $('#discount_class').removeClass('d-none');
                    $('#subtotal_class').removeClass('d-none');
                    // $('#discount_data').text('(coupon discount)');
                    $('#discount').text('-' + formatCurrencyvalue(response.promotion_discount_amount));
                    $('#subtotal').text(formatCurrencyvalue(subtotal));
                } else {
                    $('#discount_class').addClass('d-none');
                    $('#subtotal_class').addClass('d-none');
                }

                let taxAmount = 0;
                if (response.tax_array && response.tax_array.length > 0) {
                   taxAmount = 0;
                    if (response.tax_array && response.tax_array.length > 0) {
                        response.tax_array.forEach(tax => {
                            taxAmount += parseFloat(tax.tax_amount);
                        });
                    }

                }

                if (taxAmount === 0) {
                    $('#tax_tr').addClass('d-none');
                } else {
                    $('#tax_tr').removeClass('d-none');
                    $('#tax').text('+' + formatCurrencyvalue(taxAmount));
                }

                const total = subtotal + taxAmount;
                $('#total').text(formatCurrencyvalue(total));
                $('#total-payment').text(formatCurrencyvalue(total));
                $('#selected-price').val(total);

                if (response.promotion_discount_amount > 0) {
                    $('#old-price').text(formatCurrencyvalue(response.price)).removeClass('d-none');
                } else {
                    $('#old-price').text('').addClass('d-none');
                }

                if (response.tax_array && response.tax_array.length > 0) {
                    createTaxTable(response.tax_array);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                $('#errorModalMessage').text('An error occurred while updating payment details.');
                if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
            }
        });
    }

    function updateCouponDisplay() {
    // Hide all promotion items first
    const allPromotions = $('#promotional_id .promotion-item');
    allPromotions.hide();

    // Show only first 2 promotions
    allPromotions.slice(0, 2).show();
}


    function formatCurrencyvalue(value) {
        value = parseFloat(value);
        if (window.currencyFormat !== undefined) {
            return window.currencyFormat(value);
        }
        return value.toFixed(2);
    }

            function initializeCouponSearch() {
                const searchInput = $('#coupon-search');
                searchInput.off('input').on('input', function() {
                    const searchTerm = $(this).val().toLowerCase().trim();
                    $('.promotion-item').each(function() {
                        const $item = $(this);
                        const code = String($item.data('code') || '').toLowerCase();
                        const text = $item.text().toLowerCase();
                        if (searchTerm === '' || code.indexOf(searchTerm) > -1 || text.indexOf(searchTerm) > -1) {
                            $item.show();
                        } else {
                            $item.hide();
                        }
                    });
                    const visibleItems = $('.promotion-item:visible').length;
                    $('#no-results-message').remove();
                    if (visibleItems === 0 && searchTerm !== '') {
                        $('#promotional_id, #all-coupons-list').append(`
                            <div id="no-results-message" class="col-12 text-center p-3">
                                <p class="text-muted mb-0">{{ __('frontend.no_coupons_found') }}</p>
                            </div>
                        `);
                    }
                });
            }

            $(document).ready(function() {
             @if(session('error'))
             $('#errorModalMessage').text('{{ session('error') }}');
             if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
             @endif
             const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
             var selectedPlanId = @json($planId); // Injected from the backend
             if (selectedPlanId) {
                 $('input[type="radio"][value="' + selectedPlanId + '"]').prop('checked', true);
                 $('#selected-plan-id').val(selectedPlanId);
                 $('#selected-price').val($('input[type="radio"][value="' + selectedPlanId + '"]').data('amount'));
                 updatePaymentDetails(selectedPlanId);
             }


    $('.payment-radio-btn').on('change', function() {
        var selectedPrice = $(this).data('amount');
        var selectedPlanId = $(this).val();
        $('#selected-price').val(selectedPrice);
        $('#selected-plan-id').val(selectedPlanId);

        // Reset UI and selected promotions
        $('#coupon-search').val('');
        $('.coupon-radio').prop('checked', false);
        $('#selected-promotion-id').val(''); // Reset selected promotion ID
        $('.coupons-status').text('{{ __("frontend.apply") }}').removeClass('d-none');
        $('.remove-coupon').addClass('d-none');

        // Fetch available promotions and update payment details
        $.ajax({
            url: `${baseUrl}/get-available-promotions`,
            method: 'POST',
            data: {
                plan_id: selectedPlanId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
            updatePromotions(response);
            // Update payment details without promotion
            updatePaymentDetails(selectedPlanId, null);

            // Initialize coupon search functionality for new promotions
            initializeCouponSearch();
            updateCouponDisplay();

        },
            error: function(xhr) {
                $('#errorModalMessage').text('Error loading promotions');
                if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
            }
        });
    });




             $('#payment-form').on('submit', function(e) {
                 e.preventDefault(); // Prevent default form submission
                 const paymentMethod = $('#payment-method').val();
                if (!paymentMethod) {
                    $('#errorModalMessage').text('Please select a payment method before proceeding.');
                    if (!$('#errorModal').hasClass('show')) {
                    $('#errorModal').modal('show');
                    }
                    return; // Exit the function
                }

                 const formData = $(this).serialize();
                 $.ajax({
                     url: $(this).attr('action'),
                     method: 'POST',
                     data: formData,
                     success: function(response) {
                         if (response.redirect) {
                             window.location.href = response.redirect;
                         }
                     },
                     error: function(xhr) {
                         const errorResponse = xhr.responseJSON || {};
                         const errorMessage = errorResponse.error || 'An error occurred. Please try another payment method.';
                         // Display an error modal using Bootstrap
                         $('#errorModalMessage').text(errorMessage);
                         if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
                     }
                 });
             });

// Razor Pay
             $('#payment-form').on('submit', function(e) {

                if (document.getElementById('payment-method').value !== 'razorpay') {
                    return true;
                }

                e.preventDefault();

                // Include promotion ID in the data
                const formData = new FormData(this);
                const selectedPromotionId = $('.coupon-radio:checked').val();
                if (selectedPromotionId) {
                    formData.append('promotion_id', selectedPromotionId);
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        var options = {
                            "key": response.key,
                            "amount": response.amount,
                            "currency": response.currency,
                            "name": response.name,
                            "description": response.description,
                            "order_id": response.order_id,
                            "handler": function (paymentResponse){
                                const successUrl = new URL(response.success_url);
                                successUrl.searchParams.append('gateway', 'razorpay');
                                successUrl.searchParams.append('razorpay_payment_id', paymentResponse.razorpay_payment_id);
                                successUrl.searchParams.append('plan_id', response.plan_id);

                                window.location.href = successUrl.toString();
                            },
                            "prefill": {
                                "name": response.prefill.name??'-',
                                "email": response.prefill.email,
                                "contact": response.prefill.contact??'-',
                            },
                            "theme": {
                                "color": "#F37254"
                            }
                        };

                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    },
                    error: function(xhr) {
                        if(xhr.status === 401) {
                            window.location.href = xhr.responseJSON.redirect_url;
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    }
                });
                });

// Flutterwave

$('#payment-form').on('submit', function(e) {
    if (document.getElementById('payment-method').value !== 'flutterwave') {
        return true;
    }

    e.preventDefault();

    // Include promotion ID in the data
    const formData = new FormData(this);
    const selectedPromotionId = $('.coupon-radio:checked').val();
    if (selectedPromotionId) {
        formData.append('promotion_id', selectedPromotionId);
    }

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.status === 'success') {
                const config = response.data;
                FlutterwaveCheckout({
                    public_key: config.public_key,
                    tx_ref: config.tx_ref,
                    amount: config.amount,
                    currency: config.currency,
                    payment_options: config.payment_options,
                    customer: {
                        email: config.customer.email,
                        name: config.customer.name,
                        phone_number: config.customer.phonenumber
                    },
                    customizations: config.customizations,
                    callback: function(response) {
                        if (response.status === "successful") {
                            window.location.href = config.redirect_url +
                                '&transaction_id=' + response.transaction_id +
                                '&tx_ref=' + response.tx_ref +
                                '&plan_id=' + config.meta.plan_id;
                        } else {
                            alert('Payment failed. Please try again.');
                        }
                    },
                    onclose: function() {
                        // Handle when customer closes the payment modal
                    }
                });
            } else {
                alert(response.message || 'Payment initialization failed');
            }
        },
        error: function(xhr) {
            const errorMsg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
            alert(errorMsg);
        }
    });
});

    // Function to apply coupon
    $('#apply-coupon-btn').on('click', function () {
        const couponCode = $('#coupon-code').val();
        const planId = $('#selected-plan-id').val();

        if (!couponCode) {
            $('#errorModalMessage').text('Please enter a coupon code.');
            if (!$('#errorModal').hasClass('show')) {
            $('#errorModal').modal('show');
            }
            return;
        }

        $.ajax({
            url: `${baseUrl}/apply-coupon`,
            method: 'POST',
            data: {
                coupon_code: couponCode,
                plan_id: planId,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    // Update UI with valid coupon details
                    $('#discount_class').removeClass('d-none');
                    $('#discount_data').text('(' + response.coupon_discount_percentage + '%)');
                    $('#discount').text('-' + formatCurrencyvalue(response.coupon_discount_amount));
                    $('#total').text(formatCurrencyvalue(response.total_after_coupon));
                    $('#total-payment').text(formatCurrencyvalue(response.total_after_coupon));
                    $('#old-price').text(formatCurrencyvalue(response.original_price)).removeClass('d-none');
                } else {
                    // Show error message for invalid or expired coupon
                    $('#errorModalMessage').text(response.message || 'Invalid or expired coupon code.');
                    if (!$('#errorModal').hasClass('show')) {
                    $('#errorModal').modal('show');
                    }
                }
            },
            error: function (xhr) {
                // Handle server errors
                $('#errorModalMessage').text('An error occurred while applying the coupon. Please try again.');
                if (!$('#errorModal').hasClass('show')) {
                $('#errorModal').modal('show');
                }
            }
        });
    });

    // Handle promotion selection
    $('.coupon-radio').on('change', function () {
        const promotionId = $(this).val();
        $('#selected-promotion-id').val(promotionId); // Set the selected promotion ID
        const planId = $('#selected-plan-id').val();

        if (!planId) {
            $('#errorModalMessage').text('Please select a plan first.');
            if (!$('#errorModal').hasClass('show')) {
            $('#errorModal').modal('show');
            }
            return;
        }

        $.ajax({
            url: `${baseUrl}/get-payment-details`,
            method: 'POST',
            data: {
                plan_id: planId,
                promotion_id: promotionId,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                // Update payment details
                $('#selected-price').val(response.total);
                $('#price').text(formatCurrencyvalue(response.total_price));
                $('#tax').text('+' + formatCurrencyvalue(response.tax));
                $('#total').text(formatCurrencyvalue(response.total));
                $('#total-payment').text(formatCurrencyvalue(response.total));

                // Handle discount details
                if (response.promotion_discount_amount > 0) {
                    $('#discount_class').removeClass('d-none');
                    $('#subtotal_class').removeClass('d-none');
                    // $('#discount_data').text('(coupon discount)');
                    $('#discount').text('-' + formatCurrencyvalue(response.promotion_discount_amount));
                    $('#subtotal').text(formatCurrencyvalue(response.subtotal));
                } else {
                    $('#discount_class').addClass('d-none');
                    $('#subtotal_class').addClass('d-none');
                }

                // Update tax table
                createTaxTable(response.tax_array);
            },
            error: function (xhr) {
                $('#errorModalMessage').text('An error occurred while applying the promotion.');
                if (!$('#errorModal').hasClass('show')) {
                $('#errorModal').modal('show');
                }
            }
        });
    });

    // Handle promotion/coupon selection
    $(document).on('change', '.coupon-radio', function() {
        const promotionId = $(this).val();
        const planId = $('#selected-plan-id').val();
        const selectedPrice = $('#selected-price').val();

        if (!planId) {
            $('#errorModalMessage').text('Please select a plan first.');
            if (!$('#errorModal').hasClass('show')) {
            $('#errorModal').modal('show');
            }
            $(this).prop('checked', false);
            return;
        }

        // $('.coupons-status').text('Apply');
        // $(this).closest('.coupons-card').find('.coupons-status').text('Applied');

        updatePaymentDetails(planId, promotionId);
    });

    function updatePaymentDetails(planId, promotionId = null) {
        const data = {
            plan_id: planId,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        if (promotionId) {
            data.promotion_id = promotionId;
        }

        $.ajax({
            url: `${baseUrl}/get-payment-details`,
            method: 'POST',
            data: data,
            success: function(response) {
                $('#price').text(formatCurrencyvalue(response.total_price));
            let subtotal = response.subtotal;
                $('#subtotal').text(formatCurrencyvalue(subtotal));


            let taxAmount = response.tax; // Use tax from backend
                if (taxAmount > 0) {
                $('#tax_tr').removeClass('d-none');
                $('#tax').text('+' + formatCurrencyvalue(taxAmount));
            } else {
                $('#tax_tr').addClass('d-none');
            }

                if (taxAmount === 0) {
                    $('#tax_tr').addClass('d-none');
                } else {
                    $('#tax_tr').removeClass('d-none');
                    $('#tax').text('+' + formatCurrencyvalue(taxAmount));
                }

                const total = subtotal + taxAmount;
                $('#total').text(formatCurrencyvalue(total));
                $('#total-payment').text(formatCurrencyvalue(total));
                $('#selected-price').val(total);

                if (response.promotion_discount_amount > 0) {
                    $('#old-price').text(formatCurrencyvalue(response.price)).removeClass('d-none');
                } else {
                    $('#old-price').text('').addClass('d-none');
                }

                if (response.tax_array && response.tax_array.length > 0) {
                    createTaxTable(response.tax_array);
                }
            },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    $('#errorModalMessage').text('An error occurred while updating payment details.');
                    if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
                }
            });
        }

// Handle promotion/coupon selection
$(document).on('change', '.coupon-radio', function() {
    const promotionId = $(this).val();
    const planId = $('#selected-plan-id').val();

    if (!planId) {
        $('#errorModalMessage').text('Please select a plan first.');
       if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
        $(this).prop('checked', false);
        return;
    }


    $('.coupons-status').text('{{ __("frontend.apply") }}');
    $('.coupons-status').removeClass('d-none');

    $('.remove-coupon');
    $(this).closest('.coupons-card').find('.coupons-status').text('{{ __("frontend.remove") }}');
    $(this).closest('.coupons-card').find('.remove-coupon');

    // Get payment details with the selected promotion
    $.ajax({
        url: `${baseUrl}/get-payment-details`,
        method: 'POST',
        data: {
            plan_id: planId,
            promotion_id: promotionId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.promotion_discount_amount > 0) {
                // Show discount section
                $('#discount_class').removeClass('d-none');
                $('#subtotal_class').removeClass('d-none');
                $('#discount').text('-' + formatCurrencyvalue(response.promotion_discount_amount));
                $('#subtotal').text(formatCurrencyvalue(response.subtotal));

                // Update UI for selected coupon
                const selectedCouponCard = $(`#coupon_id_${promotionId}`).closest('.coupons-card');
                // selectedCouponCard.find('.remove-coupon').removeClass('d-none');

                // Update total and other values
                $('#total').text(formatCurrencyvalue(response.total));
                $('#total-payment').text(formatCurrencyvalue(response.total));
                $('#selected-price').val(response.total);

                // Show original price if there's a discount
                $('#old-price').text(formatCurrencyvalue(response.total_price)).removeClass('d-none');
            } else {
                // Hide discount section if no discount
                $('#discount_class').addClass('d-none');
                $('#subtotal_class').addClass('d-none');
                $('#old-price').addClass('d-none');
            }

            // Update tax if present
            if (response.tax > 0) {
                $('#tax_tr').removeClass('d-none');
                $('#tax').text('+' + formatCurrencyvalue(response.tax));
            } else {
                $('#tax_tr').addClass('d-none');
            }
        },
        error: function(xhr) {
            $('#errorModalMessage').text('An error occurred while applying the promotion.');
            if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }

            // Reset coupon selection on error
            $('.coupon-radio').prop('checked', false);
            $('#discount_class').addClass('d-none');
            $('#subtotal_class').addClass('d-none');
        }
    });
});

// Handle coupon removal
$(document).on('click', '.remove-coupon', function() {
    const promotionId = $(this).data('coupon-id');
    const planId = $('#selected-plan-id').val();

    // Reset the UI for this coupon
    const couponCard = $(this).closest('.coupons-card');
    couponCard.find('.coupon-radio').prop('checked', false);
    couponCard.find('.coupons-status').text('{{ __("frontend.apply") }}');
    // Reset the UI
    $(this).closest('.coupons-card').find('.coupon-radio').prop('checked', false);
    $(this).closest('.coupons-card').find('.coupons-status').text('{{ __("frontend.apply") }}');
       $('.coupons-status').removeClass('d-none');
    $(this).addClass('d-none');

    // Hide discount sections
    $('#discount_class').addClass('d-none');
    $('#subtotal_class').addClass('d-none');
    $('#old-price').addClass('d-none');

    // Update payment details without promotion
    updatePaymentDetails(planId, null);
});
    });

    // Coupon search functionality
    $('#coupon-search').on('input', function() {
        const searchTerm = $(this).val().toLowerCase().trim();

        $('.promotion-item').each(function() {
            const code = String($(this).data('code') || '').toLowerCase();
            const text = $(this).text().toLowerCase();

            if (searchTerm === '' || code.indexOf(searchTerm) > -1 || text.indexOf(searchTerm) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Show/hide no results message
        const visibleItems = $('.promotion-item:visible').length;
        if (visibleItems === 0) {
            if ($('#no-results-message').length === 0) {
                $('#promotional_id').append(`
                    <div id="no-results-message" class="col-12 text-center p-3">
                        <p class="text-muted mb-0">{{ __('frontend.no_coupons_found') }}</p>
                    </div>
                `);
            }
        } else {
            $('#no-results-message').remove();
        }
    });

    // Handle checkbox click to search
    $(document).on('change', '.coupon-radio', function() {
        const promotionId = $(this).val();
        const planId = $('#selected-plan-id').val();

        if (!planId) {
            $('#errorModalMessage').text('Please select a plan first.');
            if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
            $(this).prop('checked', false);
            return;
        }

        // Update UI for selected coupon
        $('.coupons-status').text('{{ __("frontend.apply") }}');
        $(this).closest('.coupons-card').find('.coupons-status').text('{{ __("frontend.remove") }}');

        // Update payment details with the selected promotion
        updatePaymentDetailsWithPromotion(planId, promotionId);
    });

    // Clear search on focus
    $('#coupon-search').on('focus', function() {
        $(this).val('');
        $('.promotion-item').show();
        $('#no-results-message').remove();
        updateMainCouponDisplay(); // Keep showing only first 2 coupons in main view
    });

    // Sync radio selection between main view and modal
    $(document).on('change', 'input[name="modal_coupon_id"]', function() {
        const couponId = $(this).val();

        // Update main view radio button
        $(`#coupon_id_${couponId}`).prop('checked', true).trigger('change');

        // Close modal after selection
        $('#all-coupons').modal('hide');
    });

    // Update modal radio button when main view selection changes
    $(document).on('change', 'input[name="coupon_id"]', function() {
        const couponId = $(this).val();
        $(`#modal_coupon_${couponId}`).prop('checked', true);
    });

    // Reset modal state when closed
    $('#all-coupons').on('hidden.bs.modal', function() {
        const selectedCouponId = $('input[name="coupon_id"]:checked').val();
        if (selectedCouponId) {
            $(`#modal_coupon_${selectedCouponId}`).prop('checked', true);
        }
    });

    // Search functionality in modal
    $('#coupon-search').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase().trim();

        $('.promotion-item').each(function() {
            // Get code from data attribute, convert to string and ensure it exists
            const code = String($(this).data('code') || '').toLowerCase();
            // Get all text content from the promotion item
            const text = $(this).text().toLowerCase();

            if (searchTerm === '' || code.indexOf(searchTerm) > -1 || text.indexOf(searchTerm) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Show/hide no results message
        const visibleItems = $('.promotion-item:visible').length;
        if (visibleItems === 0) {
            if ($('#no-results-message').length === 0) {
                $('#promotional_id').append(`
                    <div id="no-results-message" class="col-12 text-center p-3">
                        <p class="text-muted mb-0">{{ __('frontend.no_coupons_found') }}</p>
                    </div>
                `);
            }
        } else {
            $('#no-results-message').remove();
        }
    });
    function updatePaymentDetailsWithPromotion(planId, promotionId) {
        $.ajax({
            url: `${baseUrl}/get-payment-details`,
            method: 'POST',
            data: {
                plan_id: planId,
                promotion_id: promotionId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Update price display
                $('#price').text(formatCurrencyvalue(response.total_price));

                // Handle promotion discount
                if (response.promotion_discount_amount > 0) {
                    $('#discount_class').removeClass('d-none');
                    $('#subtotal_class').removeClass('d-none');
                    $('#discount').text('-' + formatCurrencyvalue(response.promotion_discount_amount));
                    $('#subtotal').text(formatCurrencyvalue(response.subtotal));
                    $('#old-price').text(formatCurrencyvalue(response.total_price)).removeClass('d-none');
                } else {
                    $('#discount_class').addClass('d-none');
                    $('#subtotal_class').addClass('d-none');
                    $('#old-price').addClass('d-none');
                }

                // Handle tax
                if (response.tax > 0) {
                    $('#tax_tr').removeClass('d-none');
                    $('#tax').text('+' + formatCurrencyvalue(response.tax));
                } else {
                    $('#tax_tr').addClass('d-none');
                }

                // Update totals
                const total = parseFloat(response.total);
                $('#total').text(formatCurrencyvalue(total));
                $('#total-payment').text(formatCurrencyvalue(total));
                $('#selected-price').val(total);

                // Update tax table if available
                if (response.tax_array && response.tax_array.length > 0) {
                    createTaxTable(response.tax_array);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                $('#errorModalMessage').text('An error occurred while updating payment details.');
                if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
            }
        });
    }

    function updateMainCouponDisplay() {
    // Show only first 2 promotions in main view
    const allPromotions = $('#promotional_id .promotion-item');
    allPromotions.hide();
    allPromotions.slice(0, 2).show();
}
    // Single event handler for coupon selection (both modal and main view)
    $(document).on('change', '.coupon-radio', function(e) {
    e.stopPropagation();

    const promotionId = $(this).val();
    const planId = $('#selected-plan-id').val();
    const currentPlanRadio = $(`input[type="radio"][value="${planId}"]`);
    const isModal = $(this).closest('#all-coupons').length > 0;

    // Validate plan selection
    if (!planId) {
        $('#errorModalMessage').text('Please select a plan first.');
        if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
        $(this).prop('checked', false);
        return;
    }
    currentPlanRadio.prop('checked', true);

    syncCouponSelections(promotionId);
    // Update payment details
    updatePaymentDetailsWithPromotion(planId, promotionId);
});


    // Remove coupon handling
    $(document).on('click', '.coupons-status.remove-action', function(e) {
    e.preventDefault();
    e.stopPropagation();

    const promotionId = $(this).data('promotion-id');
    const planId = $('#selected-plan-id').val();

    // Reset all coupon selections and displays
    $('.coupon-radio').prop('checked', false);
    $('.coupons-status').text('{{ __("frontend.apply") }}')
                        .removeClass('remove-action')
                        .removeAttr('data-promotion-id');

    $('#coupon-search').val('').trigger('input');
    $('#selected-promotion-id').val('');

    // Hide discount sections
    $('#discount_class').addClass('d-none');
    $('#subtotal_class').addClass('d-none');
    $('#old-price').addClass('d-none');

    // Update payment details without promotion
    updatePaymentDetailsWithPromotion(planId, null);
});
function syncCouponSelections(promotionId) {
    $('.coupon-radio').prop('checked', false);
    $('.coupons-status').each(function() {
        $(this).text('{{ __("frontend.apply") }}')
               .removeClass('remove-action')
               .removeAttr('data-promotion-id');
    });

    if (promotionId) {
        // Update both modal and main view selections
        $(`.coupon-radio[value="${promotionId}"]`).each(function() {
            $(this).prop('checked', true);
            const statusElement = $(this).closest('.coupons-card')
                                      .find('.coupons-status');

            // Force text update and class addition
            setTimeout(() => {
                statusElement.text('{{ __("frontend.remove") }}')
                           .addClass('remove-action')
                           .attr('data-promotion-id', promotionId);
            }, 0);
        });
    }

    updateMainCouponDisplay();
}

function syncModalWithMainView() {
    // Get selected coupon from main view
    const selectedMainCoupon = $('input[name="coupon_id"]:checked');
    const selectedCouponId = selectedMainCoupon.val();

    if (selectedCouponId) {
        // Update modal selection
        $(`input[name="modal_coupon_id"][value="${selectedCouponId}"]`)
            .prop('checked', true);

        // Update status text in both views
        $('.coupons-status').text('{{ __("frontend.apply") }}')
                           .removeClass('remove-action')
                           .removeAttr('data-promotion-id');

        $(`.coupon-radio[value="${selectedCouponId}"]`).each(function() {
            $(this).closest('.coupons-card')
                   .find('.coupons-status')
                   .text('{{ __("frontend.remove") }}')
                   .addClass('remove-action')
                   .attr('data-promotion-id', selectedCouponId);
        });
    }
}

// Update the modal events
$('#all-coupons').on('show.bs.modal', function() {
    syncModalWithMainView();
});

$('#all-coupons').on('hidden.bs.modal', function() {
    const modalElement = $('#all-coupons');
    if (modalElement.length > 0) {
        syncModalWithMainView();
    } else {
        console.error('Modal element not found.');
    }
});

// Update the plan selection handler
$('.payment-radio-btn').on('change', function() {
    var selectedPrice = $(this).data('amount');
    var selectedPlanId = $(this).val();
    $('#selected-price').val(selectedPrice);
    $('#selected-plan-id').val(selectedPlanId);

    // Reset UI and selected promotions
    $('#coupon-search').val('');
    $('.coupon-radio').prop('checked', false);
    $('#selected-promotion-id').val(''); // Reset selected promotion ID
    $('#discount_class').addClass('d-none');
    $('#subtotal_class').addClass('d-none');
    $('#old-price').addClass('d-none');
    $.ajax({
        url: `${baseUrl}/get-available-promotions`,
        method: 'POST',
        data: {
            plan_id: selectedPlanId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            updatePromotions(response);
            updatePaymentDetails(selectedPlanId, null);
            initializeCouponSearch();
            updateCouponDisplay();
            syncModalWithMainView();
        },
        error: function(xhr) {
            $('#errorModalMessage').text('Error loading promotions');
            if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
        }
    });
});

// Update the coupon selection handler
$(document).on('change', '.coupon-radio', function(e) {
    e.stopPropagation();

    const promotionId = $(this).val();
    const planId = $('#selected-plan-id').val();

    if (!planId) {
        $('#errorModalMessage').text('Please select a plan first.');
       if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
        $(this).prop('checked', false);
        return;
    }

    // Sync selections and update UI
    syncCouponSelections(promotionId);

    // Update payment details
    updatePaymentDetailsWithPromotion(planId, promotionId);
        if ($(this).closest('#all-coupons').length > 0) {
            $('#all-coupons').modal('hide');
        }
    });

    // Add this function to initialize promotions on page load
function initializePromotions() {
    const selectedPlanId = $('input[name="plan_name"]:checked').val();
    if (selectedPlanId) {
        $.ajax({
            url: `${baseUrl}/get-available-promotions`,
            method: 'POST',
            data: {
                plan_id: selectedPlanId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                updatePromotions(response);
                updateMainCouponDisplay();
                initializeCouponSearch();
            },
            error: function(xhr) {
                console.error('Error loading initial promotions:', xhr);
            }
        });
    }
}

// Modify the document ready function
$(document).ready(function() {
    // Set first plan as selected by default if none is selected
    if (!$('input[name="plan_name"]:checked').length) {
        $('input[name="plan_name"]:first').prop('checked', true);
    }

    // Get the selected plan's details
    const selectedPlan = $('input[name="plan_name"]:checked');
    const selectedPlanId = selectedPlan.val();
    const selectedPrice = selectedPlan.data('amount');

    // Set initial values
    $('#selected-plan-id').val(selectedPlanId);
    $('#selected-price').val(selectedPrice);

    // Initialize promotions for the selected plan
    initializePromotions();

    // Update payment details without promotion
    updatePaymentDetails(selectedPlanId, null);

    // ... rest of your existing document ready code ...
});

// Update the promotion display function
function updatePromotions(response) {
    if (response.promotions && response.promotions.length > 0) {
        let mainViewHtml = '';
        let modalViewHtml = '';
        response.promotions.forEach(function(promotion, index) {
            const discount = parseFloat(promotion.discount);
            let discountText = '';

            if (promotion.discount_type === 'percentage') {
                discountText = `${discount}%`;
            } else {
                discountText = formatCurrencyvalue(discount);
            }

            const promotionHtml = `
                 <div class="col-md-6 mb-2 promotion-item" data-code="${promotion.code}">
                    <label class="form-check-label rounded coupons-card d-flex justify-content-between gap-3 p-3">
                        <div class="d-flex align-items-center gap-3">
                            <input class="form-check-input coupon-radio"
                                   type="radio"
                                   name="coupon_id"
                                   id="coupon_id_${promotion.id}"
                                   value="${promotion.id}">
                            <div>
                                <p class="mb-2 font-size-14">
                                    {{ __('frontend.get_extra') }} ${discountText} {{ __('frontend.off') }}
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <p class="mb-0 font-size-14">{{ __('frontend.use_code') }}:</p>
                                    <h6 class="mb-0">${promotion.code}</h6>
                                </div>
                            </div>
                        </div>
                        <span class="font-size-14 coupons-status">{{ __('frontend.apply') }}</span>
                    </label>
                </div>
            `;
            const promotionModelHtml = `
                 <div class="col-md-12 mb-2 promotion-item" data-code="${promotion.code}">
                    <label class="form-check-label rounded coupons-card d-flex justify-content-between gap-3 p-3">
                        <div class="d-flex align-items-center gap-3">
                            <input class="form-check-input coupon-radio"
                                   type="radio"
                                   name="modal_coupon_id"
                                   id="modal_coupon_${promotion.id}"
                                   value="${promotion.id}">
                            <div>
                                <p class="mb-2 font-size-14">
                                    {{ __('frontend.get_extra') }} ${discountText} {{ __('frontend.off') }}
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <p class="mb-0 font-size-14">{{ __('frontend.use_code') }}:</p>
                                    <h6 class="mb-0">${promotion.code}</h6>
                                </div>
                            </div>
                        </div>
                        <span class="font-size-14 coupons-status">{{ __('frontend.apply') }}</span>
                    </label>
                </div>
            `;
            if (index < 2) {
                mainViewHtml += promotionHtml;
            }
            modalViewHtml += promotionModelHtml;
        });

        $('#promotional_id').html(mainViewHtml);
        $('#all-coupons-list').html(modalViewHtml);
        if (response.promotions.length > 2) {
            $('.view-all-coupons').show();
        } else {
            $('.view-all-coupons').hide();
        }

        $('#promotional_section').removeClass('d-none');

        // Ensure only one coupon is selected at a time
        $('.coupon-radio').on('change', function() {
            const selectedCouponId = $(this).val();
            $('.coupon-radio').not(this).prop('checked', false); // Uncheck all other radios
            $('#selected-promotion-id').val(selectedCouponId); // Update selected promotion ID
        });
    } else {
        // $('#promotional_section').addClass('d-none');
    }
}

// Update the main coupon display function
function updateMainCouponDisplay() {
    const mainPromotions = $('#promotional_id .promotion-item');
    mainPromotions.hide();
    mainPromotions.slice(0, 2).show();
}

// Update the payment form submission handler
$('#payment-form').on('submit', function(e) {
    e.preventDefault();

    // Get the payment method
    const paymentMethod = $('#payment-method').val();

    // Check if payment method is selected
    if (!paymentMethod) {
        $('#errorModalMessage').text('Please select a payment method before proceeding.');
        if (!$('#errorModal').hasClass('show')) {
                            $('#errorModal').modal('show');
                            }
        return;
    }

    // Get the selected promotion ID from the checked radio button
    const selectedPromotionId = $('.coupon-radio:checked').val();

    // Create form data including the promotion ID
    const formData = new FormData(this);
    if (selectedPromotionId) {
        formData.set('promotion_id', selectedPromotionId);
    }

    // Make the AJAX request
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (paymentMethod === 'midtrans' && response.snapToken) {
                // Open Midtrans Snap popup
                window.snap.pay(response.snapToken, {
                    onSuccess: function(result){
                        window.location.href = window.baseUrl + '/payment/success?gateway=midtrans&transaction_id=' + result.transaction_id;
                    },
                    onPending: function(result){
                        window.location.href = window.baseUrl + '/payment/success?gateway=midtrans&transaction_id=' + result.transaction_id;
                    },
                    onError: function(result){
                        alert('Payment failed: ' + result.status_message);
                    },
                    onClose: function(){
                    }
                });
            } else if (response.redirect) {
                window.location.href = response.redirect;
            }
        },
        error: function(xhr) {
            const errorResponse = xhr.responseJSON || {};
            const errorMessage = errorResponse.error || 'An error occurred. Please try another payment method.';
            $('#errorModalMessage').text(errorMessage);
            if (!$('#errorModal').hasClass('show')) {
                $('#errorModal').modal('show');
            }
        }
    });
});

// Update the function that handles promotion selection to ensure promotion ID is stored
$(document).on('change', '.coupon-radio', function() {
    const promotionId = $(this).val();
    const planId = $('#selected-plan-id').val();

    // Store the selected promotion ID in the hidden input
    $('#selected-promotion-id').val(promotionId);

    // Rest of your existing promotion handling code...
    updatePaymentDetailsWithPromotion(planId, promotionId);
});
function updateCouponSelections() {
    $(document).on('change', 'input[name="coupon_id"], input[name="modal_coupon_id"]', function() {
        const selectedValue = $(this).val();
        const isMainView = $(this).attr('name') === 'coupon_id';

        $('input[name="coupon_id"], input[name="modal_coupon_id"]').prop('checked', false);

        if (isMainView) {
            $(`input[name="coupon_id"][value="${selectedValue}"]`).prop('checked', true);
            $(`input[name="modal_coupon_id"][value="${selectedValue}"]`).prop('checked', false);
        } else {
            $(`input[name="modal_coupon_id"][value="${selectedValue}"]`).prop('checked', true);
            $(`input[name="coupon_id"][value="${selectedValue}"]`).prop('checked', false);
        }

        $('.coupons-status').text('{{ __("frontend.apply") }}');

        $(this).closest('.coupons-card').find('.coupons-status').text('{{ __("frontend.remove") }}');
    });
}
</script>
