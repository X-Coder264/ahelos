<?php

namespace Ahelos\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMessageAnswer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The message.
     *
     * @var string
     */
    public $answer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('contact_email_answer');
    }
}
