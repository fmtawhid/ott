@extends('backend.layouts.app', ['isBanner' => false])

@section('title') {{ 'Dashboard' }} @endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                <a href="{{ route('backend.users.index') }}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-user"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ $totalusers }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_total_users') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <!-- <div class="col-md-4 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-user-gear"></i>
                            </div>
                            <div class="card-data">
                                {{-- <h1 class="">{{ $activeusers }}</h1> --}}
                                {{-- <p class="mb-0 fs-6">{{ __('dashboard.lbl_active_users') }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('backend.subscriptions.index') }}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-users-three"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ $totalSubscribers }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_total_subscribers') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                <a href="{{ route('backend.users.index', ['type' => 'soon-to-expire']) }}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-hourglass"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ $totalsoontoexpire }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_soon_to_expire') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
<div class="col-md-4 col-sm-6">
    <a href="{{ route('backend.reviews.index') }}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="card-icon mb-4 fs-1">
                    <!-- Outlined star icon with forced grey color -->
                    <svg width="31" height="27" viewBox="0 0 46 35" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_10479_23096)">
<path d="M29.5977 22.7916L35.8872 26.5762C36.0481 26.6755 36.2348 26.725 36.4238 26.7185C36.6128 26.7121 36.7957 26.6499 36.9495 26.5399C37.1033 26.4298 37.2212 26.2768 37.2883 26.1C37.3554 25.9232 37.3688 25.7305 37.3268 25.5461L35.6165 18.4815L41.2134 13.7565C41.3572 13.6353 41.4616 13.4739 41.5133 13.293C41.5649 13.1122 41.5615 12.92 41.5033 12.7411C41.4452 12.5622 41.3351 12.4047 41.187 12.2887C41.0389 12.1728 40.8596 12.1036 40.6719 12.0901L33.3261 11.5082L30.496 4.80394C30.4211 4.63018 30.2969 4.48216 30.1389 4.37817C29.9808 4.27417 29.7957 4.21875 29.6065 4.21875C29.4173 4.21875 29.2322 4.27417 29.0742 4.37817C28.9161 4.48216 28.792 4.63018 28.7171 4.80394L25.887 11.5082L18.5411 12.0901C18.3527 12.102 18.1723 12.17 18.0229 12.2854C17.8736 12.4008 17.7621 12.5582 17.703 12.7374C17.6438 12.9166 17.6396 13.1094 17.6909 13.291C17.7422 13.4726 17.8467 13.6347 17.9909 13.7565L23.5878 18.4815L21.8634 25.5461C21.8213 25.7305 21.8347 25.9232 21.9019 26.1C21.969 26.2768 22.0869 26.4298 22.2407 26.5399C22.3945 26.6499 22.5773 26.7121 22.7663 26.7185C22.9553 26.725 23.142 26.6755 23.303 26.5762L29.5977 22.7916Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15.2627 20.6631L4.98828 30.9375" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M17.1629 31.4189L7.80078 40.7811" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M29.9984 31.2397L20.457 40.7812" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_10479_23096">
<rect width="45" height="45" fill="white" transform="translate(0.769531)"/>
</clipPath>
</defs>
</svg>
                </div>
                <div class="card-data">
                    <h1 class="">{{ $totalreview }}</h1>
                    <p class="mb-0 fs-6">{{ __('dashboard.lbl_review') }}</p>
                </div>
            </div>
        </div>
    </a>
