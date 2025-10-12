<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiringSubscriptionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function build()
    {
        return $this->subject('Expiring Subscription Email')
                    ->view('emails.expiring_subscription');
    }


}
