@extends('setting::backend.setting.index')

@section('settings-content')

<div class="container">
    <div class="col-md-12 d-flex justify-content-between mb-4">
        <h4><i class="fa fa-language"></i> {{ __('setting_sidebar.lbl_language') }}</h4>

    </div>

    <form id="form-submit" method="POST" class="requires-validation" novalidate>
        @csrf
        <div class="container">
            <div class="row gy-3">
                <div class="col">
                    <label class="form-label">{{ __('setting_language_page.lbl_language') }}<span class="text-danger">*</span></label>
                    <select id="language_id" name="language_id" class="form-control select2" required>
                        <option value="" disabled {{ old('language_id') ? '' : 'selected' }}>{{__('placeholder.lbl_select_language')}}</option>
                        @foreach($languages as $language)
                            <option value="{{ $language['id'] }}" {{ old('language_id','en') == $language['id'] ? 'selected' : '' }}>
                                {{ $language['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="language_id-error">Language field is required</div>
                </div>
                <div class="col">
                    <label class="form-label">{{ __('setting_language_page.lbl_file') }}<span class="text-danger">*</span></label>
                    <select id="file_id" name="file_id" class="form-control select2">
                        <option value="" disabled {{ old('file_id') ? '' : 'selected' }}>{{ __('messages.lbl_select_file') }}</option>
                        <!-- Options will be dynamically loaded here -->
                    </select>
                    <div class="invalid-feedback" id="file_id-error">File field is required</div>
                </div>
            </div>
        </div>


        <div class="container py-3">
            <div class="row">
                <div class="col">
                    <h6>
                        <label class="form-label">{{ __('setting_language_page.lbl_key') }}</label>
                    </h6>
                </div>
                <div class="col">
                    <h6>
                        <label class="form-label">{{ __('setting_language_page.lbl_value') }}</label>
                    </h6>
                </div>
            </div>

        <div class="container py-3" id="translation-keys">



            <!-- Translation keys will be dynamically loaded here -->

        </div>
        </div>

        <div class="text-end">
        <button type="submit" class="btn btn-primary" id="form_btn">{{ __('messages.save') }}</button>
        </div>
    </form>
</div>
@endsection
@push('after-scripts')


<script>
    document.addEventListener('DOMContentLoaded', function() {

        $('.select2').select2();

         $('#language_id').on('change', function() {
             var languageId = $(this).val();
             fetchFiles(languageId);
         });
         $('#file_id').on('change', function() {
        var languageId = document.getElementById('language_id').value;
        var fileId = $(this).val();
        fetchLangData(fileId,languageId);

     });
        const languageId = document.getElementById('language_id').value;
        if (languageId) {
            fetchFiles(languageId).then(() => {
                const fileId = document.getElementById('file_id').value;
                if (fileId) {
                    fetchLangData(fileId, languageId);
                }
            });
        }

        document.getElementById('language_id').addEventListener('change', function() {
            var languageId = this.value;
            fetchFiles(languageId);
        });

        document.getElementById('file_id').addEventListener('change', function() {
            var fileId = this.value;
            var languageId = document.getElementById('language_id').value;
            fetchLangData(fileId, languageId);
        });





        function fetchFiles(languageId) {
            fetch(`{{ route('backend.languages.array_list') }}?language_id=${languageId}`)
                .then(response => response.json())
                .then(data => {
                    let fileSelect = document.getElementById('file_id');
                    fileSelect.innerHTML = '<option value="">{{ __('Select File') }}</option>';
                    data.forEach(file => {
                        let option = document.createElement('option');
                        option.value = file.id;
                        option.textContent = file.name;
                        fileSelect.appendChild(option);
                    });
                    if (data.length > 0) {
                        fileSelect.value = data[0].id;
                        $(fileSelect).trigger('change'); // Trigger the change event to fetch language data
                        var languageId = document.getElementById('language_id').value;
                        var fileId = fileSelect.value;
                        // fetchLangData(fileId,languageId);
                    }
                })
                .catch(error => {
                    console.error('Error fetching files:', error);
                    // Handle error if needed
                });
            }

        function fetchLangData(fileId, languageId) {
            fetch(`{{ route('backend.languages.get_file_data') }}?file_id=${fileId}&language_id=${languageId}`)
                .then(response => response.json())
                .then(data => {
                    let container = document.getElementById('translation-keys');
                    container.innerHTML = '';
                    data.forEach(item => {
                        let row = document.createElement('div');
                        row.className = 'row';

                        let keyCol = document.createElement('div');
                        keyCol.className = 'col';
                        let keyGroup = document.createElement('div');
                        keyGroup.className = 'form-group';
                        let keyInput = document.createElement('input');
                        keyInput.type = 'text';
                        keyInput.className = 'form-control';
                        keyInput.value = item.key;
                        keyInput.disabled = true;
                        keyGroup.appendChild(keyInput);
                        keyCol.appendChild(keyGroup);

                        let valueCol = document.createElement('div');
                        valueCol.className = 'col';
                        let valueGroup = document.createElement('div');
                        valueGroup.className = 'form-group';
                        let valueInput = document.createElement('input');
                        valueInput.type = 'text';
                        valueInput.name = `lang_data[${item.key}]`;
                        valueInput.className = 'form-control';
                        valueInput.value = item.value;
                        valueGroup.appendChild(valueInput);
                        valueCol.appendChild(valueGroup);

                        row.appendChild(keyCol);
                        row.appendChild(valueCol);

                        container.appendChild(row);
                    });
                });
        }
    });



    function submitForm(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get language_id and file_id
    let languageId = document.getElementById('language_id').value;
    let fileId = document.getElementById('file_id').value;

    // Clear previous error messages
    document.getElementById('language_id').classList.remove('is-invalid');
    document.getElementById('file_id').classList.remove('is-invalid');
    document.getElementById('language_id-error').style.display = 'none';
    document.getElementById('file_id-error').style.display = 'none';

    let hasError = false;

    // Validate language_id
    if (!languageId) {
        document.getElementById('language_id').classList.add('is-invalid');
        document.getElementById('language_id-error').style.display = 'block';
        hasError = true;
    }

    // Validate file_id
    if (!fileId) {
        document.getElementById('file_id').classList.add('is-invalid');
        document.getElementById('file_id-error').style.display = 'block';
        hasError = true;
    }

    if (hasError) {
        return; // Stop form submission if validation fails
    }

    // Initialize an array to hold the formatted data
    let formattedData = [];

    // Get all input fields inside #translation-keys
    let dataInputs = document.querySelectorAll('#translation-keys input[type="text"]');

    // Iterate over each input field
    dataInputs.forEach(input => {
        // Extract key and value from input name and value
        let key = input.name.replace('lang_data[', '').replace(']', '');
        let value = input.value;
        // Skip if key or value is empty
        if (!key || !value) {
            return;
        }

        // Construct the data object with key, value, languageId, and fileId
        let dataObj = {
            key: key,
            value: value,
            language: languageId,
            file: fileId
        };

        // Push the data object to formattedData array
        formattedData.push(dataObj);
    });

    // Prepare the payload as JSON
    const payload = JSON.stringify({
        language_id: languageId,
        file_id: fileId,
        data: formattedData
    });

    // Send the FormData via fetch
    fetch('{{ route('backend.languages.store') }}', {
        method: 'POST',
        body: payload,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json' // Set content type to JSON
        }
    })
    .then(response => response.json())
    .then(data => {
        window.successSnackbar('Setting save successfully!');
    })
    .catch(error => {
        window.errorSnackbar('Something went wrong, please check');
    });
}

$("#form_btn").click(function(e) {

    e.preventDefault();
    submitForm(e);
});


    $("#form_btn").click(function(e){

        e.preventDefault();
        submitForm(e)
    });
</script>

@endpush

