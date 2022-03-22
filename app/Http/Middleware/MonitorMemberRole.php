<?php

namespace App\Http\Middleware;
use DB;
use Auth;
use Session;

use Closure;

class MonitorMemberRole
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
        //check if user is a member
        $getLoggedInRoleName  = strtoupper(Session::get('roleName'));
        if($getLoggedInRoleName == strtoupper('member') )
        {   
            return $next($request);
        }
        else
        {
            //Fake user --> system logs user out if not Auth or redirect back home
            return redirect()->route('home');
        }
        
        
    }

}//end class