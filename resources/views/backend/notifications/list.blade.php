<div class="card-header border-bottom p-3">
    <h5 class="mb-0">{{ __('messages.all_notifications') }} ({{ $all_unread_count }})</h5>
</div>

<div class="card-body overflow-auto card-header-border p-0 card-body-list max-17 scroll-thin">
    <div class="dropdown-menu-1 overflow-y-auto list-style-1 mb-0 notification-height">
        @if(isset($notifications) && count($notifications) > 0)

        @foreach($notifications->sortByDesc('created_at')->take(5) as $notification)
            @php
                $timezone = App\Models\Setting::where('name', 'default_time_zone')->value('val') ?? 'UTC';
                $notification->created_at = $notification->created_at->setTimezone($timezone);
                $notification->updated_at = $notification->updated_at->setTimezone($timezone);
                $notification_type = ucwords(str_replace('_', ' ', $notification->data['data']['notification_type'])) . '!';
            @endphp

            @if($notification->data['data']['notification_group']=='subscription')
                <div class="dropdown-item-1 float-none p-3 list-unstyled iq-sub-card  {{ $notification->read_at ? '':'notify-list-bg'}} ">
                    <a href="{{ route('backend.subscriptions.index', ['id' => $notification->data['data']['id'] , 'notification_id' => $notification->id]) }}" class="">
                        <div class="d-flex justify-content-between">
                            <h6>{{ $notification_type }}</h6>
                            <h6>#{{ $notification->data['data']['id']}}</h6>
                        </div>
                        <div class="list-item d-flex">
                            <div class="me-3 mt-1">
                                <button type="button" class="btn btn-primary-subtle btn-icon rounded-pill">
                                    {{ strtoupper(substr($notification->data['data']['username'], 0, 1)) }}
                                </button>
                            </div>
                            <div class="list-style-detail">
                                @if($notification->data['data']['notification_type']=='new_subscription')
                                    <p class="heading-color text-start mb-1">New subscription purchase by <span class="body-color">{{ ($notification->data['data']['username']) }}</span></p>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-body">{{ $notification->created_at->format('d/m/Y') }}</small>
                                        <small class="text-body">{{ $notification->created_at->format('h:i A') }}</small>
                                    </div>
                                @endif
                                @if($notification->data['data']['notification_type']=='cancle_subscription')
                                    <p class="heading-color text-start mb-1">Subscription cancle by <span class="body-color">{{ ($notification->data['data']['username']) }}</span></p>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-body">{{ $notification->created_at->format('d/m/Y') }}</small>
                                        <small class="text-body">{{ $notification->created_at->format('h:i A') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endif

        @endforeach
        @else
        <li class="list-unstyled dropdown-item-1 float-none p-3">
            <div class="list-item d-flex justify-content-center align-items-center">
                <div class="list-style-detail ml-2 mr-2">
                    <h6 class="font-weight-bold">{{ __('messages.no_notification') }}</h6>
                    <p class="mb-0"></p>
                </div>
            </div>
        </li>
        @endif
    </div>
</div>
<div class="card-footer py-2 border-top">
    <div class="d-flex align-items-center gap-3 justify-content-end">
        @if($all_unread_count > 0 )
        <a href="{{ route('backend.notifications.markAllAsRead') }}" data-type="markas_read" class="text-primary mb-0 notifyList pull-right"><span>{{__('messages.mark_all_as_read') }}</span></a>
        @endif
        @if(isset($notifications) && count($notifications) > 0)
        <a href="{{ route('backend.notifications.index') }}" class="btn btn-sm btn-primary">{{ __('messages.view_all') }}</a>
        @endif
    </div>
</div>
{{-- @if(isset($notifications) && count($notifications) > 0)
<div class="card-footer text-muted p-3 text-center ">
    <a href="{{ route('backend.notifications.index') }}" class="mb-0 btn-link btn-link-hover font-weight-bold view-all-btn">{{ __('messages.view_all') }}</a>
</div>
@endif --}}
