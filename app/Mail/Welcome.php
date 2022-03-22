<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $service;

    public function __construct($name, $service)
    {
        //
        $this->name     = $name;
        $this->service  = $service;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
    {           
        $subject    = 'Registration Complete';
        return $this->view('Emails.welcome')
                    ->subject($subject)
                    ->with([
                        'name' => $this->name,
                        'service' => $this->service
                    ]);
                
    }
}