<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Response;  
use DB;
use App\Http\Requests\ReCaptchataTestFormRequest;
use Mail;
use Session;
use App\Mail\Reminder;
use App\Mail\Welcome;


class AdvertiserController extends BaseController
{
    
    public function createEmail()
    {
        return view('Advertiser.createEmail');
    }

    //create email using JSON from HOME PAGE //ReCaptchataTestFormRequest
    public function createEmail_JSON(ReCaptchataTestFormRequest $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:advertisers,email',
        ]);
        $getEmail = trim($request['email']);
    
        //generate email code
        //$confirmation_code = str_random(30);
        $desired_length = 99999; 
        $unique = uniqid();
        $time = time();
        $emailCode =  substr($unique, 0, $desired_length).$time;

        //Send Verification Email
        $name                     = 'virads.com.ng';
        Mail::to($getEmail, $name)->send(new Reminder($emailCode));

        $lastID = DB::table('advertisers')->insertGetId(array( 
            'email'                 => strtolower($getEmail), 
            'emailcode'             => $emailCode,
            'verifyemail'           => 0,
            'created_at'            => date('Y-m-d'),
            'updated_at'            => date('Y-m-d')           
        ));
        if($lastID){
             return redirect('/advertiser/create/email')->with('msg', 'A verification link had been sent to your inbox, kindly click on the verification link to complete your service request form. Thank you.');
              //return redirect('/advertiser/create');
        }else{
             return redirect('/advertiser/create/email')->with('err', 'Please enter a valid email address and/or prove you are not a robot');
        }

    }


    //get request from mail box
    public function verify($emailCode = null)
    {
        if($emailCode == "")
        {
             return redirect('/advertiser/create/email')->with('err', 'Email not verified ! Incorrect verification code');
        }
        if(!(DB::table('advertisers')->where('emailcode', $emailCode)->first()))
        {
             return redirect('/advertiser/create/email')->with('err', 'Email not verified ! Incorrect verification code');
        }
        if((DB::table('advertisers')->where('emailcode', $emailCode)->where('verifyemail', 1)->where('companyname', '<>', null)->where('serviceNeeded', '<>', null)->first()))
        {
             return redirect('/advertiser/create/email')->with('mgs', 'Email already verified and your application is submited..');
        }
        if((DB::table('advertisers')->where('emailcode', $emailCode)
            ->where('verifyemail', 1)->where('companyname', null)->where('serviceNeeded', null)->first()))
        {
             return view('Emails.emailVerified')->with('mgs', 'Email already verified! Thank you.');
        }
        Session::put('emailCode', $emailCode);
        DB::table('advertisers')->where('emailCode', $emailCode)->update(array( 
            'verifyemail'           => 1, 
            'updated_at'            => date('Y-m-d')           
        )); 
        return view('Emails.emailVerified');
    }


    //load advertiser completion-form
    public function create()
    {
        if((Session::get('emailCode')) == "")
        {
             return redirect('/advertiser/create/email')->with('err', 'You are redirected here because you cannot access that page');
        }
        return view('Advertiser.create');
    }



    public function welcome()
    {

        return view('Emails.welcome');

    }



    public function store(ReCaptchataTestFormRequest $request)
    {
        $emailCode = Session::get('emailCode');
        //Validate
        $this->validate($request, [
            'companyOrAgencyName'   => 'required|string',
            'BrandOrProductName'    => 'required|string',
            'serviceNeeded'         => 'required|regex:/^[a-zA-Z0-9,.!?\)\( ]*$/',
            'contactName'           => 'regex:/^[a-zA-Z0-9,.!?\)\( ]*$/',
            'phoneNumber'           => 'required|numeric',
            'contactAddress'        => 'string',
            //'aboutCompany'            => 'string',
        ]);
        //get all requests
        $companyOrAgencyName        = ucfirst(trim($request['companyOrAgencyName'])); 
        $BrandOrProductName         = ucfirst(trim($request['BrandOrProductName'])); 
        $serviceNeeded              = ucfirst(strtolower(trim($request['serviceNeeded']))); 
        $contactName                = ucfirst(trim($request['contactName'])); 
        $phoneNumber                = trim($request['phoneNumber']); 
        $contactAddress             = ucfirst(trim($request['contactAddress'])); 
        $aboutCompany               = trim($request['aboutCompany']); 
        $date                       = date('Y-m-d');
        //update database
        $lastID = DB::table('advertisers')->where('emailCode', $emailCode)->update(array( 
            'companyname'           => $companyOrAgencyName, 
            'brandname'             => $BrandOrProductName,
            'serviceneeded'         => $serviceNeeded,
            'contactname'           => $contactName,
            'phoneno'               => $phoneNumber,
            'contactaddress'        => $contactAddress,
            'aboutcompany'          => $aboutCompany,
            'updated_at'            => $date           
        )); 
        if($lastID)
        {
            $getDetails = DB::table('advertisers')->where('emailcode', $emailCode)->first();
            $advertiserName          = $getDetails->companyname;
            $advertiserServiceNeeded = $getDetails->serviceneeded;
            $advertiserEmail         = $getDetails->email;
            
            //Send registration complete Email
            $name                     = 'virads.com.ng';
            Mail::to($advertiserEmail, $name)->send(new Welcome($advertiserName, $advertiserServiceNeeded));

            $this->addLog('New Advertiser was added database with ID: '.$lastID);
            return redirect('/advertiser/success/congrats')->with('msg', 'Your service request was successfully submitted. '); 
        }else{
            return back()->with('err', 'Something went wrong while submitting your service request. Please try again. (or your request has been taken)'); 
        } 
    }
        

    public function congratulation()
    {
        return view('Advertiser.congratulation');
    }

}
