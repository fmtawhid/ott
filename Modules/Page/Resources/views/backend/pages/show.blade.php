@extends('frontend::layouts.master')
@section('content')
<div class="page-title">
        <h4 class="m-0 text-center">{{$page->name}}</h4>
</div>

<div class="section-spacing-bottom">

    <div class="container">
        @if(empty($page->description))
        <div class="text-center">
            <img src="{{ asset('img/NoData.png') }}" alt="No Data" class="img-fluid">
            <p>No data found</p>
        </div>
    @else
        <p>{!! $page->description !!}</p>
    @endif
    </div>
</div>

@endsection
