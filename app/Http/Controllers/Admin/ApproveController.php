<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApproveController extends Controller
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
        return view('admin.part.approve');
    }

    public function feed_index(Request $request){
        // dump($request->all());
        $data = DB::table('sc_confirm_register')
            ->join('sm_mem_m_membership_registered', 'sc_confirm_register.membership_no', '=', 'sm_mem_m_membership_registered.membership_no');

        $limit = $request->input('limit');
        $start = $request->input('offset');
        $order = $request->input('sort');
        $dir = $request->input('order');

        $totalData = count($data->get());

        $totalFiltered = $totalData;


        if(empty($request->input('search')))
        {
            // dump($start,$limit,$order,$dir);
            // if(!empty($start) || !empty($limit)){

                $posts = $data->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            // }else{

            //     $posts = $data->limit(10)->orderBy($order,$dir)->get();

            // }

            $totalFiltered = count($posts);
            
        }
        else {
            $search = $request->input('search');

            // $posts = $data->offset($start)
            //         ->limit($limit)
            //         ->orderBy($order,$dir)
            //         ->get();
            $posts = $data->where('sc_confirm_register.membership_no','LIKE',"%{$search}%")
                            ->orWhere('sm_mem_m_membership_registered.MEMBER_NAME', 'LIKE',"%{$search}%")
                            ->orWhere('sm_mem_m_membership_registered.MEMBER_SURNAME', 'LIKE',"%{$search}%")
                            ->orWhere('sm_mem_m_membership_registered.ID_CARD', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = count($posts);
        }

        $data = array();

        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $disa1 = $post->mem_confirm == 1 ? "disabled" : "";
                $disa2 = $post->mem_confirm == 0 ? "disabled" : "";
                $nestedData['sc_confirm_register.membership_no'] = $post->membership_no;
                $nestedData['member_name'] = '<a href="'.route("admin.impersonate", $post->membership_no).'" target="_blank" style="color: #ff935d;">'.$post->PRENAME." ".$post->MEMBER_NAME." ".$post->MEMBER_SURNAME.'</a>';
                $nestedData['password'] = $post->mem_password_sha;
                $nestedData['sm_mem_m_membership_registered.id_card'] = $post->ID_CARD;
                $nestedData['sc_confirm_register.mem_confirm'] = $post->mem_confirm == 1 ? '<font color="blue"><b>อนุมัติแล้ว</b></font>' : '<font color="#FF0000"><b>ยังไม่อนุมัติ</b></font>' ;
                $nestedData['success'] = '<button id="btnok" class="btn btn-success" type="button" name="newconfirm" value="1" '.$disa1.' >ยืนยัน</button>';
                $nestedData['cancel'] = '<button id="btncancel" class="btn btn-warning" type="button" name="newconfirm" value="0" '.$disa2.' >ยกเลิก</button>';
                $nestedData['delete'] = '<button id="btndel" class="btn btn-danger" type="button" name="newconfirm" value="2">ลบ</button>';

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
        $update_memconfirm = DB::table('sc_confirm_register')->where('membership_no',$request->membership_no)->update(['mem_confirm'=>$request->mem_confirm]);
    }

    public function delete_memconfirm(Request $request)
    {
        $delete_memconfirm = DB::table('sc_confirm_register')->where('membership_no',$request->membership_no)->delete();
    }

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
