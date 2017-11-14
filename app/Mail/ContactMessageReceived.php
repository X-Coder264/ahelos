<?php

namespace Ahelos\Mail;

use Ahelos\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user-message instance.
     *
     * @var ContactMessage
     */
    public $contact_message;

    /**
     * Create a new message instance.
     * @param  \Ahelos\ContactMessage  $contact_message
     * @return void
     */
    public function __construct(ContactMessage $contact_message)
    {
        $this->contact_message = $contact_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nova kontakt poruka')
                    ->view('contact_email');
    }
}
