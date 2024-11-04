<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Api_mem_receive_gainController extends Controller
{
    // For Webmember page Gian
    public function member_gian()
    {
        $membership_no = Auth::user()->membership_no;

        $gain = DB::table('sm_mem_m_member_recrieve_gain')
                ->select('MEMBERSHIP_NO',
                'REC_NO',
                'GAIN_NAME',
                'related_na'
                )
                ->where('MEMBERSHIP_NO','=',$membership_no)
                ->get();

        return response()->json(compact('gain'));
    }
}
