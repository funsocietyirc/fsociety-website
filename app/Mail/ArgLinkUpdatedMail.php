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
    public $title;
    public $body;

    public function __construct(ArgTracking $arg, string $title, string $body)
    {
        $this->arg = $arg;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)->view('mail.argLinkUpdated');
    }
}
