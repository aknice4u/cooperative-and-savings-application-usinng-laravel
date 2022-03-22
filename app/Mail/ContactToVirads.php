<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactToVirads extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $getName;
    public $getEmail;
    public $getMessage;

    public function __construct($getName, $getEmail, $getMessage)
    {
        //
        $this->getName    = $getName;
        $this->getEmail   = $getEmail;
        $this->getMessage = $getMessage;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
    {           
        $subject     = $this->getName . ' Contacted Us';
        return $this->view('Emails.sendContactToVirads')
                    ->subject($subject)
                    ->with([
                        'fullName'  => $this->getName,
                        'email'     => $this->getEmail,
                        'message'   => $this->getMessage
                    ]);
                
    }
}