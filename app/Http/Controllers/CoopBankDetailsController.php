<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use App\Models\BankDetails;
use Auth;
use Session;
use DB;

class CoopBankDetailsController extends UniversalFunctionController
{
 
	public function __construct()
    {
        $this->middleware('auth');
    }



  public function createBank()
  {    
   	$data = $this->getAlltoDoList();
       return view("Admin.Bank.home", $data);
  }

  public function storeBank(Request $request)
  {
      $this->validate($request, [
          'accountName'     => 'required|string|max:500',
          'bankName'        => 'required|string|max:500', 
          'accountNumber'   => 'required|numeric', 
      ]);
      $modelBank = new BankDetails;
      $modelBank->account_name    = trim($request->accountName);
      $modelBank->bank_name       = trim($request->bankName);
      $modelBank->account_number  = trim($request->accountNumber);
      $modelBank->updated_at      = date('Y-m-d');
      if($modelBank->save())
      {
        return redirect()->route('addBankDetails')->with('message', 'You have successfully added new bank');
      }
      else{
        return redirect()->route('addBankDetails')->with('error', 'Your operation was not successful. Try again');
      }
  }


  public function deleteBank($bankID)
  {
      $modelBank = new BankDetails;
      if(!empty($bankID) and $modelBank::where('bankID', $bankID)->first())
      {
        $modelBank::where('bankID', $bankID)->delete();
        return redirect()->route('addBankDetails')->with('message', 'You have successfully deleted a record');
      }else
      {
        return redirect()->route('addBankDetails')->with('error', 'Sorry, we cannot delete this record. Try again');
      }
      return redirect()->route('addBankDetails')->with('error', 'Sorry, record not found!');
  }


}//end class
