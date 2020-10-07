<?php

namespace App\Mail;

use App\Models\ContactQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WebContactMail extends Mailable
{
    use Queueable, SerializesModels;


    protected $contact_query;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactQuery $contact_query)
    {
        $this->contact_query = $contact_query;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.web-contact');
    }
}
