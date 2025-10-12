<div class="d-flex gap-3 align-items-center">
  <img src="{{ setBaseUrlWithFileName(optional($review->user)->file_url) ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-40 rounded-pill">
  <div class="text-start">
      <h6 class="m-0">{{ optional($review->user)->full_name ?? default_user_name() }}</h6>
      <small>{{ optional($review->user)->email ?? '--' }}</small>
  </div>
</div>
