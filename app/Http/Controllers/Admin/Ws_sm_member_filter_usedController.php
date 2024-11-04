<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ws_sm_member_filter_usedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $constaint = DB::select("SELECT * from www_constant limit 1")[0];
        $Promoneysoftlaunch = $constaint->www_promoney_softlaunch;
        $FollowMEsoftlaunch = $constaint->www_followme_softlaunch;
        $member_maintenance = $constaint->member_maintenance;

        return view('admin.part.ws_sm_member_filter_used', compact('constaint', 'Promoneysoftlaunch', 'FollowMEsoftlaunch', 'member_maintenance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function feed_index(Request $request)
    {

        $data = DB::table('sm_mem_m_membership_registered')
            ->join('sm_member_filter_used', 'sm_mem_m_membership_registered.membership_no', '=', 'sm_member_filter_used.membership_no')
            ->where('member_status_code', '0')
            ->select(
                DB::raw('CONCAT(DAY(date_of_birth),"/",MONTH(date_of_birth),"/",YEAR(date_of_birth)+543) as date_of_birth'),
                'sm_mem_m_membership_registered.membership_no as membership_no',
                'sm_mem_m_membership_registered.member_name as member_name',
                'sm_mem_m_membership_registered.member_surname as member_surname',
                'sm_mem_m_membership_registered.id_card as id_card',
                'promoney_active',
                'followme_active',
                'register_active',
                'web_member_active'
            );

        $limit  = $request->input('limit');
        $start = $request->input('offset');
        $order = $request->input('sort');
        $dir = $request->input('order');

        $totalData = count($data->get());
        // dd($totalData);
        $totalFiltered = $totalData;


        if (empty($request->input('search'))) {
            $posts = $data->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        } else {
            $search = $request->input('search');

            $posts = $data->where('sm_member_filter_used.membership_no', 'LIKE', "%{$search}%")
                ->orWhere('member_name', 'LIKE', "%{$search}%")
                ->orWhere('member_surname', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {

                $nestedData['membership_no'] = $post->membership_no;
                // $nestedData['member_name'] = '<a href="'.route("admin.impersonate", $post->membership_no).'" target="_blank" style="color: #ff935d;">';
                // $nestedData['member_name'] = '<a href="'.route("admin.impersonate", $post->membership_no).'" target="_blank" style="color: #ff935d;">'.$post->prename." ".$post->member_name." ".$post->member_surname.'</a>';
                $nestedData['member_name'] = $post->member_name . " " . $post->member_surname;
                // $nestedData['member_name'] =+ '</a>';
                $nestedData['web_member_active'] = '<div style="display:flex; padding-right: 6px;">  ' . $this->DotStatus($post->web_member_active) . ' &nbsp;&nbsp; ' . $this->ButtonActive($post->web_member_active, 'web_member_active') . '</div>';
                $nestedData['followme_active'] = '<div style="display:flex; padding-right: 6px;"> ' . $this->DotStatus($post->followme_active) . ' &nbsp;&nbsp; ' . $this->ButtonActive($post->followme_active, 'followme_active') . ' </div>';
                $nestedData['promoney_active'] = '<div style="display:flex; padding-right: 6px;"> ' . $this->DotStatus($post->promoney_active) . ' &nbsp;&nbsp; ' . $this->ButtonActive($post->promoney_active, 'promoney_active') . ' </div>';
                // $nestedData['register_active'] = $this->ButtonActive($post->register_active, 'register_active');


                $nestedData['update'] = '<button style="display:flex; margin-right: 8px;" id="btnupdateMem" class="btn btn-success">อัพเดท</button>';
                $nestedData['delete'] = '<button style="display:flex; margin-right: 8px;" id="btndelMem" class="btn btn-danger">ลบ</button>';

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
    private function DotStatus($status)
    {
        $array_color_status_bootstrap = ['Crimson', 'MediumSeaGreen'];
        $color = $status == 1 ? $array_color_status_bootstrap[1] : $array_color_status_bootstrap[0];
        $html = '<div style="height:20px;width:20px; margin:0; margin:auto; border-radius: 50%; background-color:' . $color . ';" class=""></div>';
        return $html;
    }
    private function ButtonActive($status, $name)
    {
        // ' . $status == 0 ? 'selected' : '' . '

        // ' . $status == 1 ? 'selected' : '' . '
        $array_status_des = ['ไม่อนุญาต', 'อนุญาต'];
        $array_color_status_des = ['Crimson', 'MediumSeaGreen'];
        $array_color_status_bootstrap = ['danger', 'success'];

        $active_false = $status == 0 ? "selected" : "";
        $active_true = $status == 1 ? "selected" : "";

        $active_color = $status == 1 ? $array_color_status_bootstrap[1] : $array_color_status_bootstrap[0];

        $html = '<select class="form-control text-' . $active_color . '" name="' . $name . '" >
            <option style="color:' . $array_color_status_des[0] . ';" value="0" ' . $active_false . '>
            ' . $array_status_des[0] . '
            </option>
            <option style="color:' . $array_color_status_des[1] . ';" value="1"  ' . $active_true . '>
            ' . $array_status_des[1] . '
            </option>
        </select>';
        return $html;
    }
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
        // dd($request->all(),$request->addMemNo);
        $chkMem = DB::table('sm_mem_m_membership_registered')->where('membership_no', $request->addMemNo)->get();
        if (count($chkMem) > 0) {
            $addMem = DB::table('sm_member_filter_used')->insert([
                'membership_no' => $request->addMemNo,
                'promoney_active' => $request->promoney_active,
                'followme_active' => $request->followme_active,
                'web_member_active' => $request->web_member_active,
                'entry_date' => DATETIME,
                'created_date' => DATETIME
            ]);
            $typeColor = 'message';
            $msg = 'เพิ่มเลขทะเบียน ' . $request->addMemNo . ' แล้ว';
        } else {
            $typeColor = 'danger';
            $msg = 'ไม่มีเลขทะเบียน ' . $request->addMemNo . ' ในระบบ..กรุณาตรวจสสอบ เลขทะเบียนใหม่';
        }
        // dd(count($chkMem));

        return redirect()->back()->with($typeColor, $msg);
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
    public function update(Request $request)
    {
        //
        // dd($request->followme_active);
        $membership_no = $request->membership_no;
        $followme_active = $request->followme_active;
        $promoney_active = $request->promoney_active;
        $web_member_active = $request->web_member_active;
        // dd($followme_active, $promoney_active, $web_member_active);
        try {
            $update = DB::table('sm_member_filter_used')->where('membership_no', $membership_no)->update([
                'promoney_active' => $promoney_active,
                'followme_active' => $followme_active,
                'web_member_active' => $web_member_active,
                'updarted_date' => DATETIME

            ]);
        } catch (Exception $err) {
            return response()->json(['code' => "UP500FAILE", 'message' => 'ปรับข้อมูลไม่สำเร็จ ', 'data' => $err]);
        }

        return response()->json(['code' => "UP200SUCCESS", 'message' => 'ปรับข้อมูลสำเร็จ ', 'data' => '']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
    }

    public function delete(Request $request)
    {
        // dd($request->membership_no);
        // $delete = DB::table('sm_member_filter_used')->where('membership_no', $request->membership_no)->delete();
        try {
            $delete = DB::table('sm_member_filter_used')->where('membership_no', $request->membership_no)->delete();
        } catch (Exception $err) {
            return response()->json(['code' => "DEL500FAILE", 'message' => 'ลบข้อมูลไม่สำเร็จ ', 'data' => $err]);
        }

        return response()->json(['code' => "DEL200SUCCESS", 'message' => 'ลบข้อมูลสำเร็จ ', 'data' => '']);
    }
}
