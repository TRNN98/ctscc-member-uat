<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\admin\www_mobile_send_msg;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Ws_mobile_send_messageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_memno = DB::table('sc_confirm_register')
            ->where('mem_confirm', '1')
            ->select('membership_no', DB::raw('fp_get_member_name(membership_no) as member_name'))->get();
        $search_group = DB::table('sm_mem_m_membership_registered')
            ->join('sc_confirm_register', 'sc_confirm_register.membership_no', '=', 'sm_mem_m_membership_registered.membership_no')
            ->join('sm_mem_m_ucf_member_group', 'sm_mem_m_ucf_member_group.MEMBER_GROUP_NO', '=', 'sm_mem_m_membership_registered.MEMBER_GROUP_NO')
            ->where('member_status_code', '0')
            ->groupBy('sm_mem_m_ucf_member_group.MEMBER_GROUP_NAME')
            ->select('sm_mem_m_ucf_member_group.MEMBER_GROUP_NAME', 'sm_mem_m_membership_registered.MEMBER_GROUP_NO')
            ->get();
        // dd($search_group);
        $search_memno = json_encode($search_memno);
        $search_group = json_encode($search_group);
        return view('admin.part.ws_mobile_send_message', compact('search_memno', 'search_group'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function retreiveData(Request $request)
    {
        //
        $search = $request->search;
        $action = $request->action;
        // dd($search ,$action);
        switch ($action) {
            case 'membership[]':
                if (empty($search) || $search == ' ') {
                    // $data = DB::select("SELECT MEMBERSHIP_NO,CONCAT('( ',MEMBERSHIP_NO,' ) ',MEMBER_NAME, ' ' ,MEMBER_SURNAME ) AS TEXT
                    // FROM sm_mem_m_membership_registered", []);
                    $data = DB::select("SELECT sm_mem_m_membership_registered.MEMBERSHIP_NO,CONCAT('( ',sm_mem_m_membership_registered.MEMBERSHIP_NO,' ) ',sm_mem_m_membership_registered.MEMBER_NAME, ' ' ,sm_mem_m_membership_registered.MEMBER_SURNAME ) AS TEXT
                    FROM sc_confirm_register JOIN
                    sm_mem_m_membership_registered ON sm_mem_m_membership_registered.membership_no =sc_confirm_register.membership_no
                    where mem_confirm ='1'
                    ", []);
                } else {
                    $data = DB::select(
                        "SELECT sm_mem_m_membership_registered.MEMBERSHIP_NO,CONCAT('( ',sm_mem_m_membership_registered.MEMBERSHIP_NO,' ) ',sm_mem_m_membership_registered.MEMBER_NAME, ' ' ,sm_mem_m_membership_registered.MEMBER_SURNAME ) AS TEXT
                    FROM   sc_confirm_register JOIN
                    sm_mem_m_membership_registered ON sm_mem_m_membership_registered.membership_no =sc_confirm_register.membership_no
                    where
                    1=1
                    and mem_confirm ='1'
                    and (sm_mem_m_membership_registered.membership_no like '%" . $search . "%'   OR sm_mem_m_membership_registered.MEMBER_NAME like '%" . $search . "%'   OR sm_mem_m_membership_registered.MEMBER_SURNAME like '%" . $search . "%'  )",
                        []
                    );
                }
                // if(!empty($data[0]->TEXT))
                return   response()->json([
                    'rc_code' => '1',
                    'res' => $data,
                    'error' => '0'
                ], 200);
                break;
            case 'member_group[]':
                if (empty($search) || $search == ' ') {
                    $data = DB::select("SELECT MEMBER_GROUP_NO,CONCAT('(',MEMBER_GROUP_NO,') ',MEMBER_GROUP_NAME) AS TEXT
                    FROM sm_mem_m_ucf_member_group ", []);
                } else {
                    $data = DB::select(
                        "SELECT MEMBER_GROUP_NO,CONCAT('(',MEMBER_GROUP_NO,') ',MEMBER_GROUP_NAME) AS TEXT
                        FROM sm_mem_m_ucf_member_group where (MEMBER_GROUP_NO like '%" . $search . "%'   OR MEMBER_GROUP_NAME like '%" . $search . "%'  )",
                        []
                    );
                }
                // if(!empty($data[0]->TEXT))
                return   response()->json([
                    'rc_code' => '1',
                    'res' => $data,
                    'error' => '0'
                ], 200);
                break;
            case 'member_external_import[]':

                // $path = asset('mediafiles/');
                // $inputFileName = $path . '/' . $search;
                $path = 'mediafiles/';
                $inputFileName = $path  . $search;
                /** Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = IOFactory::load($inputFileName);
                // $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $excel_result = json_encode($sheetData);
                $excel_result = json_decode($excel_result);
                // var_dump($excel_result);
                $membership_arr = array();
                // dd($inputFileName);

                foreach ($excel_result as $key => $value) {
                    if ($key == 1) {
                        $header = $value->A;
                    }
                    if ($key != 1) {
                        $val = Lpad($value->A);
                        array_push($membership_arr, "$val");
                    }
                }
                // dd($membership_arr,str_replace(']', '', str_replace('[', '', json_encode($membership_arr))));
                switch ($header) {
                    case 'เลือกตามทะเบียนสมาชิกรายตัว':

                        $data = DB::select("SELECT sm_mem_m_membership_registered.MEMBERSHIP_NO,CONCAT('( ',sm_mem_m_membership_registered.MEMBERSHIP_NO,' ) ',sm_mem_m_membership_registered.MEMBER_NAME, ' ' ,sm_mem_m_membership_registered.MEMBER_SURNAME ) AS TEXT
                  FROM   sc_confirm_register JOIN
                    sm_mem_m_membership_registered ON sm_mem_m_membership_registered.membership_no =sc_confirm_register.membership_no

                        where
                        1=1
                       and mem_confirm ='1'
                          and  sc_confirm_register.membership_no in (" . str_replace(']', '', str_replace('[', '', json_encode($membership_arr))) . ")");

                        break;
                    case 'เลือกตามรายหน่วย':
                        $data = '';
                        break;

                    default:
                        // echo 'กรุณาระบุหัวข้อให้ถูกต้อง';
                        $data = '';
                        break;
                }
                return   response()->json([
                    'rc_code' => '1',
                    'res' => $data,
                    'error' => '0'
                ], 200);
                break;

            default:
                return   response()->json([
                    'rc_code' => '-1',
                    'res' => 'ไม่พบข้อมูล',
                    'error' => 'ไม่พบข้อมูล'
                ], 404);
        }
        $data = DB::select("SELECT MEMBERSHIP, CONCAT('( ',MEMBERSHIP_NO,' ) ',MEMBER_NAME, ' ' ,MEMBER_SURNAME ) AS TEXT
        FROM sm_mem_m_membership_registered", []);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $img = '';
        if (!empty($request->show_pic_upload)) {
            // $nphoto = config('app.coop_file_path') . '/' . $request->show_pic_upload;
            $img = $request->show_pic_upload;
        } else {
        }
        $ndata = '';
        if (!empty($request->show_file_upload)) {
            // $ndata = config('app.coop_file_path') . '/' . $request->show_file_upload;
            $ndata =  $request->show_file_upload;
        } else {
        }
        $microDate    = date_create_from_format('U.u', number_format(microtime(true), 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Bangkok')))->format('u');
        $strYear    = date("Y");
        $strMonth    = date("m");
        $strDay        = date("d");
        $strHour    = date("H");
        $strMinute    = date("i");
        $strSeconds    = date("s");
        $today        = date_create("$strYear-$strMonth-$strDay $strHour:$strMinute:$strSeconds");
        $system_datetime = date_format($today, "d-m-Y H:i:s:") . $microDate;
        $insertSend = '';

        if (!empty($request->membership)) {
            foreach ($request->membership as $membership) {
                try {
                    $insertSend = DB::table('www_mobile_send_msg')
                        ->insert([
                            'SYSTEM_DATETIME' => $system_datetime,
                            'title' => $request->QTitle,
                            'message' => $request->QNote,
                            'member_ref' => $membership,
                            'operate_date' => DATETIME,     'img' => $img,
                            'ndata' => $ndata,
                            "message_type" => "01",
                        ]);
                } catch (Exception $e) {
                    // f_message("ทำรายการไม่สำเร็จ !!! error > " . $e);
                    return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ กรุณาลองใหม่อีกครั้ง!!');
                }
            }
        } else if (!empty($request->data)) {
            foreach ($request->data as $data) {
                try {
                    $insertSend = DB::table('www_mobile_send_msg')
                        ->insert([
                            'SYSTEM_DATETIME' => $system_datetime,
                            'title' => $data[1],
                            'message' => $data[2],
                            'member_ref' => $data[0],
                            'operate_date' => DATETIME,     'img' => $img,
                            'ndata' => $ndata,
                            "message_type" => "01",
                        ]);
                } catch (Exception $e) {
                    // f_message("ทำรายการไม่สำเร็จ !!! error > " . $e);
                    return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ กรุณาลองใหม่อีกครั้ง!!');
                }
            }
        } else if (!empty($request->member_group)) {
            // dd($request->member_group);
            foreach ($request->member_group as $member_group) {
                try {
                    $insertSend = DB::table('www_mobile_send_msg')
                        ->insert([
                            'SYSTEM_DATETIME' => $system_datetime,
                            'title' => $request->QTitle,
                            'message' => $request->QNote,
                            'member_ref' => $member_group,
                            'operate_date' => DATETIME,     'img' => $img,
                            'ndata' => $ndata,
                            "message_type" => "02",
                        ]);
                } catch (Exception $e) {
                    // f_message("ทำรายการไม่สำเร็จ !!! error > " . $e);
                    return redirect()->back()->with('danger', 'ไม่สามารถบันทึกได้ กรุณาลองใหม่อีกครั้ง!!');
                }
            }
        } else if (!empty($request->radioMemGroup) && $request->radioMemGroup == 'search_all') {
            if ($request->radioMemGroup == 'search_all') {
                $insertSend = DB::table('www_mobile_send_msg')
                    ->insert([
                        'SYSTEM_DATETIME' => $system_datetime,
                        'title' => $request->QTitle,
                        'message' => $request->QNote,
                        'member_ref' => 'all',
                        'operate_date' => DATETIME,
                        'img' => $img,
                        'ndata' => $ndata,
                        "message_type" => "03",
                    ]);
            }
        }
        // if ($request->optionsSearch == 'search_all') {
        //     $insertSend = DB::table('www_mobile_send_msg')
        //         ->insert([
        //             'SYSTEM_DATETIME' => $system_datetime,
        //             'title' => $request->QTitle,
        //             'message' => $request->QNote,
        //             'member_ref' => 'all',
        //             'operate_date' => DATETIME,
        //             'img' => $img,
        //             'ndata' => $ndata
        //         ]);
        // } else {
        //     for ($i = 0; $i < count($request->dual_select); $i++) :
        //         $insertSend = DB::table('www_mobile_send_msg')
        //             ->insert([
        //                 'SYSTEM_DATETIME' => $system_datetime,
        //                 'title' => $request->QTitle,
        //                 'message' => $request->QNote,
        //                 'member_ref' => $request->dual_select[$i],
        //                 'operate_date' => DATETIME,     'img' => $img,
        //                 'ndata' => $ndata
        //             ]);
        //     endfor;
        // }
        if ($insertSend == true) {
            return redirect()->back()->with('message', 'ส่งข้อความไปยัง Mobile App แล้ว');
        } else {
            return redirect()->back()->with('error', 'ส่งข้อความไปยัง Mobile App ไม่สำเร็จ');
        }
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
