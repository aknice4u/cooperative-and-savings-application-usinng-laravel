<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use carbon\carbon;
use Session;
use DB;
use File;
use Auth;

class TransactionController extends BasicfunctionController 
{
   public function computation(Request $request)
   {
   	 

   	 //Increase Memory Size
		ini_set('memory_limit', '-1');
	//
   	 $data['warning'] = '';
   	 $data['success'] = '' ;
   	 $to= $request['to'];
   	if($to==null){$to= Carbon::now()->format('Y-m-d');}
   	$data['to'] = $to;
   	 $division = $request['division'];
   	 $data['division'] = $division ;
   	 $year= $request['year'];
   	 //$year= '2018';
   	 $data['year'] = $year;
   	 $month= $request['month'];
   	 //$month= 'September';
   	 $data['month'] = $month;
   	 $description="$month $year monthly Contribution";
   	 $r_date=date("Y-m-d");
   	$data['Divisions'] = $this->DivisionList();
   	$MonthlyDefault =[];
   	if ( isset( $_POST['reprocess'] ) ) {
   	    $this->validate($request, [    
            'year' =>'required|string',
            'month' =>'required|string', 
        ]);
   	    if (!DB::Select("SELECT * FROM `tblcontributionfromsalary` WHERE `year`='$year' and `month`='$month'"))
   	    return redirect()->back()->with('errorMessage', "Sorry, we cannot process this month contribution. Import $year $month deduction from salary and Try again!.");
	   $this->DeleteperiodEntry($division,$year,$month);
	   }
   	if ( isset( $_POST['process'] )|| isset( $_POST['reprocess'] ) ) {
   	$this->validate($request, [    
            'year' =>'required|string',
            'month' =>'required|string', 
        ]);
   	if ($this->ConfirmperiodEntry($division,$year,$month))
	   {
	   $data['warning'] = "The computation is already done for this period";
	   $data['MonthlyDefault'] = $MonthlyDefault;
	   return view('TransactionComputation.computation', $data);
	   }
	   if (!DB::Select("SELECT * FROM `tblcontributionfromsalary` WHERE `year`='$year' and `month`='$month'"))
   	    return redirect()->back()->with('errorMessage', "Sorry, we cannot process this month contribution. Import $year $month deduction from salary and Try again!.");
	   
	   $MonthlyDefault = $this->MonthlyDefault($division,$year,$month);
   	 foreach ($MonthlyDefault as $b){
   	     $salary_deduction=$this->Salary_Deduction ($year,$month,$b->regno);
   	     if($salary_deduction>0){
   	         $total_contribution=$b->monthly_contribution+$b->loan_repay+$b->interest_repay;
   	         if($total_contribution==$salary_deduction){
               	 DB::table('tbltransaction')->insert(array(
            		'regno'	    	=> $b->regno,
            		'year'    	=> $year,
            		'month'    	=> $month,
            		'description'    => $description,
            		'monthcontribution'	    	=> $b->monthly_contribution,
            		'loanborrow'    	=> '0',
            		'loanrepay'    	=> $b->loan_repay,
            		'loaninterest'    => '0',
            		'interestrepay'	    	=> $b->interest_repay,
            		'divisionID'	    	=> $b->divisionID,
            		'transtype'  =>        1,
            		'transaction_date'    	=> $to,
            		'updatedby'    	=> Auth::user()->username,
            		'date_updated'    => $r_date,
            	));
   	         }else{
   	             //put the contribution algorithm here
   	             $balasat=$this->MemberBalanceAsAt($to,$b->regno);
   	             $loanbal=$balasat->lbalsum;
   	             $intbal=$balasat->ibalsum;

   	             $loan_repay= $b->loan_repay;
   	             if($loanbal<$loan_repay)$loan_repay=$loanbal;
   	             if($salary_deduction<$loan_repay)$loan_repay=$salary_deduction;
   	             $salary_deduction -=$loan_repay;
   	             $interest_repay= $b->interest_repay;
   	             if($intbal<$interest_repay)$interest_repay=$intbal;
   	             if($salary_deduction<$interest_repay)$interest_repay=$salary_deduction;
   	             $salary_deduction -=$interest_repay;
   	             DB::table('tbltransaction')->insert(array(
            		'regno'	    	=> $b->regno,
            		'year'    	=> $year,
            		'month'    	=> $month,
            		'description'    => $description,
            		'monthcontribution'	    	=> $salary_deduction,
            		'loanborrow'    	=> '0',
            		'loanrepay'    	=> $loan_repay,
            		'loaninterest'    => '0',
            		'interestrepay'	    	=> $interest_repay,
            		'divisionID'	    	=> $b->divisionID,
            		'transtype'  =>        1,
            		'transaction_date'    	=> $to,
            		'updatedby'    	=> Auth::user()->username,
            		'date_updated'    => $r_date,
            	));
   	             
   	         }
   	     }
   	 
   	 }
   	$data['success'] = "This period computation is success done!";
   	
   	}
   	if ( isset( $_POST['modify'] ) ) {
   	$this->validate($request, [    
            'contribution' =>'required|numeric|min:0',
            'loanrepayment' =>'required|numeric|min:0',
            'intrepayment' =>'required|numeric|min:0', 
        ]);
   	$contribution= $request['contribution'];
   	$loanrepayment= $request['loanrepayment'];
   	$intrepayment= $request['intrepayment'];
   	$regno= $request['regno'];
   	  DB::Update("UPDATE `tbldefaultMonthlyContribution` SET `monthly_contribution`='$contribution',`loan_repay`='$loanrepayment',`interest_repay`='$intrepayment' where`regno`='$regno'");
   	  DB::Update("UPDATE `tblmembers` SET `monthly_contribution`='$contribution' WHERE `regNo`='$regno'");
   	  $data['success'] = "Contribution adjustment successfully updated!";
   	}
   	if ( isset( $_POST['modify'] ) ||isset( $_POST['process'] )|| isset( $_POST['reprocess'] )||isset( $_POST['go'] ) ) {
   	$MonthlyDefault = $this->MonthlyDefault($division,$year,$month);
   	}
   	
   	$data['MonthlyDefault'] = $MonthlyDefault;
   	return view('TransactionComputation.computation', $data);

   }
   
