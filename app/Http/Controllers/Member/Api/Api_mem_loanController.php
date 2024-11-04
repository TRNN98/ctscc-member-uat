<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_mem_loanController extends Controller
{

    // For Webmember Head loan
    public function member_loan()
    {
        $membership_no = Auth::user()->membership_no;

        $dataloan = DB::select('SELECT sm_lon_m_loan_card.loan_contract_no,
                                    sm_lon_m_loan_card.loan_approve_amount,
                                    sm_lon_m_loan_card.last_period,
                                    -- sm_lon_m_loan_card.last_access_date,
                                    sm_lon_m_loan_card.principal_balance,
                                    -- sm_lon_m_loan_card.total_interest,
                                    sm_lon_m_loan_card.begining_of_contract,
                                    sm_lon_m_loan_card.loan_type_description,
                                    sm_lon_m_loan_card.period_payment_amount,
                                    ((sm_lon_m_loan_card.loan_approve_amount -sm_lon_m_loan_card.principal_balance )/sm_lon_m_loan_card.loan_approve_amount) * 100 as percent_pay
                                    -- sm_lon_m_contract_coll.remark,
                                FROM sm_lon_m_loan_card
                                    -- , sm_lon_m_contract_coll
                                WHERE 1 = 1
                                -- AND sm_lon_m_contract_coll.loan_contract_no = sm_lon_m_loan_card.loan_contract_no
                                AND (sm_lon_m_loan_card.principal_balance > 0)
                                AND (sm_lon_m_loan_card.membership_no = ' . $membership_no . ')
                                GROUP BY sm_lon_m_loan_card.loan_contract_no
                                ORDER BY sm_lon_m_loan_card.principal_balance DESC');

        $collateral = DB::select(
            'SELECT sm_lon_m_contract_coll.loan_contract_no,
                                    sm_lon_m_contract_coll.ref_own_no,
                                    sm_lon_m_contract_coll.used_amount,
                                    sm_lon_m_loan_card.principal_balance,
                                    sm_lon_m_contract_coll.collateral_type_code,
                                    sm_lon_m_contract_coll.collateral_description
                                FROM sm_lon_m_contract_coll,
                                    sm_lon_m_loan_card
                                WHERE 1 = 1
                                AND (sm_lon_m_loan_card.loan_contract_no = sm_lon_m_contract_coll.loan_contract_no )
                                AND ((sm_lon_m_contract_coll.status = "0" ) OR (sm_lon_m_contract_coll.status IS NULL ))
                                AND (sm_lon_m_loan_card.principal_balance > 0)
                                AND (sm_lon_m_contract_coll.membership_no = :membership_no)
                                ORDER BY sm_lon_m_contract_coll.loan_contract_no ASC',
            ['membership_no' => $membership_no]
        );

        // $remark = DB::table('sm_lon_m_contract_coll')->where('membership_no',$membership_no)->pluck('remark')->first();
        // strpos($remark,'https://www.dropbox.com') !== false

        $i = 0;
        $Arrpercent = array();

        foreach ($dataloan as $row) {
            $percent . $i = $row->percent_pay;
            $Arrpercent[] = $percent . $i;
            $i++;
        }

        return response()->json(compact('dataloan', 'Arrpercent', 'collateral'));
    }

    // For webmember Statement Loan
    public function member_loan_statement($id, Request $request)
    {
        $membership_no = Auth::user()->membership_no;
        $accno = $id;

        $loan_check_mem = DB::table('sm_lon_m_loan_card')->where('loan_contract_no', '=', $accno)->pluck('membership_no')->first();

        if ($loan_check_mem !== $membership_no) {
            return response()->json(['error' => 'สัญญาเงินกู้ ไม่ถูกต้อง'], 401);
        }

        $headLoan_statement = DB::select("SELECT sm_lon_m_loan_card.loan_contract_no,
                                                sm_lon_m_loan_card.loan_approve_amount,
                                                sm_lon_m_loan_card.last_period,
                                                -- sm_lon_m_loan_card.last_access_date,
                                                sm_lon_m_loan_card.principal_balance,
                                                -- sm_lon_m_loan_card.total_interest,
                                                sm_lon_m_loan_card.begining_of_contract,
                                                sm_lon_m_loan_card.loan_type_description,
                                                sm_lon_m_loan_card.period_payment_amount
                                        FROM sm_lon_m_loan_card
                                        WHERE (sm_lon_m_loan_card.loan_contract_no = '" . $accno . "' ) AND
                                                (sm_lon_m_loan_card.principal_balance > 0) AND
                                                ( sm_lon_m_loan_card.membership_no = '" . $membership_no . "' )");

        if (isset($request->inputdatepickerstart) and isset($request->inputdatepickerend)) {
            $datepickerstart = $request->inputdatepickerstart;
            $datepickerend = $request->inputdatepickerend;

            list($tid, $tim, $tiy) = explode("/", $datepickerstart);
            $datestart = $tid . '-' . $tim . '-' . ($tiy - 543);
            $datestart = date("Y-m-d", strtotime($datestart));

            list($ed, $em, $ey) = explode("/", $datepickerend);
            $dateend = $ed . '-' . $em . '-' . ($ey - 543);
            $dateend = date("Y-m-d", strtotime($dateend));

            $loan_statement = DB::table('sm_lon_m_loan_card_detail')
                ->select(
                    'sm_lon_m_loan_card_detail.loan_payment_date',
                    'sm_lon_m_loan_card_detail.payment_amount',
                    'sm_lon_m_loan_card_detail.period',
                    'sm_lon_m_loan_card_detail.interest_amount',
                    'sm_lon_m_loan_card_detail.PRINCIPAL_BALANCE',
                    'sm_lon_m_loan_card_detail.item_type_code',
                    'sm_lon_m_loan_card_detail.item_type_description'
                )
                ->where('loan_contract_no', '=', $accno)
                ->whereBetween('LOAN_PAYMENT_DATE', array($datestart, $dateend))
                ->orderBy('seq_no', 'desc')->paginate(10);
        } else {
            $loan_statement = DB::table('sm_lon_m_loan_card_detail')
                ->select(
                    'sm_lon_m_loan_card_detail.loan_payment_date',
                    'sm_lon_m_loan_card_detail.payment_amount',
                    'sm_lon_m_loan_card_detail.period',
                    'sm_lon_m_loan_card_detail.interest_amount',
                    'sm_lon_m_loan_card_detail.PRINCIPAL_BALANCE',
                    'sm_lon_m_loan_card_detail.item_type_code',
                    'sm_lon_m_loan_card_detail.item_type_description'
                )
                ->where('loan_contract_no', '=', $accno)
                ->orderBy('seq_no', 'desc')->paginate(10);
        }

        return response()->json(compact('headLoan_statement', 'loan_statement'));
    }
}
