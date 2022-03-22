<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;

class SmsTwilioController extends Controller
{
    public function sendSms($countryCode, $numberToSendMessageTo, $textMessageToSend)
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $appSid     = config('app.twilio')['TWILIO_APP_SID'];
        $client     = new Client($accountSid, $authToken);
        $data['message']    = "Message not sent. No parameter, Try again";
        $data['status']     = 0; //Input Error
        if(($numberToSendMessageTo != null) and ($textMessageToSend != null))
        {
            try
            {
                // Use the client to do fun stuff like send text messages!
                $client->messages->create(
                    // the number you'd like to send the message to
                    //substr(ltrim($countryCode, '+'), 0, 3)
                        '+' . (ltrim($countryCode, '+'), 0, 3) . $numberToSendMessageTo,
                    array(
                         // A Twilio phone number you purchased at twilio.com/console
                         'from' => '+17204393482',
                         // the body of the text message you'd like to send
                         'body' => $textMessageToSend;
                        )
                );
                $data['message'] = "Message sent successfully";
                $data['status']  = 200; //successful
            }
            catch (Exception $e)
            {
                //echo "Error: " . $e->getMessage();
                $data['message'] = "Error: " . $e->getMessage();
                $data['status']  = 500; //internal error
            }
        }
        return $data;
    }

}//end class