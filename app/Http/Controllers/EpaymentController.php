<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;
use Session;

class EpaymentController extends Controller
{
    public function index()
    {
        $data['epay'] = DB::table('tblepayment')
        ->where('batch','=',session('batchNo'))
        ->get();
        $data['sum'] = DB::table('tblepayment')
        ->where('batch','=',session('batchNo'))
        ->sum('amount');
        return view('epayment/listepayment',$data);
    }

    public function allApprovedLoans()
    {
      $data['report'] = DB::table('tblloanrequest')
      ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
      ->join('tbldivision','tbldivision.id','=','tblmembers.branch')
      ->select('*','tblloanrequest.account_no as acctNo','tblloanrequest.ID as loanID')
      ->where('tblloanrequest.approval_status','=',1)
      ->where('tblloanrequest.payment_generated','=',0)
      ->where('tblloanrequest.payment_confirmation','=',0)
      ->get();
      return view('epayment/loanRequestApproved',$data);
    }

    Public function NewBatchNo(){

    $myData= DB::Select("SELECT max(`batch`) as BTN FROM `tblepayment`");
    //return $myData[0]->BTN;
    if($myData[0]->BTN ==''){
    return 'BTN00000001';
    }

    $BTN1 =$myData[0]->BTN;
    $arr = explode("BTN", $BTN1);

    $newcode=$arr[1]+1;
    while(strlen($newcode)<8)
     {
        $newcode="0".$newcode;
     }
    return 'BTN'.$newcode;
    }

    public function updateSelected(Request $request)
   {

       $ch          = $request['checkname'];
       $id             = $request['id'];
     if($ch == '')
     {
       return back()->with('err','Please, Select at least one item');
     }
        foreach ($ch as $key=>$value) {
         DB::table('tblloanrequest')
         ->where('ID','=',$ch[$key])
         ->update(array(
           'payment_generated'          =>1,

           'payment_generated_date'     => date('Y-m-d'),

          ));

     }
         return redirect('/payment/generated');

   }

   public function paymentGenerated()
   {
     $data['epay'] = DB::table('tblloanrequest')
     ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
     ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
     ->join('tbldivision','tbldivision.id','=','tblmembers.branch')
     ->select('*','tblloanrequest.account_no as acctNo','tblloanrequest.ID as loanID')
     ->where('.tblloanrequest.approval_status','=',1)
     ->where('tblloanrequest.payment_generated','=',1)
     ->where('tblloanrequest.payment_confirmation','=',0)
     ->get();
     $data['sum'] = DB::table('tblloanrequest')
     ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
     ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
     ->where('approval_status','=',1)
     ->where('tblloanrequest.payment_generated','=',1)
     ->where('tblloanrequest.payment_confirmation','=',0)
     ->sum('tblloanrequest.amount');
     return view('epayment/generated', $data);
   }

   public function payRestore()
   {
        $data['to_restore'] = DB::table('tblloanrequest')
        ->join('tblmembers','tblmembers.regNo','=','tblloanrequest.regNo')
        ->join('tblbank','tblbank.ID','=','tblloanrequest.bankid')
        ->select('*','tblloanrequest.account_no as acctNo','tblloanrequest.ID as loanID')
        ->where('.tblloanrequest.approval_status','=',1)
        ->where('tblloanrequest.payment_generated','=',1)
        ->where('tblloanrequest.payment_confirmation','=',0)
        ->get();
         return view('epayment/restore',$data);

   }

   public function postRestore(Request $request)
    {
       $btn = $request['submit'];
       if($btn == 'Restore')
       {
          $ch          = $request['checkname'];
          if($ch == '')
          {
            return back()->with('err','Please, Select at least one item');
          }
         foreach ($ch as $key=>$value) {
          DB::table('tblloanRequest')
          ->where('ID','=',$ch[$key])
          ->update(array(
            'payment_generated'          =>0,
            'payment_generated_date'     => date('Y-m-d'),

           ));
      }

      return redirect('/epayment/restore');
    }
    elseif ($btn == 'Confirm') {
     $ch          = $request['checkname'];
     if($ch == '')
     {
       return back()->with('err','Please, Select at least one item');
     }
         foreach ($ch as $key=>$value) {
          DB::table('tblloanrequest')
          ->where('ID','=',$ch[$key])
          ->update(array(
            'pay_confirmation'   => 1,

           ));

          }
          $batch1=$this->NewBatchNo();
          foreach ($ch as $key=>$value) {
           DB::table('tblloanrequest')
           ->where('ID','=',$ch[$key])
           ->update(array(
             'payment_generated'          =>0,

             'payment_generated_date'     => date('Y-m-d'),

            ));
       }


      Session::put('batchNo',  $batch1);
      return redirect('/epayment/restore');

    }

    }


