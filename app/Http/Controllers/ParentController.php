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
        $cmpname = gethostname();
        $host = $_SERVER['HTTP_HOST'];
        DB::table('audit_log')->insert(
            ['comp_name' => $cmpname, 'user_id' => $userID, 'date' => $nowInNigeria, 'ip_addr' => $ip, 'operation' => $operation,
            'host' => $host, 'referer' => $url]);
        return;
    }

    protected function logged_in_as($name){
        $role = DB::table('roles')
            ->select('roles.*','users.username')
            ->join('role_user','roles.id','=','role_user.role_id')
            ->join('users','users.id','=','role_user.user_id')
            ->where('users.id',Auth::user()->id)
            ->where('roles.name',$name)
            ->first();
        if(is_array($role))
            return !true;

        return !false;
    }
    protected function get_role(){

         $role = DB::table('roles')
            ->select('roles.*','users.username')
            ->join('role_user','roles.id','=','role_user.role_id')
            ->join('users','users.id','=','role_user.user_id')
            ->where('users.id',Auth::user()->id)
            ->first();
        return $role;
    }

}