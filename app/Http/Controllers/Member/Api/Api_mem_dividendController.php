<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_mem_dividendController extends Controller
{
    // Webmember page Dividend
    public function member_div()
    {
        $membership_no = Auth::user()->membership_no;

        $check = DB::select('SELECT sm_mem_m_membership_registered.MEMBERSHIP_NO
                                FROM sm_lon_m_loan_card,sm_mem_m_membership_registered
                                where
                                    sm_mem_m_membership_registered.membership_no = sm_lon_m_loan_card.MEMBERSHIP_NO
                                and sm_lon_m_loan_card.membership_no = "'.$membership_no.'"
                                and sm_lon_m_loan_card.PRINCIPAL_BALANCE > 0 and MEMBER_STATUS_CODE = 3
                            ');


        // if(f_get_mem_receive_dividend() == 1)
        // {
        //     $dividend_sql .= "and sm_mem_m_capital_stock_detail.account_year < '".date("Y")."'";
        // }
        //     $dividend_sql .= "ORDER BY sm_mem_m_capital_stock_detail.account_year DESC";
        // if(isset($check['membership_no'])){
        //     $dividend_sql .= " limit 0,2";
        // }
 if(f_get_mem_receive_dividend() == 0)
        {
        $div = DB::select('SELECT sm_mem_m_capital_stock_detail.account_year,
                                        sm_mem_m_capital_stock_detail.membership_no,
                                        sm_mem_m_capital_stock_detail.average_return,
                                        sm_mem_m_capital_stock_detail.drop_dividend,
                                        sm_mem_m_capital_stock_detail.drop_average,
                                        sm_mem_m_capital_stock_detail.dividend,
                                        sm_mem_m_capital_stock_detail.total_interest
                                        -- ,sm_mem_m_capital_stock_detail.share_coll_dividend
                                        -- ,sm_mem_m_capital_stock_detail.group_pay_code
                                        -- ,sm_mem_m_capital_stock_detail.insurance_amount
                                        ,   SHARE_RATE * 100 AS share_rate,
                                            LONINT_RATE * 100 AS lonint_rate,
                                            (SELECT
                                                    CONCAT(MONEY_TYPE_NAME,
                                                                BANK_NAME,
                                                                " เลขที่บัญชี ",
                                                                BANK_ACC_NO)
                                                FROM
                                                    sm_mem_m_capital_pay
                                                WHERE
                                                    1 = 1
                                                        and EXT_STATUS = "0"
                                                        AND sm_mem_m_capital_pay.MEMBERSHIP_NO = sm_mem_m_capital_stock_detail.MEMBERSHIP_NO
                                                        AND sm_mem_m_capital_pay.ACCOUNT_YEAR = sm_mem_m_capital_stock_detail.ACCOUNT_YEAR) AS bank_des
                                 FROM 	sm_mem_m_capital_stock_detail
                                 left join www_kep_divinded_controller on www_kep_divinded_controller.account_year = sm_mem_m_capital_stock_detail.account_year
                                 WHERE 	sm_mem_m_capital_stock_detail.membership_no = "'.$membership_no.'" AND www_kep_divinded_controller.approve_status  = "1" ORDER BY sm_mem_m_capital_stock_detail.account_year DESC  ');
        }
        
        return response()->json(compact('div'));
    }
}