<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use DB;

class MemberController extends Controller
{

   public function getMemberTransaction()
   {     
   	return view("Member.Transaction.transaction");
   }
   
}//end class
