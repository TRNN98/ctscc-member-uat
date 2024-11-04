<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_mem_collController extends Controller
{
    // Webmember page coll
    public function member_coll()
    {
        $membership_no = Auth::user()->membership_no;

        $guarantee = DB::select('SELECT
                                        sm_lon_m_contract_coll.loan_contract_no,
                                        sm_mem_m_membership_registered.membership_no,
                                        sm_mem_m_membership_registered.prename,
                                        sm_mem_m_membership_registered.member_name,
                                        sm_mem_m_membership_registered.member_surname,
                                        sm_lon_m_loan_card.principal_balance,
                                        sm_lon_m_loan_card.loan_approve_amount,
                                        sm_lon_m_loan_card.begining_of_contract,
                                        sm_lon_m_contract_coll.collateral_no,
                                        sm_lon_m_contract_coll.ref_own_no,
                                        sm_lon_m_contract_coll.used_amount,
                                        sm_lon_m_loan_card.old_interest_arrear
                                    FROM
                                        sm_mem_m_membership_registered,
                                        sm_lon_m_contract_coll,
                                        sm_lon_m_loan_card
                                    WHERE  1 = 1
                                    AND (sm_lon_m_loan_card.loan_contract_no = sm_lon_m_contract_coll.loan_contract_no )
                                    AND (sm_mem_m_membership_registered.membership_no = sm_lon_m_contract_coll.membership_no)
                                    AND 	(sm_lon_m_contract_coll.ref_own_no = :membership_no )
                                    AND   (sm_lon_m_loan_card.principal_balance > 0 )
                                    AND   (sm_lon_m_contract_coll.collateral_type_code = "01")
                                    AND 	(sm_lon_m_contract_coll.status = "0" OR sm_lon_m_contract_coll.status IS NULL)'
                                        , ['membership_no' => $membership_no]
                                    );

        // $collateral = DB::select('SELECT sm_lon_m_contract_coll.loan_contract_no,
        //                                     sm_lon_m_contract_coll.ref_own_no,
        //                                     sm_lon_m_contract_coll.used_amount,
        //                                     sm_lon_m_loan_card.principal_balance,
        //                                     sm_lon_m_contract_coll.collateral_type_code,
        //                                     sm_lon_m_contract_coll.collateral_description
        //                                 FROM sm_lon_m_contract_coll,
        //                                     sm_lon_m_loan_card
        //                                 WHERE 1 = 1
        //                                 AND (sm_lon_m_loan_card.loan_contract_no = sm_lon_m_contract_coll.loan_contract_no )
        //                                 AND ((sm_lon_m_contract_coll.status = "0" ) OR (sm_lon_m_contract_coll.status IS NULL ))
        //                                 AND (sm_lon_m_loan_card.principal_balance > 0)
        //                                 AND (sm_lon_m_contract_coll.membership_no = :membership_no)
        //                                 ORDER BY sm_lon_m_contract_coll.loan_contract_no ASC'
        //                                 , ['membership_no' => $membership_no]
        //                             );


        // return response()->json(compact('guarantee','collateral'));
        return response()->json(compact('guarantee'));
    }
}
