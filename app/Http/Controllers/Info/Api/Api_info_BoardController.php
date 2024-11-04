<?php

namespace App\Http\Controllers\Info\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Api_info_BoardController extends Controller
{
    public function getMembership()
    {
        if (Auth::guard('admin')->check()) {
            $is_admin = true;

        }else{
            $is_admin = false;
        }
        return $is_admin;
    }

    public function checkAuth()
    {
        if (Auth::guard('admin')->check()) {
            $auth = true;

        }else if(Auth::guard('api')->check()){
            $auth = true;

        }else{
            $auth = false;
        }
        return $auth;
    }

    public function board_list()
    {
        $is_admin =  $this->getMembership();
        $auth = $this->checkAuth();

        if ($auth) {
            $board = DB::table('www_board')
            ->select('www_board.*',
            DB::raw('(select count(1) from www_board_ans where www_board.No = www_board_ans.QuestionNo) as CountAnwser'))
            ->where('show_status',1)
            ->orderBy('Date','desc')
            ->paginate(15);
        }

        return response()->json(compact('board', 'is_admin'));
    }

    public function board_create(Request $request)
    {
        $auth = $this->checkAuth();
        if ($auth == false) {
            return response()->json([
                'rc_code' => '-1',
                'rc_des' => 'กรุณา เข้าสู่ระบบ',
                'error' => 'กรุณา เข้าสู่ระบบ'
            ], 400);
        }

        $IP = $_SERVER['REMOTE_ADDR'];
        $today = date('Y-m-d H:i:s');
        if (Auth::guard('admin')->check()) {
            $membership_no = Auth::guard('admin')->user()->username;
        }else{
            $membership_no = Auth::guard('api')->user()->membership_no;
        }

        $insert_board = DB::table('www_board')
                            ->insert(
                              [
                                 'Category' => 'BOARD_TOPIC'
                                ,'Question' => CheckVulgar($request->Question)
                                ,'Note' => CheckVulgar($request->QNote)
                                ,'Name' => CheckVulgar($request->QName)
                                ,'Namer' => ''
                                ,'IP' => $IP
                                ,'Email' => ''
                                ,'Date' => $today
                                ,'nphoto' => null
                                ,'ndata' => null
                                ,'pageview' => 0
                                ,'membership_no' => $membership_no
                                ,'show_status' => '1'
                              ]
                            );

        if($insert_board){
            return response()->json([
                'rc_code' => '1',
                'rc_des' => 'บันทึกสำเร็จ'
            ]);
        }else{
            return response()->json([
                'rc_code' => '0',
                'rc_des' => 'บันทึก ไม่สำเร็จ'
            ]);
        }

    }

    public function board_show($id)
    {
        $auth = $this->checkAuth();
        if ($auth == false) {
            return response()->json([
                'rc_code' => '-1',
                'rc_des' => 'กรุณา เข้าสู่ระบบ',
                'error' => 'กรุณา เข้าสู่ระบบ'
            ], 400);
        }

        $is_admin =  $this->getMembership();

        $showboard = DB::table('www_board')->where('show_status',1)->where('No',$id)->first();
        $board_detail = board_detail_answer($id);

        //update pageview
        $pageview = DB::table('www_board')->where('No',$id)->pluck('pageview')->first();
        $update_pageview = DB::table('www_board')->where('No',$id)->update(['pageview'=> (string)((int)$pageview+1) ]);

        return response()->json(compact('showboard', 'board_detail', 'is_admin'));
    }

    public function board_ans(Request $request)
    {
        $auth = $this->checkAuth();
        if ($auth == false) {
            return response()->json([
                'rc_code' => '-1',
                'rc_des' => 'กรุณา เข้าสู่ระบบ',
                'error' => 'กรุณา เข้าสู่ระบบ'
            ], 400);
        }
        if (Auth::guard('admin')->check()) {
            $membership_no = Auth::guard('admin')->user()->username;
        }else{
            $membership_no = Auth::guard('api')->user()->membership_no;
        }
        // dd($_SERVER);
        $IP = $_SERVER['REMOTE_ADDR'];
        $today = date('Y-m-d H:i:s');
        //dd($request->all(),(int)$request->QNo);
        $insert_board_ans = DB::table('www_board_ans')
                            ->insert(
                              [
                                  'Category' => 'BOARD_ANS'
                                , 'QuestionNo' => (int)$request->QNo
                                , 'Name' =>  CheckVulgar($request->QName)
                                , 'Namer' => $membership_no = empty($membership_no) ? 'Admin' : $membership_no
                                , 'IP' => $IP
                                , 'Msg' => CheckVulgar($request->QNote)
                                , 'Date' => $today
                                , 'nphoto' => ''
                                , 'ndata' => ''
                              ]
                            );


        if($insert_board_ans){
            return response()->json([
                'rc_code' => '1',
                'rc_des' => 'บันทึกสำเร็จ'
            ]);
        }else{
            return response()->json([
                'rc_code' => '0',
                'rc_des' => 'บันทึก ไม่สำเร็จ'
            ]);
        }
    }

    public function board_ans_del($id)
    {
        $auth = $this->checkAuth();
        if ($auth == false) {
            return response()->json([
                'rc_code' => '-1',
                'rc_des' => 'กรุณา เข้าสู่ระบบ',
                'error' => 'กรุณา เข้าสู่ระบบ'
            ], 400);
        }

        $delete_board_ans = DB::table('www_board_ans')->where('No',$id)->delete();

        if($delete_board_ans){
            return response()->json([
                'rc_code' => '1',
                'rc_des' => 'บันทึกสำเร็จ'
            ]);
        }else{
            return response()->json([
                'rc_code' => '0',
                'rc_des' => 'บันทึก ไม่สำเร็จ'
            ]);
        }
    }

    public function board_del($id)
    {
        $auth = $this->checkAuth();
        if ($auth == false) {
            return response()->json([
                'rc_code' => '-1',
                'rc_des' => 'กรุณา เข้าสู่ระบบ',
                'error' => 'กรุณา เข้าสู่ระบบ'
            ], 400);
        }
        // dd($id);
        $delete_board = DB::table('www_board')->where('No',$id)->delete();
        $delete_board_ans = DB::table('www_board_ans')->where('QuestionNo',$id)->delete();

        if($delete_board || $delete_board_ans){
            return response()->json([
                'rc_code' => '1',
                'rc_des' => 'บันทึกสำเร็จ'
            ]);
        }else{
            return response()->json([
                'rc_code' => '0',
                'rc_des' => 'บันทึก ไม่สำเร็จ'
            ]);
        }
        // return redirect()->back();
    }

}
