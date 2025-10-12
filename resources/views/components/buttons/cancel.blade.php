@props(["small"=>""])
<button onclick="window.history.back();" class="btn btn-warning ms-1 {{($small=='true')? 'btn-sm' : ''}}" data-bs-toggle="tooltip" title="{{__('messages.cancel')}}"><i class="fas fa-reply"></i>&nbsp;{{ $slot }}</button>
