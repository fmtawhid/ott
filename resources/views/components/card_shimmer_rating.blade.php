<div class="review-card">
    <div class="review-detail rounded p-3">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 ">
        <div class="d-flex align-items-center justify-content-center gap-3">
          <img  class="img-fluid user-img rounded-circle placeholder">
          <div>
            <h6 class="placeholder-glow">
              <span class="placeholder col-6"></span>
            </h6>
            <p class="mb-0 placeholder-glow">
              <span class="placeholder col-4"></span>
            </p>
          </div>
        </div>
        <div class="d-flex align-items-center gap-1">
          @for ($i = 0; $i < 5; $i++)
            <i class="ph-fill ph-star text-warning placeholder"></i>
          @endfor
        </div>
      </div>
      <p class="mb-0 mt-4 fw-medium placeholder-glow">
        <span class="placeholder col-8"></span>
      </p>
    </div>
  </div>
