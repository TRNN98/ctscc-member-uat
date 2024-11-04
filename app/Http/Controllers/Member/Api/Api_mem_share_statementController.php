<?php

namespace App\Http\Controllers\Member\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_mem_share_statementController extends Controller
{

    public function Share_statement(Request $request)
    {
        $memstatus = DB::select("call mem_share_det('" . Auth::user()->membership_no . "')");
        return response()->json($memstatus);
        //     $req = $request->json()->all();
        //     membership_no = :membership_no ", ['membership_no' => Auth::user()->membership_no ]);
        //     return response()->json($memstatus);
    }

    // For WebMember Page Share
    public function member_share()
    {
        $membership_no = Auth::user()->membership_no;

        $sharehead = DB::select('SELECT
                share_amount,
                share_stock,
                period_recrieve,
                drop_status,
                (
                CASE
                    drop_status
                    WHEN "1"
                    THEN "งดส่งค่าหุ้น"
                    ELSE FORMAT (share_amount, 0)
                END
                ) AS share_amount_fp
            FROM
                sm_mem_m_share_mem
            WHERE membership_no = :membership_no', ['membership_no' => $membership_no]);

        $sharestatement = DB::table('sm_mem_m_share_holding_detail')->select('operate_date', DB::raw('(COALESCE(sign_flag,1) * share_value) AS share_value'), 'item_type_description', 'sign_flag', 'period', 'share_stock')->where('membership_no', '=', $membership_no)->orderBy('seq_no', 'desc')->paginate(10);

        return response()->json(compact('sharehead', 'sharestatement'));
    }

    public function searchMember_share(Request $request)
    {
        $membership_no = Auth::user()->membership_no;

        $sharehead = DB::select('SELECT share_amount , share_stock , period_recrieve ,drop_status
                                ,( case drop_status when "1" then "งดส่งค่าหุ้น"  else  format(share_amount,0) end) as share_amount_fp
                                FROM sm_mem_m_share_mem
                                WHERE membership_no = :membership_no', ['membership_no' => $membership_no]);

        if (isset($request->inputdatepickerstart) and isset($request->inputdatepickerend)) {
            $datepickerstart = $request->inputdatepickerstart;
            $datepickerend = $request->inputdatepickerend;

            list($tid, $tim, $tiy) = explode("/", $datepickerstart);
            $datestart = $tid . '-' . $tim . '-' . ($tiy - 543);
            $datestart = date("Y-m-d", strtotime($datestart));

            list($ed, $em, $ey) = explode("/", $datepickerend);
            $dateend = $ed . '-' . $em . '-' . ($ey - 543);
            $dateend = date("Y-m-d", strtotime($dateend));

            $sharestatement = DB::table('sm_mem_m_share_holding_detail')
                ->select('operate_date', DB::raw('(COALESCE(sign_flag,1) * share_value) AS share_value'), 'item_type_description', 'sign_flag', 'period', 'share_stock')
                ->where('membership_no', '=', $membership_no)
                ->whereBetween('operate_date', array($datestart, $dateend))
                ->orderBy('seq_no', 'desc')->paginate(10);

            return response()->json(compact('sharehead', 'sharestatement'));
        }
    }
}
