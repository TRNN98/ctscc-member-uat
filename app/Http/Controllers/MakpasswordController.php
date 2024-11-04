<?php

namespace App\Http\Controllers;

use App\Model\user\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MakpasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $secret ;
    private  $membership_no ;
    // -------------------------------------------ปอม--------------------------------------------------------------------------
    // php artisan tinker
    // $pom = app()->make('App\Http\Controllers\MakpasswordController');

    // $user = app()->call([$pom,'index'],[]);

    // app()->call([$pom,'Hashing'],[$user]);
    // ---------------------------------------------------------------------------------------------------------------------
        public function index()
        {
            // ประกาศ Model member/user *** sc_confirm_register
            // ประกาศ primary key เป็น Membership_no  && Keytype = 'string'
            $user = User::get();
            // $user = User::where('seq','=',$where)->get();
             return $user;
        }
    public function Hashing($user)
    {
        $pom = [];
        foreach($user as $users)
        {
            // $pom[] = $users->membership_no;
            $member = User::where('membership_no',$users->membership_no)->first();
            // รหัสที่ affected
            $pom[] = $member->membership_no;
            $member->mem_password_sha = hash_hmac('sha256',$member->mem_password,config('auth.SECRET_AUTH'));
            $member->save();
        }
        // ส่งกลับ
        return $pom;
    }
}
