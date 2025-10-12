@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.episodes.index" />
<div class="card">
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-4">

                <div class="poster">
                    <img src="{{ $data->poster_url ?  $data->poster_url : setDefaultImage($data['poster_url'])}}" alt="{{ $data->name }}" class="img-fluid w-100">
                </div>
            </div>
            <div class="col-md-8">
                <div class="details">
                    <h1 class="mb-2">{{ $data->name ?? '-' }}</h1>
                    <p class="mb-3">{!! $data->description ?? '-'!!}</p>
                    <div class="d-flex flex-wrap align-items-center gap-3 gap-xl-5">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="m-0">{{__('movie.lbl_release_date')}} :</h6> {{ \Carbon\Carbon::parse($data->release_date)->format('d M, Y') ?? '-'}}
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="m-0">{{__('movie.lbl_duration')}} :</h6> {{ formatDuration($data->duration) ?? '-'}}
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="m-0"ng>{{__('movie.lbl_trailer_url')}} :</h6> <a href="{{ $data->trailer_url }}" target="_blank"><u>{{ $data->trailer_url ?? '-'}}</u></a>
                        </div>
                    </div>
                    <hr class="my-5">
                    <div class="movie-info">
                        <h5>{{__('messages.lbl_episode_info')}}</h5>
                        <div class="d-flex flex-wrap align-items-center gap-3 gap-xl-5">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0">{{__('movie.lbl_genres')}} :</h6>
                                @php
                                    $genremapping = optional($data->entertainmentdata)->entertainmentGenerMappings
                                @endphp
                                @foreach ($genremapping as $mapping)
                                    {{ optional($mapping->genre)->name ?? '-'}}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0">{{__('messages.lbl_languages')}} :</h6>
                                {{ ucfirst(optional($data->entertainmentdata)->language) ?? '-'}}
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">
                    <div class="rating">
                        <h5>{{__('dashboard.rating')}}</h5>
                        <div class="d-flex flex-wrap align-items-center gap-3 gap-xl-5">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0">{{__('movie.lbl_imdb_rating')}} :</h6>
                                {{ $data->IMDb_rating ?? '-'}}
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0">{{__('messages.lbl_content_rating')}} :</h6>
                                {{ $data->content_rating ?? '-'}}
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
</div>


@endsection
<style>
    .star-rating {
    display: flex;
}

.star {
        font-size: 1.2rem;
        color: var(--bs-border-color);
        /* Default color for empty stars */
        margin-right: 2px;
}

.star.filled {
    color: var(--bs-warning);
    /* Color for filled stars */
}
</style>
