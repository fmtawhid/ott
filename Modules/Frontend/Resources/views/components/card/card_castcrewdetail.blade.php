
<div class="actor-detail-card d-flex align-items-center flex-md-row flex-column justify-center gap-md-5 gap-4 rounded-3">
    <img src="{{ $data['profile_image'] }}" class="img-fluid actor-img rounde-3 object-cover rounded" alt="Actor Images">
    <div>
        <p class="actor-description readmore-wrapper">
            <span class="readmore-text line-count-3">{!! $data['bio'] !!}</span>
            <span class="readmore-btn badge bg-dark cursor-pointer">{{__('frontend.read_more')}}</span>
        </p>
        <div class="d-flex flex-wrap align-items-center justify-contnet-center gap-md-5 gap-3 actor-desc">
            <div class="d-inline-flex align-items-center gap-3">
                <i class="ph ph-user"></i>
                <p class="mb-0 fw-medium">{{ $data['type'] }}</p>
            </div>
            <div class="d-inline-flex align-items-center gap-3">
                <i class="ph ph-cake"></i>
                <p class="mb-0 fw-medium">{{  $data['dob'] ? formatDate($data['dob']) : '-' }}</p>
            </div>
            <div class="d-inline-flex align-items-center gap-3">
                <i class="ph ph-map-pin-area"></i>
                <p class="mb-0 fw-medium">{{  $data['place_of_birth'] ? $data['place_of_birth'] : '-'  }}</p>
            </div>
        </div>
    </div>
</div>

