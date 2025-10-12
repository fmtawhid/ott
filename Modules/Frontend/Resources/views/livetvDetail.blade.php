@extends('frontend::layouts.master')

@section('content')
<div id="thumbnail-section">
    @php
        if($data['stream_type'] == 'Embedded'){
            $videodata = Crypt::encryptString($data['embedded']);
        }else{
            $videodata =($data['server_url']);
        }
    @endphp
    @include('frontend::components.section.thumbnail',  ['data' => $videodata ,'embedded' => $data['embedded'],'type'=>$data['stream_type'],'thumbnail_image'=>$data['poster_image'],'dataAccess'=>$data['access'],'plan_id'=>$data['plan_id'],'content_type' => 'livetv','content_id' => $data['id'], 'content_video_type'=>'video'])
</div>
<div id="detail-section">
    <div class="detail-page-info section-spacing">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="movie-detail-content">
                        <h4>{{ $data['name'] }}</h4>
                        <p class="font-size-14">{!! $data['description'] !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-spacing-bottom">
    <div class="container-fluid">
        @if(!empty($suggestions))
            <h4>{{__('frontend.suggested_channels')}}</h4>
            <div class="row mt-3 gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                @foreach($suggestions as $suggested)
                    <div class="col">
                        <a href="{{ route('livetv-details', ['id' => $suggested['id']]) }}" class="livetv-card d-block position-relative">
                            <img src="{{ $suggested['poster_image'] }}" alt="{{ $suggested['name'] }}" class="livetv-img object-cover img-fluid w-100 rounded">
                            <span class="live-card-badge">
                                <span class="live-badge fw-semibold text-uppercase">{{__('frontend.live')}}</span>
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<div class="modal fade" id="DeviceSupport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
            <div class="modal-body user-login-card m-0 p-4 position-relative">
                <button type="button" class="btn btn-primary custom-close-btn rounded-2" data-bs-dismiss="modal">
                    <i class="ph ph-x text-white fw-bold align-middle"></i>
                </button>

                <div class="modal-body">
                    {{__('frontend.device_not_support')}}
                  </div>

                <div class="d-flex align-items-center justify-content-center">
                    <a href="{{ Auth::check() ? route('subscriptionPlan') : route('login') }}"class="btn btn-primary mt-5" >{{__('frontend.upgrade')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
