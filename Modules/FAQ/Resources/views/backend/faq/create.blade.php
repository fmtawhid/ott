@extends('backend.layouts.app')

@section('content')
<x-back-button-component route="backend.faqs.index" />
{{ html()->form('POST', route('backend.faqs.store'))
        ->attribute('enctype', 'multipart/form-data')
        ->attribute('data-toggle', 'validator')
        ->attribute('id', 'form-submit')  // Add the id attribute here
        ->class('requires-validation')  // Add the requires-validation class
        ->attribute('novalidate', 'novalidate')  // Disable default browser validation
        ->open() }}
@csrf
    <div class="card">
        <div class="card-body">
            <div class="row gy-3">
                <!-- Question Field -->
                <div class="col-md-6">
                    {{ html()->label(__('faq.lbl_question') . ' <span class="text-danger">*</span>', 'question')->class('form-label') }}
                    {{ html()->text('question')
                            ->attribute('value', old('question'))
                            ->placeholder(__('faq.enter_question'))
                            ->class('form-control')
                            ->required() }}
                    @error('question')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="question-error">Question field is required</div>
                </div>

                <!-- Answer Field -->
                <div class="col-md-6">
                    {{ html()->label(__('faq.lbl_answer') . ' <span class="text-danger">*</span>', 'answer')->class('form-label') }}
                    {{ html()->textarea('answer')
                            ->attribute('value', old('answer'))
                            ->placeholder(__('faq.enter_answer'))
                            ->class('form-control')
                            ->required() }}
                    @error('answer')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback" id="answer-error">Answer field is required</div>
                </div>

                <!-- Status Field -->
                <div class="col-md-6">
                    {{ html()->label(__('faq.lbl_status'), 'status')->class('form-label') }}
                    <div class="d-flex align-items-center justify-content-between form-control">
                        {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                        <div class="form-check form-switch">
                            {{ html()->hidden('status', 1) }}
                            {{ html()->checkbox('status', old('status', true))
                                    ->class('form-check-input')
                                    ->id('status') }}
                        </div>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">
        {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right')->id('submit-button') }}
    </div>

{{ html()->form()->close() }}
@endsection

@push('after-scripts')
<script>

tinymce.init({
    selector: '#answer',
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
