<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use carbon\carbon;
use Session;
use DB;
use Auth;


class DivisionController extends Controller
{
   public function index()
   {
   	
   	$data['divisions']= DB::table('tbldivision')->get();
   	return view('Division.division', $data);
   	
   	   	 $rawdata= DB::SELECT ("SELECT * FROM `tblmembers`  ");
	  foreach ($rawdata as $value) {
	  $dataval =str_replace("  "," ",trim($value->first_name));
	  $dataval =str_replace("  "," ",$dataval);
	  $dataval =str_replace(",","",$dataval);
	  $dataval =str_replace(".","",$dataval);
	  $Arrayval=explode(" ",$dataval);
	  echo sizeof($Arrayval);
	  $lastname='';
	  $middlename='';
	  $firstname='';
	  $title='';
	  switch  (sizeof($Arrayval)){
	  case 0:
	  break;
	  case 1:
	  
	  $lastname=$Arrayval[0];
	  break;
	  case 2:
	  $lastname=$Arrayval[0];
	  $firstname=$Arrayval[1];
	  
	  break;
	  case 3:
	  $lastname=$Arrayval[0];
	  $middlename=$Arrayval[1];
	  $firstname=$Arrayval[2];
	  
	  break;
	  case 4:
	  $lastname=$Arrayval[0];
	  $middlename=$Arrayval[1];
	  $firstname=$Arrayval[2];
	  
	  break;
	  }
	  DB::table('tblmembers')->where('ID', $value->ID)->update([	
	  			'first_name' 		=> $lastname
	  			,'middle_name' 		=> $middlename
	  			,'last_name' 		=> $firstname
	  			
	  		]);
	  
	  }
die("complete");

   }
   
   public function add(Request $request)
   {
   
   	$this->validate($request, [
           
            'divisionName' => 'required|string|unique:tbldivision,division,',
            

        ]);
   	
   	//dd($request->all());
   	$division = $request->input('divisionName');
   	
   	$ok= DB::table('tbldivision')->insert(
                      [  'division' => $division]); 
   	if($ok)
   	{
   		return redirect()->route('showDivisions')->with('message', 'Division successfully added');
   	}else
   	{
   		return redirect()->route('showDivisions')->with('errorMessage', 'An error occurred, division was not added');
   	}

   }
   
   public function update(Request $request)
   {
	   $y= $request->input('divisionid');
	   $div= DB::Table('tbldivision')->where('ID', $y)->first();
   	$this->validate($request, [
           
            'divisionChange' => 'required|string|unique:tbldivision,division,'.$div->ID,
            

        ]);
   	
   	$id= $request->input('divisionid');
   	$division = $request->input('divisionChange');
   	$reallyUpdate= DB::table('tbldivision')->where('ID',$id)->update(['division' => $division ]);
   	
            return redirect()->route('showDivisions')->with('message','Division successfully updated');
        

   }
   
   public function destroy($id)
   {
   
   $divisionExist1 = DB::table('tblmembers')->where('branch',$id)->exists();
   if($divisionExist1)
   {
   	return redirect()->route('showDivisions')->with('errorMessage', 'Cannot delete division as a member is currently assigned to it');
   	
   }else
   {
   	$divisionExist2 = DB::table('tbltransaction')->where('divisionID',$id)->exists();
   	if($divisionExist2)
   	{
   		return redirect()->route('showDivisions')->with('errorMessage', 'Cannot delete division as a transaction was used with it');
   	}else
   	{
   		DB::table('tbldivision')->where('ID',$id)->delete();
   		return redirect()->route('showDivisions')->with('message', 'Division successfully deleted');
   		
   	}
   
   }
  
   
   }
   
  
   
   
  
}
