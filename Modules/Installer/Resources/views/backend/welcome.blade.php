@extends('installer::backend.layouts.master')

@section('template_title')
    {{ trans('installer_messages.welcome.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer_messages.welcome.title') }}
@endsection

@section('container')
    <p class="text-center">
      {{ trans('installer_messages.welcome.message') }}
    </p>
    <p class="text-center">
      <a href="{{ route('requirements') }}" class="button intsaller-btn"  id="submit-data" onclick="disableButton()">
        {{ trans('installer_messages.welcome.next') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
      </a>
    </p>
@endsection

@section('scripts')
    <script type="text/javascript">

        function disableButton() {
            document.getElementById('submit-data').classList.add('disabled');
            document.getElementById('submit-data').innerText = 'Loading...';
    }
    </script>
@endsection
