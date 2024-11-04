<?php

namespace App\Http\Controllers\Member\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_mem_cremController extends Controller
{
    public function member_crem()
    {

        $membership_no = Auth::user()->membership_no;

        $crem = DB::table('sm_crem_master')
                ->join('sm_crem_ucf_keep_type','sm_crem_ucf_keep_type.keep_type','=','sm_crem_master.keep_type')
                ->join('sm_crem_rule','sm_crem_master.crem_type','=','sm_crem_rule.crem_type')
                ->join('sm_mem_m_ucf_prename','sm_crem_master.prename_code','=','sm_mem_m_ucf_prename.prename_code')  
                ->join('sm_mem_m_membership_registered','sm_mem_m_membership_registered.membership_no','=','sm_crem_master.membership_no')
                ->where('sm_crem_master.crem_code','=',$membership_no)  
                ->first();
                
        $group = DB::select("SELECT	
                                aa.MEMBER_GROUP_NO, 
                                CONCAT(aa.MEMBER_GROUP_NAME,'(',bb.member_group_name,')') AS  MEMBER_GROUP_NAME   
                            FROM    
                                sm_mem_m_ucf_member_group as aa,    
                                sm_mem_m_ucf_member_group as bb  
                            WHERE   
                                ( aa.member_group_control = bb.member_group_no ) 
                                AND ( ( aa.member_group_no =  ( SELECT	member_group_no
                                                                FROM	sm_mem_m_membership_registered
                                                                WHERE	MEMBERSHIP_NO = '".$membership_no."') 
                                    ) ) ; ");
        $group = $group[0];
        
        $date_of_birth = calage($crem->DATE_OF_BIRTH); 
    
        return response()->json(compact('crem','date_of_birth','group'));
    }
}
