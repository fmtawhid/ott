@extends('backend.layouts.app')

@section('title') {{ __('profile.title') }} @endsection

@section('content')
<div id="profile-app"></div>
@endsection

@push('after-styles')
  <style>
    .modal-backdrop {
      --bs-backdrop-zindex: 1030;
    }
  </style>
@endpush
@push('after-scripts')
<script src="{{ asset('js/profile-vue.min.js')}}"></script>
@endpush
