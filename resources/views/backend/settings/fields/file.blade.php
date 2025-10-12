@php
$required = (Str::contains($field['rules'], 'required')) ? "required" : "";
$required_mark = ($required != "") ? '<span class="text-danger"> <strong>*</strong> </span>' : '';
@endphp

<div class="form-group mb-3 col-md-6 {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label for="{{ $field['name'] }}" class='form-label'> <strong>{{ $field['label'] }}</strong> ({{ $field['name'] }})</label> {!! $required_mark !!}
    <div class="row">
        <div class="col-lg-8 order-1">
            <input type="{{ $field['type'] }}"
                name="{{ $field['name'] }}"
                value="{{ old($field['name'], setting($field['name'])) }}"
                class="form-control {{ Arr::get( $field, 'class') }} {{ $errors->has($field['name']) ? ' is-invalid' : '' }}"
                id="{{ $field['name'] }}"
                placeholder="{{ $field['label'] }}" {{ $required }}>

            @if ($errors->has($field['name'])) <small class="invalid-feedback">{{ $errors->first($field['name']) }}</small> @endif
        </div>
        <div class="col-lg-4 order-0">
            <div class="card text-center inline-block">
                <div class="card-body {{isset($field['imageClass']) ? $field['imageClass'] : ''}}">
                    <img class="img-fluid" src="{{asset(setting($field['name']) )}}" alt="{{$field['name']}}">
                </div>
            </div>
        </div>
    </div>
</div>
