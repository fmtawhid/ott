<div id="season-card-wrapper" class="section-spacing-bottom px-0">
    <div class="seasons-tabs-wrapper position-relative">
        <div class="season-tabs-inner">
            <div class="left">
                <i class="ph ph-caret-left"></i>
            </div>
            <div class="season-tab-container custom-nav-slider">
                <ul class="nav nav-tabs season-tab" id="season-tab" role="tablist">
                    @foreach ($data as $index => $item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                    id="season-{{ $index + 1 }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#season-{{ $index + 1 }}-pane"
                                    type="button"
                                    role="tab"
                                    aria-controls="season-{{ $index + 1 }}-pane"
                                    aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                Season {{ $index + 1 }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="right">
                <i class="ph ph-caret-right"></i>
            </div>
        </div>

        <div class="tab-content" id="season-tab-content">
            @foreach($data as $index => $value)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                        id="season-{{ (int)$index + 1 }}-pane"
                        role="tabpanel"
                        aria-labelledby="season-{{ (int)$index + 1 }}"
                        tabindex="0">
                    @if($value['access'] == 'pay-per-view' && !\Modules\Entertainment\Models\Entertainment::isPurchased($value['season_id'],'season'))
                    <div class="bg-dark text-white p-3 mb-2 d-flex justify-content-between align-items-center" style="border-width: 2px;">
                        <div>
                            @if($data['purchase_type'] === 'rental')
                                <span>
                                    {!! __('messages.rental_info', [
                                        'days' => $data['available_for'],
                                        'hours' => $data['access_duration']
                                    ]) !!}
                                    <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#rentalPurchaseModal">
                                        <i class="ph ph-info">i</i>
                                    </button>
                                </span>
                            @else
                                <span>
                                    {!! __('messages.purchase_info', [
                                        'days' => $data['available_for'],
                                    ]) !!}
                                    <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#onetimePurchaseModal">
                                        <i class="ph ph-info">i</i>
                                    </button>
                                </span>
                            @endif
                        </div>
                        <div>
                            <div>
                                @if($value['purchase_type'] === 'rental')
                                    <a href="{{ route('pay-per-view.paymentform',['id' => $value['season_id']]) }}" class="btn btn-success d-flex align-items-center">
                                        <i class="bi bi-lock-fill me-1"></i>
                                        @if($value['discount'] > 0)
                                            <span class="me-2">
                                                {{ __('messages.rent_button', ['price' => Currency::format($value['price'] - ($value['price'] * ($value['discount'] / 100)), 2)]) }}
                                            </span>
                                            <span class="text-decoration-line-through text-white-50">
                                                {{ Currency::format($value['price'], 2) }}
                                            </span>
                                        @else
                                            {{ __('messages.rent_button', ['price' => Currency::format($value['price'], 2)]) }}
                                        @endif
                                    </a>
                                @else
                                    <a href="{{ route('pay-per-view.paymentform',['id' => $value['season_id']]) }}" class="btn btn-success d-flex align-items-center">
                                        <i class="bi bi-unlock-fill me-1"></i>
                                        @if($value['discount'] > 0)
                                            <span class="me-2">
                                                {{ __('messages.one_time_button', ['price' => Currency::format($value['price'] - ($value['price'] * ($value['discount'] / 100)), 2)]) }}
                                            </span>
                                            <span class="text-decoration-line-through text-white-50">
                                                {{ Currency::format($value['price'], 2) }}
                                            </span>
                                        @else
                                            {{ __('messages.one_time_button', ['price' => Currency::format($value['price'], 2)]) }}
                                        @endif
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                        <ul id="episode-list-{{ $value['season_id'] }}" class="list-inline m-0 p-0 d-flex flex-column gap-4 episode-list">
                            @foreach($value['episodes']->toArray(request()) as $episodeIndex => $episode)
                                <li>
                                    @include('frontend::components.card.card_episode', ['data' => $episode, 'index' => $episodeIndex])
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- One-time Purchase Modal for this season -->
                    <div class="modal fade" id="onetimePurchaseModal-{{ $value['season_id'] }}" tabindex="-1" aria-labelledby="onetimePurchaseModalLabel-{{ $value['season_id'] }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-dark text-white rounded shadow-lg border-0">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold" id="onetimePurchaseModalLabel-{{ $value['season_id'] }}">{{ $value['name'] }}</h5>
                                    <button class="custom-close-btn btn btn-primary" data-bs-dismiss="modal">
                                        <i class="ph ph-x"></i>
                                    </button>
                                </div>

                                <div class="modal-body px-4">
                                    <div class="row border-bottom pb-3 mb-4">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <p class="mb-1 text-muted fw-semibold">Validity</p>
                                            <h6 class="mb-0">Watch Time</h6>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <p class="mb-1 text-muted fw-semibold">Unlimited</p>
                                            <h6 class="mb-0">
                                                {{ \Carbon\Carbon::now()->format('d-m-Y') }} to
                                                {{ \Carbon\Carbon::now()->addDays($value['available_for'])->format('d-m-Y') }}
                                            </h6>
                                        </div>
                                    </div>

                                    <ul class="list-unstyled small text-white-50 mb-4">
                                        <li class="mb-2">• You have <strong>{{ $value['available_for'] }} days</strong> to start watching once purchased. Unlimited validity to finish once started streaming.</li>
                                        <li class="mb-2">• You can watch this content multiple times until the expiration period.</li>
                                        <li class="mb-2">• This is a <strong>non-refundable</strong> transaction.</li>
                                        <li class="mb-2">• This content is only available for purchase and not part of Premium Subscription.</li>
                                        <li class="mb-2">• You can play your content on supported devices.</li>
                                    </ul>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" checked id="agreeCheckbox-{{ $value['season_id'] }}">
                                        <label class="form-check-label small text-white-50" for="agreeCheckbox-{{ $value['season_id'] }}">
                                            By purchasing you agree to our <a href="{{ route('page.show', ['slug' => 'terms-conditions']) }}" class="text-decoration-underline text-white">Terms Of Use</a>.
                                        </label>
                                    </div>
                                </div>

                                <div class="modal-footer border-0 px-4 pb-4">
                                    <a href="{{ route('pay-per-view.paymentform', ['id' => $value['season_id']]) }}" id="onetimeSubmitButton-{{ $value['season_id'] }}" class="btn btn-success btn-lg w-100 d-flex align-items-center justify-content-center gap-2 fw-semibold">
                                        <i class="bi bi-unlock-fill"></i>
                                        @if($value['discount'] > 0)
                                            <span class="me-2">
                                                {{ __('messages.btn_onetime_payment', ['price' => Currency::format($value['price'] - ($value['price'] * ($value['discount'] / 100)), 2)]) }}
                                            </span>
                                            <span class="text-decoration-line-through text-white-50">
                                                {{ Currency::format($value['price'], 2) }}
                                            </span>
                                        @else
                                            {{ __('messages.btn_onetime_payment', ['price' => Currency::format($value['price'], 2)]) }}
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rental Purchase Modal for this season -->
                    <div class="modal fade" id="rentalPurchaseModal-{{ $value['season_id'] }}" tabindex="-1" aria-labelledby="rentalPurchaseModalLabel-{{ $value['season_id'] }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-dark text-white rounded shadow-lg border-0">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold" id="rentalPurchaseModalLabel-{{ $value['season_id'] }}">{{ $value['name'] }}</h5>
                                    <button class="custom-close-btn btn btn-primary" data-bs-dismiss="modal">
                                        <i class="ph ph-x"></i>
                                    </button>
                                </div>

                                <div class="modal-body px-4">
                                    <div class="row border-bottom pb-3 mb-4">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <p class="mb-1 text-muted fw-semibold">Validity</p>
                                            <h6 class="mb-0">Watch Duration</h6>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <p class="mb-1 text-muted fw-semibold">{{ $value['available_for'] }} Days</p>
                                            <h6 class="mb-0">{{ $value['access_duration'] }} Hours</h6>
                                        </div>
                                    </div>

                                    <ul class="list-unstyled small text-white-50 mb-4">
                                        <li class="mb-2">• You have <strong>{{ $value['available_for'] }} days</strong> to start watching once rented.</li>
                                        <li class="mb-2">• After starting, the video will be available for <strong>{{ $value['access_duration'] }} hours</strong>.</li>
                                        <li class="mb-2">• This is a <strong>non-refundable</strong> transaction.</li>
                                        <li class="mb-2">• This content is not part of the Premium Subscription plan.</li>
                                        <li class="mb-2">• Accessible only on supported devices.</li>
                                    </ul>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" checked id="rentalAgreeCheckbox-{{ $value['season_id'] }}">
                                        <label class="form-check-label small text-white-50" for="rentalAgreeCheckbox-{{ $value['season_id'] }}">
                                            By renting you agree to our <a href="{{ route('page.show', ['slug' => 'terms-conditions']) }}" class="text-decoration-underline text-white">Terms Of Use</a>.
                                        </label>
                                    </div>
                                </div>

                                <div class="modal-footer border-0 px-4 pb-4">
                                    <a href="{{ route('pay-per-view.paymentform', ['id' => $value['season_id']]) }}" id="rentalSubmitButton-{{ $value['season_id'] }}" class="btn btn-success btn-lg w-100 d-flex align-items-center justify-content-center gap-2 fw-semibold">
                                        <i class="bi bi-lock-fill"></i>
                                        @if($value['discount'] > 0)
                                            <span class="me-2">
                                                {{ __('messages.btn_rent_payment', ['price' => Currency::format($value['price'] - ($value['price'] * ($value['discount'] / 100)), 2)]) }}
                                            </span>
                                            <span class="text-decoration-line-through text-white-50">
                                                {{ Currency::format($value['price'], 2) }}
                                            </span>
                                        @else
                                            {{ __('messages.btn_rent_payment', ['price' => Currency::format($value['price'], 2)]) }}
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($value['total_episodes'] > 5)
                    <div class="viewmore-button-wrapper">
                        <button id="view-more-btn-{{ $value['season_id'] }}"
                                data-page="6"
                                data-season-id="{{ $value['season_id'] }}"
                                class="btn btn-dark view-more-btn">{{__('frontend.view_more')}}</button>
                        <button id="view-less-btn-{{ $value['season_id'] }}"
                                data-page="5"
                                data-season-id="{{ $value['season_id'] }}"
                                class="btn btn-secondary view-less-btn"
                                style="display: none;">{{__('frontend.view_less')}}</button>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle all one-time purchase checkboxes
        document.querySelectorAll('[id^="agreeCheckbox-"]').forEach(function(checkbox) {
            const seasonId = checkbox.id.split('-')[1];
            const button = document.getElementById('onetimeSubmitButton-' + seasonId);

            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    button.classList.remove('disabled-link');
                    button.style.pointerEvents = 'auto';
                    button.style.opacity = '1';
                } else {
                    button.classList.add('disabled-link');
                    button.style.pointerEvents = 'none';
                    button.style.opacity = '0.5';
                }
            });
        });

        // Handle all rental checkboxes
        document.querySelectorAll('[id^="rentalAgreeCheckbox-"]').forEach(function(checkbox) {
            const seasonId = checkbox.id.split('-')[1];
            const button = document.getElementById('rentalSubmitButton-' + seasonId);

            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    button.classList.remove('disabled-link');
                    button.style.pointerEvents = 'auto';
                    button.style.opacity = '1';
                } else {
                    button.classList.add('disabled-link');
                    button.style.pointerEvents = 'none';
                    button.style.opacity = '0.5';
                }
            });
        });
    });
