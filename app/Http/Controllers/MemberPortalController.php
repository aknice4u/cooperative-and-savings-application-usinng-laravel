<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use Entrust;
use Session;
use Excel;
use Input;
use DB;
use QrCode;
use Intervention\Image\ImageManager;
use Hash;


class MemberPortalController extends Controller
{
	public function index(Request $request)
	{
		$data['success'] = "";
		
	  	$data['error'] = "";
	  	
	  	$data['warning'] = "";
	  	
	  	$divisions = DB::table('tbldivision')
	  			->get();
	  	
	  	$data['division'] = $request['division'];
	  	
	  	$data['divisions'] = $divisions;
	  	
	  	$data['members'] = DB::table('tblmembers')
	  			->leftjoin('tblbank', 'tblmembers.bankid', '=', 'tblbank.ID')
			  	->leftjoin('tbldivision', 'tblmembers.branch', '=', 'tbldivision.ID')
			  	->leftjoin('tblmaritalstatus', 'tblmembers.marital_status', '=', 'tblmaritalstatus.ID')
	  			->select(DB::raw('tblmaritalstatus.status as marital_stats'), 'tbldivision.division', 'tblbank.bank', 'tblmembers.*')->get();
	  	
	  	if($request['division']){
	  	
	  		$data['members'] = DB::table('tblmembers')->where('branch', $request['division'])
	  			->leftjoin('tblbank', 'tblmembers.bankid', '=', 'tblbank.ID')
			  	->leftjoin('tbldivision', 'tblmembers.branch', '=', 'tbldivision.ID')
			  	->leftjoin('tblmaritalstatus', 'tblmembers.marital_status', '=', 'tblmaritalstatus.ID')
			  	->select(DB::raw('tblmaritalstatus.status as marital_stats'), 'tbldivision.division', 'tblbank.bank', 'tblmembers.*')->get();
	  		
	  	}
	  	
	  	$data['pagetitle'] = "View Members Information";
	  	
	  	if(Auth::user()->role == 4){
			return view('MemberPortal.index', $data);
		} else {
			return view('MemberPortal.member_index', $data);
		}
	}
}