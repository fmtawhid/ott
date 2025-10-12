<?php

namespace Modules\Frontend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        $content = null;
        $type = 'N/A';
        if ($this->type == 'movie') {
            $content = $this->movie;
            $type = 'Movie';
        } elseif ($this->type == 'episode') {
            $content = $this->episode;
            $type = 'Episode';
        } elseif ($this->type == 'video') {
            $content = $this->video;
            $type = 'Video';
        }

        return [
            'date' => $this->created_at->format('Y-m-d H:i:s'),
            'name' => $content ? $content->name : 'N/A',
            'type' => $type,
            'expire_date' => $this->view_expiry_date ? $this->view_expiry_date : 'N/A',
            'amount' => (float)$this->content_price,
            'discount' => (float)$this->discount_percentage ?? 0,
            'total' => (float)$this->price
        ];
    }
}