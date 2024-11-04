<?php

namespace App\Http\Controllers\Member\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_mem_mobileProController extends Controller
{

    public function AdminAll(Request $request)
    {
        
        $req = $request->json()->all();
        $memstatus = DB::select("call pro_admin(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "',
            '" . $req['data1'] . "',
            '" . $req['data2'] . "',
            '" . $req['data3'] . "'
        )");
        return response()->json($memstatus);
    }

    public function checkToken(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call mem_version_update()");
        return response()->json($memstatus);
    }

    public function deviceProStatus(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call pro_device_status(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "',
            '" . $req['imei'] . "',
            '" . $req['platform'] . "',
            '" . $req['model'] . "',
            '" . $req['phone'] . "',
            '" . $req['bank'] . "'
        )");
        return response()->json($memstatus);
    }

    public function insertHistory(Request $request)
    {
        $req = $request->json()->all();
        $memstatus = DB::select("call pro_history(
            '" . $req['mode'] . "',
            '" . Auth::user()->membership_no . "',
            '" . $req['type'] . "',
            '" . $req['account_name_from'] . "',
            '" . $req['account_id_from'] . "',
            '" . $req['account_name_to'] . "',
            '" . $req['account_id_to'] . "',
            '" . $req['amount'] . "',
            '" . $req['date'] . "',
            '" . $req['fee'] . "',
            '" . $req['imei'] . "',
            '" . $req['bank'] . "',
            '" . $req['note'] . "'
        )");
        return response()->json($memstatus);
    }
}

