<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use App\Models\EditAccount;
use Session;
use Auth;
use DB;

class EditAccountController extends Controller
{

   public function __construct()
   {
        $this->middleware('auth');
   }

   public function create()
   {     
   	return view("Account.editAccount");
   }

   //
   public function processAccount(Request $request)
   {    
      $this->validate($request, [
          'password' => 'required|string|min:4|max:100|confirmed',
      ]);
      $tempPassword  = ($request['password']);
      $password      = bcrypt($tempPassword);
      $tableModel    = new EditAccount;
      $userID        = Auth::user()->id;
      //
      if($tableModel->where('id', $userID)->update(array('password'  => $password)))
      {
         return redirect()->route('editAccount')->with('message', 'Success, your account has been updated successfully.');
      }else{
         return redirect()->route('editAccount')->with('error', 'We are sorry, we could not update your account. Try again.');
      }
      
   }
   
}//end class
