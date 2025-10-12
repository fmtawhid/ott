<div class="d-flex gap-3 align-items-center">
    @php

        $decodedData = is_string($data->data) ? json_decode($data->data, true) : $data->data;
        
        // Safely access data with optional handling
        $notificationGroup = $decodedData['subject'] ?? '-';
        $subject = $decodedData['subject'] ?? '';

        $notification = \Modules\NotificationTemplate\Models\NotificationTemplateContentMapping::where('subject', $subject)->first();
        $notificationMessage = $notification->notification_message ?? 'Message not found';
    @endphp

    <div class="text-start">
        <h6 class="m-0">{{ $notificationGroup }}</h6>
        <span>{{ $notificationMessage }}</span>
    </div>
</div>

