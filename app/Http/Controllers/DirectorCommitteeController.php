<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use carbon\carbon;
use Session;
use DB;
use File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Auth;


class DirectorCommitteeController extends Controller
{
	

	public function allCoopCommittee()
	{	
		$data['getAllExecutive'] = DB::table('tblmanagement_executive')->where('status', 1)->get();
		
		return view('Member.BoardOfCommittee.committeeDetails', $data);
	}
	
	
	public function create()
	{
		$data['getAllExecutive'] = DB::table('tblmanagement_executive')->where('status', 1)->get();
		
		return view('Member.BoardOfCommittee.createCommittee', $data);
	}
	
	
	public function store(Request $request)
	{
		 $this->validate($request, [
             		'executiveName' => 'required|string|unique:tblmanagement_executive,email',
            		'executivePosition' => 'required|string',
            		'telephoneNumber' =>'string',
        	]);
        	//
        	$getName 	= trim($request->input('executiveName'));
        	$getPosition 	= trim($request->input('executivePosition'));
        	$getTelephone 	= trim($request->input('telephoneNumber'));
        	$getEmail 	= trim($request->input('email'));
        	$location	= trim($request->input('location'));
        	//
        	$success = DB::table('tblmanagement_executive')->insert([ 
        		'executive_name' => $getName, 
        		'position' 	=> $getPosition,
        		'telephone' 	=> $getTelephone,
        		'email' 	=> $getEmail,
                      	'created_at' 	=> date('Y-m-d'), 
                      	'createdby' 	=> auth::user()->name, 
                      	'location' 	=> $location,
                ]); 
                if($success){
                	return redirect()->route('createCommittee')->with('message', 'New Management committee information was added successfully.');
                }else{
                	return redirect()->route('createCommittee')->with('error', 'Sorry, we cannot add this record! Please try again.');
                }
	}
	
	
	public function createUpdate()
	{
		return redirect()->route('createCommittee');
	}
	
	
	public function update(Request $request)
	{
		 $this->validate($request, [
             		'executiveName' 	=> 'required|string|unique:tblmanagement_executive,email',
            		'executivePosition' 	=> 'required|string',
            		'telephoneNumber' 	=> 'string',
            		'recordDetails' 	=> 'required|numeric',
        	]);
        	//
        	$getName 	= trim($request->input('executiveName'));
        	$getPosition 	= trim($request->input('executivePosition'));
        	$getTelephone 	= trim($request->input('telephoneNumber'));
        	$getEmail 	= trim($request->input('email'));
        	$recordID	= trim($request->input('recordDetails'));
        	$location	= trim($request->input('location'));
        	//
        	$success = DB::table('tblmanagement_executive')->where('executiveID', $recordID)->update([ 
        		'executive_name' => $getName, 
        		'position' 	=> $getPosition,
        		'telephone' 	=> $getTelephone,
        		'email' 	=> $getEmail,
                      	'updated_at' 	=> date('Y-m-d'), 
                      	'createdby' 	=> auth::user()->name, 
                      	'location' 	=> $location, 
                ]); 
                if($success){
                	return redirect()->route('createCommittee')->with('message', 'Management committee details was successfully updated.');
                }else{
                	return redirect()->route('createCommittee')->with('error', 'Sorry, we cannot add this record! Please try again.');
                }
	}
	
	
	public function delete($recordID)
	{ 
		if(DB::table('tblmanagement_executive')->where('executiveID', $recordID)->first()){
			$success = DB::table('tblmanagement_executive')->where('executiveID', $recordID)->delete();
		}
        	
                if($success){
                	return redirect()->route('createCommittee')->with('message', 'A record was deleted successfully.');
                }else{
                	return redirect()->route('createCommittee')->with('error', 'Sorry, we cannot delete this record! Please try again.');
                }
	}
	
	
	
  
}
