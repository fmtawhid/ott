@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div class="header-title">
            <h4 class="mb-0">{{ __('settings.change_layout_order') }}</h4>
        </div>

        @if(session('success'))
            <div class="snackbar" id="snackbar">
                <div class="d-flex justify-content-around align-items-center">
                    <p class="mb-0">{{ session('success') }}</p>
                    <a href="#" class="dismiss-link text-decoration-none text-success" onclick="dismissSnackbar(event)">Dismiss</a>
                </div>
            </div>
        @endif
    </div>

    <div id="sortable" class="mb-5">
        @foreach($data as $mobile_setting)
            <div class="d-flex align-items-center gap-4 mobile-setting-row mt-5" data-id="{{ $mobile_setting->id }}" data-position="{{ $mobile_setting->position }}">

                    <div class="flex-grow-1">

                    <div class="card mb-0">
                        <div class="card-body py-2 px-3">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <h5 class="m-0">{{ $mobile_setting->name }}:</h5>
                                @if($mobile_setting->slug == 'banner' || $mobile_setting->slug == 'continue-watching' || $mobile_setting->slug == 'advertisement' || $mobile_setting->slug == 'rate-our-app')
                                    <div class="form-check form-switch">
                                        {{ html()->hidden('value', 0) }}
                                        {{
                                            html()->checkbox('value', old('value', $mobile_setting->value))
                                                    ->class('form-check-input status-switch')
                                                    ->id('value')
                                                    ->value(1)
                                                    ->data('id', $mobile_setting->id)
                                                    ->data('name', $mobile_setting->name)
                                                    ->data('position', $mobile_setting->position)
                                        }}
                                    </div>
                                @endif
                                @if($mobile_setting->slug !== 'banner' && $mobile_setting->slug !== 'continue-watching' && $mobile_setting->slug !== 'advertisement' && $mobile_setting->slug !== 'rate-our-app')
                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                        @hasPermission('edit_dashboard_setting')
                                        <button class="btn btn-warning-subtle btn-sm fs-4 edit-button" data-id="{{ $mobile_setting->id }}">
                                            <i class="ph ph-pencil-simple-line align-middle"></i>
                                        </button>
                                        @endhasPermission

                                        <button class="collapsed btn btn-success-subtle btn-sm fs-4 accordion-btn" data-id="{{ $mobile_setting->id }}" data-bs-toggle="collapse" data-bs-target="#accordian_btn_{{ $mobile_setting->id }}" aria-expanded="false" aria-controls="accordian_btn_{{ $mobile_setting->id }}">
                                            <i class="ph ph-plus align-middle"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div id="accordian_btn_{{ $mobile_setting->id }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            {{ html()->form('POST' ,route('backend.mobile-setting.store'))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')->open() }}
                            @csrf
                            {{ html()->hidden('id')->value($mobile_setting->id) }}
                            {{ html()->hidden('name')->value($mobile_setting->name) }}
                            {{ html()->hidden('position')->value($mobile_setting->position) }}

                            <div class="mb-3">
                                {{ html()->label(__('movie.lbl_select'). ' ' . $mobile_setting->name .':'. '<span class="text-danger">*</span>', 'dashboard_select')->class('form-label') }}
                                {{ html()->select('dashboard_select[]', old('dashboard_select'))->class('form-control select2')->id('dashboard_select_'.$mobile_setting->id)->multiple() }}
                                @error('dashboard_select')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-end">
                                {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right') }}
                            </div>

                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


<div class="modal fade @if ($errors->any()) show @endif" id="addModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('settings.mobile_setting') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{ route('backend.mobile-setting.addNewRequest') }}" method="POST"  data-toggle="validator">
                @csrf
                    {{ html()->hidden('id')->id('mobileSettingId')->value(isset($mobileSetting) ? $mobileSetting->id : '') }}

                    <div class="mb-3">
                        {{ html()->label(__('settings.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-control-label') }}
                        {{ html()->text('name')->attribute('value', old('name'))->placeholder(__('placeholder.lbl_mobile_setting_name'))->class('form-control') }}
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                          {{ html()->label(__('movie.type') . '<span class="text-danger">*</span>', 'type')->class('form-label') }}
                           {{ html()->select('type', $typeValue->pluck('name', 'slug')->prepend(__('placeholder.lbl_select_type'), ''))->class('form-control select2')->id('type') }}
                           @error('type')
                               <span class="text-danger">{{ $message }}</span>
                           @enderror
                    </div>
                    <div class="col-md-12" id="type_value">
                        {{ html()->label(__('movie.lbl_value'), 'optionvalue')->class('form-label') }}
                        {{ html()->select('optionvalue[]')->class('form-control select2')->id('optionvalue')->multiple() }}
                        @error('optionvalue')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mt-5">
                            <a href="{{ route('backend.mobile-setting.index') }}" class="btn btn-dark">Close</a>
                            {{ html()->submit(trans('messages.save'))->class('btn btn-md btn-primary float-right') }}
                        </div>
                    </div>

               </form>
            </div>

        </div>
    </div>
</div>



@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
<style>
    .select2-container {
    z-index: 2050; /* Adjust this value if needed to ensure it stays above the modal's background */
}
</style>
@endpush

@push('after-scripts')
<!-- DataTables Core and Extensions -->
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<script src="{{ asset('js/form/index.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addModalElement = document.getElementById('addModal');
        const addModalInstance = new bootstrap.Modal(addModalElement, {});

        @if($errors->any())
            addModalInstance.show();
            addModalElement.addEventListener('hide.bs.modal', function (event) {
                event.preventDefault();
            });
        @endif

        addModalElement.addEventListener('hidden.bs.modal', function () {
            addModalElement.querySelectorAll('input:not([name="_token"])').forEach(input => input.value = '');
            addModalElement.querySelectorAll('textarea').forEach(textarea => textarea.value = '');
        });
    });

    function showMessage(message) {
        Snackbar.show({
            text: message,
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        $('.edit-button').on('click', function() {
            var id = $(this).data('id');
            var editUrl = '{{ route('backend.mobile-setting.edit', ':id') }}';
            editUrl = editUrl.replace(':id', id);

            $.ajax({
                url: editUrl,
                method: 'GET',
                success: function(data) {
                    $('#mobileSettingId').val(data.id);
                    $('input[name="name"]').val(data.name);
                    $('input[name="position"]').val(data.position);
                    $('#type').val(data.slug).trigger('change');
                   // Clear existing options in 'optionvalue'
                   $('#optionvalue').html('').trigger('change');

                   if (data.value) {
                // Set the selected options based on the array of IDs
                var selectedValues = JSON.parse(data.value); // Convert the JSON string to an array

                // Use AJAX to get the options based on the type
                $.ajax({
                    url: '{{ route('backend.mobile-setting.get-type-value', ':slug') }}'.replace(':slug', data.slug),
                    method: 'GET',
                    success: function(response) {
                        var options = '<option value="">Select an option</option>'; // Add a default empty option
                        $.each(response, function(index, item) {
                            options += '<option value="' + item.id + '">' + item.name + '</option>';
                        });
                        $('#optionvalue').html(options);

                        // Set the selected values
                        $('#optionvalue').val(selectedValues).trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                    }
                });
            }

                    $('#addModal').modal('show');
                }
            });
        });

        $('.delete-button').on('click', function() {
            var id = $(this).data('id');
            var deleteUrl = '{{ route('backend.mobile-setting.destroy', ':id') }}';
            deleteUrl = deleteUrl.replace(':id', id);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Done',
                                text: data.message,
                                icon: 'success',
                                iconColor: '#5F60B9'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                    });
                }
            });
        });

        $('.accordion-btn').on('click', function() {
            var mobileSettingId = $(this).data('id');
            var dropdown = $('#dashboard_select_' + mobileSettingId);

            $.ajax({
                url: '{{ route('backend.mobile-setting.get-dropdown-value', ':id') }}'.replace(':id', mobileSettingId),
                method: 'GET',
                success: function(data) {
                    dropdown.empty();

                    if (data.selected) {
                        $.each(data.selected, function(key, value) {
                            dropdown.append($('<option>', {
                                value: value.id,
                                text: value.name,
                                selected: true
                            }));
                        });
                    }

                    if (data.available) {
                        $.each(data.available, function(key, value) {
                            if (!data.selected || !data.selected.some(selectedItem => selectedItem.id === value.id)) {
                                dropdown.append($('<option>', {
                                    value: value.id,
                                    text: value.name
                                }));
                            }
                        });
                    }

                    dropdown.trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch dropdown values:', error);
                }
            });
        });

        $('.status-switch').on('change', function() {
            var value = $(this).is(':checked') ? 1 : 0;
            var id = $(this).data('id');
            var name = $(this).data('name');
            var position = $(this).data('position');

            $.ajax({
                url: '{{ route('backend.mobile-setting.store') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    name: name,
                    position: position,
                    value: value
                },
                success: function(response) {
                    showMessage(response.message);
                },
                error: function(xhr, status, error) {
                    console.error('Failed to update status:', error);
                }
            });
        });
    });


    document.addEventListener('DOMContentLoaded', (event) => {
        let draggedElement = null;

        document.querySelectorAll('.drag-button').forEach(button => {
            button.addEventListener('mousedown', (e) => {
                const row = document.querySelector(`[data-id="${button.dataset.id}"]`);
            if (row.dataset.slug === 'banner' || row.dataset.slug === 'continue-watching') {
                return;
            }

                row.setAttribute('draggable', 'true');

                row.addEventListener('dragstart', (e) => {
                    draggedElement = row;
                    e.dataTransfer.effectAllowed = 'move';
                    row.classList.add('dragging');
                });

                row.addEventListener('dragend', (e) => {
                    row.classList.remove('dragging');
                    row.removeAttribute('draggable');
                    updatePositions();
                    // showMessage('Position changed successfully');
                }, { once: true });

                row.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';

                const rows = [...document.querySelectorAll('.mobile-setting-row:not(.dragging)')];
                let afterElement = getDragAfterElement(rows, e.clientY);

                const parent = document.getElementById('sortable');
                if (afterElement === null) {
                    // Append to the end if no after element
                    parent.appendChild(draggedElement);
                } else {
                    parent.insertBefore(draggedElement, afterElement);
                }
            });

                row.addEventListener('drop', (e) => {
                    showMessage('Position changed successfully');
                    e.stopPropagation();
                    e.preventDefault();
                });
            });
        });
        function getDragAfterElement(rows, y) {
        let closest = null;
        let closestOffset = Number.NEGATIVE_INFINITY;

        rows.forEach(row => {
            const box = row.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;

            if (offset < 0 && offset > closestOffset) {
                closestOffset = offset;
                closest = row;
            }
        });

        return closest;
    }
        function updatePositions() {
            const rows = document.querySelectorAll('.mobile-setting-row');
            let sortedIDs = [];

            rows.forEach((row, index) => {
                row.setAttribute('data-position', index + 1);
                sortedIDs.push(row.getAttribute('data-id'));

                const positionNumberElement = row.querySelector('.position-number');
                if (positionNumberElement) {
                    positionNumberElement.textContent = `{{ __('settings.lbl_position_number') }}: ${index + 1}`;
                }
            });

            $.ajax({
                url: '{{ route('backend.mobile-setting.update-position') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    sortedIDs: sortedIDs
                },
                success: function(response) {
                    console.log('Positions updated successfully.');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to update positions:', error);
                }
            });
        }
    });

    $('#type').on('change', function() {
        var selectedValue = $(this).val();
        toggleTypeValue();

        if (!selectedValue) {
            $('#tvshow_id_error').text('Type is required.');
            return;
        }

        if (selectedValue !== 'advertisement' || selectedValue !== 'rate-our-app') {

            $.ajax({
                url: '{{ route('backend.mobile-setting.get-type-value', ':slug') }}'.replace(':slug', selectedValue),
                method: 'GET',

                success: function(response) {

                    var options = '';
                    $.each(response, function(index, item) {
                        options += '<option value="' + item.id + '">' + item.name + '</option>';
                    });
                    $('#optionvalue').html(options).trigger('change');
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        }
    });

    function toggleTypeValue() {
                var selectedValue = $('#type').val();
                if (selectedValue === 'advertisement' || selectedValue === 'rate-our-app') {
                    $('#type_value').hide();
                } else {
                    $('#type_value').show();
                }
            }

            toggleTypeValue();


</script>
@endpush
