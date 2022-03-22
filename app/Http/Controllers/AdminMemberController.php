<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use DB;

class AdminMemberController extends Controller
{

   public function createEditProfile()
   {     
   	return view("Admin.Member.editMember");
   }

   
   public function createMemberRegistration()
   {     
   	return view("Admin.Member.memberRegistration");
   }


   //
   public function getMemberTransaction()
   {     
   	return view("Member.Transaction.transaction");
   }
   
}//end class
