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

class BasicfunctionController extends ParentController
{
   	Public function DivisionList (){
		$data= DB::Select("SELECT * FROM `tbldivision`");
		return $data; 
	}
	Public function Salary_Deduction ($yr,$mnt,$fileno){
	    $amt=0;
		$data= DB::Select("SELECT * FROM `tblcontributionfromsalary` WHERE `year`='$yr' and `month`='$mnt' and `regno`='$fileno'");
		if($data)$amt=$data[0]->amount;
		return $amt; 
	}
	Public function GetDivID($div){
		$divid=0;
		$data= DB::Select("SELECT * FROM `tbldivision` WHERE `division`='$div'");
		if($data)
		   {
		 	$divid =$data[0]->ID;
		   }
		return $divid; 
	}
	Public function MonthlyDefault ($division,$year,$month){
	
	$qdivision=1;
	if ($division!=''){$qdivision="exists (SELECT null FROM `tblmembers` WHERE `tblmembers`.`regNo`=`tbldefaultMonthlyContribution`.`regno` and `tblmembers`.`branch`='$division')";}
	$nam= "(select CONCAT(`last_name`, ' ', `middle_name`, ' ',`first_name`) from tblmembers where tblmembers.regNo=`tbldefaultMonthlyContribution`.`regno`) as Names";
	
		$data= DB::Select("SELECT *, $nam,
		 (SELECT `division` FROM `tbldivision` WHERE exists (select  null  from tblmembers where tbldefaultMonthlyContribution.regno=tblmembers.regNo and tblmembers.branch= tbldivision.`ID` )) as division,
		 (SELECT `tblmembers`.`branch` FROM `tblmembers` WHERE `tblmembers`.`regNo`=`tbldefaultMonthlyContribution`.`regno`) as divisionID,
		(`monthly_contribution`+`loan_repay`+`interest_repay`) as totalPayment
		,(SELECT `amount` FROM `tblcontributionfromsalary` WHERE `month`='$month' and `year`='$year' and `tblcontributionfromsalary`.`regno`=tbldefaultMonthlyContribution.regno) as payrollcontribution 
		 FROM `tbldefaultMonthlyContribution` where $qdivision
		
		and exists(SELECT null FROM `tblmembers` WHERE `status`=1 and `tblmembers`.`regNo`=`tbldefaultMonthlyContribution`.`regno`)");
		return $data;
	}
	Public function MemberTransactionReport ($to,$from,$regno){
		$cbalsum =0;
		$lbalsum =0;
		$ibalsum =0;
		$initdata= DB::Select("SELECT sum(`monthcontribution`) as cbal, sum(`loanborrow`-`loanrepay` ) as lbal, sum(`loaninterest`-`interestrepay`) as ibal 
		FROM `tbltransaction` WHERE DATE_FORMAT(`transaction_date`,'%Y-%m-%d')<'$from' and regno='$regno' ");
		if($initdata)
		   {
		 	$cbalsum =$initdata[0]->cbal;
		 	$lbalsum =$initdata[0]->lbal;
		 	$ibalsum =$initdata[0]->ibal;
		   }
		$timedate= "(DATE_FORMAT(`transaction_date`,'%Y-%m-%d') BETWEEN '$from' AND '$to')";
		$data= DB::Select("SELECT *,(@cbalsum := @cbalsum +`monthcontribution`) as `cbal`,(@lbalsum := @lbalsum+`loanborrow` -`loanrepay`) as `lbal`,(@ibalsum := @ibalsum + `loaninterest` -`interestrepay`) as `ibal` 
		FROM `tbltransaction`  JOIN (SELECT @cbalsum := '$cbalsum') r ,(SELECT @lbalsum := '$lbalsum') y ,(SELECT @ibalsum := '$ibalsum') z WHERE $timedate and regno='$regno'
		order by DATE_FORMAT(`transaction_date`,'%Y-%m-%d') ,`ID`");
		return $data;
	}
	
  Public function MemberList(){
		$data= DB::Select ("SELECT *, CONCAT(`last_name`, ' ', `middle_name`, ' ',`first_name`) as Names FROM `tblmembers` WHERE 1 order by `regNo`");
		return $data;
	}
	Public function MemberBalance ($regno){
		$data= DB::Select("SELECT sum(`monthcontribution`) as cbal, sum(`loanborrow`-`loanrepay` ) as lbal, sum(`loaninterest`-`interestrepay`) as ibal 
		FROM `tbltransaction` WHERE  regno='$regno' ");
		if (!$data){$data= DB::Select("SELECT 0 as cbal, 0 as lbal, 0 as ibal"); }
		return $data[0];
	}
	
	Public function ConfirmperiodEntry($division,$year,$month){
	$qdivision=1;
	if ($division!=''){$qdivision="`divisionID`='$division'";}
		$confir= DB::Select("SELECT * FROM `tbltransaction` WHERE `year`='$year' and `month`='$month' and $qdivision");
		if(($confir)){return true;}else{return false;}
	}
	Public function DeleteperiodEntry($division,$year,$month){
	$qdivision=1;
	if ($division!=''){$qdivision="`divisionID`='$division'";}
	DB::DELETE ("DELETE FROM `tbltransaction` WHERE  $qdivision and `year`='$year' and `month`='$month'");
		
	}
	Public function MemberSummaryLists ($to,$division){
		$qdivision=1;
		if ($division!=''){$qdivision="`branch`='$division'";}
		$nam= "CONCAT(`last_name`, ' ', `middle_name`, ' ',`first_name`)  as Names";
		$data= DB::Select("SELECT *, $nam 
		,(SELECT `division` FROM `tbldivision` WHERE `tbldivision`.`ID`=`tblmembers`.`branch`) as Division
		,(SELECT sum(`monthcontribution`) FROM `tbltransaction` WHERE `tbltransaction`.`regno`=`tblmembers`.`regNo` and DATE_FORMAT(`transaction_date`,'%Y-%m-%d')<='$to') as CB
		,(SELECT sum(`loanborrow`-`loanrepay`) FROM `tbltransaction` WHERE `tbltransaction`.`regno`=`tblmembers`.`regNo` and DATE_FORMAT(`transaction_date`,'%Y-%m-%d')<='$to') as LCB
		,(SELECT sum(`loaninterest`-`interestrepay`) FROM `tbltransaction` WHERE `tbltransaction`.`regno`=`tblmembers`.`regNo` and DATE_FORMAT(`transaction_date`,'%Y-%m-%d')<='$to') as LIB
		FROM `tblmembers` WHERE $qdivision order by `branch` , `last_name`");
		return $data;
	}
	Public function TransactionReport ($year,$month,$division){
		$qdivision=1;
		if ($division!=''){$qdivision="`divisionID`='$division'";}
		$nam= "(select CONCAT(`last_name`, ' ', `middle_name`, ' ',`first_name`) from tblmembers where tblmembers.regNo=`tbltransaction`.regno ) as Names";
		$data= DB::Select("SELECT *, $nam 
		,(SELECT `division` FROM `tbldivision` WHERE `tbldivision`.`ID`=`tbltransaction`.divisionID) as Division 
		,(`monthcontribution`+`loanrepay`+`interestrepay`) as totalPayment 
		FROM `tbltransaction` WHERE $qdivision and `year`='$year' and `month`='$month'");
		return $data;
	}
	Public function MemberTransactionAchive ($to,$from,$regno){
		$cbalsum =0;
		$lbalsum =0;
		$ibalsum =0;
		$initdata= DB::Select("SELECT sum(`monthcontribution`) as cbal, sum(`loanborrow`-`loanrepay` ) as lbal, sum(`loaninterest`-`interestrepay`) as ibal 
		FROM `tblachievetransaction` WHERE DATE_FORMAT(`transaction_date`,'%Y-%m-%d')<'$from' and regno='$regno' ");
		if($initdata)
		   {
		 	$cbalsum =$initdata[0]->cbal;
		 	$lbalsum =$initdata[0]->lbal;
		 	$ibalsum =$initdata[0]->ibal;
		   }
		$timedate= "(DATE_FORMAT(`transaction_date`,'%Y-%m-%d') BETWEEN '$from' AND '$to')";
		$data= DB::Select("SELECT *,(@cbalsum := @cbalsum +`monthcontribution`) as `cbal`,(@lbalsum := @lbalsum+`loanborrow` -`loanrepay`) as `lbal`,(@ibalsum := @ibalsum + `loaninterest` -`interestrepay`) as `ibal` 
		FROM `tblachievetransaction`  JOIN (SELECT @cbalsum := '$cbalsum') r ,(SELECT @lbalsum := '$lbalsum') y ,(SELECT @ibalsum := '$ibalsum') z WHERE $timedate and regno='$regno'
		order by DATE_FORMAT(`transaction_date`,'%Y-%m-%d') ,`ID`");
		return $data;
	}
	Public function LoadPayrollContribution ($year,$month){
		$url= "http://convert.nicn.gov.ng/coopapi.php";
			$data1='{
			 "year" : "'.$year.'",
			 "month": "'.$month.'"
			}';
			  $ch = curl_init($url);
			  $headers = array('Content-Type: application/json');
			  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			  curl_setopt($ch, CURLOPT_POST, true);
			  curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_POST, 1); 
			  $result= curl_exec($ch);
			curl_close($ch);
		 $data= json_decode($result);
		 if ($data){DB::Select("DELETE FROM `tblcontributionfromsalary` WHERE `year`='$year' and `month`='$month'");}
		 foreach ($data as $b){
		 DB::table('tblcontributionfromsalary')->insert(array(
		'regno'	    	=> $b->fileNo,
		'year'    	=> $year,
		'month'    	=> $month,
		'amount'    => $b->nicnCoop,
		
	));
		 }
		 
		return null;
			
	}
	Public function ViewSalaryContribution($year,$month,$division ){
	$qd=1;
	if($division!='')$qd="tbldivision.ID='$division'";
	$data= DB::Select("SELECT tblcontributionfromsalary.*, CONCAT(`last_name`, ' ', `middle_name`, ' ',`first_name`) as Names,division 
        FROM `tblcontributionfromsalary` 
        left join tblmembers on tblmembers.regNo=tblcontributionfromsalary.regno 
        left join tbldivision on tbldivision.ID= tblmembers.branch=tblmembers.branch 
        where `year`='$year' and `month`='$month' and $qd order by regno");
		
		return $data;
	
	$nam= "(select CONCAT(`last_name`, ' ', `middle_name`, ' ',`first_name`) from tblmembers where tblmembers.regNo=`tblcontributionfromsalary`.regno ) as Names";
		$data= DB::Select("SELECT *, $nam
		,(SELECT `division` FROM `tbldivision` WHERE exists (select  null  from tblmembers where tblcontributionfromsalary.regno=tblmembers.regNo and tblmembers.branch= tbldivision.`ID` )) as division
		FROM `tblcontributionfromsalary` WHERE `year`='$year' and `month`='$month'");
		
		return $data; 
	}
  
}
