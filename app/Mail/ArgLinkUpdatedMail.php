<?php

namespace Fsociety\Mail;

use Fsociety\Models\ArgTracking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArgLinkUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $arg;

    public function __construct(ArgTracking $arg)
    {
        $this->arg = $arg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A ARG Link has been updated')->view('mail.argLinkUpdated');
    }
}
