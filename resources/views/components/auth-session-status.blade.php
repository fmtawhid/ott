@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert bg-success-subtle']) }}>
        {{ $status }}
    </div>
@endif