</div>

                <div class="col-md-4 col-sm-6">
                <a >
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-lockers"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ $totalUsageFormatted }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_storage_full') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                  <div class="col-md-4 col-sm-6">
                <a href="#">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-hourglass"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ $count_of_rent_movie + $count_of_rent_episode }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_rent_content') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                 <div class="col-md-4 col-sm-6">
                    <a href="{{ route('backend.subscriptions.index') }}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-money"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ Currency::format( $subscription_revenue) }}</h1>
                                <p class="mb-0 fs-6">{{ __('messages.lbl_total_subscription_revenue') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                  <div class="col-md-4 col-sm-6">
                    <a href="{{ route('backend.pay-per-view-history') }}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-money"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ Currency::format( $rent_revenue) }}</h1>
                                <p class="mb-0 fs-6">{{ __('messages.lbl_total_rent_revenue') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-money"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ Currency::format( $total_revenue) }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_total_revenue') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <!-- @if(isenablemodule('movie')==1)
                <div class="col-md-4 col-sm-6">
                <a href="{{ route('backend.movies.index') }}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-film-strip"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ $totalmovies }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_total_movies') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endif
                @if(isenablemodule('tvshow')==1)
                <div class="col-md-4 col-sm-6">
                <a href="{{ route('backend.tvshows.index') }}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-television-simple"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ $totaltvshow }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_total_shows') }}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endif
                @if(isenablemodule('video')==1)
                <div class="col-md-4 col-sm-6">
                <a href="{{ route('backend.videos.index') }}">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="card-icon mb-5 fs-1">
                                <i class="ph ph-video"></i>
                            </div>
                            <div class="card-data">
                                <h1 class="">{{ $totalvideo }}</h1>
                                <p class="mb-0 fs-6">{{ __('dashboard.lbl_total_videos') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                @endif -->
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-stats">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dashboard.lbl_top_genres') }}</h3>
                </div>
                <div class="card-body">
                    <div id="chart-top-genres"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stats card-block card-height">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <h3 class="card-title">{{ __('dashboard.lbl_tot_revenue') }}</h3>
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle total_revenue" type="button" id="dropdownTotalRevenue" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('dashboard.year') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-soft-primary sub-dropdown" aria-labelledby="dropdownTotalRevenue">
                            <li><a class="revenue-dropdown-item dropdown-item" data-type="Year">{{ __('dashboard.year') }}</a></li>
                            <li><a class="revenue-dropdown-item dropdown-item" data-type="Month">{{ __('dashboard.month') }}</a></li>
                            <li><a class="revenue-dropdown-item dropdown-item" data-type="Week">{{ __('dashboard.week') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart-top-revenue"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stats card-block card-height">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <h3 class="card-title">{{ __('dashboard.new_subscribers') }}</h3>
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle total_subscribers" type="button" id="dropdownNewSubscribers" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('dashboard.year') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-soft-primary sub-dropdown" aria-labelledby="dropdownNewSubscribers">
                            <li><a class="subscribers-dropdown-item dropdown-item" data-type="Year">{{ __('dashboard.year') }}</a></li>
                            <li><a class="subscribers-dropdown-item dropdown-item" data-type="Month">{{ __('dashboard.month') }}</a></li>
                            <li><a class="subscribers-dropdown-item dropdown-item" data-type="Week">{{ __('dashboard.week') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart-new-subscription"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-block card-height">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <h3 class="card-title">{{ __('dashboard.lbl_most_watched') }}</h3>
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle most_watch" type="button" id="dropdownMostWatch" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('dashboard.year') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-soft-primary sub-dropdown" aria-labelledby="dropdownMostWatch">
                            <li><a class="mostwatch-dropdown-item dropdown-item" data-type="Year">{{ __('dashboard.year') }}</a></li>
                            <li><a class="mostwatch-dropdown-item dropdown-item" data-type="Month">{{ __('dashboard.month') }}</a></li>
                            <li><a class="mostwatch-dropdown-item dropdown-item" data-type="Week">{{ __('dashboard.week') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart-most-watch"></div>
                </div>
            </div>
        </div>
<div class="col-md-6">
    <div class="card card-stats card-block card-height">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="card-title">{{ __('customer.reviews') }}</h3>
            <a href="{{ route('backend.reviews.index') }}">{{ __('dashboard.view_all') }}</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-primary">
                        <th>{{ __('dashboard.name') }}</th>
                        <th>{{ __('dashboard.date') }}</th>
                        <th>{{ __('dashboard.category') }}</th>
                        <th>{{ __('dashboard.rating') }}</th>
                    </thead>
                    <tbody>
                        @if($reviewData)
                        @foreach($reviewData as $review)
                        <tr>
                           <td class="d-flex gap-3 align-items-center">
    @if(optional($review->user))
        <a href="{{ url('/app/users/details/' . $review->user->id) }}" class="d-flex gap-3 align-items-center text-decoration-none">
            <img src="{{ setBaseUrlWithFileName($review->user->file_url) ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-40 rounded-pill">
            <div class="text-start">
                <h6 class="m-0">{{ $review->user->first_name . ' ' . $review->user->last_name }}</h6>
                <small class="text-white">{{ $review->user->email }}</small>
            </div>
        </a>
    @else
        <div class="d-flex gap-3 align-items-center">
            <img src="{{ default_user_avatar() }}" alt="avatar" class="avatar avatar-40 rounded-pill">
            <div class="text-start">
                <h6 class="m-0">{{ default_user_name() }}</h6>
                <small class="text-white">--</small>
            </div>
        </div>
    @endif
</td>

                            <td>{{ $review->created_at ? formatDate($review->created_at->format('Y-m-d')) : '' }}</td>
                            <td>{{ ucfirst(optional($review->entertainment)->type) }}</td>
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">
                                                <i class="ph ph-fill ph-star"></i>
                                            </span>
                                        @endfor
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">{{ __('messages.no_data_available') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

        <div class="col-12">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card card-block card-height">
                        <div class="card-header card-header-primary">
                            <h3 class="card-title">{{ __('dashboard.lbl_top_rated') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <div id="chart-top-rated"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="card card-block card-height">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <h3 class="card-title">{{ __('dashboard.transaction_history') }}</h3>
                            <a href="{{ route('backend.subscriptions.index') }}">{{ __('dashboard.view_all') }}</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>{{ __('dashboard.name') }}</th>
                                        <th>{{ __('dashboard.date') }}</th>
                                        <th>{{ __('dashboard.plan') }}</th>
                                        <th>{{ __('dashboard.amount') }}</th>
                                        <th>{{ __('dashboard.duration') }}</th>
                                        <th>{{ __('dashboard.payment_method') }}</th>
                                    </thead>
                                    <tbody>

                                        @foreach($subscriptionData as $subscription)
                                        <tr>
                                         <td>
                                            <a href="{{ $subscription->user ? route('backend.users.details', $subscription->user->id) : '#' }}"
                                                class="d-flex gap-3 align-items-center text-decoration-none text-dark {{ $subscription->user ? '' : 'disabled' }}">
        <img src="{{ setBaseUrlWithFileName(optional($subscription->user)->file_url) ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-40 rounded-pill">
        <div class="text-start">
            <h6 class="m-0">
                {{ optional($subscription->user)->first_name .' '. optional($subscription->user)->last_name  ?? default_user_name() }}
            </h6>
            <small class="text-dark"> <!-- ensure email is white or dark, depending on your theme -->
                {{ optional($subscription->user)->email ?? '--' }}
            </small>
        </div>
    </a>
</td>
                                            <td>{{ $subscription->is_manual == 1 ? (optional($subscription->start_date) ? \Carbon\Carbon::parse($subscription->start_date)->format('d F Y') : '--') : (optional($subscription->subscription_transaction?->created_at) ? \Carbon\Carbon::parse($subscription->subscription_transaction->created_at)->format('d F Y'): '--') }}</td>
                                            <td>{{ $subscription->name }}</td>
                                            <td>{{ Currency::format($subscription->total_amount) }}</td>
                                            <td>{{ $subscription->duration. ' ' . optional($subscription->plan)->duration }}</td>
                                            <td>{{ ucfirst(optional($subscription->subscription_transaction)->payment_type) }}</td>
                                        </tr>
                                        @endforeach
                                        @if($subscriptionData->isEmpty())
                                        <tr>
                                            <td colspan="5">{{__('messages.no_data_available')}}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@push('after-scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

const formatCurrencyvalue = (value) => {
           if (window.currencyFormat !== undefined) {
             return window.currencyFormat(value)
           }
           return value
        }

    document.addEventListener('DOMContentLoaded', function() {
        var Base_url = "{{ url('/') }}";
        var url = Base_url + "/app/get_genre_chart_data";

        $.ajax({
            url: url,
            method: "GET",
            data: {},
            success: function(response) {
                if (document.querySelectorAll('#chart-top-genres').length) {
                    const chartData = response.data.chartData;
                    const category = response.data.category;
                    const options = {
                        series: chartData,
                        chart: {
                            height: 385,
                            type: 'donut',
                        },
                        stroke: {
                            width: 0,
                        },
                        colors: ['var(--bs-primary)', 'var(--bs-primary-tint-20)', 'var(--bs-primary-tint-40)', 'var(--bs-primary-tint-60)', 'var(--bs-primary-tint-80)'],
                        labels: category,
                        dataLabels: {
                            enabled: false,
                        },
                        legend: {
                            show: true,
                            position: 'bottom',
                            fontSize: '14px',
                            labels: {
                                colors: ['var(--bs-white)', 'var(--bs-white)', 'var(--bs-white)', 'var(--bs-white)', 'var(--bs-white)']
                            },
                        }

                    };

                    var chart = new ApexCharts(document.querySelector("#chart-top-genres"), options);
                    chart.render();
                }
            }
        });
    });

    revanue_chart('Year')

    var chart = null;
    let revenueInstance;

    function revanue_chart(type) {
    var Base_url = "{{ url('/') }}";
    var url = Base_url + "/app/get_revnue_chart_data/" + type;

    $("#revenue_loader").show();

    $.ajax({
        url: url,
        method: "GET",
        data: {},
        success: function(response) {
            $("#revenue_loader").hide();
            $(".total_revenue").text(type);

            if (document.querySelectorAll('#chart-top-revenue').length) {
                const monthlyTotals = response.data.chartData;
                const category = response.data.category;

                const options = {
                    series: [{
                        name: "Total Revenue",
                        data: monthlyTotals
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    colors: ['var(--bs-primary)'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                    },
                    grid: {
                        borderColor: 'var(--bs-border-color)',
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0
                        },
                    },
                    xaxis: {
                        categories: category
                    },
                    yaxis: {
                        decimalsInFloat: 2,
                        labels: {
                            formatter: function (value) {
                                return formatCurrencyvalue(value);
                            }
                        }
                    },
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function(value) {
                                return formatCurrencyvalue(value); // Currency formatting
                            }
                        }
                    },
                };

                if (revenueInstance) {
                    revenueInstance.updateOptions(options);
                } else {
                    revenueInstance = new ApexCharts(document.querySelector("#chart-top-revenue"), options);
                    revenueInstance.render();
                }
            }
        }
    });
}

    $(document).on('click', '.revenue-dropdown-item', function() {
        var type = $(this).data('type');
        revanue_chart(type);
    });


    subscriber_chart('Year')
    let subscriberInstance;

    function subscriber_chart(type) {
        var Base_url = "{{ url('/') }}";
        var url = Base_url + "/app/get_subscriber_chart_data/" + type;

        $("#subscriber_loader").show();

        $.ajax({
            url: url,
            method: "GET",
            data: {},
            success: function(response) {
                $("#subscriber_loader").hide();
                $(".total_subscribers").text(type);
                if (document.querySelectorAll('#chart-new-subscription').length) {
                    const chartData = response.data.chartData;
                    const category = response.data.category;
                    const options = {
                        series: chartData,
                        chart: {
                            type: 'bar',
                            height: 350,
                            stacked: true,
                            toolbar: {
                                show: true
                            },
                            zoom: {
                                enabled: true
                            }
                        },
                        colors: ['var(--bs-primary)', 'var(--bs-primary-tint-20)', 'var(--bs-primary-tint-40)', 'var(--bs-primary-tint-60)'],
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                legend: {
                                    position: 'bottom',
                                    offsetX: -20,
                                    offsetY: 0
                                }
                            }
                        }],
                        grid: {
                            borderColor: 'var(--bs-border-color)',
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '25%',
                                borderRadius: 3,
                                borderRadiusApplication: 'end', // 'around', 'end'
                                borderRadiusWhenStacked: 'last', // 'all', 'last'
                                dataLabels: {
                                    total: {
                                        enabled: true,
                                        style: {
                                            fontSize: '13px',
                                            fontWeight: 900,
                                            color: 'var(--bs-body-color)'
                                        }
                                    }
                                }
                            },
                        },
                        xaxis: {
                            // type: 'datetime',
                            categories: category
                        },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            labels: {
                                colors: 'var(--bs-body-color)',
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            theme: 'dark',
                        },
                    };

                    if (subscriberInstance) {
                        subscriberInstance.updateOptions(options);
                    } else {
                        subscriberInstance = new ApexCharts(document.querySelector("#chart-new-subscription"), options);
                        subscriberInstance.render();
                    }
                }
            }
        })
    };

    $(document).on('click', '.subscribers-dropdown-item', function() {
        var type = $(this).data('type');
        subscriber_chart(type);
    });


    document.addEventListener('DOMContentLoaded', function() {
    var Base_url = "{{ url('/') }}";
    var url = Base_url + "/app/get_toprated_chart_data";

    $.ajax({
        url: url,
        method: "GET",
        data: {},
        success: function(response) {
            console.log('Top Rated Chart Response:', response);
            if (document.querySelectorAll('#chart-top-rated').length) {
                const chartData = response.data.chartData;

                // Prepare series data and labels for radialBar
                const series = chartData.map(item => item.data[0]); // Extract the first value from data array
                const labels = chartData.map(item => item.name); // Extract names

                console.log('Chart Data:', chartData);
                console.log('Series:', series);
                console.log('Labels:', labels);

                const options = {
                    series: series,
                    chart: {
                        height: 430,
                        type: 'radialBar',
                        events: {
                            dataPointSelection: function(event, chartContext, { dataPointIndex }) {
                                // Log the clicked data point
                                console.log('Clicked on segment:', labels[dataPointIndex], 'with value:', series[dataPointIndex]);
                            }
                        }
                    },
                    colors: ['var(--bs-primary)', 'var(--bs-primary-tint-40)'],
                    labels: labels,
                    dataLabels: {
                        enabled: true,
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: "65%"
                            },
                            track: {
                                background: 'var(--bs-body-bg)',
                                strokeWidth: '100%',
                            },
                            dataLabels: {
                                name: {
                                    fontSize: '30px',
                                    color: 'var(--bs-heading-color)',
                                },
                                value: {
                                    fontSize: '16px',
                                    color: 'var(--bs-heading-color)',
                                    formatter: function (val) {
                                        return val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'var(--bs-heading-color)',
                                    fontSize: '22px',
                                    label: 'Total',
                                    formatter: function (w) {
                                        // Calculate total from series values
                                        let total = w.config.series.reduce((a, b) => a + b, 0); // sum up each entry's value
                                        return total;
                                    }
                                }
                            }
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        fontSize: '14px',
                        labels: {
                            colors: ['var(--bs-white)', 'var(--bs-white)']
                        },
                    },
                    responsive: [{
                        breakpoint: 300,
                        options: {
                            chart: {
                                height: 150,
                            },
                        },
                    }]
                };

                // Create the chart instance
                var chart = new ApexCharts(document.querySelector("#chart-top-rated"), options);
                chart.render().then(() => {
                    // Attach click event listener to legend labels
                    const legendItems = document.querySelectorAll('#chart-top-rated .apexcharts-legend-series');

                    legendItems.forEach((item, index) => {
                        item.addEventListener('click', function() {
                            // Use toggleSeries to safely toggle visibility
                            chart.toggleSeries(labels[index]);
                        });
                    });
                });
            }
        }
    });
});




    mostwatch_chart('Year')
    let mostwatchInstance;

    function mostwatch_chart(type) {
        var Base_url = "{{ url('/') }}";
        var url = Base_url + "/app/get_mostwatch_chart_data/" + type;

        $("#mostwatch_loader").show();

        $.ajax({
            url: url,
            method: "GET",
            data: {},
            success: function(response) {
                $("#mostwatch_loader").hide();
                $(".most_watch").text(type);
                if (document.querySelectorAll('#chart-most-watch').length) {
                    const chartData = response.data.chartData;
                    const category = response.data.category;
                    const options = {
                        series: chartData,
                        chart: {
                            type: 'bar',
                            height: 350,
                            stacked: true,
                            toolbar: {
                                show: true
                            },
                            zoom: {
                                enabled: true
                            }
                        },
                        colors: ['var(--bs-primary)', 'var(--bs-primary-tint-20)', 'var(--bs-primary-tint-40)', 'var(--bs-primary-tint-60)'],
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                legend: {
                                    position: 'bottom',
                                    offsetX: -10,
                                    offsetY: 0,

                                }
                            }
                        }],
                        grid: {
                            borderColor: 'var(--bs-border-color)',
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '25%',
                                borderRadius: 3,
                                borderRadiusApplication: 'end', // 'around', 'end'
                                borderRadiusWhenStacked: 'last', // 'all', 'last'
                                dataLabels: {
                                    total: {
                                        enabled: true,
                                        style: {
                                            fontSize: '13px',
                                            fontWeight: 900,
                                            color: 'var(--bs-body-color)'
                                        }
                                    }
                                }
                            },
                        },
                        xaxis: {
                            // type: 'datetime',
                            categories: category
                        },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            labels: {
                                colors: 'var(--bs-body-color)',
                            },
                            markers: {
                                offsetX: -5
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            theme: 'dark',
                        },
                    };

                    if (mostwatchInstance) {
                        mostwatchInstance.updateOptions(options);
                    } else {
                        mostwatchInstance = new ApexCharts(document.querySelector("#chart-most-watch"), options);
                        mostwatchInstance.render();
                    }
                }
            }
        })
    };

    $(document).on('click', '.mostwatch-dropdown-item', function() {
        var type = $(this).data('type');
        mostwatch_chart(type);
    });
</script>

@endpush
<style>
    .star-rating {
    display: flex;
}

.star {
        font-size: 1.2rem;
        color: var(--bs-border-color);
        /* Default color for empty stars */
        margin-right: 2px;
    }

    .star.filled {
        color: var(--bs-warning);
        /* Color for filled stars */
    }
</style>
