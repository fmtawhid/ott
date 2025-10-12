@extends('backend.layouts.app', ['isBanner' => false])

@section('title')
    {{ 'Genres' }}
@endsection

@section('content')
    <h3 class="mb-3">Genre List</h3>
    <div class="container mb-5">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto d-flex">
                <select class="form-control form-control-sm mr-2">
                    <option disabled selected>No Action</option>
                    <option>Option 1</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                </select>
                <button class="btn btn-primary ml-2" style="margin-left: 10px">Button</button>
            </div>
            <div class="col-auto d-flex">
                <input type="text" class="form-control form-control-sm mr-2" placeholder="Search">

                <a href="{{ route('backend.'. $module_name . '.create') }}" class="btn btn-primary"
                    id="add-post-button"> Add Genres</a>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($genres as $gener)
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-start align-items-center">

                            <div>
                                <h6 class="mb-2">{{$gener->name}}</h6>
                                <div class="form-check form-switch">

                                <input type="checkbox" class="form-check-input" role="switch"
                                  id="flexSwitchCheckChecked" value="{{ $gener->status }}"
                                  @if($gener->status == 1) checked @endif>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach

        </div>


    </div>
@endsection

@push('after-styles')
@endpush
