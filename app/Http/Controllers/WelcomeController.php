<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use DB;

class WelcomeController extends Controller
{

   public function loadPage()
   {     
   	return view("auth.login");
   }



}//end class
