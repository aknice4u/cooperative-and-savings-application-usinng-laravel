<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class ParentController extends Controller
{
    public function addLog($operation)
    {
        $ip = Request::ip();
        $url = Request::fullUrl();
        $userID = Auth::user()->id;
        $nowInNigeria = Carbon::now('Africa/Lagos');
        $host = $_SERVER['HTTP_HOST'];
        DB::table('audit_log')->insert(
            ['user_id' => $userID, 'date' => $nowInNigeria, 'ip_addr' => $ip, 'operation' => $operation,
            'host' => $host, 'referer' => $url]);
        return;
    }//



}//end class