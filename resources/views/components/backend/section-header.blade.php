@props(["toolbar"=>"", "subtitle"=>""])

<div class="d-flex justify-content-between flex-column flex-sm-row gap-3">
    <div>
      {{ $slot }}
    </div>
    @if($toolbar != "")
    <div class="btn-toolbar gap-3 align-items-center justify-content-end" role="toolbar" aria-label="Toolbar with buttons">
        {{ $toolbar }}
    </div>
    @endif
</div>
