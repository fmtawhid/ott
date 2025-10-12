@extends('backend.layouts.app')

@section('title', __($module_title))

@push('after-styles')
<link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush

@section('content')
<div class="card-main mb-5">
    <div class="row">
        <div class="col">

            <table id="datatable" class="table dataTable table-responsive notification-table">
                <thead>
                    <tr>
                        <th>
                            {{ __('notification.lbl_id') }}
                        </th>
                        <th>
                            {{ __('notification.type') }}
                        </th>
                        <th>
                            {{ __('notification.lbl_text') }}
                        </th>
                        <th>
                            {{ __('notification.lbl_customer') }}
                        </th>
                        <th>
                            {{ __('notification.lbl_update') }}
                        </th>
                        <th>
                            {{ __('notification.lbl_action') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($$module_name as $module_name_singular)
                    <?php
                    $row_class = '';
                    $span_class = '';
                    if ($module_name_singular->read_at == '') {
                        $row_class = 'table-info';
                        $span_class = 'font-weight-bold';
                    }
                    ?>

                    <input type="hidden" id="idData" value="{{$module_name_singular->id}}">

                    <tr class="{{$row_class}}">
                        @if($module_name_singular->data['data']['notification_type']=='new_subscription')
                            <td>
                                <span class="{{$span_class}}">{{ ucfirst($module_name_singular->data['data']['id']) }}</span>
                            </td>

                            <td>
                                <span class="{{$span_class}}">{{ ucfirst($module_name_singular->data['data']['notification_group']) }}</span>
                            </td>
                            @php
                                $notification = \Modules\NotificationTemplate\Models\NotificationTemplateContentMapping::where('subject', $module_name_singular->data['subject'])->first();
                            @endphp
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="text-start">
                                        <a href="#"><h6>{{ $module_name_singular->data['subject'] }}</h6></a>
                                        <span class="font-weight-bold">{{ $notification->notification_message }}</span>
                                    </div>
                                </div>
                            </td>

                            @php
                                $user = \App\Models\User::find($module_name_singular->data['data']['user_id']);
                            @endphp

                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <img src="{{ setBaseUrlWithFileName($user->file_url) ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-40 rounded-pill">
                                    <div class="text-start">
                                        <h6 class="m-0">{{ $user->full_name ?? default_user_name() }}</h6>
                                        <span>{{ $user->email ?? '--' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $module_name_singular->updated_at->diffForHumans() }}
                            </td>

                            <td>
                                <a onclick="remove_notification()" id="delete-{{$module_name}}-{{$module_name_singular->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash"></i></a>
                            </td>

                            @else
                            <td> </td>
                            <td>
                                <span class="{{$span_class}}">{{ucwords(str_replace('_', ' ', $module_name_singular->data['data']['notification_group'])) }}</span>
                            </td>

                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="text-start">
                                        <a href="#"><h6>{{ $module_name_singular->data['subject'] }}</h6></a>
                                        <span class="font-weight-bold"> Your  {{$module_name_singular->data['data']['service_name']}} account balance is insufficient. Please recharge your account to maintain service availability.</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex gap-3 align-items-center">

                                    <div class="text-start">
                                        <h6 class="m-0">{{ $module_name_singular->data['data']['user_name']  }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $module_name_singular->updated_at->diffForHumans() }}
                            </td>

                            <td>
                                <a onclick="remove_notification()" id="delete-{{$module_name}}-{{$module_name_singular->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="ph ph-trash"></i></a>
                            </td>

                        @endif
                        </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">{{ __('No data found') }}</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <!-- <div class="float-left">
                    {{ __('Total') }} {{ $$module_name->total() }} {{ __($module_name) }}
                </div> -->
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $$module_name->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>


<script>
    function remove_notification() {

        var id = document.getElementById('idData').value;
        var url = "{{ route('notification.remove', ['id' => ':id']) }}";
        url = url.replace(':id', id);

        var message = 'Are you certain you want to delete it?';
        confirmSwal(message).then((result) => {
            if (!result.isConfirmed) return
            $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Deleted',
                        text: response.message,
                        icon: 'success'
                    })
                    window.location.reload();
                    successSnackbar(response.message);
                },
                error: function(response) {
                    alert('error');
                }
            });
        })


    }
</script>

@endpush
@endsection
