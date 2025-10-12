<div class="d-flex gap-3 align-items-center">
  <img src="{{  setBaseUrlWithFileName($data->file_url) }}" alt="avatar" class="avatar avatar-40 rounded-pill">
  <div class="text-start">
    <h6 class="m-0">{{ $data->full_name ?? default_user_name() }}</h6>
    <span>{{ $data->email ?? '--' }}</span>
  </div>
</div>
