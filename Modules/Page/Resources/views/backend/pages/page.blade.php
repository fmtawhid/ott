@extends('backend.layouts.page')


@section('title')
{{ $data->name }}
@endsection


@push('after-styles')
<link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush
@section('content')

<div class="iq-navbar-header navs-bg-color" style="height: 100px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-center align-items-center flex-wrap">
                    <div class="px-4">
                        <h2>{{$data->name}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="iq-header-img">
    </div>
</div>
    <div class="container">

        <div class="card">
            <div class="card-body">

            {!! $data->description !!}

            </div>
        </div>
    </div>

@endsection
