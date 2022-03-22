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


class RemitanceAmountController extends Controller
{
	public function index(Request $request){
	
		$data['success'] = "";
	  	$data['error'] = "";
	  	
	  	
	  	if($request['saving']){
	  		$this->validate($request, [
	  			'saving' => 'required',
	  			'loan'		=> 'required',
	  			'interest' => 'required'
	  		],[],[
	  			'saving' => 'Savings',
	  			'loan'		=> 'Loan',
	  			'interest' => 'Interest'
	  		]);
	  		$olddata = DB::Table('tbldefaultMonthlyContribution')->where('ID', $request['old-id'])->first();
	  		DB::Table('tblnewMonthlyContribution')->insert([
	  			'old_id' => $request['old-id'],
	  			'old_mc' => $olddata->monthly_contribution,
	  			'old_loan' => $olddata->loan_repay,
	  			'old_interest' => $olddata->interest_repay,
	  			'regno' => $request['regno'],
	  			'new_mc' => $request['saving'],
	  			'new_loan' => $request['loan'],
	  			'new_interest' => $request['interest']
	  		]);
	  		$data['success'] = "Request has been sent and would be approved by Admin shortly!";
	  	}
	  	
	  	
	  	
	  	$regdetails = DB::table('tblmembers')->where('regNo', Auth::user()->username)->first();
	  	
	  	$data['old'] = DB::Table('tbldefaultMonthlyContribution')->where('regno', $regdetails->regNo)->first();
	  	
	  	$data['new'] = DB::Table('tblnewMonthlyContribution')->where('regno', $regdetails->regNo)->get();
	  	
	  	$data['regdetails'] = $regdetails;
	  	
	  	$data['pagetitle'] = "Change Contribution values";
	  	
	  	return view('RemitanceChange.index', $data);
	  	
	}
	
	public function admin(Request $request)
	{
	
		$data['success'] = "";
	  	$data['error'] = "";
	  	
	  	
	  	if($request['bankname']){
	  		$this->validate($request, [
	  			'bankname' => 'required|min:3|max:255|unique:tblbank,bank'
	  		],[],[
	  			'bankname'	=> 'Bank name'
	  		]);
	  		
	  		DB::Table('tblbank')->insert([
	  			'bank' => $request['bankname']
	  		]);
	  		$data['success'] = "Bank added successfully!";
	  	}
	  	
	  	if($request['bank-edit']){
	  		$forma = DB::Table('tblbank')->Where('ID', $request['z-id'])->first()->bank;
	  		DB::Table('tblbank')->Where('ID', $request['z-id'])->update([
	  			'bank' => $request['bank-edit']
	  		]);
	  		$data['success'] = "Bank name was successfully changed from ".$forma." to ".$request['bank-edit'];
	  	}	  	
	  	
	  	
	  	$data['new'] = DB::Table('tblnewMonthlyContribution')->orderby('id', 'desc')->orderby('date_approved', 'desc')->get();
	  	
	  	$data['pagetitle'] = "Approve change of Contribution";
	  	
	  	return view('RemitanceChange.admin', $data);
	  	
	}
	
	public function print(Request $request, $id = null){
	
		if(!is_null($id)){
			if(DB::table('tblnewMonthlyContribution')->where('id', $id)->count() == 0){
				return redirect()->back();
			}
			$info = DB::Table('tblnewMonthlyContribution')->where('id', $id)->where('approved', 1)->first();
			$user = DB::Table('tblmembers')->where('regNo', $info->regno)->first();
			$old = DB::table('tbldefaultMonthlyContribution')->where('ID', $info->old_id)->first();
			
			$data['info'] = $info;
			$data['user'] = $user;
			$data['old'] = $old;
			$data['iddd'] = $id;
			
			return view('RemitanceChange.print', $data);
		} 
		return redirect()->back();
	}
	
