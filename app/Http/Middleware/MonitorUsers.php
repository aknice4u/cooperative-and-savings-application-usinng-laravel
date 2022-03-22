<?php

namespace App\Http\Middleware;
use DB;
use Auth;
use Session;

use Closure;

class MonitorUsers
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //redirect if user is under suspension ==>(stale Data)
        $getLoggedInUserRoleID  = Session::get('roleID'); 
        // ==>active data
        $getCurrentDBRoleID = DB::table('users')->where('users.id', auth::user()->id)->value('users.role');
        if(($getCurrentDBRoleID == $getLoggedInUserRoleID))
        {   
        
            return $next($request);
        }
        else
        {
            //Fake user --> system logs user out
            return redirect()->route('logout');
        }
        
        
    }

}