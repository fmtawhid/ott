@extends('frontend::layouts.master')

@section('content')
<div class="faq-block section-spacing-bottom">
    <div class="page-title">
        <h4 class="m-0 text-center">{{__('frontend.faq')}}</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-1 d-lg-block d-none"></div>
            <div class="col-lg-10">
                @if($content->isEmpty())
                    <div class="text-center">
                        <img src="{{ asset('img/NoData.png') }}" alt="No Data" class="img-fluid">
                        <p>No data found</p>
                    </div>
                @else
                    <div class="accordion" id="faq">
                        @foreach($content as $key => $value)
                            <div class="accordion-item custom-accordion rounded">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button custom-accordion-button gap-3 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_{{ $value->id }}" aria-expanded="true" aria-controls="collapseOne">
                                        {{ $value->question }}
                                    </button>
                                </h2>
                                <div id="collapseOne_{{ $value->id }}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faq">
                                    <div class="accordion-body custom-accordion-body p-0">
                                        <span> {!! $value->answer !!}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-lg-1 d-lg-block d-none"></div>
        </div>
    </div>
</div>
@endsection