</script>

<script>

$(document).ready(function() {

    const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
    const apiUrl = `${baseUrl}/api/episode-list`;

    $('.view-more-btn').on('click', function() {
        let button = $(this);
        let showLessButton=$('.view-less-btn');
        let page = button.data('page');
        let seasonId = button.data('season-id');

        // Dynamically set the URL with query parameters
        let url = `${apiUrl}?per_page=${page}&season_id=${seasonId}&is_ajax=1`;

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {

                if (response.status) {

                    $('#episode-list-' + seasonId).empty().append(response.html);

                    if (response.hasMore) {
                        button.data('page', page + 1);
                        showLessButton.show();
                    } else {
                        // If no more pages, hide the button
                        button.hide();
                    }
                } else {
                    console.log('No more episodes to load.');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
    $('.view-less-btn').on('click', function() {
        let button = $(this);
        let seasonId = button.data('season-id'); // Use data attribute for season ID

        // Reset the episode list
        $('#episode-list-' + seasonId).empty(); // Clear the current list
        let page = button.data('page');
        // Fetch the first page of episodes again
        let url = `${apiUrl}?per_page=5&season_id=${seasonId}&is_ajax=1`; // Request only the first two episodes
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.status) {
                    $('#episode-list-' + seasonId).append(response.html);
                    button.hide();
                    $('#view-more-btn-' + seasonId).data('page', 6).show(); // Show the View More button
                } else {
                    console.log('Failed to load initial episodes.');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
        $(this).hide(); // Hide the View Less button
        $('#view-more-btn-' + seasonId).data('page', 6).show(); // Reset and show the View More button
    });

});
</script>

