<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use Entrust;
use Session;
use Excel;
use Input;
use DB;
use QrCode;
use Intervention\Image\ImageManager;
use Hash;


class PaymentTransactionController extends Controller
{
	  public function paymenttransaction(Request $request)
	  {
	  	$data['success'] = "";
	  	$data['error'] = "";
	  	$data['oldsel'] = "";
	  	$data['saving'] = "";
	  	$data['loan'] = "";
	  	$data['interest'] = "";
	  	$data['description'] = "";
	  	$data['date'] = "";
	  	if($request['reg']){
	  		$data['oldsel'] = $request->get('reg');
	  		$data['saving'] = $request->get('contribution');
		  	$data['loan'] = $request->get('loan');
		  	$data['interest'] = $request->get('interest');
		  	$data['description'] = $request->get('description');
		  	$data['date'] = $request->get('date');
	  		if($request['date'] == ""){
	  			$data['error'] = "Date is required!";
	  		} else {
	  			if($request->get('contribution') <= 0 && $request->get('loan') <= 0 && $request->get('interest') <= 0){
	  				$data['error'] = "One or more of your values cannot be less than 0!";
	  			} else {
			  		$reg = trim(explode('-', $request['regno'])[0]);
			  		$date = explode('/', $request['date']);
			  		$date = $date[2].'-'.$date[0].'-'.$date[1];
			  		
			  		if($request['division'] !== "" && $request['regno'] !== ""){
			  			if($request['contribution'] !== null || $request['loan'] !== null || $request['interest'] !== null){
					  		DB::table('tbltransaction')->insert([
					  			'regno'	=> $reg,
					  			'divisionID' => $request['division'],
					  			'description'	=> $request['description'],
					  			'monthcontribution'	=>  ($request['contribution'] == null) ? 0 : $request['contribution'],
					  			'loanrepay' 		=> ($request['loan'] == null) ? 0 : $request['loan'],
					  			'interestrepay'		=> ($request['interest'] == null) ? 0 : $request['interest'],
					  			'transaction_date'	=> $date,
					  			'updatedby'		=> Auth::user()->username,
					  			'date_updated'		=> date('Y-m-d'),
					  			'transtype'		=> 2,
					  			'year'			=> 'N/A',
					  			'month'			=> 'N/A'
					  		]);
						  		$data['saving'] = "";
							  	$data['loan'] = "";
							  	$data['interest'] = "";
							  	$data['description'] = "";
							  	$data['date'] = "";
					  		$data['success'] = "Payment Transaction has been recorded successfully!";
					  	} else {
					  		//return redirect()->back()->with('error', 'Zero Amount provided for all!');
					  		$data['error'] = "Zero Amount provided for all!";
					  	}
				  	} else {
				  		//return redirect()->back()->with('error', 'Division and Registration Number is required!');
				  		$data['error'] = "Division and Registration Number is required!";
			  		}
			     	}
			 }
		  	//dd($data);
	  	}
	  	$data['division'] = DB::Table('tbldivision')->get();
	  	$data['division_id'] = "";
	  	$data['members'] = null;
	  	if($request['division']){
	  		$data['division_id'] = $request['division'];
	  		$data['members'] = DB::Table('tblmembers')->Where('branch', $request['division'])->get();
	  	}
	  	
	  	$data['pagetitle'] = "Payment Transaction";
	  	
	  	return view('PaymentTransaction.index', $data);
	  }
}