<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use App\Models\ToDoList;
use Auth;
use Session;
use DB;

class HomeController extends UniversalFunctionController
{

	public function __construct()
    {
        $this->middleware('auth');
    }



   public function loadPage()
   {    
   		//DashBoard Selector

   		$data = $this->getAlltoDoList();
   		//
   		$data['myLastContribution'] 	= $this->MyLastContribution(Auth::user()->username);
   		$data['myOutstandings'] 	= $this->MyOutstandings(Auth::user()->username);
   		$data['myTotalSavings'] 	= $this->MyTotalSavings(Auth::user()->username);
   		$data['myLastLoan'] 		= $this->MyLastLoan(Auth::user()->username);
   		$data['totalLoanSaving'] 	= $this->TotalSavings();
   		$data['totalUnpaidLoanInterest'] = $this->TotalOutstandings();
   		
   		if (Auth::user())
   		{
		  if(Session::get('roleName') == "admin")
		  {
		      return view("Admin.Home.welcome", $data);
		  }
		  else{
		      return view("Member.Home.welcome", $data);
		  }
		  
		}else{
		     return view("Member.Home.welcome", $data);
		}
   }


    public function addToDolist(Request $request)
    {
      $getValue         	= (trim($request['todoList']));
      $tableName           	= strtolower(trim('todo_list'));
      $fieldName1     		= 'caption';
      $fieldName2     		= null;
      $fieldName3     		= null;
      $value1 				= $getValue;
      $value2 				= null;
      $value3 				= null;
      //
      $return = $this->insertAnyTodoList($tableName, $fieldName1, $fieldName2, $fieldName3, $value1, $value2, $value3);
      $data = $return['message'];
      return response()->json($data);

    }//


    //Delete ToDo List
    public function removeToDolist(Request $request)
    {
    	$recordID       = (trim($request['todoListID']));
        $tableName      = strtolower(trim('todo_list'));
        $recordField    = trim('id');
        $imageFieldName = '';
        $getPath        = null;
        $filePath       = null;
        $return = $this->deleteAnyRecord($tableName, $recordField, $recordID, $filePath, $imageFieldName);
        $data = $return['message'];
        //
      	return response()->json($data);
    }


    //flagToDolist
    public function flagToDolist(Request $request)
    {
      $checkedID           = (trim($request['checkedID']));
      $tableName           = (trim('todo_list'));
      $recordFieldName     = (trim('id'));
      $recordName          = $checkedID;
      $updateFieldName     = (trim('flag'));
      //
      $return = $this->enableOrDisableAnyFlag($tableName, $updateFieldName, $recordFieldName, $recordName);
      $data = $return['message'];
      return response()->json($data);

    }//

}//end class
