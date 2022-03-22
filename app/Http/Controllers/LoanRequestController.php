<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;
use Session;
//use mail;


class LoanRequestController extends Controller
{

    public function create()
    {
      
$data['guaran']='';
$data['guaran2'] ='';
      $fileNo = Auth::user()->username;
      $data['member'] = DB::table('tblmembers')
      ->join('tbldefaultMonthlyContribution','tbldefaultMonthlyContribution.regno','=','tblmembers.regNo')
      ->where('tblmembers.regNo','=',$fileNo)
      ->where('tbldefaultMonthlyContribution.regNo','=',$fileNo)
      ->select('*','tblmembers.regNo as fileNo','tblmembers.bankid as mybank','tblmembers.account_no as myAcctno')
      ->first();
      
       $data['depart'] = DB::table('tbldepartments')->get();
        $data['desig'] = DB::table('tbldesignation')->get();

     $divFlash = session::get('div');
     $divFlash2 = session::get('div2');

          if($divFlash !='')
          {
            $data['guaran'] = DB::table('tblmembers')->where('branch','=',$divFlash)->get();
            
          }
          if($divFlash2 !='')
          {
            $data['guaran2'] = DB::table('tblmembers')->where('branch','=',$divFlash2)->get();
          }

      $data['divisions'] = DB::table('tbldivision')->get();
      $data['banks'] = DB::table('tblbank')->get();
      return view('loanRequest/create',$data);
    }
    
    public function createLoanAdmin(Request $request)
    {
      
$data['guaran']='';
$data['guaran2'] ='';
      $fileNo = Auth::user()->username;
      $data['member'] = DB::table('tblmembers')
      ->join('tbldefaultMonthlyContribution','tbldefaultMonthlyContribution.regno','=','tblmembers.regNo')
      ->where('tblmembers.regNo','=',$fileNo)
      ->where('tbldefaultMonthlyContribution.regNo','=',$fileNo)
      ->select('*','tblmembers.regNo as fileNo','tblmembers.bankid as mybank','tblmembers.account_no as myAcctno')
      ->first();
      $data['users'] = DB::table('tblmembers')->orderBy('regNo')->get();

     $divFlash = session::get('div');
     $divFlash2 = session::get('div2');

          if($divFlash !='')
          {
            $data['guaran'] = DB::table('tblmembers')->where('branch','=',$divFlash)->get();
            
          }
          if($divFlash2 !='')
          {
            $data['guaran2'] = DB::table('tblmembers')->where('branch','=',$divFlash2)->get();
          }

      $data['divisions'] = DB::table('tbldivision')->get();
      $data['banks'] = DB::table('tblbank')->get();
      return view('loanRequest/addLoanRequestAdmin',$data);
    }

    public function store(Request $request)
    {

      $request ->session()->flash('div',$request['division']);
      $request ->session()->flash('div2',$request['division2']);
      $interest_rate = DB::table('tblinterestrate')
       ->select('rate')
       ->first();
      $this->validate($request, [
          'amount'                   => 'required|numeric|min:1',
          //'months'                 => 'required|numeric',
          //'guarantor'                => 'required',
         // 'guarantor2'               => 'required',
          'purpose'                  => 'required',
           'bank'                    => 'required|numeric',

          ]);

          //dd($request['loanMonthly']);

          $insertId = DB::table('tblloanrequest')->insertGetId(array(
              'regno'                 => $request['regNo'],
              'amount'                => $request['amount'],
              'period'                => $request['months'],
              'total_interest'        => $request['interest'],
              'loan_repay'            => $request['loanMonthlyRepay'],
              'interest_repay'        => $request['interestMonthly'],
              'account_no'            => $request['accountNumber'],
              'bankid'                => $request['bank'],
              'gaurantor'             => $request['guarantor'],
              'guarantor2'            => $request['guarantor2'],
              'department'             => $request['department'],
              'designation'            => $request['designation'],
              'purpose'               => $request['purpose'],
              'loan_rate'             => $interest_rate->rate,
              'last_updatedby'        => Auth::user()->username,
              'date_updated'          => date('Y-m-d'),
              'status'                => 1,
          ));


         return redirect("/loan-request/add")->with('msg','Successfully Submitted');
          //return redirect("/loan/bond/$insertId")->with('msg','Successfully Submitted');
    }
    
