<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\admin\www_mobile_send_msg;
use App\Model\member\SmMemMembershipRegistered;

class Ws_approve_messageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.part.ws_approve_message');
    }

    public function feed_indexMemno(Request $request)
    {

        $data = DB::table('www_mobile_send_msg')
            ->select(
                'www_mobile_send_msg.seq as seq',
                'www_mobile_send_msg.operate_date as operate_date',
                'sc_confirm_register.membership_no as member_name',
                'www_mobile_send_msg.title as title',
                'www_mobile_send_msg.message as detail',
                'status_confirm',
                'www_mobile_send_msg.status as status_read',
                'www_mobile_send_msg.img',
                'www_mobile_send_msg.ndata'

            )
            ->where("message_type", "01")
            ->join('sc_confirm_register', 'sc_confirm_register.membership_no', '=', 'www_mobile_send_msg.member_ref')
            ->join('sm_mem_m_membership_registered', 'sm_mem_m_membership_registered.membership_no', '=', 'sc_confirm_register.membership_no');

        $limit = $request->input('limit');
        $start = $request->input('offset');
        $order = $request->input('sort');
        $dir = $request->input('order');

        $totalData = count($data->get());

        $totalFiltered = $totalData;


        if (empty($request->input('search'))) {
            $posts = $data->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        } else {
            $search = $request->input('search');

            // $posts = $data->offset($start)
            //         ->limit($limit)
            //         ->orderBy($order,$dir)
            //         ->get();
            $posts = $data->where('sc_confirm_register.membership_no', 'LIKE', "%{$search}%")
                // ->orWhere('sm_mem_m_membership_registered.MEMBER_NAME', 'LIKE',"%{$search}%")
                // ->orWhere('sm_mem_m_membership_registered.MEMBER_SURNAME', 'LIKE',"%{$search}%")
                // ->orWhere('sm_mem_m_membership_registered.ID_CARD', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        }
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $ind => $post) {
                $nestedData['checkboxStatus'] =
                    $post->status_confirm == 0 ? '
                        <input type="checkbox" class="checkboxList' . $ind . '" name="checkboxList[]" value="' . $post->seq . '"/>
                    '
                    : '';
                $nestedData['operate_date'] = convert_to_Thaidate(explode(' ', $post->operate_date)[0])
                    . ' [เวลา ' . explode(' ', $post->operate_date)[1] . ' น.]';
                $nestedData['member_name'] = $post->member_name . ' <u>[ส่งตามทะเบียนสมาชิก]</u>';
                $img = '';
                if (!empty($post->img)) {
                    $path = "/mediafiles/" . $post->img;
                    $img = '<a href="' . $path . '" target="_blank" rel="noreferrer noopener"><img src="' . $path . '" width="85px" height="85px" style="object-fit: cover;" /></a>';
                }
                $nestedData['img'] = $img;
                $nestedData['detail'] = '
                <button class="btn btn-default" data-toggle="modal" type="button" data-target=".mydetail' . $ind . '">รายละเอียด</button>

                <div id="" class="modal fade mydetail' . $ind . '" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">' . $post->title . '</h4>
                            </div>
                            <div class="modal-body">
                                <p>' . $post->detail . '</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                ';
                $nestedData['status_confirm'] = $status_confirm = $post->status_confirm == 0 ? '<font class="text-danger">ยังไม่อนุมัติ</font>' : '<font class="text-success">อนุมัติเรียบร้อย</font>';
                $nestedData['status_read'] = $status_read = $post->status_read == 0 ? '<font class="text-danger">ยังไม่อ่าน</font>' : '<font class="text-success">อ่านแล้ว</font>';
                $nestedData['ndata'] = !empty($post->ndata) ? '<a href="/mediafiles/' . $post->ndata . '" target="_blank"><font color="blue">ลิงก์เอกสารแนบ</font></a>' : "-";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            // "draw"            => intval($request->input('draw')),
            "total"    => intval($totalData),
            "totalNotFiltered" => intval($totalFiltered),
            "rows"            => $data
        );
        echo json_encode($json_data);
    }

    public function feed_indexGroup(Request $request)
    {
        $data = DB::table('www_mobile_send_msg')
            ->select(
                'www_mobile_send_msg.seq as seq',
                'www_mobile_send_msg.operate_date as operate_date',
                // 'sc_confirm_register.membership_no as member_name',
                'www_mobile_send_msg.title as title',
                'www_mobile_send_msg.message as detail',
                'status_confirm',
                'www_mobile_send_msg.status as status_read',
                // 'sm_mem_m_membership_registered.MEMBER_GROUP_NO as member_group_no',
                'sm_mem_m_ucf_member_group.member_group_name',
                'sm_mem_m_ucf_member_group.MEMBER_GROUP_NO as member_group_no',
                'www_mobile_send_msg.img',
                'www_mobile_send_msg.ndata'
            )
            ->where("message_type", "02")
            // ->join('sm_mem_m_membership_registered', 'sm_mem_m_membership_registered.member_group_no', '=', 'www_mobile_send_msg.member_ref')
            // ->join('sc_confirm_register', 'sc_confirm_register.membership_no', '=', 'sm_mem_m_membership_registered.membership_no')
            ->join('sm_mem_m_ucf_member_group', 'sm_mem_m_ucf_member_group.member_group_no', '=', DB::raw('www_mobile_send_msg.member_ref COLLATE utf8_general_ci'));

        $limit = $request->input('limit');
        $start = $request->input('offset');
        $order = $request->input('sort');
        $dir = $request->input('order');

        $totalData = count($data->get());

        $totalFiltered = $totalData;


        if (empty($request->input('search'))) {
            $posts = $data->offset($start)
                ->limit($limit)
                ->orderBy('sm_mem_m_ucf_member_group.MEMBER_GROUP_NO', $dir)
                ->get();

            $totalFiltered = count($posts);
        } else {
            $search = $request->input('search');

            // $posts = $data->offset($start)
            //         ->limit($limit)
            //         ->orderBy($order,$dir)
            //         ->get();
            $posts = $data->where('sm_mem_m_ucf_member_group.member_group_name', 'LIKE', "%{$search}%")
                ->orWhere('sm_mem_m_ucf_member_group.MEMBER_GROUP_NO', 'LIKE', "%{$search}%")
                // ->orWhere('sm_mem_m_membership_registered.MEMBER_SURNAME', 'LIKE',"%{$search}%")
                // ->orWhere('sm_mem_m_membership_registered.ID_CARD', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        }

        $data = array();

        if (!empty($posts)) {
            foreach ($posts as $ind => $post) {
                $nestedData['checkboxStatus'] =
                    $post->status_confirm == 0 ? '
                        <input type="checkbox" class="checkboxList' . $ind . '" name="checkboxList[]" value="' . $post->seq . '"/>
                    '
                    : '';
                $nestedData['operate_date'] = convert_to_Thaidate(explode(' ', $post->operate_date)[0])
                    . ' [เวลา ' . explode(' ', $post->operate_date)[1] . ' น.]';
                $nestedData['member_name'] = $post->member_group_no . ' ' . $post->member_group_name . ' <u>[ส่งตามรายหน่วย]</u>';
                $img = '';
                if (!empty($post->img)) {
                    $path = "/mediafiles/" . $post->img;
                    $img = '<a href="' . $path . '" target="_blank" rel="noreferrer noopener"><img src="' . $path . '" width="85px" height="85px" style="object-fit: cover;" /></a>';
                }
                $nestedData['img'] = $img;

                $nestedData['detail'] = '
                <button class="btn btn-default" data-toggle="modal" type="button" data-target=".mydetail' . $ind . '">รายละเอียด</button>

                <div id="" class="modal fade mydetail' . $ind . '" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">' . $post->title . '</h4>
                            </div>
                            <div class="modal-body">
                                <p>' . $post->detail . '</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                ';

                $nestedData['status_confirm'] = $status_confirm = $post->status_confirm == 0 ? '<font class="text-danger">ยังไม่อนุมัติ</font>' : '<font class="text-success">อนุมัติเรียบร้อย</font>';
                $nestedData['status_read'] = $status_read = $post->status_read == 0 ? '<font class="text-danger">ยังไม่อ่าน</font>' : '<font class="text-success">อ่านแล้ว</font>';
                $nestedData['ndata'] = !empty($post->ndata) ? '<a href="/mediafiles/' . $post->ndata . '" target="_blank"><font color="blue">ลิงก์เอกสารแนบ</font></a>' : "-";

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            // "draw"            => intval($request->input('draw')),
            "total"    => intval($totalData),
            "totalNotFiltered" => intval($totalFiltered),
            "rows"            => $data
        );

        echo json_encode($json_data);
    }
    public function feed_indexAll(Request $request)
    {

        // dd($request->all());
        $data = DB::table('www_mobile_send_msg')
            ->select(
                'www_mobile_send_msg.seq as seq',
                'www_mobile_send_msg.operate_date as operate_date',
                'www_mobile_send_msg.title as title',
                'www_mobile_send_msg.message as detail',
                'status_confirm',
                'www_mobile_send_msg.status as status_read',
                'www_mobile_send_msg.img',
                'www_mobile_send_msg.ndata'
            )
            ->where('member_ref', 'all');

        $limit = $request->input('limit');
        $start = $request->input('offset');
        // $order = $request->input('sort');
        $order = 'seq';
        $dir = $request->input('order');

        $totalData = count($data->get());

        $totalFiltered = $totalData;


        if (empty($request->input('search'))) {
            $posts = $data->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        } else {
            $search = $request->input('search');

            // $posts = $data->offset($start)
            //         ->limit($limit)
            //         ->orderBy($order,$dir)
            //         ->get();
            $posts = $data->where('member_ref', 'LIKE', "%{$search}%")
                // ->orWhere('sm_mem_m_membership_registered.MEMBER_NAME', 'LIKE',"%{$search}%")
                // ->orWhere('sm_mem_m_membership_registered.MEMBER_SURNAME', 'LIKE',"%{$search}%")
                // ->orWhere('sm_mem_m_membership_registered.ID_CARD', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        }

        $data = array();

        if (!empty($posts)) {
            foreach ($posts as $ind => $post) {
                $nestedData['checkboxStatus'] =
                    $post->status_confirm == 0 ? '
                        <input type="checkbox" class="checkboxList' . $ind . '" name="checkboxList[]" value="' . $post->seq . '"/>
                    '
                    : '';
                $nestedData['operate_date'] = convert_to_Thaidate(explode(' ', $post->operate_date)[0])
                    . ' [เวลา ' . explode(' ', $post->operate_date)[1] . ' น.]';
                $img = '';
                if (!empty($post->img)) {
                    $path = "/mediafiles/" . $post->img;
                    $img = '<a href="' . $path . '" target="_blank" rel="noreferrer noopener"><img src="' . $path . '" width="85px" height="85px" style="object-fit: cover;" /></a>';
                }
                $nestedData['img'] = $img;

                $nestedData['member_name'] = ' <u>[ส่งแบบทุกคน]</u>';
                $nestedData['detail'] = '
                <button class="btn btn-default" data-toggle="modal" type="button" data-target=".mydetail' . $ind . '">รายละเอียด</button>

                <div id="" class="modal fade mydetail' . $ind . '" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">' . $post->title . '</h4>
                            </div>
                            <div class="modal-body">
                                <p>' . $post->detail . '</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                ';
                $nestedData['status_confirm'] = $status_confirm = $post->status_confirm == 0 ? '<font class="text-danger">ยังไม่อนุมัติ</font>' : '<font class="text-success">อนุมัติเรียบร้อย</font>';
                $nestedData['status_read'] = $status_read = $post->status_read == 0 ? '<font class="text-danger">ยังไม่อ่าน</font>' : '<font class="text-success">อ่านแล้ว</font>';
                $nestedData['ndata'] = !empty($post->ndata) ? '<a href="/mediafiles/' . $post->ndata . '" target="_blank"><font color="blue">ลิงก์เอกสารแนบ</font></a>' : "-";

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            // "draw"            => intval($request->input('draw')),
            "total"    => intval($totalData),
            "totalNotFiltered" => intval($totalFiltered),
            "rows"            => $data
        );

        echo json_encode($json_data);
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
        // dd($request->all());

        $notificationSent = false;
        $microDate    = date_create_from_format('U.u', number_format(microtime(true), 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Bangkok')))->format('u');
        $strYear    = date("Y");
        $strMonth    = date("m");
        $strDay        = date("d");
        $strHour    = date("H");
        $strMinute    = date("i");
        $strSeconds    = date("s");
        $today        = date_create("$strYear-$strMonth-$strDay $strHour:$strMinute:$strSeconds");
        $system_datetime = date_format($today, "d-m-Y H:i:s:") . $microDate;

        foreach ($request->checkboxList as $ind => $val) {
            $www_mobile_send_msg = www_mobile_send_msg::find($val);
            $www_mobile_send_msg->status_confirm = '1';
            $www_mobile_send_msg->save();

            if (!$notificationSent) {
                if ($request->selSearch == 'group') {
                    $member = SmMemMembershipRegistered::where('member_group_no', $www_mobile_send_msg->member_ref)->pluck('membership_no');

                    $record = [];
                    $send = [];

                    foreach ($member as $key => $value) {
                        $record[$key]['SYSTEM_DATETIME'] = $system_datetime;
                        $record[$key]['title'] = $www_mobile_send_msg->title;
                        $record[$key]['message'] = $www_mobile_send_msg->message;
                        $record[$key]['member_ref'] = $value;
                        $record[$key]['operate_date'] = $www_mobile_send_msg->operate_date;
                        $record[$key]['img'] = $www_mobile_send_msg->img;
                        $record[$key]['ndata'] = $www_mobile_send_msg->ndata;
                        $record[$key]['message_type'] = "02";
                        $record[$key]['status_confirm'] = 1;

                        array_push($send, array("field" => "tag", "key" => "membership_no", "relation" => "=", "value" => "$value"));
                        array_push($send, array("operator" => "OR"));
                    }

                    $insertSend = DB::table('www_mobile_send_msg')->insert($record);

                    $res = sendMulti($www_mobile_send_msg->title, $www_mobile_send_msg->message, $send);

                    // dd($res);

                } else if ($request->selSearch == 'memno') {
                    sendSingle($www_mobile_send_msg->title, $www_mobile_send_msg->message, $www_mobile_send_msg->member_ref);
                } else if ($request->selSearch == 'all') {
                    sendAll($www_mobile_send_msg->title, $www_mobile_send_msg->message);
                    break;
                }
            }
        }
        $notificationSent = !$notificationSent;
        if ($notificationSent) {
            return redirect()->back()->with('message', 'อนุมัติการส่งข้อความ แล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่สามารถอนุมัติการส่งข้อความ');
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
        dd($request->all(), $id);
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
