<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Reminder extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $request;

    public function __construct($request)
    {
        //
        $this->request = $request;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
    {           
        $subject    = 'Email Verification';
        return $this->view('Emails.verifyEmail')
                    ->subject($subject)
                    ->with([
                        'emailCode' => $this->request
                    ]);
                
    }
}