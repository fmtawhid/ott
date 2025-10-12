<div class="review-card">
    <div class="review-detail rounded">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 ">
        <div class="d-flex align-items-center justify-content-center gap-3">
          @if($data['profile_image'])

         <img src="{{setBaseUrlWithFileName($data['profile_image'])}}  " alt="user" class="img-fluid user-img rounded-circle">

         @else

         <img src="{{setBaseUrlWithFileName($data->user['file_url'] ?? null)}}" alt="user" class="img-fluid user-img rounded-circle">

         @endif
          <div>
            @if(!empty($data->user['first_name']))
            <h6 class="line-count-1 font-size-18">{{($data->user['first_name'] . ' ' . $data->user['last_name'])}}</h6>
            @else
            <h6 class="line-count-1 font-size-18">Zatra TV User</h6>

            @endif
            <p class="mb-0 font-size-14-0">   {{ $data['created_at'] ? formatDate(\Carbon\Carbon::parse($data['created_at'])->format('Y-m-d'))  : '-' }}  </p>
          </div>
        </div>
        <div class="d-flex align-items-center gap-1">
         @for ($i = 0; $i < $data['rating']; $i++)
          <i class="ph-fill ph-star text-warning"></i>
         @endfor
        </div>
      </div>
      <p class="mb-0 mt-4 fw-medium">{{$data['review']}}</p>
    </div>
</div>
