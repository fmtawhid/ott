<div class="d-flex gap-3 align-items-center">

  <img src="{{ setBaseUrlWithFileName($data->user->file_url) ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-40 rounded-pill">
  <div class="text-start">
    <h6 class="m-0">{{ $data->user->full_name ?? default_user_name() }}</h6>
    <span>{{ $data->user->email ?? '--' }}</span>
  </div>
</div>
