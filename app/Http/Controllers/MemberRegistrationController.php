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


class MemberRegistrationController extends Controller
{

   public function getApplicants()
   {
   	$data['applicants']=DB::Table('tblapplicant')->where('status',0)->get();
   	$data['app']=DB::Table('tblapplicant')->where('status',0)->get();
   	
   	return view('memberRegistration.getApplicant',$data);
   
   
   }
   
   //retrieve applicant and approve/deny
   public function retrieveApplicants($id)
   {
   	$data['applicants']=DB::Table('tblapplicant')
   	->where('tblapplicant.cardNo',$id)
   	->where('tblapplicant.status',0)
   	->leftjoin('tblgender','tblapplicant.gender',"=",'tblgender.id')
   	->leftjoin('tbltitle','tblapplicant.title',"=",'tbltitle.id')
   	->leftjoin('tblstates','tblapplicant.state',"=",'tblstates.StateID')
   	->leftjoin('tbllga','tblapplicant.lga',"=",'tbllga.lgaId')
   	->leftjoin('tblmaritalstatus','tblapplicant.marital_status',"=",'tblmaritalstatus.ID')
   	->leftjoin('tblbank','tblapplicant.bankid',"=",'tblbank.ID')
   	->leftjoin('tbldivision','tblapplicant.branch',"=",'tbldivision.ID')
   	->first();
   	
   	return view('memberRegistration.approveApplication',$data);
   
   
   }
   
   public function index(Request $request, $id=null)
   {
   
   	
   	
   	
   	if($id!==null)
   	{
   	   $data['member'] = DB::Table('tblmembers')->where('regNo', $id)->first();
   	   $data['picExist']= DB::Table('tblmembers')->where('regNo', $id)->value('image_ext');
   	   if($data['member']===null)
   	   {
   	   	return redirect()->route('editProfile')->with('errorMessage','Member does not exist');
   	   }
   	   
   	}else if($request->input('regNo')!==null)
   	{
   	   $data['member'] = DB::Table('tblmembers')->where('regNo', $request->input('regNo'))->first();
   	   $data['picExist'] = DB::Table('tblmembers')->where('regNo', $request->input('regNo'))->value('image_ext');
   	   if($data['member']===null)
   	   {
   	   	return redirect()->route('editProfile')->with('errorMessage','Member does not exist');
   	   }
   	}
   	else
   	{
   	$data['member']=null;
   	$data['picExist']=null;
	}
	//dd($data['member']);
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
   	}elseif($data['member'])
   	{
   	$data['LgaList'] = DB::table('tbllga')->where('stateId', '=',$data['member']->state)->get();
   	}
   	
   	//dd($data['member']->state);
   	