	public function delete($id = null)
	{
		if($id !== null){
			if(DB::Table('tblnewMonthlyContribution')->where('id', $id)->where('approved', 0)->delete()){
				return redirect()->back()->with('message', 'Delete action was successful!');
			} else {
				return redirect()->back()->with('error', 'Oops! this request has already been approved');
			}
		}
		return redirect()->back();
	}
	
	public function approve_req($id = null){
		if($id !== null){
			if(DB::table('tblnewMonthlyContribution')->where('id', $id)->count() == 0){
				return redirect()->back()->with('error', 'something went wrong!');
			}
			
			DB::table('tblnewMonthlyContribution')->where('id', $id)->update([
				'approved'	=> 1,
				'date_approved'	=> time()
			]);
			
			$values = DB::Table('tblnewMonthlyContribution')->where('id', $id)->first();
			DB::table('tbldefaultMonthlyContribution')->where('id', $values->old_id)->update([
				'monthly_contribution' 	=> $values->new_mc,
				'loan_repay'		=> $values->new_loan,
				'interest_repay'	=> $values->new_interest 
			]);
			return redirect('print-change/'.$id);//->back()->with('message', 'Request was approved successfully, you will be redirected to a print page shortly');
		}
		return redirect()->back();
	}
	
	public function printslip($id = null)
	{
		if(!is_null($id)){
			if(DB::table('tblnewMonthlyContribution')->where('id', $id)->count() == 0){
				return redirect()->back();
			}
			$info = DB::Table('tblnewMonthlyContribution')->where('id', $id)->where('approved', 1)->first();
			$user = DB::Table('tblmembers')->where('regNo', $info->regno)->first();
			$old = DB::table('tbldefaultMonthlyContribution')->where('ID', $info->old_id)->first();
			
			$data['info'] = $info;
			$data['user'] = $user;
			$data['old'] = $old;
			$data['iddd'] = $id;
			
			return view('RemitanceChange.printslip', $data);
		} 
		return redirect()->back();
	}
	
	
	public function rate(Request $request){
		$data['success'] = "";
	  	$data['error'] = "";
	  	
	  	
	  	if($request['bankname']){
	  		$this->validate($request, [
	  			'bankname' => 'required|min:3|max:255|unique:tblbank,bank'
	  		],[],[
	  			'bankname'	=> 'Bank name'
	  		]);
	  		
	  		DB::Table('tblbank')->insert([
	  			'bank' => $request['bankname']
	  		]);
	  		$data['success'] = "Bank added successfully!";
	  	}
	  	
	  	if($request['description']){
	  		$forma = DB::Table('tblinterestrate')->Where('ID', $request['z-id'])->first();
	  		$fd = $forma->description;
	  		$fr = $forma->rate;
	  		if($request['rate'] >= 0){ 
		  		DB::Table('tblinterestrate')->Where('ID', $request['z-id'])->update([
		  			'description' => $request['description'],
		  			'rate'	=> $request['rate']
		  		]);
		  		if($fd !== $request['description']){
		  			if($fr !== $request['rate']){
		  				$data['success'] = "Interest description was successfully changed from ".$fd." to ".$request['description']." and rate from ". $fr. " to ".$request['rate'];
		  			} else {
		  				$data['success'] = "Interest description was successfully changed from ".$fd." to ".$request['description'];
		  			}
		  		} elseif($fr !== $request['rate']){
		  			$data['success'] = "Interest Rate was successfully changed from ". $fr. " to ".$request['rate'];
		  		}
		  		
		  		if($fd == $request['description'] && $fr == $request['rate']){
		  			$data['error'] = "No Update was done, it's all the same!";
		  		}
		  	} else {
		  		$data['error'] = "Rate value cannot be less than 0";
		  	}
	  	}	  	
	  	
	  	
	  	$data['new'] = DB::Table('tblinterestrate')->get();
	  	
	  	$data['pagetitle'] = "Change Interest rate";
	  	
	  	return view('RemitanceChange.rate', $data);
	}
	
	
}