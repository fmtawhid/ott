@extends('installer::backend.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.classic.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-code fa-fw" aria-hidden="true"></i> {{ trans('installer_messages.environment.classic.title') }}
@endsection

@section('container')

    <form method="post" action="{{ route('environmentSaveClassic') }}">
        {!! csrf_field() !!}
        <textarea class="textarea" name="envConfig">{{ $envConfig }}</textarea>
        <div class="buttons buttons--right">
            <button class="button intsaller-btn button--light" id="submit-env" type="submit" onclick="disableButton()">
            	<i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i>
             	{!! trans('installer_messages.environment.classic.save') !!}
            </button>
        </div>
    </form>

    @if( ! isset($environment['errors']))
        <div class="buttons-container">
            <a class="button float-left intsaller-btn" id="environment-wizard" href="{{ route('environmentWizard') }}">
                <i class="fa fa-sliders fa-fw" aria-hidden="true"></i>
                {!! trans('installer_messages.environment.classic.back') !!}
            </a>
            <a class="button float-right intsaller-btn" id="database-btn" href="{{ route('database') }}" onclick="disabledatabseButton()" >
                <i class="fa fa-check fa-fw" aria-hidden="true"></i>
                {!! trans('installer_messages.environment.classic.install') !!}
                <i class="fa fa-angle-double-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    @endif

@endsection


@section('scripts')
    <script type="text/javascript">

        function disableButton() {
            document.getElementById('submit-env').classList.add('disabled');
            document.getElementById('database-btn').classList.add('disabled');
            document.getElementById('environment-wizard').classList.add('disabled');
            document.getElementById('submit-env').innerText = 'Loading...';

      }

    function disabledatabseButton(){

         document.getElementById('submit-env').classList.add('disabled');
         document.getElementById('database-btn').classList.add('disabled');
         document.getElementById('environment-wizard').classList.add('disabled');
         document.getElementById('database-btn').innerText = 'Loading...';

    }
  </script>

@endsection