    public function confirm(Request $request)
    {
         $ch          = $request['checkname'];

         foreach ($ch as $key=>$value) {
          DB::table('tblloanrequest')
          ->where('ID','=',$ch[$key])
          ->update(array(
            'payment_confirmation'   => 1,

           ));

          }
          $batch1=$this->NewBatchNo();

          foreach ($ch as $key=>$value) {

           DB::table('tblepayment')
          ->insert(array(
            'loanID'   => $ch[$key],
            'beneficiary'      => $request['beneficiary'][$key],
            'amount'          => $request['amount'][$key],
            'accountNo'       => $request['accountNo'][$key],
            'bank'            => $request['bank'][$key],
            'date_generated'            => date('Y-m-d'),
            'batch'           => $batch1,
           ));
          }

      Session::put('batchNo',  $batch1);
      return redirect('/epayment');

    }


    public function export()
    {
      $results = DB::table('tblepayment')
    ->where('batch','=',session('batchNo'))
      ->get();
      $date = date('Y-m-d');
      $filename = "epayment".$date.".csv";

        $fp = fopen($filename,"w");
        $seperator = "";
        $comma = "";

        $seperator .= 'BENEFICIARY, AMOUNT, ACCOUNT NO, BANK';
        $seperator .= "\n";
        fputs($fp,$seperator);

        if($results != "")
        {
        $seperator = "";
        $comma = "";

        foreach ($results as $val){
            //$name = str_replace( ',', '', $val->name );
        //$name = $val->first_name.' '.$val->middle_name.' '.$val->last_name;
        $value1 = array($val->beneficiary, $val->amount, $val->accountNo, $val->bank);
        $value = implode(",",$value1);
        //$seperator .= $comma . '' .str_replace("", '""', $value);
        $seperator .= $value."\n";

        $comma = ",";
        }

        $seperator .= "\n";
        fputs($fp, $seperator);
        }

        fclose($fp);


        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=$filename");
        readfile($filename);

    }

    

    public function viewBatch()
   {
     $data['allPayments'] = DB::select("select ID,batch,beneficiary,amount, sum(`amount`) as sum from tblepayment where date_generated >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) group by batch, ID, beneficiary, amount");
            /* $currentMonth = date('m');
             $data['allPayments'] = DB::table("tblepayment")
            ->whereRaw('MONTH(date_generated) = ?',[$currentMonth])
            ->groupBy('batch')
            ->get();*/
     return view('epayment/batch',$data);
   }
   public function epaymentBatch($batch)
   {
     $data['viewBatch'] = DB::table('tblepayment')->where('batch','=',$batch)->get();
     $data['sum'] = DB::table('tblepayment')->where('batch','=',$batch)->sum('amount');
     $data['current_batch'] = $batch;
     return view('epayment/batchEpayment',$data);
   }

   public function postBatch(Request $request)
    {
       // $fromdate            = date('Y-m-d', strtotime(trim($request['dateFrom'])));
         //$todate              = date('Y-m-d', strtotime(trim($request['dateTo'])));
         $data['current_batch'] = "";
         $fromdate            = $request['dateFrom'];
         $todate              = $request['dateTo'];


         $batch = $request['batch'];
         $data['batch'] = DB::table('tblepayment')->select('ID','batch','beneficiary','amount')->groupBy('batch')->get();
         /*$data['audited'] = DB::table('tblepayment')
         ->where('batch','=',$batch)
         ->get();*/
          if($fromdate !='')
          {
         Session::put('from',  $fromdate);
         }
         Session::put('to',    $todate);
         if($fromdate == '')
         {
          $data['allPayments'] = DB::table('tblepayment')
         ->where('date_generated', $todate)
         ->groupBy('batch')
          ->selectRaw('*, sum(amount) as sum')
         ->get();

         return view('epayment/batch',$data);

         }
         else
         {
         $data['allPayments'] = DB::table('tblepayment')
         ->whereBetween('date_generated', [$fromdate, $todate])
         ->groupBy('batch')
         ->selectRaw('*, sum(amount) as sum')
         ->get();

         return view('epayment/batch',$data);
        }
    }




}
