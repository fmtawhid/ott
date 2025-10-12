@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('content')
    <div class="card-main mb-5">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">
                    <x-backend.quick-action url="{{ route('backend.entertainments.bulk_action') }}">
                        <div class="">
                            <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                style="width:100%">
                                <option value="">{{ __('messages.no_action') }}</option>

                                <option value="change-status">{{ __('messages.lbl_status') }}</option>
                                @hasPermission('delete_movies')
                                <option value="delete">{{ __('messages.delete') }}</option>
                                @endhasPermission
                                @hasPermission('restore_movies')
                                <option value="restore">{{ __('messages.restore') }}</option>
                                @endhasPermission
                                @hasPermission('force_delete_movies')
                                <option value="permanently-delete">{{ __('messages.permanent_dlt') }}</option>
                                @endhasPermission
                            </select>
                        </div>
                        <div class="select-status d-none quick-action-field" id="change-status-action">
                            <select name="status" class="form-control select2" id="status" style="width:100%">
                                <option value="1" selected>{{ __('messages.active') }}</option>
                                <option value="0">{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </x-backend.quick-action>



                      <!--<button type="button" class="btn btn-dark" data-modal="export">-->
                      <!--  <i class="ph ph-export align-middle"></i> {{ __('messages.export') }}-->
                      <!--</button>-->
                </div>

                <x-slot name="toolbar">

                    <div>
                        <div class="datatable-filter">
                            <select name="column_status" id="column_status" class="select2 form-control"
                                data-filter="select" style="width: 100%">
                                <option value="">{{__('messages.all')}}</option>
                                <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                    {{ __('messages.inactive') }}</option>
                                <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                    {{ __('messages.active') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text pe-0" id="addon-wrapping"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                       <input type="text" id="movie_name" class="form-control dt-search" placeholder="{{ __('placeholder.lbl_search') }}" aria-label="Search" aria-describedby="addon-wrapping">

                    </div>
                    <button class="btn btn-dark d-flex align-items-center gap-1 btn-group" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i class="ph ph-funnel"></i>{{__('messages.advance_filter')}}</button>
                    @hasPermission('add_movies')
                     <a href="{{ route('backend.movies.create') }}" class="btn btn-primary d-flex align-items-center gap-1" id="add-post-button"> <i class="ph ph-plus-circle"></i> {{__('messages.new')}}</a>
                     @endhasPermission
                </x-slot>
            </x-backend.section-header>
            <table id="datatable" class="table table-responsive">
            </table>
    </div>
    <x-backend.advance-filter>
        <x-slot name="title">
            <h4 class="mb-0">{{ __('messages.advance_filter') }}</h4>
        </x-slot>

            <div class="form-group">

                <div class="form-group datatable-filter">
                  <input type="hidden" class="form-control" name ="type" id="type" value="moive"></input>
                </div>

              <div class="form-group datatable-filter">
                <label class="form-label" for="gener">{{__('movie.lbl_genres')}}</label>
                <select name="gener" id="gener" class="form-control select2" data-filter="select">
                    <option value="">{{ __('messages.all') }} </option>
                    @foreach ($geners as $gener)
                        <option value="{{ $gener->id }}">{{ $gener->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group datatable-filter">
                <label class="form-label" for="language">{{__('movie.lbl_movie_language')}}</label>
                <select name="language" id="language" class="form-control select2" data-filter="select">
                    <option value="">{{ __('messages.all') }} </option>
                    @foreach ($movie_language as $language)
                        <option value="{{ $language->value }}">{{ $language->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group datatable-filter">
                {{ html()->label(__('movie.lbl_movie_access') , 'movie_access')->class('form-label') }}
                <div class="d-flex align-items-center">
                    <label class="form-check form-check-inline form-control ps-5 cursor-pointer">
                        <input class="form-check-input" type="radio" name="movie_access" id="paid" value="paid"
                            onchange="showPlanSelection(this.value === 'paid')"
                            {{ old('movie_access') == 'paid' ? 'checked' : '' }} >
                        <label class="form-check-label" for="paid">{{__('movie.lbl_paid')}}</label>
                    </label>
                    <label class="form-check form-check-inline form-control ps-5 cursor-pointer">
                        <input class="form-check-input" type="radio" name="movie_access" id="free" value="free"
                            onchange="showPlanSelection(this.value === 'paid')"
                            {{ old('movie_access') == 'free' ? 'checked' : '' }}>
                        <label class="form-check-label" for="free">{{__('movie.lbl_free')}}</label>
                    </label>
                </div>

                @error('movie_access')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
          </div>

          <div class="form-group datatable-filter d-none" id="planSelection">
            <div  class="form-group datatable-filter">
                <label class="form-label" for="plan_id">{{__('movie.lbl_select_plan')}}</label>
                <select name="plan_id" id="plan_id" class="form-control select2" data-filter="select">
                    <option value="">{{ __('movie.all') }} {{__('movie.lbl_select_plan')}}</option>
                    @foreach ($plan as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>

            </div>


          </div>

        <div class="text-end">
        <button type="reset" class="btn btn-dark" id="reset-filter">{{__('messages.reset')}}</button>
        </div>

    </x-backend.advance-filter>
    @if(session('success'))
        <div class="snackbar" id="snackbar">
            <div class="d-flex justify-content-around align-items-center">
                <p class="mb-0">{{ session('success') }}</p>
                <a href="#" class="dismiss-link text-decoration-none text-success" onclick="dismissSnackbar(event)">{{__('messages.dismiss')}}</a>
            </div>
        </div>
    @endif
@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush
    @push('after-scripts')
    <!-- DataTables Core and Extensions -->
     <script src="{{ asset('js/form-modal/index.js') }}" defer></script>
     <script src="{{ asset('js/form/index.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" defer>
        const columns = [
            {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="entertainment" onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            { data: 'thumbnail_url',
              name: 'thumbnail_url',
              title: "{{ __('movie.movie') }}",
              orderable: false,
              searchable: true,
             },
             {
                data: 'like_count',
                name: 'like_count',
                title: "{{ __('movie.likes') }}",

            },
            {
                data: 'watch_count', // New column for TV Category
                name: 'watch_count', // Corresponding name on the server-side
                title: "{{ __('movie.watch') }}", // Add localization key for TV Category

            },
           {
            data: 'movie_access',
             name: 'movie_access',
             title: "{{ __('movie.access') }}",
             render: function (data, type, row) {
                 let capitalizedData = data.charAt(0).toUpperCase() + data.slice(1);
                 let className = data == 'free' ? 'badge bg-info-subtle p-2' : 'badge bg-success-subtle p-2';
                 return '<span class="' + className + '">' + capitalizedData + '</span>';
             }
           },
            {
                data: 'plan_id',
                name: 'plan_id',
                title: "{{ __('movie.plan') }}",

            },
            {
               data: 'language',
               name: 'language',
               title: "{{ __('movie.language') }}",
               render: function (data, type, row) {
                   return data.charAt(0).toUpperCase() + data.slice(1);
               }
           },

            {
                data: 'status',
                name: 'status',
                title: "{{ __('messages.lbl_status') }}",
                width: '5%',
            },

            {
                data: 'is_restricted',
                name: 'is_restricted',
                title: "{{ __('movie.lbl_restricted_content') }}",
                width: '5%',
            },
            {
              data: 'updated_at',
              name: 'updated_at',
              title: "{{ __('messages.updated_at') }}",
              orderable: true,
             visible: false,
           },

        ]


        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('messages.action') }}",
            width: '5%'
        }]

        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {

            selectedaccess=null;

            $('input[name="movie_access"]').change(function() {
               selectedaccess = $(this).val();

               window.renderedDataTable.ajax.reload(null, false);
           });

           $('#movie_name').on('input', function() {
    window.renderedDataTable.ajax.reload(null, false);
});
           $('#gener').on('select', function() {
               window.renderedDataTable.ajax.reload(null, false);
           });

           $('#language').on('select', function() {
               window.renderedDataTable.ajax.reload(null, false);
            });

           $('#plan_id').on('select', function() {

               window.renderedDataTable.ajax.reload(null, false);
           });

            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [[ 9, "desc" ]],
                advanceFilter: () => {
    return {
        type: $('#type').val(),
        movie_name: $('#movie_name').val(),
        language: $('#language').val(),
        gener: $('#gener').val(),
        movie_access: selectedaccess,
        plan_id: $('#plan_id').val(),
    }
}
            });
        })

        $('#reset-filter').on('click', function(e) {
            $('#moive_name').val(''),
            $('#language').val(''),
            $('#gener').val(''),
            $('#movie_access').val(''),
            $('#plan_id').val(''),

            $('input[name="movie_access"]').prop('checked', false);
            selectedaccess = null;
            window.renderedDataTable.ajax.reload(null, false)
        })
        function resetQuickAction () {
        const actionValue = $('#quick-action-type').val();
        if (actionValue != '') {
            $('#quick-action-apply').removeAttr('disabled');

            if (actionValue == 'change-status') {
                $('.quick-action-field').addClass('d-none');
                $('#change-status-action').removeClass('d-none');
            } else {
                $('.quick-action-field').addClass('d-none');
            }
        } else {
            $('#quick-action-apply').attr('disabled', true);
            $('.quick-action-field').addClass('d-none');
        }
      }

      $('#quick-action-type').change(function () {
        resetQuickAction()
      });

      $(document).on('update_quick_action', function() {
        // resetActionButtons()
      })

        function showPlanSelection(isPaid) {
        const planSelectionDiv = document.getElementById('planSelection');
        const planIdSelect = document.getElementById('plan_id');

        if (isPaid) {
            planSelectionDiv.classList.remove('d-none');
        } else {
            planSelectionDiv.classList.add('d-none');
            planIdSelect.value = '';
        }
    }
        document.addEventListener('DOMContentLoaded', function() {
            var movieAccessPaid = document.getElementById('paid');
            if (movieAccessPaid.checked) {
                showPlanSelection(true);
            }
        });

</script>
@endpush
