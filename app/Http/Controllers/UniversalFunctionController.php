<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use App\Models\ToDoList;
use App\Models\BankDetails;
use Carbon\Carbon;
use Session;
use Auth;
use Schema;
use DB;

class UniversalFunctionController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }



    ////////////////START UNIVERSAL FUNCTIONS///////////////////////////

    //UPLOAD & INSERT FUNCTION to upload any image file with 8 parameters 
    public function uploadAnyFile($tableName, $fileNameField, $captionField, $caption, $subCaptionField, $subCaption, $path, $file)
    {
        $data['message']     = "Sorry, we cannot upload this file. Attach the right file and try again.";
        $data['messageCode'] = 0;
        $data['recordID']    = 0;

        if((($file) && ($file != Null || $file != "")))
        {
            $originalExtension      = $file->getClientOriginalExtension();
            $imageNewName           = date('Y-m-d-h-i-sa-'). rand() . '.' .$originalExtension;
            $path                   = base_path() . '/' . $path;
            $updated_at             = date('Y-m-d');
            //start moving file
            if(Schema::hasTable($tableName) and $fileNameField != null and $captionField !=null)
            {
                if($file->move($path , $imageNewName))
                {
                    if((!empty($captionField) and empty($subCaptionField)) or (($captionField != null) and ($subCaptionField == null)))
                    {
                        $recordID = DB::table($tableName)->insert(
                            array( 
                                $fileNameField   => $imageNewName,
                                $captionField    => $caption,
                                //'updated_at'     => $updated_at
                        ));
                    }
                    else if((!empty($captionField) and !empty($subCaptionField)) or (($captionField != null) and ($subCaptionField != null)))
                    {
                        $recordID = DB::table($tableName)->insert(
                        array( 
                            $fileNameField       => $imageNewName,
                            $captionField        => $caption,
                            $subCaptionField     => $subCaption,
                            //'updated_at'         => $updated_at
                        )); 
                    }else{
                       $recordID = DB::table($tableName)->insert(
                        array( 
                            $fileNameField       => $imageNewName,
                            //'updated_at'         => $updated_at
                        )); 
                    }
                  if($recordID)
                  {
                    //Success
                    $data['message']     = "Success, Your file has been uploaded Successfully";
                    $data['messageCode'] = 1;
                    $data['recordID']    = $recordID;
                    //$this->addLog('File Successfully uploaded', 'File uploaded Successfully');
                    return $data;
                  }else{
                    //Not Success
                    return $data;
                  }
                }else{
                    //Not Success
                    return $data;
                }
            }else{
                //Not Success
                return $data;
            }
        }else{
            //Not Success
            return $data;
        }
    }// end function


    //UPLOAD &  UPDATE FUNCTION to upload any image file with 10 parameters 
    public function uploadAnyFileUpdate($tableName, $fileNameField, $captionField, $caption, $subCaptionField, $subCaption, $path, $file, $whereField, $whereID)
    {
        $data['message']     = "Sorry, we cannot upload this file. Attach the right file and try again.";
        $data['messageCode'] = 0;
        $data['recordID']    = 0;

        if((($file) && ($file != Null || $file != "")))
        {
            $originalExtension      = $file->getClientOriginalExtension();
            $imageNewName           = date('Y-m-d-h-i-sa-'). rand() . '.' .$originalExtension;
            $path                   = base_path() . '/' . $path;
            $updated_at             = date('Y-m-d');
            //start moving file
            if(Schema::hasTable($tableName) and $fileNameField != null and $captionField !=null)
            {   
                if(DB::table($tableName)->where($whereField, $whereID)->first())
                {
                    if($file->move($path , $imageNewName))
                    {
                        if((!empty($captionField) and empty($subCaptionField)) or (($captionField != null) and ($subCaptionField == null)))
                        {
                            $recordID = DB::table($tableName)->where($whereField, $whereID)->update(
                                array( 
                                    $fileNameField   => $imageNewName,
                                    $captionField    => $caption,
                                    //'updated_at'     => $updated_at
                            ));
                        }
                        else if((!empty($captionField) and !empty($subCaptionField)) or (($captionField != null) and ($subCaptionField != null)))
                        {
                            $recordID = DB::table($tableName)->where($whereField, $whereID)->update(
                            array( 
                                $fileNameField       => $imageNewName,
                                $captionField        => $caption,
                                $subCaptionField     => $subCaption,
                                //'updated_at'         => $updated_at
                            )); 
                        }else{
                           $recordID = DB::table($tableName)->where($whereField, $whereID)->update(
                            array( 
                                $fileNameField       => $imageNewName,
                                //'updated_at'         => $updated_at
                            )); 
                        }
                      if($recordID)
                      {
                        //Success
                        $data['message']     = "Success, Your file has been uploaded Successfully";
                        $data['messageCode'] = 1;
                        $data['recordID']    = $recordID;
                        //$this->addLog('File Successfully uploaded', 'File uploaded Successfully');
                        return $data;
                      }else{
                        //Not Success
                        return $data;
                      }
                    }else{
                        //Not Success
                        return $data;
                    }
                }else{
                    //Not Success
                    return $data;
                }
            }else{
                //Not Success
                return $data;
            }
        }else{
            //Not Success
            return $data;
        }
    }// end function


    //Function to delete any record permanently with 5 parameters
    public function deleteAnyRecord($tableName, $recordField, $recordID, $filePath, $imageFieldName)
    {
        $data['message']     = "Sorry, we cannot remove this record permanently now, pls try again later.";
        $data['messageCode'] = 0;
        $data['recordID']    = $recordID;

        if((($recordID) && ($recordID != Null || $recordID != "")))
        {
            if(Schema::hasTable($tableName) and ($recordField != null or $recordField != ''))
            {
                if(DB::table($tableName)->where($recordField, $recordID)->first())
                {
                    if(DB::table($tableName)->where($recordField, $recordID)->delete())
                    {   
                        //Success
                        $data['message']     = "Success, a record was removed from our system Successfully";
                        $data['messageCode'] = 1;
                        $data['recordID']    = $recordID;
                        if((($imageFieldName) && ($imageFieldName != Null || $imageFieldName != "")))
                        {
                            unlink($filePath . DB::table($tableName)->where($recordField, $recordID)->value($imageFieldName));
                        }
                        return $data;
                    }else{
                        //Not Success
                        return $data;
                    }
                }else{
                    //Not Success
                    return $data;
                }
            }else{
                //Not Success
                return $data;
            }
        }else{
            //Not Success
            return $data;
        }
    }// end function



    //Function to turn ON/OFF
    //store
    public function enableOrDisableAnySection($tableName, $updateFieldName, $recordFieldName, $recordName, $operationID)
    { 
        $updated_at          = date('Y-m-d');
        $data['message']     = "We cannot complete this operation. Your session might have been expired or check your internet!";
        $data['messageCode'] = 0;
        $data['recordID']    = $operationID;
      //
      if(Schema::hasTable($tableName) and ($operationID == 1 or $operationID == 0))
      {     
            //Successfully
            $data['message']     = "Success, your status was successfully complete";
            $data['messageCode'] = 1;
            $data['recordID'] = $operationID;
            if($operationID == 1)
            {
                DB::table($tableName)->where($recordFieldName, $recordName)->update(
                    array( 
                        $updateFieldName  => 1,
                        'updated_at'      => $updated_at
                ));
            }
            if($operationID == 0)
            {
                DB::table($tableName)->where($recordFieldName, $recordName)->update(
                    array( 
                        $updateFieldName  => 0,
                        'updated_at'      => $updated_at
                ));
                $data['message']     = "Success, your status was successfully completed";
            }
            return $data;
      }else{
        return $data;
      }
      return $data;
    }//



    public function insertAnyTodoList($tableName, $fieldName1, $fieldName2, $fieldName3, $value1, $value2, $value3)
    { 
        $updated_at          = date('d M, Y h-i-sa');
        $data['message']     = "We cannot complete this operation. Your session might have been expired or check your internet!";
        $data['messageCode'] = 0;
        $data['recordID']    = 0;
      //
      if(Schema::hasTable($tableName))
      {     
            //Successfully
            $data['message']     = "Success, your record was successfully added";
            $data['messageCode'] = 1;
            $data['recordID'] 	 = 1;
            if(($fieldName1 != null and $fieldName2 != null and $fieldName3 != null) or (!empty($fieldName1) and !empty($fieldName2) and !empty($fieldName1) ))
            {
                $recordID = DB::table($tableName)->insert(
                    array( 
                        $fieldName1  	=> $value1,
                        $fieldName2		=> $value2,
                        $fieldName3		=> $value3,
                        'userID' 		=> Auth::user()->id,
                        'updated_at'    => $updated_at
                ));
                return $data;
            }else if(($fieldName1 != null and $fieldName2 != null) or (!empty($fieldName1) and !empty($fieldName2)))
            {
            	$recordID = DB::table($tableName)->insert(
                    array( 
                        $fieldName1  	=> $value1,
                        $fieldName2		=> $value2,
                        'userID' 		=> Auth::user()->id,
                        'updated_at'    => $updated_at
                ));
                return $data;
            }else
            {
            	$recordID = DB::table($tableName)->insert(
                    array( 
                        $fieldName1  	=> $value1,
                        'userID' 		=> Auth::user()->id,
                        'updated_at'    => $updated_at
                ));
                return $data;
            }
      }else{
        return $data;
      }
      return $data;
    }//
    

    public function enableOrDisableAnyFlag($tableName, $updateFieldName, $recordFieldName, $recordName)
	{
        $data['message']     = "We cannot complete this operation. Please try again";
        $data['messageCode'] = 0;
        //
		if(Schema::hasTable($tableName))
      	{ 	
      		$data['message']     = "Success, your operation was successful";
        	$data['messageCode'] = 1;
	      	if(DB::table($tableName)->where($recordFieldName, $recordName)->where('userID', Auth::user()->id)->value('flag') == 1)
	      	{
	      		DB::table($tableName)->where($recordFieldName, $recordName)->where('userID', Auth::user()->id)->update(
	              	array($updateFieldName  => 0));
	      		//
	      		return $data;
	      	}else{
	      		DB::table($tableName)->where($recordFieldName, $recordName)->where('userID', Auth::user()->id)->update(
	              	array($updateFieldName  => 1));
	      		//
	      		return $data;
	      	}
      }else{
      	return $data;
      }
      	//
      	return $data;
	}


	/////////END UNIVERSAL FUNCTIONS///////////////


	//Get all todo list records
	public function getAlltoDoList()
	{
	    $toDoListObject = new ToDoList;
	    $data['toDoList'] =  $toDoListObject::where('active', 1)->where('userID', Auth::user()->id)
	        ->orderBy('id', 'Asc')
            ->select('*', 'updated_at as posted')
	        ->paginate(5);
         //
        $modelBank = new BankDetails;
        $data['getAllBanks'] =  $modelBank::where('active', 1)->orderBy('bankID', 'Desc')->get();
        //
	    return $data;
	}

	Public function MyLastContribution ($regno){
		$val=0;
		$data= DB::Select("SELECT (monthcontribution+psavings+csavings+ssavings+loanrepay+interestrepay) as val 
		FROM `tbltransaction` WHERE `regno`='$regno' and `transtype`=1 order by `ID` Desc limit 1");
		if($data){$val=$data[0]->val;}
		return $val;
	}
	Public function MyTotalSavings ($regno){
		$val=0;
		$data= DB::Select("SELECT sum(`monthcontribution`) as val FROM `tbltransaction` WHERE `regno`='$regno'");
		if($data){ $val=$data[0]->val;}
		return $val;
	}
	Public function MyLastLoan ($regno){
		$data= DB::Select("SELECT `amount`,`loan_rate`,`total_interest`,`period`,`approved_date` 
		FROM `tblloanrequest` WHERE `regno`='$regno' and `approval_status`=1 order by`ID` desc limit 1");
		if($data){return $data[0];} 
		else{return DB::Select("SELECT 0 as `amount`,'NA' as `loan_rate`,'NA' as `total_interest`, 'NA' as`period`,'0000-00-00' as `approved_date`")[0];}
		return $val;
	}
	
	Public function MyOutstandings ($regno){
		$data= DB::Select("SELECT sum(`loanborrow`-`loanrepay`) as unpaidloan, sum(`loaninterest`-`interestrepay`) as unpaidinterest 
		FROM `tbltransaction` WHERE `regno`='$regno'");
		
		if($data){return $data[0];} 
		else{return DB::Select("SELECT 0 as `unpaidloan`,'NA' as `unpaidinterest`")[0];}
		
	}
	Public function TotalOutstandings (){
		$data= DB::Select("SELECT sum(`loanborrow`-`loanrepay`) as unpaidloan, sum(`loaninterest`-`interestrepay`) as unpaidinterest 
		FROM `tbltransaction`");
		if($data){return $data[0];} 
		else{return DB::Select("SELECT 0 as `unpaidloan`,'NA' as `unpaidinterest`")[0];}
		
	}
	Public function TotalSavings (){
		$val=0;
		$data= DB::Select("SELECT sum(`monthcontribution`) as val FROM `tbltransaction`");
		if($data){$val=$data[0]->val;}
		return $val;
	}

}//end class
