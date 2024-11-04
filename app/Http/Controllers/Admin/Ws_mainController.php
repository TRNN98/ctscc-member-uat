<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class Ws_mainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $count_board = DB::select('SELECT count(*) as count_board FROM www_board');
       $count_login = DB::select('SELECT count(*) as count_login FROM www_counter_member where visit_date = date(now())');
       $count_visitDay = DB::select('SELECT count(*) as count_visitDay FROM www_counter where visit_date = date(now())');
       $count_member = DB::select("SELECT count(*) as count_member FROM sm_mem_m_membership_registered where member_status_code = '0'");

       $myDatay = DB::select('SELECT COUNT(visit_date) as visit_years ,YEAR(visit_date) as years FROM www_counter GROUP BY  YEAR(visit_date) order by YEAR(visit_date) desc limit 0,5');

       $myDatam = DB::select('SELECT COUNT(visit_date) as visit_months ,fp_get_month_name(month(visit_date),1) as months ,  YEAR(visit_date) as years FROM  www_counter WHERE     YEAR(visit_date) = year(now()) GROUP BY  month(visit_date) order by month(visit_date) desc limit 0,5');

       $member_recent_regis = DB::select('SELECT * FROM www_counter_member order by visit_date desc , visit_time desc limit 0,10');
       $member_recent = DB::select('SELECT
                                        sc_confirm_register.membership_no,
                                        sc_confirm_register.operate_date,
                                        sm_mem_m_membership_registered.member_name,
                                        sm_mem_m_membership_registered.member_surname
                                    FROM
                                        sc_confirm_register,
                                        sm_mem_m_membership_registered
                                    where
                                        sc_confirm_register.membership_no = sm_mem_m_membership_registered.MEMBERSHIP_NO
                                    ORDER BY sc_confirm_register.operate_date DESC
                                    LIMIT 0 , 6');
       $board_recent = DB::select('SELECT www_board.No , www_board.Question , www_board_ans.Msg ,www_board_ans.Date , www_board_ans.Name ,www_board_ans.Member  FROM  www_board_ans, www_board where www_board_ans.QuestionNo = www_board.No order by www_board_ans.Date desc limit 0,6');

       // dd($board_recent);
        return view('admin.part.ws_main',['count_board' => $count_board[0] , 'count_login' => $count_login[0] , 'count_visitDay' => $count_visitDay[0] , 'count_member' => $count_member[0] , 'myDatam' => $myDatam , 'myDatay' => $myDatay , 'member_recent_regis' => $member_recent_regis , 'member_recent' => $member_recent , 'board_recent' => $board_recent  ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
