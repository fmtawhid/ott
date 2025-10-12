@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('content')
    <div class="card-main mb-5">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">
                    <x-backend.quick-action url="{{ route('backend.' . $module_name . '.bulk_action') }}">
                        <div class="">
                            <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                style="width:100%">
                                <option value="">{{ __('messages.no_action') }}</option>
                                <option value="change-status">{{ __('messages.lbl_status') }}</option>
                                @hasPermission('delete_episodes')
                                <option value="delete">{{ __('messages.delete') }}</option>
                                @endhasPermission
                                @hasPermission('restore_episodes')
                                <option value="restore">{{ __('messages.restore') }}</option>
                                @endhasPermission
                                @hasPermission('force_delete_episodes')
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
                        <input type="text" class="form-control dt-search" placeholder="{{__('placeholder.lbl_search')}}" aria-label="Search"
                            aria-describedby="addon-wrapping">
                    </div>
                    <button class="btn btn-dark d-flex align-items-center gap-1 btn-group" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i class="ph ph-funnel"></i>{{__('messages.advance_filter')}}</button>
                        @hasPermission('add_'.$module_name)
                            <a href="{{ route('backend.' . $module_name . '.create') }}" class="btn btn-primary d-flex align-items-center gap-1" id="add-post-button"> <i class="ph ph-plus-circle"></i>{{__('messages.new')}}</a>
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
                    <label class="form-label" for="entertainment_id">{{__('movie.lbl_tv_show')}}</label>
                    <select name="entertainment_id" id="entertainment_id" class="form-control select2" data-filter="select">
                        <option value="">{{ __('messages.all') }} {{__('movie.lbl_tv_show')}}</option>
                        @foreach ($tvshows as $tvshow)
                            <option value="{{ $tvshow->id }}">{{ $tvshow->name }}</option>
                        @endforeach
                    </select>
                </div>

            <div class="form-group datatable-filter">
                {{ html()->label(__('episode.lbl_season'), 'season_id')->class('form-label') }}
                {{ html()->select(
                        'season_id',
                        $seasons->pluck('name', 'id')->prepend(__('placeholder.lbl_select_season'),''),old('season_id'))->class('form-control select2')->id('season_id') }}
                @error('season_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group datatable-filter">
                {{ html()->label(__('episode.access') , 'access')->class('form-label') }}
                <div class="d-flex align-items-center">
                    <label class="form-check form-check-inline form-control ps-5 cursor-pointer">
                        <input class="form-check-input" type="radio" name="access" id="paid" value="paid"
                            onchange="showPlanSelection(this.value === 'paid')"
                            {{ old('access') == 'paid' ? 'checked' : '' }} >
                        <label class="form-check-label" for="paid">{{__('episode.lbl_paid')}}</label>
                    </label>
                    <label class="form-check form-check-inline form-control ps-5 cursor-pointer">
                        <input class="form-check-input" type="radio" name="access" id="free" value="free"
                            onchange="showPlanSelection(this.value === 'paid')"
                            {{ old('access') == 'free' ? 'checked' : '' }}>
                        <label class="form-check-label" for="free">{{__('episode.lbl_free')}}</label>
                    </label>
                </div>

                @error('access')
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
                <a href="#" class="dismiss-link text-decoration-none text-success" onclick="dismissSnackbar(event)">Dismiss</a>
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
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="episode" onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            { data: 'poster_url',
              name: 'poster_url',
              title: "{{ __('episode.singular_title') }}",
              orderable: false,
              searchable: false,
            },
            { data: 'name',
              name: 'name',
              title: "{{ __('messages.name') }}",
              visible: false },

            {
                data: 'entertainment_id',
                name: 'entertainment_id',
                title: "{{ __('season.lbl_tv_shows') }}"
            },

            {
                data: 'access',
                name: 'access',
                title: "{{ __('episode.access') }}",
                render: function (data, type, row) {
                    const formattedData = data.charAt(0).toUpperCase() + data.slice(1);
                    let className = data == 'free' ? 'badge bg-info-subtle p-2' : 'badge bg-success-subtle p-2';
                    return '<span class="' + className + '">' + formattedData + '</span>';
                }

            },
            {
                data: 'plan_id',
                name: 'plan_id',
                title: "{{ __('episode.plan') }}"

            },
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true,
                title: "{{ __('messages.lbl_status') }}"
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
              title: "{{ __('messages.update_at') }}",
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

            var selectedaccess=null;

            $('input[name="access"]').change(function() {
               selectedaccess = $(this).val();

               window.renderedDataTable.ajax.reload(null, false);
           });

            $('#entertainment_id').on('input', function() {
               window.renderedDataTable.ajax.reload(null, false);
            });

            $('#season_id').on('input', function() {
               window.renderedDataTable.ajax.reload(null, false);
            });

            $('#plan_id').on('select', function() {

               window.renderedDataTable.ajax.reload(null, false);
           });

            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [[ 8, "desc" ]],
                advanceFilter: () => {
                    return {
                        entertainment_id: $('#entertainment_id').val(),
                        season_id: $('#season_id').val(),
                        access: selectedaccess,
                        plan_id: $('#plan_id').val(),
                    }
                }
            });
        })

        $('#reset-filter').on('click', function(e) {
            $('#entertainment_id').val(''),
            $('#access').val(''),
            $('#plan_id').val(''),

            $('input[name="access"]').prop('checked', false);
            selectedaccess = null;

            $('#season_id').select2({
            width: '100%',
            placeholder: "{{ trans('messages.select_name', ['select' => trans('messages.season')]) }}",
            allowClear: true  // Allow clearing selection
        }).val(null).trigger('change');

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

      function getSeasons(entertainmentId) {
        var getSeasonsListUrl = "{{ route('backend.seasons.index_list', ['entertainment_id' => '']) }}" + entertainmentId;
        getSeasonsListUrl = getSeasonsListUrl.replace('amp;', '');

        $.ajax({
            url: getSeasonsListUrl,
            success: function(result) {
                var formattedResult = result.map(function(season) {
                    return { id: season.id, text: season.name };
                });

                // Populate the season dropdown with fetched data
                $('#season_id').select2({
                    width: '100%',
                    placeholder: "{{ trans('messages.select_name', ['select' => trans('messages.season')]) }}",
                    data: formattedResult,
                    allowClear: true  // Allow clearing selection
                }).val(null).trigger('change'); // Clear any selected value
            }
        });
    }

    // Event handler for changing entertainment_id
    $('#entertainment_id').change(function() {
        var entertainmentId = $(this).val();

        // Clear and reset the season dropdown
        $('#season_id').empty().select2({
            width: '100%',
            placeholder: "{{ trans('messages.select_name', ['select' => trans('messages.season')]) }}",
            allowClear: true  // Allow clearing selection
        }).val(null).trigger('change'); // Clear any selected value

        if (entertainmentId) {
            getSeasons(entertainmentId);
        }
    });

    function showPlanSelection(show) {
            var planSelection = document.getElementById('planSelection');
            if (show) {
                planSelection.classList.remove('d-none');
            } else {
                planSelection.classList.add('d-none');
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
