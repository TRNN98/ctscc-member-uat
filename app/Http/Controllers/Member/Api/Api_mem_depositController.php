<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_mem_depositController extends Controller
{
 // webmember Head Deposit
    public function member_dep()
    {
        $membership_no = Auth::user()->membership_no;

        $datadeposit = DB::select(" SELECT  sm_dep_m_creditor.deposit_type_code,
                                            sm_dep_m_creditor.deposit_type_code,
                                            sm_dep_m_creditor.membership_no,
                                            sm_dep_m_creditor.deposit_name,
                                            sm_dep_m_creditor.deposit_balance,
                                            sm_dep_m_creditor.accumulate_interest,
                                            sm_dep_m_creditor.deposit_account_name,
                                            sm_dep_m_creditor.withdrawable_amount,
                                            sm_dep_m_creditor.deposit_account_no,
                                            sm_dep_m_creditor.loan_holding_amount
                                    FROM    sm_dep_m_creditor
                                    WHERE 1 = 1
                                    AND ( sm_dep_m_creditor.membership_no = '" . $membership_no . "' )
                                    AND ( sm_dep_m_creditor.deposit_balance > 0 )
                                    AND (sm_dep_m_creditor.close_status= '0')");

        foreach ($datadeposit as $row) {
            $deposit_balance += $row->deposit_balance;
            $accumulate_interest += $row->accumulate_interest;
            // $loan_holding_amount += $row->loan_holding_amount;
        }
        // dd($deposit_balance);
        return response()->json(compact('datadeposit', 'deposit_balance', 'accumulate_interest'));
    }

    // Webmember Statement Deposit
    public function member_dep_statement($id, Request $request)
    {
        $membership_no = Auth::user()->membership_no;
        $DepAccNo = $id;

        $dep_check_mem = DB::table('sm_dep_m_creditor')->where('deposit_account_no', '=', $DepAccNo)->pluck('membership_no')->first();

        if ($dep_check_mem !== $membership_no) {
            return response()->json(['error' => 'บัญชีเงินฝาก ไม่ถูกต้อง'], 401);
        }

        $DepStatementHead = DB::table('sm_dep_m_creditor as creditor')
            ->select(
                'creditor.deposit_account_no',
                'creditor.deposit_name',
                'creditor.deposit_account_name',
                'creditor.withdrawable_amount',
                'creditor.deposit_balance',
                'creditor.deposit_opened_date'
            )
            ->where('creditor.deposit_account_no', '=', $DepAccNo)
            ->first();

        if (isset($request->inputdatepickerstart) and isset($request->inputdatepickerend)) {
            $datepickerstart = $request->inputdatepickerstart;
            $datepickerend = $request->inputdatepickerend;

            list($tid, $tim, $tiy) = explode("/", $datepickerstart);
            $datestart = $tid . '-' . $tim . '-' . ($tiy - 543);
            $datestart = date("Y-m-d", strtotime($datestart));

            list($ed, $em, $ey) = explode("/", $datepickerend);
            $dateend = $ed . '-' . $em . '-' . ($ey - 543);
            $dateend = date("Y-m-d", strtotime($dateend));

            $dep_statement = DB::table('sm_dep_m_creditor_item')
                ->select(
                    'sm_dep_m_creditor_item.deposit_account_no',
                    'sm_dep_m_creditor_item.seq_no',
                    'sm_dep_m_creditor_item.total_balance',
                    'sm_dep_m_creditor_item.deposit_balance',
                    'sm_dep_m_creditor_item.operate_date',
                    // 'sm_dep_m_creditor_item.deposit_item_type',
                    'sm_dep_m_creditor_item.deposit_item_description',
                    'sm_dep_m_creditor_item.sign_flag'
                )
                // ->join('sm_dep_m_ucf_dep_item_type', 'sm_dep_m_creditor_item.item_type', '=', 'sm_dep_m_ucf_dep_item_type.deposit_item_type')
                ->where('sm_dep_m_creditor_item.deposit_account_no', '=', $DepAccNo)
                ->whereBetween('sm_dep_m_creditor_item.operate_date', array($datestart, $dateend))
                ->orderBy('sm_dep_m_creditor_item.operate_date', 'desc')
                ->orderBy('sm_dep_m_creditor_item.seq_no', 'desc')
                ->paginate(10);
        } else {
            $dep_statement = DB::table('sm_dep_m_creditor_item')
                ->select(
                    'sm_dep_m_creditor_item.deposit_account_no',
                    'sm_dep_m_creditor_item.seq_no',
                    'sm_dep_m_creditor_item.total_balance',
                    'sm_dep_m_creditor_item.deposit_balance',
                    'sm_dep_m_creditor_item.operate_date',
                    // 'sm_dep_m_creditor_item.deposit_item_type',
                    'sm_dep_m_creditor_item.deposit_item_description',
                    'sm_dep_m_creditor_item.sign_flag'
                )
                // ->join('sm_dep_m_ucf_dep_item_type', 'sm_dep_m_creditor_item.item_type', '=', 'sm_dep_m_ucf_dep_item_type.deposit_item_type')
                ->where('sm_dep_m_creditor_item.deposit_account_no', '=', $DepAccNo)
                ->orderBy('sm_dep_m_creditor_item.operate_date', 'desc')
                ->orderBy('sm_dep_m_creditor_item.seq_no', 'desc')
                ->paginate(10);
        }

        return response()->json(compact('DepStatementHead', 'dep_statement'));
    }
}
