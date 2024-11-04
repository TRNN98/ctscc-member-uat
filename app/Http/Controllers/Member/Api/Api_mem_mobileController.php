<?php

namespace App\Http\Controllers\Member\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_mem_mobileController extends Controller
{
    public function pdpa(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_pdpa(
            '" . $req['membership_no'] . "',
            '" . $req['mode'] . "'
            )");
        return response()->json($memstatus);
    }

    public function address(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_address(
            '" . $req['mode'] . "'
        )");
        return response()->json($memstatus);
    }

    public function proadmin(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call pro_admin(
            '" . $req['membership_no'] . "',
            '" . $req['mode'] . "'
        )");
        return response()->json($memstatus);
    }

    public function auth(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_auth(
            '" . $req['membership_no'] . "',
            '" . $req['pass'] . "',
            '" . $req['mode'] . "'
            )");
        return response()->json($memstatus);
    }

    public function mem_coll(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_coll_mem(
            '" . Auth::user()->membership_no . "',
            '" . $req['mode'] . "'
            )");
        return response()->json($memstatus);
    }

    public function dep(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_dep(
            '" . Auth::user()->membership_no . "',
            '" . $req['deposit_account_no'] . "',
            '" . $req['mode'] . "'
            )");
        return response()->json($memstatus);
    }

    public function div(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_div(
            '" . Auth::user()->membership_no . "',
            '" . $req['account_year'] . "',
            '" . $req['mode'] . "'
            )");
        return response()->json($memstatus);
    }

    public function rate(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_rate(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "'
            )");
        return response()->json($memstatus);
    }

    public function Info(Request $request)
    {
        // $req = $request->json()->all();
        $memstatus = DB::select("call mem_info(
            '" . Auth::user()->membership_no . "',
            '" . $request->mode . "'
            )");

        return response()->json($memstatus);
    }

    public function upload(Request $request)
    {
        // parse_str($request->getContent(), $req);
        $req = $request->json()->all();
        $realImage = base64_decode($req['image']);
        file_put_contents("member/profile/" . $req['name'] . ".jpg", $realImage);
    }

    public function kept(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_kept(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "',
            '" . $req['receive_year'] . "',
            '" . $req['receive_month'] . "',
            '" . $req['seq_no'] . "'
            )");
        return response()->json($memstatus);
    }

    public function kept_rec(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_kept_rec(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "',
            '" . $req['receive_year'] . "',
            '" . $req['receive_month'] . "',
            '" . $req['seq_no'] . "',
            '" . $req['receipt_no'] . "'
            )");
        return response()->json($memstatus);
    }

    public function Cremation(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_kept_crem(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "',
            '" . $req['account_year'] . "'
            )");
            
        return response()->json($memstatus);
    }

    public function Lone(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_lon(
            '" . Auth::user()->membership_no . "',
            '" . $req['contract_no'] . "',
            '" . $req['mode'] . "'
            )");
        return response()->json($memstatus);
    }

    public function userlogin(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call status_login_user(
            '" . Auth::user()->membership_no . "',
            '" . $req['status'] . "'
            )");
        return response()->json($memstatus);
    }

    public function msg(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call SP_MEM_M_MEMBER_MSGINFO(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "',
            '" . $req['seq'] . "',
            '" . $req['type'] . "'
            )");
        return response()->json($memstatus);
    }

    public function welfare(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_welfare(
            '" . $req['mode'] . "'
        )");
        return response()->json($memstatus);
    }

    public function gain(Request $request)
    {
        $memstatus = DB::select("call mem_gain('" . Auth::user()->membership_no . "')");
        return response()->json($memstatus);
    }

    public function Share(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_share(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "'
        )");
        return response()->json($memstatus);
    }

    public function Share_statement(Request $request)
    {
        $memstatus = DB::select("call mem_share_det('" . Auth::user()->membership_no . "')");
        return response()->json($memstatus);
    }

    public function versionupdate(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_version_update()");
        return response()->json($memstatus);
    }

    public function checkfogetpassword(Request $request)
    {
        $req = $request->json()->all();
        $this->secret = config('auth.SECRET_AUTH');
        $this->password = $req['password'];
        $this->membership_no = $req['membership_no'];
        $new_password = hash_hmac('sha256', $this->password, $this->secret);

        $rows = DB::select("SELECT mem_password FROM sc_confirm_register WHERE membership_no =:user limit 1", ['user' => $this->membership_no]);
        if ($rows[0]->mem_password == $new_password) {
            return ["checkforget" => '0'];
        } else {
            return ["checkforget" => '1'];
        }
    }

    public function deviceFollowMeStatus(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call followme_device_status(
            '" . $req['mode'] . "',
            '" . $req['membership_no'] . "',
            '" . $req['imei'] . "',
            '" . $req['platform'] . "',
            '" . $req['model'] . "',
            '" . $req['phone'] . "',
            '" . $req['bank'] . "',
            '" . $req['type'] . "'
        )");
        return response()->json($memstatus);
    }

    public function send_otp(Request $request)
    {
        $req = $request->json()->all();
        $msisdn = $req['MobileNumber'];
        $result = send_otp($msisdn);
        return response()->json($result);
    }

    public function verify_otp(Request $request)
    {
        $req = $request->json()->all();
        $token = $req['Token'];
        $pin = $req['Pin'];
        $result = verify_otp($token, $pin);
        return response()->json($result);
    }

    public function notify(Request $request)
    {
        if (!collect([
            ['ctscc', 'D398h%ch9&'],
        ])->contains([$request->getUser(), $request->getPassword()])) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $req = $request->json()->all();
        // to do

        $res = sendSingle(substr($req['head_msg'], 1, -1), substr($req['det_msg'], 1, -1), substr($req['membership_no'], 1, -1));

        return response()->json([
            'rd_code' => 1,
            'rd_desc' => 'success',
            'res_msg' => json_decode($res),
        ]);
    }


    public function getNewToken(Request $request)
    {
        $req = $request->json()->all();
        $mem = DB::select("call followme_device_status(
            '5',
            '" . $req['membership_no'] . "',
            '" . $req['imei'] . "',
            '',
            '',
            '',
            '',
            ''
        )");
   
        if($mem[0]->status > 0){
            $rows = DB::select(
                "SELECT 
                    mem_password_encrypt 
                FROM sc_confirm_register 
                WHERE membership_no =:user 
                limit 1", ['user' => $req['membership_no']]);

            $req1 = [
                'mem_password' => SoatDecode($rows[0]->mem_password_encrypt)
            ];
            
            $request->merge($req1);
            return $this->issueToken($request, 'password');
        }
    }
    
}
