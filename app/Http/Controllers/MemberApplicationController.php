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
//use Auth;


class MemberApplicationController extends Controller
{
   public function index()
   {
   
   
   	
   	
   	
   	$data['tempMember']=null;
	
   	$data['StateList'] = DB::table('tblstates')->get();
   	$data['DivisionList'] = DB::table('tbldivision')->get();
   	$data['BankList'] = DB::table('tblbank')->get();
   	$data['TitleList'] = DB::table('tbltitle')->get();
   	$data['GenderList'] = DB::table('tblgender')->get();
   	$data['MaritalList'] = DB::table('tblmaritalstatus')->get();
   	
   	$data['LgaList']='';
   	$stateSession = session::get('state');
   	
   	if($stateSession !='')
   	{
   	$data['LgaList'] = DB::table('tbllga')->where('stateId', '=',$stateSession)->get();
   	}
   	
   	return view('memberRegistration.applicationForm', $data);

   }
   
   public function save(Request $request)
   {
   
  	$request->session()->flash('state',$request->input('state') );
   	$cardNo= $request->input('cardNo');
   	$presentMember = DB::Table('tblmembers')->where('regNo', $cardNo)->first();
   	$presentApplicant = DB::Table('tblapplicant')->where('cardNo', $cardNo)->where('status', 0)->first();
   	$deniedApplicant = DB::Table('tblapplicant')->where('cardNo', $cardNo)->where('status', 2)->first();
   	
   	if($presentMember)
   	{
   		return redirect()->action(
		    'MemberApplicationController@index')->with('errorMessage','Applicant has already been registered');
   	}else if($presentApplicant)
   	{
   		return redirect()->action(
		    'MemberApplicationController@index')->with('errorMessage','Application is already being reviewed');
   	}else{
   	
   	if($deniedApplicant){
   	
   	DB::table('tblapplicant')->where('cardNo', $cardNo)->delete();
   	}
   	$stringToTime = strtotime($request->input('employmentDate'));
   	//dd($request->input('employmentDate'));
   	//dd($stringToTime);
   	$request['stringtt']=$stringToTime;
   	 $this->validate($request, [
           
            'cardNo' => 'required|unique:tblapplicant,cardNo,',
            'email' => 'required|unique:tblapplicant,email_address,',
           
            
            'last_name' =>'required|string',
            'middle_name' =>'required|string',
            'first_name' =>'required|string',
            'phoneNo' => 'required|numeric',
            'state' => 'required|numeric',
            'lga' => 'required|numeric',
            'address' =>'required|string',
            'nok' =>'required|string',
            'nokaddress' =>'required|string',
            'nokphoneNo' =>'required|numeric',
            'division' =>'required|numeric',
            'monthbution' =>'required|numeric',
            'bank' =>'required|numeric',
            'accNo' =>'required|numeric',
            'stringtt' => 'required',
   	]);
   	
   	if($stringToTime > time())
   	{
   	//return redirect()->back()->with('errorMessage', 'date not correct');
   	return Redirect::back()->withInput(Input::all())->with('errorMessage', 'Date cannot be in the future');
   	}
   	
   	}

   	$cardNo= $request->input('cardNo');
   	$title = $request->input('title');
   	$firstName = $request->input('first_name');
   	$middleName = $request->input('middle_name');
   	$lastName = $request->input('last_name');
   	$phoneNo = $request->input('phoneNo');
        $email = $request->input('email');
        $state = $request->input('state');
        $lga = $request->input('lga');
        $address = $request->input('address'); 
        $nok= $request->input('nok');
   	$nokaddress= $request->input('nokaddress');
   	$nokphoneNo= $request->input('nokphoneNo');
   	$division= $request->input('division');
        $contribution= $request->input('monthbution');
        $bank= $request->input('bank');
        $accNo= $request->input('accNo'); 
        $employmentDate= $request->input('employmentDate');
        $rnok= $request->input('rnok');
        $marital_status= $request->input('marital_status');
        $gender= $request->input('gender');
        //dd($marital_status);
        
        $name = $firstName.' '.$middleName.' '.$lastName;
       
        
        
       
        
        	$ok= DB::table('tblapplicant')->insert(
                      [ 'cardNo' => $cardNo, 'title' => $title,
                      'first_name' => $firstName, 'middle_name' => $middleName, 'last_name' => $lastName, 'phoneno' => $phoneNo,
                      'email_address' => $email, 'state' => $state, 'lga' => $lga,'address' => $address , 'nextofkin' => $nok, 
                      'nextofkin_address'=> $nokaddress , 'nextofkin_phoneno' => $nokphoneNo, 'branch' => $division, 
                      'monthly_contribution' => $contribution, 'bankid' => $bank,'account_no' => $accNo , 'employment_date' => $employmentDate,
                      'created_date' => Carbon::now(), 'relationship_with_nextofkin' => $rnok, 'marital_status' => $marital_status, 'gender' => $gender, 'status'=>0]); 
                      
	if(!$ok)
	{
		return redirect('/')->with('errorMessage','Application could not be sent');
	}

       	 if($request->hasFIle('passport')){
       	 
        $extension = $request->file('passport')->getClientOriginalExtension();
        
      
        
        $fileNameToStore = $email .'.'.$extension;
        
        
       $pic = DB::table('tblapplicant')->where('cardNo', $cardNo)->value('image_ext');
	
	
	if($pic!=null)
           {
                
                $file_path = base_path(). '/../coop.nicn.gov.ng/tempPic'.$fileNameToStore;
                File::delete($file_path);
           }
      
        $path = $request->file('passport')->move(
                base_path().'/../coop.nicn.gov.ng/tempPic', $fileNameToStore
            );
            
            
            DB::table('tblapplicant')->where('cardNo', '=', $cardNo)->update(['image_ext' =>$extension]);
            }
            
           

       		return redirect('/')->with('message','Your Application was sent successfully. WIll be reviewed shortly');
		   
           
       	 
       		
       

   }
   
   public function edit()
   {
   
   	
   	$data['TheMember'] = DB::Table('tbltempmembers')->get();
   	return view('memberRegistration.editForm', $data);

   }
   
   
   
   //Ajax's request
   public function LGA(Request $request)
    {
   
      $stateId = $request['id'];
  
      $data = DB::table('tbllga')->where('stateId', '=',$stateId)->get();
      return response()->json($data); 
    }
    
   

  
}
