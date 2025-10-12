@extends('frontend::layouts.master')

@section('content')

<div class="list-page">
    <div class="page-title">
        <h4 class="m-0 text-center">{{__('frontend.tv_channels')}}</h4>
    </div>

    <div class="section-spacing-bottom">
        <div class="container-fluid">
            <div class="row mt-3 gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                @foreach($data as $tvchannels)
                    <div class="col">
                        <a href="{{ route('livetv-details', ['id' => $tvchannels['id']]) }}" class="livetv-card d-block position-relative">
                            <img src="{{ $tvchannels['poster_image'] }}" alt="{{ $tvchannels['name'] }}" class="livetv-img object-cover img-fluid w-100 rounded">
                            <span class="live-card-badge">
                                <span class="live-badge fw-semibold text-uppercase">{{__('frontend.live')}}</span>
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
   
</div>
 
@endsection