    public function storeLoan(Request $request)
    {

      $request ->session()->flash('div',$request['division']);
      $request ->session()->flash('div2',$request['division2']);
      $interest_rate = DB::table('tblinterestrate')
       ->select('rate')
       ->first();
      $this->validate($request, [
          'amount'                   => 'required|numeric|min:1',
          //'months'                 => 'required|numeric',
          //'guarantor'                => 'required',
          //'guarantor2'               => 'required',
          'purpose'                  => 'required',
           'bank'                    => 'required|numeric',

          ]);

          //dd($request['loanMonthly']);

          $insertId = DB::table('tblloanrequest')->insertGetId(array(
              'regno'                 => $request['regNo'],
              'amount'                => $request['amount'],
              'period'                => $request['months'],
              'total_interest'        => $request['interest'],
              'loan_repay'            => $request['loanMonthlyRepay'],
              'interest_repay'        => $request['interestMonthly'],
              'account_no'            => $request['accountNumber'],
              'bankid'                => $request['bank'],
              'gaurantor'             => $request['guarantor'],
              'guarantor2'            => $request['guarantor2'],
              'department'             => $request['department'],
              'designation'            => $request['designation'],
              'purpose'               => $request['purpose'],
              'loan_rate'             => $interest_rate->rate,
              'last_updatedby'        => Auth::user()->username,
              'date_updated'          => date('Y-m-d'),
              'status'                => 1,
          ));


         
          //return redirect("/loan/bond/$insertId")->with('msg','Successfully Submitted');
          return redirect("/loan-request/add")->with('msg','Successfully Submitted');
    }
    
    public function interest(Request $request)
    {
       $amount = $request['amt'];
        $contribution = $request['contribution'];
       $interest_rate = DB::table('tblinterestrate')
       ->select('rate')
       ->first();
      //$total =  $amount * $interest_rate->rate/100;
      
      $month = 12;
      $monthly_repay = $amount/$month;
       $interest = $amount * $interest_rate->rate/100;
      $monthly_interest = $interest/$month;
      $totalMonthly_repay = $monthly_repay + $monthly_interest;
      $total_monthly = $monthly_repay + $monthly_interest + $contribution;
      //$total->header('Content-Type', 'text/plain');
       $total = array('monthly_loan'=>number_format((float)$monthly_repay, 2, '.', ''),'total_interest'=>number_format((float)$interest, 2, '.', ''),'monthly_interest'=>number_format((float)$monthly_interest, 2, '.', ''),'monthly_repay'=>number_format((float)$totalMonthly_repay, 2, '.', ''),'total'=>number_format((float)$total_monthly, 2, '.', '') );
       

      
       return response()->json($total);
    }
    
    public function members(Request $request)
    {
       $division = $request['division'];
       $no = Auth::user()->username;
       $members = DB::table('tblmembers')->where('branch','=',$division)->where('regNo','!=',$no)->get();
       return response()->json($members);
    }
    public function monthly_repay(Request $request)
    {

       $month = $request['months'];
       $amount = $request['amount'];
       $contribution = $request['contribution'];

       $interest_rate = DB::table('tblinterestrate')
       ->select('rate')
       ->first();

       $monthly_repay = $amount/$month;
       $interest = $amount * $interest_rate->rate/100;
      $monthly_interest = $interest/$month;
      $totalMonthly_repay = $monthly_repay + $monthly_interest;
      $total_monthly = $monthly_repay + $monthly_interest + $contribution;
       $total = array('monthly_loan'=>number_format((float)$monthly_repay, 2, '.', ''),'monthly_interest'=>number_format((float)$monthly_interest, 2, '.', ''),'monthly_repay'=>number_format((float)$totalMonthly_repay, 2, '.', ''),'total'=>number_format((float)$total_monthly, 2, '.', '') );
       return response()->json($total);
    }



