<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use App\Models\BankDetails;
use Auth;
use Session;
use DB;

class BankDetailsController extends Controller
{
 
	public function index(Request $request){
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
	  	
	  	
	  	
	  	$data['banks'] = DB::Table('tblbank')->get();
	  	
	  	$data['pagetitle'] = "Add a Bank";
	  	
	  	return view('BankDetails.index', $data);
	}
	
	public function delete($id = null){
		if($id != null){
			$chk1 = DB::Table('tblmembers')->where('bankid', $id)->count();
			$chk2 = DB::table('tblloanrequest')->where('bankid', $id)->count();
			
			if($chk1 == 0 && $chk2 == 0){
				DB::Table('tblbank')->where('id', $id)->delete();
				return redirect()->back()->with('message', 'Bank has been deleted');
			} else {
				return redirect()->back()->with('error', 'Bank could not be deleted, this could be as a result of this bank being tied to a member registration or loan request');
			}
		} 
		return redirect()->back();
	}
   

}//end class
