@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection



@section('content')

<x-back-button-component route="backend.notification-templates.index" />

    <div class="card">
        <div class="card-body">

            <div class="row mt-4">
                <div class="col">
                    {{ html()->form('POST', route("backend.notification-templates.store"))->acceptsFiles()->class('form')
                        ->attribute('data-toggle', 'validator')
                        ->attribute('id', 'form-submit')  // Add the id attribute here
                        ->class('requires-validation')  // Add the requires-validation class
                        ->attribute('novalidate', 'novalidate')  // Disable default browser validation
                        ->open() }}
                    @include ('notificationtemplate::backend.notificationtemplates.form')
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