    public function myRequest()
    {
      $fileNo = Auth::user()->username;
       //$staff = DB::table('tblmembers')->where('regno','=',$fileNo)->first;
        $data['myrequest'] = DB::table('tblloanrequest')
        ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
        ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
        ->select('*','tblloanrequest.ID as loanID')
        ->where('tblloanrequest.regNo','=',$fileNo)->get();
        $mem = DB::table('tblloanrequest')->where('regno','=',$fileNo)->first();
         if(!is_null($mem))
{
        $data['guarantor'] = DB::table('tblmembers')->where('regno','=',$mem->gaurantor)->first();
}
        return view('loanRequest/myRequest',$data);
    }

    public function editmyRequest($id)
    {
      $data['guaran'] ='';
      $data['guaran2'] ='';
      $fileNo = Auth::user()->username;
        $data['myrequest'] = DB::table('tblloanrequest')
        ->where('ID','=',$id)->first();

        $interest_rate = DB::table('tblinterestrate')
        ->select('rate')
        ->first();

         $divFlash = session::get('div');
        $divFlash2 = session::get('div2');
        
         $data['depart'] = DB::table('tbldepartments')->get();
        $data['desig'] = DB::table('tbldesignation')->get();

          if($divFlash !='')
          {
            $data['guaran'] = DB::table('tblmembers')->where('branch','=',$divFlash)->get();
            
          }
          if($divFlash2 !='')
          {
            $data['guaran2'] = DB::table('tblmembers')->where('branch','=',$divFlash2)->get();
          }

        $data['requestID'] = $id;

        $contribution = DB::table('tbldefaultMonthlyContribution')->where('regno','=',$data['myrequest']->regno)->first();

        $data['loanInterest'] = $data['myrequest']->amount * $interest_rate->rate/100;

        $data['totalMonthly_repay'] = $data['myrequest']->loan_repay + $data['myrequest']->interest_repay;
        $data['total_monthly'] = $data['myrequest']->loan_repay + $data['myrequest']->interest_repay + $contribution->monthly_contribution;

        $data['member'] = DB::table('tblmembers')
        ->join('tbldefaultMonthlyContribution','tbldefaultMonthlyContribution.regNo','=','tblmembers.regNo')
        ->where('tblmembers.regNo','=',$fileNo)
        ->where('tbldefaultMonthlyContribution.regNo','=',$fileNo)
        ->first();
        $data['divisions'] = DB::table('tbldivision')->get();
        $data['guaran'] = DB::table('tblmembers')
        ->where('regNo','=',$data['myrequest']->gaurantor)
        ->first();
       $data['guaran2'] = DB::table('tblmembers')
        ->where('regNo','=',$data['myrequest']->guarantor2)
        ->first();
        $data['divisions'] = DB::table('tbldivision')->get();
        $data['banks'] = DB::table('tblbank')->get();
        return view('loanRequest/editRequest',$data);
    }

    public function update(Request $request)
    {
      $this->validate($request, [
          'amount'                 => 'required|numeric|min:1',
          //'months'                 => 'required|numeric',

          ]);
         $id = $request['loanId'];
         

          DB::table('tblloanrequest')->where('ID','=',$request['loanId'])->update(array(
              'amount'                => $request['amount'],
              'period'                => $request['months'],
              'total_interest'        => $request['interest'],
              'loan_repay'            => $request['loanMonthlyRepay'],
              'interest_repay'        => $request['interestMonthly'],
              'account_no'            => $request['accountNumber'],
              'bankid'                => $request['bank'],
              'gaurantor'             => $request['guarantor'],
              'guarantor2'            => $request['guarantor2'],
              'department'             => $request['department'],
              'designation'            => $request['designation'],
              'purpose'               => $request['purpose'],
              'last_updatedby'        => Auth::user()->username,
              'date_updated'          => date('Y-m-d'),
              'status'                => 1,
              'approval_status'       => 0,
          ));
          return redirect("/my-request/edit/$id")->with('msg','Successfully Updated');
    }

    public function destroy($id)
    {
        //
    }

