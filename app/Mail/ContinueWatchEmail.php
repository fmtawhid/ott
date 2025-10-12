<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContinueWatchEmail extends Mailable
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
        return $this->subject('Continue Watch Email')
                    ->view('emails.continue_watch');
    }


}
