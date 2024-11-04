<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\user\User;


class Api_mem_AuthController extends Controller
{
    public function reset(Request $request)
    {
        parse_str($request->getContent(),$req);

        $this->secret = config('auth.SECRET_AUTH');
        $this->password = $req['password'];
        $this->membership_no = $req['membership_no'];

        // $rows = DB::select('SELECT seq,membership_no,mem_password,mem_password_raw FROM sc_confirm_register  ');
        // foreach ($rows as $row) {
        $new_password = hash_hmac('sha256', $this->password,$this->secret);
        DB::select('UPDATE sc_confirm_register SET mem_password =:new_password , mem_password_raw =:passwords
            WHERE membership_no =:user' ,['user' => $this->membership_no,'new_password'=>$new_password,'passwords'=>$this->password]);
        // }
        return ["rc_code" => '1'];
    }

    // Webmember change password
    public function member_password(Request $request)
    {
        $membership_no = Auth::user()->membership_no;
        $secret = config('auth.SECRET_AUTH');

        $new_password = hash_hmac('sha256', $request->mem_password, $secret);
        $old_password = hash_hmac('sha256', $request->mem_oldpassword, $secret);

        $chk_oldpass = DB::table('sc_confirm_register')->where('membership_no','=',$membership_no)->pluck('mem_password_sha')->first();

        if($old_password == $chk_oldpass)
        {
            $pass_query = DB::update('update sc_confirm_register set mem_password_sha = :new_password, mem_password = :mem_password where membership_no = :membership_no',
            ['new_password' => $new_password,'mem_password' => $request->mem_password, 'membership_no' => $membership_no]);

            if ($pass_query) {
                return response()->json([
                    'rc_code' => '1',
                    'rc_des' => 'เปลี่ยนรหัสผ่านสำเร็จ'
                ]);
            } else {
                return response()->json([
                    'rc_code' => '0',
                    'rc_des' => 'เปลี่ยนรหัสผ่าน ไม่สำเร็จ'
                ]);
            }
        }else{
            return response()->json([
                'rc_code' => '-1',
                'rc_des' => 'รหัสผ่านเดิม ไม่ถูกต้อง'
            ]);
        }


    }
}
