@extends('frontend::layouts.master')
@section('content')
<div class="page-title">
        <h4 class="m-0 text-center">{{__('frontend.privacy_policy')}}</h4>
</div>

<div class="section-spacing-bottom">
    <div class="container">
        @if(empty($content))
            <div class="text-center">
                <img src="{{ asset('img/NoData.png') }}" alt="No Data" class="img-fluid">
                <p>No data found</p>
            </div>
        @else
            <p>{!! $content !!}</p>
        @endif

    </div>
</div>
@endsection
