<?php

namespace App\Listeners;

use App\Events\UserDetails;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use Schema;
use Auth;
use DB;
use Session;

class ProcessAfterLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserDetails  $event
     * @return void
     */
    public function handle($event)
    {   
        /*Check Setup*/
        //check Todo List Table
        if(!Schema::hasTable('todo_list'))
        {
            Schema::create('todo_list', function($table) {
                $table->increments('id');
                $table->integer('userID')->nullable();
                $table->longtext('caption')->nullable();
                $table->integer('flag')->default(0);
                $table->integer('active')->default(1);
                $table->string('updated_at')->nullable();
            });
        }
        //
        if (!Schema::hasColumn('users', 'lastlogin') and !Schema::hasColumn('users', 'currentlogin'))
        {
            Schema::table('users', function($table)
            {
                $table->string('lastlogin')->nullable();
                $table->string('currentlogin')->nullable();
            });
        }
        ////////End Check Setup////////////////

        $userID = Auth::user()->id;
        $roleID = Auth::user()->role;
        //
        $roleName = DB::table('users')
            ->leftJoin('roles', 'roles.id', '=', 'users.role')
            ->where('users.id', $userID)
            ->value('roles.name');
        Session::put('roleName', strtolower(trim($roleName)));
        Session::put('roleID', $roleID); 
        //Set last Login
        $lastLogin   = DB::table('users')->where('users.id', $userID)->value('currentlogin');
        Session::put('lastLogin', $lastLogin); 
        Session::put('currentlogin', date('Y-m-d h:i:sa')); 
        DB::table('users')
            ->where('users.id', $userID)
            ->update(array( 
                'lastlogin'         => $lastLogin,
                'currentlogin'      => Session::get('currentlogin')
        ));
       
    }


}//end class