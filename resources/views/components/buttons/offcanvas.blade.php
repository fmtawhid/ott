@props(["href"=>"", "target" => "", "icon"=>"ph ph-plus-circle", "title", "small"=>"", "class"=>""])


@if($href)
<a href='{{$href}}'
    class='btn btn-primary d-flex align-items-center gap-1 {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-bs-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</a>
@else
<button type="button"
    class='btn btn-primary d-flex align-items-center gap-1 {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-crud-id="0"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</button>
@endif