   	return view('memberRegistration.registrationForm', $data);

   }
   
   public function save(Request $request)
   {
  	
  	$ifPresent=$request->input('check');
  	//dd($ifPresent);
   	$regisNo= $request->input('regNo');
   	$request->session()->put('reg', $regisNo);
   	$dMember = DB::Table('tblmembers')->where('regNo', $regisNo)->first();
   	$dUser = DB::Table('users')->where('username', $regisNo)->first();
   	$request->session()->flash('state',$request->input('state') );
   	$stringToTime = strtotime($request->input('employmentDate'));
   	
   	$request['stringtt']=$stringToTime;
   	if($ifPresent==="true")
   	{
   	//dd('welp');
   	    $this->validate($request, [
           
            //'regNo' => 'required|numeric|unique:tblmembers,regNo,'.$dMember->ID.',ID',
            //'email' => 'required|email|unique:tblmembers,email_address,'.$dMember->ID.',ID',
            
             'regNo' => 'required|unique:tblmembers,regNo,'.$dMember->ID,
            'email' => 'required|email|unique:tblmembers,email_address,'.$dMember->ID,
            
           
            
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
   	}
   	else if($ifPresent==="false")
   	{
   	
   	    $this->validate($request, [
           
            'regNo' => 'required|unique:tblmembers,regNo,',
            'email' => 'required|unique:tblmembers,email_address,',
           
            
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
        
        
   	
   	}else{
   	
   	}
   	
        
        if($stringToTime > time())
   	{

   	return Redirect::back()->withInput(Input::all())->with('errorMessage', 'Date cannot be in the future');
   	}
        
   	
   	$regNo= $request->input('regNo');
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
        $dateJoined= $request->input('employmentDate');
        $user = Auth::user()->username;
        $sex = $request->input('sex');
        $marital_status= $request->input('marital_status');
        $relationship= $request->input('rnok');
        
        $name = $firstName.' '.$middleName.' '.$lastName;
        $pwd = mt_rand(100000,999999); 
        $password = bcrypt($pwd);
        
        
       
        if($dMember)
        {
        //dd('Huh?');
        	DB::table('tblmembers')->where('regNo', $regNo)->update(
                      ['regNo' => $regNo, 'title' => $title,
                      'first_name' => $firstName, 'middle_name' => $middleName, 'last_name' => $lastName, 'phoneno' => $phoneNo,
                      'email_address' => $email, 'state' => $state, 'lga' => $lga,'address' => $address , 'nextofkin' => $nok, 
                      'nextofkin_address'=> $nokaddress , 'nextofkin_phoneno' => $nokphoneNo, 'branch' => $division, 
                      'monthly_contribution' => $contribution, 'bankid' => $bank,'account_no' => $accNo , 'date_join' => $dateJoined,
                      'created_date' => Carbon::now(), 'createdby' => $user,'gender' => $sex, 'relationship_with_nextofkin' => $relationship, 'marital_status' => $marital_status, 'status' => 1]
                  ); 
                  
                  DB::table('tbldefaultMonthlyContribution')->where('regNo', $regNo)->update(['monthly_contribution' => $contribution,
       	 'last_updated_date' => Carbon::now(), 'last_updatedby' => $user]);
                  
                  	
        }else
        {
        //dd('Boo');
        	DB::table('tblmembers')->insert(
                      [ 'regNo' => $regNo, 'title' => $title,
                      'first_name' => $firstName, 'middle_name' => $middleName, 'last_name' => $lastName, 'phoneno' => $phoneNo,
                      'email_address' => $email, 'state' => $state, 'lga' => $lga,'address' => $address , 'nextofkin' => $nok, 
                      'nextofkin_address'=> $nokaddress , 'nextofkin_phoneno' => $nokphoneNo, 'branch' => $division, 
                      'monthly_contribution' => $contribution, 'bankid' => $bank,'account_no' => $accNo , 'date_join' => $dateJoined,
                      'created_date' => Carbon::now(), 'createdby' => $user, 'gender' => $sex, 'relationship_with_nextofkin' => $relationship, 'marital_status' => $marital_status, 'status' => 1]); 
                      
                      DB::table('tbldefaultMonthlyContribution')->insert(['regno' => $regNo, 'monthly_contribution' => $contribution,
       	 'last_updated_date' => Carbon::now(), 'last_updatedby' => $user]);
       	 
        DB::table('users')->insert(['name' => $name, 'username' => $regNo,
       	 'role' => 18, 'email' => $email, 'password'=> $password,'created_at' => Carbon::now(),'updated_at' => Carbon::now(),]);
        
        }
        
        
       
      
       
       
       	 
       	 if($request->hasFIle('passport')){
        $extension = $request->file('passport')->getClientOriginalExtension();
        
      
        
        $fileNameToStore = $email .'.'.$extension;
        
        
       $pic = DB::table('tblmembers')->where('regNo', $regNo)->value('image_ext');
	
	
	if($pic!=null)
           {
                
                $file_path = base_path(). '/../coop.nicn.gov.ng/profilePic'.$fileNameToStore;
                File::delete($file_path);
           }
      
        $path = $request->file('passport')->move(
                base_path().'/../coop.nicn.gov.ng/profilePic', $fileNameToStore
            );
            
            
            DB::table('tblmembers')->where('regNo', '=', $regNo)->update(['image_ext' =>$extension]);
            }
            
            if($dMember)
            {
            	
       		
       		//return redirect()->route('memberRegistration')->with('message','Member Registered successfully');
       		return redirect()->action(
		    'MemberRegistrationController@index', ['id' => $regNo])->with('message','Record Successfully Updated');
		   
            }else
            {
            	$type=1;
            	$this->sendMail($email, $regNo, $pwd, 'coop.nicn.gov.ng/login', $lastName, $title,$type);
            	//return redirect()->route('memberRegistration')->with('message','Member updated successfully');
            	return redirect()->action(
		    'MemberRegistrationController@index', ['id' => $regNo])->with('message','Record Successfully Saved');
		    
            }
       	 
       		
       

   }
   
   public function edit()
   {
   
   	
   	$data['TheMember'] = DB::Table('tblmembers')->get();
   	return view('memberRegistration.editForm', $data);

   }
   
   public function approve(Request $request)
   {
  
   	$pwd = mt_rand(100000,999999); 
        		$password = bcrypt($pwd);
   	if($request->input('approve')=='approve')
   	{
   		//dd($request->all());
   		$app_id = $request->get('cardNo');
			$details = DB::Table('tblapplicant')->Where('cardNo', $app_id)->first();
			DB::Table('tblapplicant')->where('cardNo', $app_id)->update([
				'status' => 1
			]);
			
			
			
			DB::table('tblmembers')->insert([
				'regNo'	=> 	$details->cardNo,
				'title'	=>	$details->title,
				
				'last_name'	=> $details->last_name,
				'first_name'	=> $details->first_name,
				'middle_name'	=> $details->middle_name,
				'gender'	=> $details->gender,
				'state'	        => $details->state,
				'lga'		=> $details->lga,
				'address'	=> $details->address,
				'email_address'	=> $details->email_address,
				'phoneno'	=> $details->phoneno,
				
				'nextofkin'	=> $details->nextofkin,
				'nextofkin_address'	=> $details->nextofkin_address,
				'nextofkin_phoneno'	=> $details->nextofkin_phoneno,
				'branch'	=> $details->branch,
				'relationship_with_nextofkin'	=> $details->relationship_with_nextofkin,
				'monthly_contribution'	=> $details->monthly_contribution,
				'bankid'	=> $details->bankid,
				'account_no'	=> $details->account_no,
				'address'	=> $details->address,
				'date_join'	=> $details->employment_date,
				'marital_status'	=> $details->marital_status,				
				
				'status'	=> 1,
				'created_date'	=> date('Y-m-d'),
				'createdBy'	=> Auth::user()->username,
				'image_ext'	=> $details->image_ext
			]);
			
			$name = $details->first_name.' '.$details->middle_name.' '.$details->last_name;
			
        		
        		DB::table('tbldefaultMonthlyContribution')->insert(['regno' => $details->cardNo, 'monthly_contribution' => $details->monthly_contribution,
       	 'last_updated_date' => Carbon::now(), 'last_updatedby' => Auth::user()->username]);
       	 
        DB::table('users')->insert(['name' => $name, 'username' => $details->cardNo,
       	 'role' => 18, 'email' => $details->email_address, 'password'=> $password,'created_at' => Carbon::now(),'updated_at' => Carbon::now(),]);
        
        
        $hasPic = DB::table('tblapplicant')->where('cardNo', $details->cardNo)->value('image_ext');
			if($hasPic){
			
        $extension = $hasPic;
        
      
        
        $fileNameToMove = $details->email_address.'.'.$extension;
        $old_path = base_path().'/../coop.nicn.gov.ng/tempPic/'.$fileNameToMove;
        $new_path = base_path().'/../coop.nicn.gov.ng/profilePic/'.$fileNameToMove;
        $move = File::move($old_path, $new_path);
        


            DB::table('tblmembers')->where('regNo', '=', $details->cardNo)->update(['image_ext' =>$extension]);
            
            
            }
            $type=1;
            $this->sendMail($details->email_address, $details->cardNo, $pwd, 'coop.nicn.gov.ng/login', $details->last_name, $details->title,$type);
   	return redirect()->back()->With('message', 'Applicant Approved');
   	}else if($request->input('approve')=='deny')
   	{
   		$app_id = $request->get('cardNo');
			$details = DB::Table('tblapplicant')->Where('cardNo', $app_id)->first();
			DB::Table('tblapplicant')->where('cardNo', $app_id)->update([
				'status' => 2
			]);
			
			$type=2;
   		$this->sendMail($details->email_address, $details->cardNo, $pwd, 'coop.nicn.gov.ng/login', $details->last_name, $details->title, $type);
			return redirect()->back()->With('warningMessage', 'Application has been denied');
   	}else
   	{
   		
   		return redirect()->back()->With('errorMessage', 'An error occured');
   	}
   	
   	
   
   }
   
   
   
   //Ajax's request
   public function LGA(Request $request)
    {
   
      $stateId = $request['id'];
  
      $data = DB::table('tbllga')->where('stateId', '=',$stateId)->get();
      return response()->json($data); 
    }
    
    public function ajaxcall(Request $request){
    $id = $request['id'];
		if($request->get('id') != ""){
		
			$req = explode('-', $request->get('id'));
			$res = DB::Table('tblapplicant')
				//->where('tblapplicant.cardNo', $req[0])
				->where('tblapplicant.cardNo', $id)
				->where('tblapplicant.status', 0)
				->leftjoin('tbltitle', 'tblapplicant.title', '=', 'tbltitle.id')
				->leftjoin('tblstates', 'tblapplicant.state', '=', 'tblstates.StateID')
				->leftjoin('tbllga','tblapplicant.lga','=','tbllga.lgaId')
				->leftjoin('tblgender','tblapplicant.gender','=','tblgender.id')
				->leftjoin('tblmaritalstatus', 'tblapplicant.marital_status', '=', 'tblmaritalstatus.ID')
				->leftjoin('tbldivision','tblapplicant.branch','=','tbldivision.ID')
				->leftjoin('tblbank','tblapplicant.bankid','=','tblbank.ID')			
				->select('tblapplicant.*', 'tbltitle.title', 'tbllga.lga', 'tblstates.State', 'tblgender.gender','tbldivision.division', 'tblbank.bank','tblmaritalstatus.status')
				->first();
			
			
			//$res=$req[0];
			if(!is_null($res)){
				echo json_encode($res);
			} else {
				echo json_encode(['title' => 404]);
			}
		} else {
			echo json_encode(['title' => 404]);
		}
		
	}
	
	
    
    public function sendMail($email, $username, $password, $link, $lastname, $title, $type){
			if($type==1)
			{
			$subject = "Successfully Registered";
			
			$message = "
				<html>
				<head>
				<title>Login Details</title>
				</head>
				<body>
				<br><br><br>
				<p>Username: ". $username."<br>
				   Password: ". $password."
				</p>   
				<p>
				 Please change your password after you login
				</p>
				<p>http://www.coop.nicn.gov.ng/login</p>
				</body>
				</html>
			";
			}
			else if($type==2)
			{
			$subject = "Application Denied";
			
			$message = "
				<html>
				<head>
				<title>Application Denied</title>
				</head>
				<body>
				<br><br><br>
				<p>We regret to tell you that your application was denied. Contact our office 
				if you have other inquiries.
				</p>   
				<p>
				 Please change your password after you login
				</p>
				<p>http://www.coop.nicn.gov.ng/login</p>
				</body>
				</html>
			";
			}else
			{
			
			}
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			// More headers
			$headers .= 'From: <coop@coop.nicn.gov.ng>' . "\r\n";
			$headers .= 'reply to: donotreply@coop.nicn.gov.ng' . "\r\n";
			
			
			mail($email, $subject, $message, $headers);
		return true;
	}

  
}
