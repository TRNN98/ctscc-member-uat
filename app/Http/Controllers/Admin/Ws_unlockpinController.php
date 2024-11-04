<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Torann\GeoIP\Console\Update;

class Ws_unlockpinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $approve_user = DB::table('sm_auth_pincode')->get();
        // return view('admin.part.approve',compact('approve_user'));
        return view('admin.part.ws_unlockpin');
    }
    public function feed_mem_auth()
    {
        $mem_lock = DB::select("call mem_auth('', '', '', '', '11')");
        return response()->json(compact(
            'mem_lock'
        ));
    }
    public function feed_index(Request $request)
    {
        // dump($request->all());
        // $current_date = date('Y-m-d H:i:s');
        $current_date = date('Y-m-d');
        // $redate = DB::table('sm_auth_pincode')
        //     ->where([
        //         ['sm_auth_pincode.count', '>=', '3'],
        //         ['sm_auth_pincode.status', '>=', '1'],
        //         ['date', '<', $current_date],
        //         ['date', '>', '2:59:59']
        //     ]);
        // // ->whereDate() // 10 < 10
        // // ->whereTime(); // 4 > 2
        // $unlock = $redate->get();
        // if (!empty($unlock)) {
        //     foreach ($unlock as $un_lock) {
        //         $data = DB::table('sm_auth_device_pincode')->where('membership_no', $un_lock->membership_no)->update(['status' => '0']);
        //     }
        // }
        // $data = DB::table('sm_auth_pincode')
        //     ->where([
        //         ['sm_auth_pincode.count', '>=', '3'],
        //         ['sm_auth_pincode.status', '>=', '1'],
        //         ['date', '<=', $current_date],
        //         ['date', '>=', '3:00:00']
        //     ])->join('sm_mem_m_membership_registered', 'sm_auth_pincode.membership_no', '=', 'sm_mem_m_membership_registered.membership_no');
        $data = DB::table('sm_auth_pincode')
            ->join('sm_mem_m_membership_registered', 'sm_auth_pincode.membership_no', '=', 'sm_mem_m_membership_registered.membership_no')
            ->join('sm_auth_device_pincode', 'sm_auth_pincode.membership_no', '=', 'sm_auth_device_pincode.membership_no')
            ->where('sm_auth_pincode.count', '>=', 3)
            ->where('sm_auth_pincode.status', '>=', 1)
            ->where('sm_auth_device_pincode.status', '=', 1)
            ->where(function ($query) {
                $query->where('date', '<=', DB::raw('NOW()'))
                    ->orWhere('date', '>=', DB::raw('NOW() - INTERVAL 1 DAY'));
            });
        // dd($data->get());
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
            $posts = $data->where('sm_auth_pincode.id', 'LIKE', "%{$search}%")
                ->orWhere('sm_auth_pincode.membership_no', 'LIKE', "%{$search}%")
                ->orWhere('sm_auth_pincode.date', 'LIKE', "%{$search}%")
                ->orWhere('sm_auth_pincode.status', 'LIKE', "%{$search}%")
                ->orWhere('sm_auth_pincode.count', 'LIKE', "%{$search}%")
                ->orWhere('sm_mem_m_membership_registered.MEMBER_NAME', 'LIKE', "%{$search}%")
                ->orWhere('sm_mem_m_membership_registered.MEMBER_SURNAME', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = count($posts);
        }

        $data = array();



        if (!empty($posts)) {
            foreach ($posts as $post) {
                // $disa1 = $post->mem_confirm == 1 ? "disabled" : "";
                // $disa2 = $post->mem_confirm == 0 ? "disabled" : "";
                $nestedData['membership_id'] = $post->id;
                $nestedData['membership_no'] = $post->membership_no;
                $nestedData['member_name'] = '<font color="#ff935d">' . $post->PRENAME . " " . $post->MEMBER_NAME . " " . $post->MEMBER_SURNAME . '</font>';
                $nestedData['last_login'] = convert_to_Thaidate(explode(' ', $post->date)[0]) . ' เวลา ' . explode(' ', $post->date)[1] . ' น.';
                $nestedData['mem_status'] = $post->status == 1 ? '<font color="#FF0000"><b>ล็อค</b></font>' : '<font color="green"><b>ปกติ</b></font>';
                $nestedData['unlock'] = $post->status == 1 ? '<button id="btnok" class="btn btn-success" type="button" name="newconfirm" value="0">ปลดล็อค</button>' : '';

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
        // dd($request->membership_no, $request->mem_id, $request->mem_status);
        DB::table('sm_auth_device_pincode')->where('membership_no', $request->membership_no)->where('status', '1')->update(['status' => $request->mem_status]);
        DB::table('sm_auth_pincode')
            ->where('membership_no', $request->membership_no)
            ->where('status', '1')
            ->update([
                'status' => $request->mem_status,
                'count' => $request->mem_status
            ]);
    }

    public function delete_memconfirm(Request $request)
    {
        // $delete_memconfirm = DB::table('sm_auth_pincode')->where('membership_no', $request->membership_no)->delete();
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
