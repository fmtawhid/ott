<a href="{{ route('livetv-details', ['id' => $resource['id']]) }}">
    <div class="livetv-card position-relative">
        <img src="{{ $resource['poster_image'] }}" alt="{{ $resource['name'] }}" class="livetv-img object-cover img-fluid w-100 rounded">
    
        @if($resource['access'] == 'paid')
            @php
                $current_user_plan = auth()->user() ? auth()->user()->subscriptionPackage : null;
                $current_plan_level = $current_user_plan->level ?? 0;
            @endphp

            @if($resource['plan_level'] > $current_plan_level)
                <button type="button" class="product-premium border-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Premium">
                    <i class="ph ph-crown-simple"></i>
                </button>
            @endif
        @endif

        <span class="live-card-badge">
            <span class="live-badge fw-semibold text-uppercase">{{ __('frontend.live') }}</span>
        </span>
    </div>
</a>
