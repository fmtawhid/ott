@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection



@section('content')
<meta name="setting_local" content="none">
<input type="hidden" name="admin-profile" value="{{asset('img/avatar/avatar.webp')}}">
<input type="hidden" name="logo" value="{{asset('img/logo/logo.png')}}">
<input type="hidden" name="mini-logo" value="{{asset('img/logo/mini_logo.png')}}">
<input type="hidden" name="dark-logo" value="{{asset('img/logo/dark_logo.png')}}">
<input type="hidden" name="dark-mini-logo" value="{{asset('img/logo/dark_mini_logo.png')}}">
<input type="hidden" name="favicon" value="{{asset('img/logo/favicon.png')}}">

<div id="setting-app"></div>
{{-- <div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
            </x-slot>
        </x-backend.section-header>

        <hr>

        <div class="row mt-4">
            <div class="col">
                <form method="post" action="{{ route('backend.settings.store') }}" enctype="multipart/form-data" class="form-horizontal" role="form">
                    {!! csrf_field() !!}

                    @if(count(config('setting_fields', [])) )

                        @foreach(config('setting_fields') as $section => $fields)
                        <div class="card card-accent-primary mb-4">
                            <div class="card-header">
                                <i class="{{ Arr::get($fields, 'icon', 'glyphicon glyphicon-flash') }}"></i>
                                {{ $fields['title'] }}
                            </div>
                            <div class="card-body">
                                <p class="text-muted">{{ $fields['desc'] }}</p>

                                <div class="row mb-3">
                                    <div class="col row">
                                        @foreach($fields['elements'] as $field)
                                            @includeIf('backend.settings.fields.' . $field['type'] )
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    @endif

                    <div class="row m-b-md">
                        <div class="col-md-12">
                            <button class="btn-primary btn">
                                <i class='fas fa-save'></i> @lang('Save')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">

        </div>
    </div>
</div> --}}
@endsection

@push('after-styles')
  <style>
    .modal-backdrop {
      --bs-backdrop-zindex: 1030;
    }
  </style>
@endpush
@push('after-scripts')
<script src="{{ asset('js/setting-vue.min.js')}}"></script>
@endpush
