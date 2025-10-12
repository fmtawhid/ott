@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection


@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i> {{ $module_title }} {{ __($module_action) }}
                <x-slot name="subtitle">
                    @lang(':module_name Subscriptions Details ', ['module_name' => Str::title($module_name)])
                </x-slot>
            </x-backend.section-header>
        </div>
    </div>
    <div class="card">
       <div class="col-md-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                  <div class="card-header">
                        <h3 class="card-title">
                            Current Plan
                        </h3>
                    </div>
                 </div>
                <div class="iq-card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1 d-flex justify-content-between">

                            @if(count($subscription)!=0)
                               <div class="card-header">
                                    <h2>Free <span class="h6">(0 USD / Life Time)
                                            </span></h2>
                                    <a href="#" class="feature-link">View Features</a>
                                </div>

                                @else

                                <div class="card-header">
                                   <h4>No Subscription Plan has been selected !</h4>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('modules/subscriptions/script.js') }}"></script>


@endpush