   public function MemberReport(Request $request)
   {
       //Increase Memory Size
		ini_set('memory_limit', '-1');
		//
   	 $data['warning'] = '';
   	 $data['success'] = '' ;
   	$to= $request['to'];
   	if($to==null){$to= Carbon::now()->format('Y-m-d');}
   	$data['to'] = $to;
   	$from= $request['from'];
   	if($from==null){$from= Carbon::now()->subYear()->format('Y-m-d');    }
   	$data['from'] = $from;
   	$regno= $request['regno'];
   	$data['regno'] = $regno;  	
   	$data['MemberList'] = $this->MemberList(); 
   	$data['refregno'] = $request['refregno'];
   	$data['MemberTransactionReport'] = $this->MemberTransactionReport($to,$from,$regno);
   	return view('TransactionComputation.memberreport', $data);

   }
   
    public function ArchiveTransaction(Request $request)
   {
    	//Increase Memory Size
		ini_set('memory_limit', '-1');
		//
    	$data['warning'] = '';
   	 $data['success'] = '' ;
   	$year= $request['year'];
   	 $data['year'] = $year;
   	 $month= $request['month'];
   	 $data['month'] = $month;
   	 $description= $request['description'];
   	 $data['description'] = $description;
   	 $monthcontribution= $request['monthcontribution'];
   	 $data['monthcontribution'] = $monthcontribution;
   	 $loanborrow= $request['loanborrow'];
   	 $data['loanborrow'] = $loanborrow;
   	 $loanrepay= $request['loanrepay'];
   	 $data['loanrepay'] = $loanrepay;
   	 $loaninterest= $request['loaninterest'];
   	 $data['loaninterest'] = $loaninterest;
   	 $interestrepay= $request['interestrepay'];
   	 $data['interestrepay'] = $interestrepay;
   	$to= $request['to'];
   	if($to==null){$to= Carbon::now()->format('Y-m-d');}
   	$data['to'] = $to;
   	$tdate= $request['transactionDate'];
   	$data['transactionDate'] = $tdate;
   	$from= $request['from'];
   	if($from==null){$from= Carbon::now()->subYear()->format('Y-m-d');    }
   	$data['from'] = $from;
   	$regno= $request['regno'];
   	$data['regno'] = $regno;  	
   	$data['MemberList'] = $this->MemberList(); 
   	if ( isset( $_POST['add'] ) ) {
   	 $r_date=date("Y-m-d");
   	
   	 $this->validate($request, [ 'regno' =>'required|string','transactionDate' =>'required|string','description' =>'required|string',],[ 'transactionDate.required' =>'You must Select Transaction date'],[ ]);
   	 if ($month !='' or $year !='')
   	 {
   	 $this->validate($request, [    
            'year' =>'required|string',
            'month' =>'required|string',
            'monthcontribution'=> 'required|string',
        ]);
   	 }
   	DB::table('tblachievetransaction')->insert(array(
		'regno'	    	=> $regno,
		'year'    	=> $year,
		'month'    	=> $month,
		'description'    => $description,
		'monthcontribution'	    => ($monthcontribution==null)? 0: $monthcontribution,
		'loanborrow'    	=>($loanborrow==null)? 0: $loanborrow,
		'loanrepay'    	=> ($loanrepay==null)? 0:$loanrepay,
		'loaninterest'    =>($loaninterest==null)? 0: $loaninterest,
		'interestrepay'	    	=>($interestrepay==null)? 0: $interestrepay,
		'divisionID'	    	=> 1,
		'transtype'  =>        1,
		'transaction_date'    	=> $tdate,
		'updatedby'    	=> Auth::user()->username,
		'date_updated'    => $r_date,
	));
	}
	$data['refregno'] = $request['refregno'];
   	$data['MemberTransactionReport'] = $this->MemberTransactionAchive($to,$from,$regno);
   	return view('TransactionComputation.archive', $data);

   }
   public function DataUpload(Request $request)
   {
       //Increase Memory Size
		ini_set('memory_limit', '-1');
		//
   	 $data['warning'] = '';
   	 $data['success'] = '' ;
   	
   	$date=Carbon::now()->format('Y-m-d');
   	  $i = 0;
   	  if ( isset( $_POST['upload'] ) ){
     	 $filename = $request->file('upload'); 
        $file = fopen($filename, "r");
        $headers = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
         {
         $check = DB::table('tblmembers')->where('regNo', '=', $emapData[0])->count();
         if($i == 0 ||$emapData[0]==''||$check >0){$i = 1;}else{ 
           $string = $emapData[1]; 
           $mid=$emapData[0];
           $fn=$emapData[1];
           $mn=$emapData[2];
           $ln=$emapData[3];
           $div=$emapData[4];
           $sb=$emapData[5];
           $lb=$emapData[6];
           $ib=$emapData[7];
           $mc=$emapData[11];
           $mlp=$emapData[9];
           $mip=$emapData[10];
           $divID=$this->GetDivID($div);
           $name=$fn.' '.$mn.' '.$ln;
           $disc='Opening Balance';
           $pwd = mt_rand(100000,999999); 
           $password = bcrypt($pwd);
           DB::table('tblmembers')->insert(
                      [ 
                      'regNo' => $mid,
                      'title' => '0',
                      'first_name' => $fn,
                      'middle_name' => $mn, 
                      'last_name' => $ln,
                      'phoneno' => '08032000000',
                      'email_address' => 'noeamail@email.com',
                      'state' => '0',
                      'lga' => '0',
                      'address' => 'NA' ,
                      'nextofkin' => 'NA', 
                      'gender' => '0',
                      'nextofkin_address'=> 'NA' ,
                      'nextofkin_phoneno' => '0805555', 
                      'branch' => $divID, 
                      'monthly_contribution' => $mc, 
                      'bankid' =>'1',
                      'account_no' => '000000' , 
                      'date_join' => $date,
                      'created_date' => Carbon::now(),
                      'createdby' => Auth::user()->username
                       ]
                       ); 
         DB::table('tbldefaultMonthlyContribution')->insert(['regno' => $mid, 
	         'monthly_contribution' => ($mc== null) ? 0 :$mc,
	         'loan_repay' => ($mlp== null) ? 0 :$mlp,
	         'interest_repay' => ($mip== null) ? 0 :$mip,
	       	 'last_updated_date' => Carbon::now(),
	       	 'last_updatedby' => Auth::user()->username]);
	       	 
           
                        
      
       	 
        DB::table('users')->insert(['name' => $name, 'username' => $mid,
       	 'role' => 18, 'email' => 'noeamail@email.com', 'password'=> $password,'created_at' => Carbon::now(),'updated_at' => Carbon::now(),]);
       	 DB::table('tbltransaction')->insert([
			  			'regno'	=> $mid,
			  			'divisionID' => $divID,
			  			'description'	=> $disc,
			  			'monthcontribution'	=> ($sb == null) ? 0 : $sb,
			  			'loanborrow' 		=> ($lb == null) ? 0 : $lb,
			  			'loaninterest'		=> ($ib == null) ? 0 : $ib,
			  			'loanrepay' 		=> 0,
			  			'interestrepay'		=> 0,
			  			'transaction_date'	=> $date,
			  			'updatedby'		=> Auth::user()->username,
			  			'date_updated'		=> date('Y-m-d'),
			  			'transtype'		=> 4,
			  			'year'			=> 'N/A',
			  			'month'			=> 'N/A'
			  		]);
              
             
             }
   	}
   	}
   	return view('TransactionComputation.memberupload', $data);

   }
   public function ContributionFromSalary(Request $request)
   {
       //Increase Memory Size
		ini_set('memory_limit', '-1');
		//
   	$data['warning'] = '';
   	$data['success'] = '' ;
   	$division = $request['division'];
   	 $data['division'] = $division ;
   	 $year= $request['year'];
   	 //$year= '2018';
   	 $data['year'] = $year;
   	 $month= $request['month'];
   	 //$month= 'September';
   	 $data['month'] = $month;
   	  if ( isset( $_POST['go'] ) ){
   	  $this->LoadPayrollContribution ($year,$month);
   	  }
   	$data['ViewSalaryContribution'] = $this->ViewSalaryContribution($year,$month,$division );
   	$data['Divisions'] = $this->DivisionList();
   	return view('TransactionComputation.salary', $data);

   }
    
}
