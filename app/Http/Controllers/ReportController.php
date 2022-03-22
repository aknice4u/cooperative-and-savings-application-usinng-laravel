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

class ReportController extends BasicfunctionController 
{
   public function MonthlyContribution(Request $request)
   {
   	 $data['warning'] = '';
   	 $data['success'] = '' ;
   	 $to= $request['to'];
   	if($to==null){$to= Carbon::now()->format('Y-m-d');}
   	$data['to'] = $to;
   	 $division = $request['division'];
   	 $data['division'] = $division ;
   	 $year= $request['year'];
   	 
   	 $data['year'] = $year;
   	 $month= $request['month'];
   	 
   	 $data['month'] = $month;
   	 $data['Divisions'] = $this->DivisionList();
   	 if ( isset( $_POST['modify'] ) ) {
   	$contribution= $request['contribution'];
   	$loanrepayment= $request['loanrepayment'];
   	$intrepayment= $request['intrepayment'];
   	$regno= $request['regno'];
   	//Die("UPDATE `tbltransaction` SET `monthcontribution`='$contribution',`loanrepay`='$loanrepayment',`interestrepay`='$intrepayment' where`ID`='$regno'");
   	  DB::Update("UPDATE `tbltransaction` SET `monthcontribution`='$contribution',`loanrepay`='$loanrepayment',`interestrepay`='$intrepayment' where`ID`='$regno'");
   	  $data['success'] = "Contribution adjustment successfully updated!";
   	}
   	$data['TransactionReport'] = $this->TransactionReport($year,$month,$division);
   	return view('Reports.contributionreport', $data);

   }
   
   public function MemberReport(Request $request)
   {
   	$to= $request['to'];
   	if($to==null){$to= Carbon::now()->format('Y-m-d');}
   	$data['to'] = $to;
   	$from= $request['from'];
   	if($from==null){$from= Carbon::now()->subYear()->format('Y-m-d');    }
   	$data['from'] = $from;
   	$regno= $request['regno'];
   	$data['regno'] = $regno;  	
   	$data['MemberList'] = $this->MemberList(); 
   	$data['MemberTransactionReport'] = $this->MemberTransactionReport($to,$from,$regno);
   	return view('TransactionComputation.memberreport', $data);

   }
   public function MemberSummaryList(Request $request)
   {
       	ini_set('memory_limit', '-1');
   	 $data['warning'] = '';
   	 $data['success'] = '' ;
   	$to= $request['to'];
   	if($to==null){$to= Carbon::now()->format('Y-m-d');}
   	$data['to'] = $to;
   	$from= $request['from'];
   	if($from==null){$from= Carbon::now()->subYear()->format('Y-m-d');    }
   	$data['from'] = $from;
   	$division= $request['division'];
   	$data['division'] = $division;  	
   	$data['MemberList'] = $this->MemberList(); 
   	$data['MemberSummaryLists'] = $this->MemberSummaryLists ($to,$division);
   	$data['Divisions'] = $this->DivisionList();
   	return view('Reports.memberbalance', $data);

   }
   public function MemberReportself(Request $request)
   {
   	 $data['warning'] = '';
   	 $data['success'] = '' ;
   	$to= $request['to'];
   	if($to==null){$to= Carbon::now()->format('Y-m-d');}
   	$data['to'] = $to;
   	$from= $request['from'];
   	if($from==null){$from= Carbon::now()->subYear()->format('Y-m-d');    }
   	$data['from'] = $from;
   	$regno= Auth::user()->username;
   	$data['regno'] = $regno;  	
   	$data['MemberTransactionReport'] = $this->MemberTransactionReport($to,$from,$regno);
   	return view('Reports.memberreportself', $data);

   }
    public function ArciveReportself(Request $request)
   {
    	$data['warning'] = '';
   	 $data['success'] = '' ;
   	$to= $request['to'];
   	if($to==null){$to= Carbon::now()->format('Y-m-d');}
   	$data['to'] = $to;
   	$from= $request['from'];
   	if($from==null){$from= Carbon::now()->subYear()->format('Y-m-d');    }
   	$data['from'] = $from;
   	$regno= Auth::user()->username;
   	$data['regno'] = $regno; 
   	$data['refregno'] = $request['refregno'];
   	$data['MemberTransactionReport'] = $this->MemberTransactionAchive($to,$from,$regno);
   	return view('Reports.archiveself', $data);

   }
    
}
