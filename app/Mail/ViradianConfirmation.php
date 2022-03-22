<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViradianConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $fullName;

    public function __construct($fullName)
    {
        //
        $this->fullName = $fullName;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
    {           
        $subject    = 'Application Received';
        return $this->view('Emails.viradianAppReceived')
                    ->subject($subject)
                    ->with([
                        'fullName' => $this->fullName
                    ]);
                
    }
}