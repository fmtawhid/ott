@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection



@section('content')
<x-back-button-component route="backend.notification-templates.index" />
<div class="card">
    <div class="card-body">
        {{-- <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
        </x-backend.section-header> --}}

        {{-- <hr> --}}

        <div class="row mt-4">
            <div class="col">
                {{ html()->form('PUT' ,route('backend.notification-templates.update', $data->id))
                ->attribute('enctype', 'multipart/form-data')
                ->attribute('data-toggle', 'validator')
                ->attribute('id', 'form-submit')  // Add the id attribute here
                ->class('requires-validation')  // Add the requires-validation class
                ->attribute('novalidate', 'novalidate')  // Disable default browser validation
                ->open()
            }}

                    @include('notificationtemplate::backend.notificationtemplates.form')
                    {{ html()->form()->close() }}
              </div>
        </div>
      </div>

              <div class="card-footer">
                  <div class="row">
                      <div class="col">

                      </div>
                  </div>
              </div>
          </div>
      @endsection

      @push('after-scripts')
          <script>
              tinymce.init({
                  selector: '#mytextarea',
                  plugins: 'link image code',
                  toolbar: 'undo redo | styleselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | removeformat | code | image',
              });
              $(document).on('click', '.variable_button', function() {
                  const textarea = $(document).find('.tab-pane.active');
                  const textareaID = textarea.find('textarea').attr('id');
                  tinyMCE.activeEditor.selection.setContent($(this).attr('data-value'));
              });
          </script>
      @endpush
