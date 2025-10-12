<?php

namespace Modules\Frontend\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserCreated
{
    use SerializesModels;
    public $user;


    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
