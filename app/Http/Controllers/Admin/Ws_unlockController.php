<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Ws_unlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $approve_user = DB::table('sc_confirm_register')->get();
        // return view('admin.part.approve',compact('approve_user'));
        return view('admin.part.ws_unlock');
    }

    public function feed_index(Request $request)
    {

        $data = DB::table('sm_pro_device_regis')
            ->join('sm_mem_m_membership_registered', 'sm_pro_device_regis.membership_no', '=', 'sm_mem_m_membership_registered.membership_no')
            ->where('sm_pro_device_regis.status', '=', '1')
            // ->where('sm_pro_device_regis.phone', '!=', '')
            // ->where('sm_pro_device_regis.type', '=', 'F')
        ;

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
            $posts = $data->where('sm_pro_device_regis.membership_no', 'LIKE', "%{$search}%")
                ->orWhere('sm_mem_m_membership_registered.MEMBER_NAME', 'LIKE', "%{$search}%")
                ->orWhere('sm_mem_m_membership_registered.MEMBER_SURNAME', 'LIKE', "%{$search}%")
                ->orWhere('sm_mem_m_membership_registered.ID_CARD', 'LIKE', "%{$search}%")
                ->where('sm_pro_device_regis.status', '=', '1')
                // ->orWhere('sm_pro_device_regis.phone', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        }

        $data = array();

        if (!empty($posts)) {
            foreach ($posts as $post) {
                // $disa1 = $post->status == 1 ? "disabled" : "";
                // $disa2 = $post->mem_confirm == 0 ? "disabled" : "";
                $nestedData['sc_confirm_register.membership_no'] = $post->membership_no;
                $nestedData['member_name'] = '<a href="' . route("admin.impersonate", $post->membership_no) . '" target="_blank" style="color: #ff935d;">' . $post->PRENAME . " " . $post->MEMBER_NAME . " " . $post->MEMBER_SURNAME . '</a>';
                $nestedData['password'] = '<span>' . $post->mem_password_encrypt . '</span>';
                $nestedData['password'] .= '<i class="fa fa-eye-slash pull-right" style="cursor:pointer;margin-right:20px;" onclick="openPassWord(this);"></i>';
                $nestedData['password'] .= '<span style="display:none;color:blue;"><u>' . SoatDecode($post->mem_password_encrypt) . '</u></span>';
                // $nestedData['sm_mem_m_membership_registered.id_card'] = $post->ID_CARD;
                // $nestedData['sc_confirm_register.mem_confirm'] = $post->mem_confirm == 1 ? '<font color="blue"><b>อนุมัติแล้ว</b></font>' : '<font color="#FF0000"><b>ยังไม่อนุมัติ</b></font>' ;
                // $nestedData['success'] = '<button id="btnok" class="btn btn-success" type="button" name="newconfirm" value="1" '.$disa1.' >ยืนยัน</button>';
                // $nestedData['cancel'] = '<button id="btncancel" class="btn btn-warning" type="button" name="newconfirm" value="0" '.$disa2.' >ยกเลิก</button>';
                // $nestedData['delete'] = '<button id="btndel" class="btn btn-danger" type="button" name="newconfirm" value="2">ลบ</button>';

                $nestedData['id'] = '<p >' . $post->id . '<p>';
                $nestedData['mem_no'] = $post->membership_no;
                $nestedData['mem_name'] = '<a href="' . route("admin.impersonate", $post->membership_no) . '" target="_blank" style="color: #ff935d;">' . $post->PRENAME . " " . $post->MEMBER_NAME . " " . $post->MEMBER_SURNAME . '</a>';
                $nestedData['mem_id'] = $post->ID_CARD;
                $nestedData['mem_platform'] = $post->platform;
                $nestedData['mem_model'] = $post->model;
                $nestedData['mem_num'] = $post->MOBILE_NUMBER;
                $nestedData['unlock'] = '<button id="btnok" class="btn btn-warning" type="button" name="newconfirm" value="0" ><i class="fa fa-unlock" aria-hidden="true"></i>
                ปลดล็อค</button>';
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
        $update_memconfirm = DB::table('sm_pro_device_regis')->where('id', $request->id)->update(['status' => $request->status]);
    }

    // public function delete_memconfirm(Request $request)
    // {
    //     $delete_memconfirm = DB::table('sm_pro_device_regis')->where('id',$request->id)->delete();
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
