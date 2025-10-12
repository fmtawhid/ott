<form action="{{$url ?? ''}}" id="quick-action-form" class="form-disabled d-flex gap-3 align-items-stretch flex-wrap">
  @csrf
  {{$slot}}
  <input type="hidden" name="message_change-featured" value="{{ __('messages.message_change-featured') }}">
  <input type="hidden" name="message_change-status" value="{{ __('messages.message_change-status') }}">
  <input type="hidden" name="message_delete" value="{{ __('messages.message_delete') }}">
  <input type="hidden" name="message_restore" value="{{ __('messages.message_restore') }}">
  <input type="hidden" name="message_permanently-delete" value="{{ __('messages.message_permanently-delete') }}">
  <button class="btn btn-primary" id="quick-action-apply">{{ __('messages.apply') }}</button>
</form>