    public function viewLoanRequest()
    {
      $fileNo = Auth::user()->username;
      $data['allrequest'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->where('tblloanrequest.approval_status', '=',0)
      //->where('tblloanrequest.approval_status', '=',1)
      //->orWhere('tblloanrequest.approval_status', '=',3)
      //->orWhere('tblloanrequest.approval_status', '=',2)
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
       ->orderBy('tblloanrequest.ID','DESC')
      ->orderBy('tblloanrequest.approval_status')
     
      ->paginate(25);
      $mem = DB::table('tblloanrequest')->where('regNo','=',$fileNo)->first();
      foreach($data['allrequest'] as $g)
      {

      }
      return view('loanRequest/allRequestBulk',$data);
    }

    public function loanDetails(Request $request)
    {
      $id = $request['id'];
      $fileNo = Auth::user()->username;
      $myrequest = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regno')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->where('tblloanrequest.ID','=',$id)->first();
            return response()->json($myrequest );
    }

    public function guarantorDetails(Request $request)
    {
      $id = $request['id'];
      $mem = DB::table('tblloanrequest')->where('ID','=',$id)->first();
      $guarantor = DB::table('tblmembers')->where('regno','=',$mem->gaurantor)->first();
       return response()->json($guarantor );
    }

    public function approval(Request $request)
    {
      $id = $request['id'];
      $date = date('Y-m-d', strtotime(trim($request['date'])));
      
      $approve =  DB::table('tblloanrequest')->where('ID','=',$id)->update(array(
          'approval_status'        => 1,
          'approved_date'   => $date,
      ));

      
      $d = DB::table('tblloanrequest')->where('ID','=',$id)->first();
       $g = DB::table('tbldefaultMonthlyContribution')->where('regno','=',$d->regno)->first();
      DB::table('tbldefaultMonthlyContribution')->where('regno','=',$d->regno)->update(array(
          'loan_repay'            => $d->loan_repay + $g->loan_repay,
          'interest_repay'        => $d->interest_repay + $g->interest_repay,
      ));
      
      $div = DB::table('tblmembers')->where('regNo','=',$d->regno)->first();
      
      DB::table('tbltransaction')->insert(array(
          
          'loaninterest'          => $d->total_interest,
          'divisionID'            => $div->branch,
          'regno'                 => $d->regno,
          'loanborrow'            => $d->amount,
          'transaction_date'       => $date,
          'date_updated'          => date('Y-m-d'),
          'transtype'             => 3,
          'updatedby'             => Auth::user()->username,
          'interestrepay'         => 0,
          'description'           => "Loan Approval",
          'monthcontribution'     => $g->monthly_contribution,
          'loanrepay'             =>0,
          'year'                  =>'NA',
          'month'                 => 'NA',
      ));
       return response()->json("successfull");
    }
    
     public function viewLoanRequestBulk()
    {
      $fileNo = Auth::user()->username;
      $data['allrequest'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->where('tblloanrequest.approval_status', '=',0)
      //->where('tblloanrequest.approval_status', '=',1)
      //->orWhere('tblloanrequest.approval_status', '=',3)
      //->orWhere('tblloanrequest.approval_status', '=',2)
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
       ->orderBy('tblloanrequest.ID','DESC')
      ->orderBy('tblloanrequest.approval_status')
     
      ->paginate(25);
      $mem = DB::table('tblloanrequest')->where('regNo','=',$fileNo)->first();
      foreach($data['allrequest'] as $g)
      {

      }
      return view('loanRequest/allRequestBulk',$data);
    }
    
     public function approvalBulk(Request $request)
    {
      $id = $request['id'];
      $date = date('Y-m-d', strtotime(trim($request['date'])));
      
      foreach($id as $key => $value)
      {
        $date1 = date('Y-m-d', strtotime(trim($request['date'])));  
      $approve =  DB::table('tblloanrequest')->where('ID','=',$request['id'][$key])->update(array(
          'approval_status'        => 1,
          'approved_date'   => $date1,
      ));

      
      $d = DB::table('tblloanrequest')->where('ID','=',$request['id'][$key])->first();
       $g = DB::table('tbldefaultMonthlyContribution')->where('regno','=',$d->regno)->first();
      DB::table('tbldefaultMonthlyContribution')->where('regno','=',$d->regno)->update(array(
          'loan_repay'            => $d->loan_repay + $g->loan_repay,
          'interest_repay'        => $d->interest_repay + $g->interest_repay,
      ));
      
      $div = DB::table('tblmembers')->where('regNo','=',$d->regno)->first();
      
      DB::table('tbltransaction')->insert(array(
          
          'loaninterest'          => $d->total_interest,
          'divisionID'            => $div->branch,
          'regno'                 => $d->regno,
          'loanborrow'            => $d->amount,
          'transaction_date'       => $date1,
          'date_updated'          => date('Y-m-d'),
          'transtype'             => 3,
          'updatedby'             => Auth::user()->username,
          'interestrepay'         => 0,
          'description'           => "Loan Approval",
          'monthcontribution'     => $g->monthly_contribution,
          'loanrepay'             =>0,
          'year'                  =>'NA',
          'month'                 => 'NA',
      ));
       
      }
      return redirect('/loan-requests/bulk-list')->with('msg','Successfully Approved');
    }
    
    public function reject(Request $request)
    {
      $id = $request['id'];
      $reason = $request['reason'];
      $approve =  DB::table('tblloanrequest')->where('ID','=',$id)->update(array(
          'approval_status'           => 2,
          'reject_reason'             => $reason,
          'approved_date'   => date('Y-m-d H:i:s'),
      ));
      return back()->with('msg','Successfully Rejected');
    }

      public function guarantorAcceptance($code)
    {
      $fileNo = Auth::user()->username;
       //$staff = DB::table('tblmembers')->where('regno','=',$fileNo)->first;
        $data['myrequest'] = DB::table('tblloanrequest')
        ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
        ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
        ->select('*','tblloanrequest.ID as loanID')
        ->where('tblloanrequest.regNo','=',$fileNo)->get();
      return view('loanRequest/guarantorAcceptance',$data);
    }

   public function bond($id=null)
    {
      $data['loan'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tbldivision','tbldivision.ID','=','tblmembers.branch')
      ->where('tblloanrequest.ID','=',$id)->first();

      return view('loanRequest/loanBond',$data);
    }

public function loanHistory()
    {
      $y = date('Y');
      $date1 = "$y-01-01";
      $date2 = "$y-12-31";
      $d1 = session::get('fromDate');
      $d2 = session::get('toDate');
      if($d1 == '' && $d2 =='')
      {
      $data['allrequest'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->where('tblloanrequest.approval_status','=',1)
      ->whereBetween('tblloanrequest.date_updated',[$date1,$date2])
      ->paginate(50);
      $data['sum'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->where('tblloanrequest.approval_status','=',1)
      ->whereBetween('tblloanrequest.date_updated',[$date1,$date2])
      ->sum('amount');
      return view('loanRequest/loanCollectionHistory',$data);
    }
    else {
      $data['allrequest'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->where('tblloanrequest.approval_status','=',1)
      ->whereBetween('tblloanrequest.date_updated',[$d1,$d2])
      ->paginate(50);
      $data['sum'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->where('tblloanrequest.approval_status','=',1)
      ->whereBetween('tblloanrequest.date_updated',[$d1,$d2])
      ->sum('amount');
      return view('loanRequest/loanCollectionHistory',$data);
    }
    }

    public function searchHistory(Request $request)
    {
      $request ->session()->flash('fromDate',$request['dateFrom']);
      $request ->session()->flash('toDate',$request['dateTo']);

      $y = date('Y');
     // $date1 = $request['dateFrom'];
      //$date2 = $request['dateTo'];
       $date1 = date('Y-m-d', strtotime(trim($request['dateFrom'])));
      $date2 = date('Y-m-d', strtotime(trim($request['dateTo'])));
      $data['allrequest'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->where('tblloanrequest.approval_status','=',1)
      ->whereBetween('tblloanrequest.date_updated',[$date1,$date2])
      ->paginate(50);
       $data['sum'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->where('tblloanrequest.approval_status','=',1)
      ->whereBetween('tblloanrequest.date_updated',[$date1,$date2])
      ->sum('amount');
      return view('loanRequest/loanCollectionHistory',$data);
    }
    
     public function userDetails(Request $request)
    {
       $user = $request['users'];
       //$no = $fileNo = Auth::user()->username;
       $u= DB::table('tblmembers')
       ->join('tblbank','tblbank.ID','=','tblmembers.bankid')
       ->join('tbldefaultMonthlyContribution','tbldefaultMonthlyContribution.regno','=','tblmembers.regNo')
       ->where('tblmembers.regNo','=',$user)
       ->select('*','tblbank.ID as bankID')
       ->get();
       return response()->json($u);
    }
    
     public function print($id)
    {
      $data['desig'] = DB::table('tblloanrequest')
      ->join('tbldesignation','tbldesignation.Id', '=', 'tblloanrequest.designation')
     ->select('tbldesignation.designation')
      ->where('tblloanrequest.regno', '=',$id)->first();
      
       $data['depart'] = DB::table('tblloanrequest')
      ->join('tbldepartments','tbldepartments.Id', '=', 'tblloanrequest.department')
      ->where('tblloanrequest.regno', '=',$id)->first();
      
     $data['name'] = DB::table('tblmembers')
      ->join('tbldivision','tbldivision.ID', '=', 'tblmembers.branch')
      ->where('regNo', '=',$id)->first();
      
     $data['deduction'] = DB::table('tbldefaultMonthlyContribution')->where('regno', '=',$id)->first();
     
     
      return view('loanRequest.print',$data);
    }
    
      public function secretaryView()
    {
      $fileNo = Auth::user()->username;
      $data['allrequest'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      ->where('approval_status', '=',0)
      ->orWhere('approval_status', '=',5)
      //->orWhere('approval_status', '=',1)
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->orderBy('tblloanrequest.approval_status')
      ->paginate(25);
      $mem = DB::table('tblloanrequest')->where('regNo','=',$fileNo)->first();
      
      return view('loanRequest/secretaryView',$data);
    }
    
     public function pushTo(Request $request)
    {
       $id = $request['id'];
       $from= $request['moveTo'];
       if($from =='secretary')
       {
       $move = 4;
       $success = "Successfully Transfered to Treasurer";
       }
       elseif($from =='treasurer')
       {
       $move = 3;
        $success = "Successfully Transfered to President";
       }
       //$no = $fileNo = Auth::user()->username;
      DB::table('tblloanrequest')->where('ID','=',$id)
      ->update(array(
              
              'approval_status'       => $move,
          ));
      
      
       return response()->json($success);
    }
    
      public function treasurerView()
    {
      $fileNo = Auth::user()->username;
      $data['allrequest'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
      //->where('approval_status', '=',1)
      ->orWhere('approval_status', '=',4)
      ->select('*','tblloanrequest.ID as loanID','tblloanrequest.account_no as account_num')
      ->orderBy('tblloanrequest.approval_status')
      ->paginate(25);
      $mem = DB::table('tblloanrequest')->where('regNo','=',$fileNo)->first();
      
      return view('loanRequest/treasurerView',$data);
    }
    
     public function autocomplete(Request $request)
  {
    $query = $request->input('query');
    $search = DB::table('tblmembers')->where('last_name', 'LIKE', '%'.$query.'%')
    ->orWhere('first_name', 'LIKE', '%'.$query.'%')
    ->orWhere('middle_name', 'LIKE', '%'.$query.'%')
    ->orWhere('regNo', 'LIKE','%'.$query.'%')
    ->take(50)
    ->get();
    $return_array = null;
    foreach($search as $s)
    {
      $return_array[]  =  ["value"=>$s->last_name.' '.$s->first_name.' '.$s->middle_name.' - '.$s->regNo, "data"=>$s->regNo];
    }	
    return response()->json(array("suggestions"=>$return_array));
  }
  
  public function updateDate(Request $request)
    {
      $id = $request['id'];
      $date = date('Y-m-d', strtotime(trim($request['date'])));
      
      $approve =  DB::table('tblloanrequest')->where('ID','=',$id)->update(array(
         // 'approval_status'        => 1,
          'approved_date'   => $date,
      ));

      DB::table('tbltransaction')->where('ID','=',$id)->update(array(
          'transaction_date'       => $date,
      ));
      
       return response()->json("successfull");
    }




}
