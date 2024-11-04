<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Ws_member_registeredController extends Controller
{

    public function index()
    {
        $datamember = DB::select('SELECT sm_mem_m_membership_registered.membership_no,
                            sm_mem_m_membership_registered.prename,
                            sm_mem_m_membership_registered.member_name ,
                            sm_mem_m_membership_registered.member_surname ,
                            CONCAT(DAY(date_of_birth),"/",MONTH(date_of_birth),"/",YEAR(date_of_birth)+543) date_of_birth ,
                            sm_mem_m_membership_registered.id_card
                        FROM sm_mem_m_membership_registered');

        return view('admin.part.ws_member_registered',compact('datamember'));
    }

    public function feed_index(Request $request){
        $data = DB::table('sm_mem_m_membership_registered')
        ->where('MEMBER_STATUS_CODE', '0')
        ->select(DB::raw('CONCAT(DAY(date_of_birth),"/",MONTH(date_of_birth),"/",YEAR(date_of_birth)+543) as date_of_birth'),
                    'sm_mem_m_membership_registered.membership_no as membership_no',
                    'sm_mem_m_membership_registered.prename as prename',
                    'sm_mem_m_membership_registered.member_name as member_name' ,
                    'sm_mem_m_membership_registered.member_surname as member_surname',
                    'sm_mem_m_membership_registered.id_card as id_card' );

        $limit = $request->input('limit');
        $start = $request->input('offset');
        $order = $request->input('sort');
        $dir = $request->input('order');

        $totalData = count($data->get());

        $totalFiltered = $totalData;


        if(empty($request->input('search')))
        {
            $posts = $data->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            $totalFiltered = count($posts);
        }
        else {
            $search = $request->input('search');

            $posts = $data->where('membership_no','LIKE',"%{$search}%")
                            ->orWhere('member_name', 'LIKE',"%{$search}%")
                            ->orWhere('member_surname', 'LIKE',"%{$search}%")
                            ->orWhere('id_card', 'LIKE',"%{$search}%")
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

                $nestedData['membership_no'] = $post->membership_no;
                // $nestedData['member_name'] = '<a href="'.route("admin.impersonate", $post->membership_no).'" target="_blank" style="color: #ff935d;">';
                $nestedData['member_name'] = $post->prename." ".$post->member_name." ".$post->member_surname;
                // $nestedData['member_name'] .= '</a>';
                $nestedData['date_of_birth'] = $post->date_of_birth;
                $nestedData['id_card'] = $post->id_card;
                $nestedData['email'] = $post->email;

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
}
