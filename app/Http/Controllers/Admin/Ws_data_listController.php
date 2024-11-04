<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\www_data;
use App\Model\admin\www_data_img;

class Ws_data_listController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data_list = DB::select('SELECT * FROM www_data WHERE category = :category ORDER BY No DESC', ['category' => $_GET['Category']]);

        return view('admin.part.ws_data_list');
    }

    public function searchControl(Request $request)
    {

        $data_list = DB::table('www_data')->where('Question', 'LIKE', '%' . $request->sheach . '%')->orderBy('No', 'desc')->get();
        return redirect(url('admin/control?page=ws_data_list'))->with(['data_list' => $data_list]);
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
        // echo $request;
        // dd($request);
        $data = www_data::where('category', '=', $request->Category);

        $columns = array(
            0 => 'No',
            1 => 'Question',
            2 => 'DataSort',
        );

        $totalData = count($data->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if ($limit === "-1") {
            $posts = $data->orderBy($order, $dir)
                ->get();
        } else if (empty($request->input('search.value'))) {
            $posts = $data->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = $data->where('No', 'LIKE', "%{$search}%")
                ->orWhere('Question', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = $data->where('No', 'LIKE', "%{$search}%")
                ->orWhere('Question', 'LIKE', "%{$search}%")
                ->count();
        }



        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {

                $nestedData['No'] = $post->No;

                if(!empty($post->nphoto)){
                    $PrevImg = "<img src='".MEDIA_PATH.$post->nphoto."' width='150px' style='object-fit:contain;'/>";
                }else{
                    $PrevImg =  "";
                } 

                if (mb_strlen($post->Question, 'UTF-8') > 55) {
                    $Question = mb_substr($post->Question, 0, 55, 'UTF-8') . "...";
                } else {
                    $Question = $post->Question;
                }

                $nestedData['Question']  = '<div class="data_list_link">&nbsp;
                    <a href="' . url('show', $post->No) . '" target="_blank"
                        title="' . htmlspecialchars($post->Question) . '">
                        ' . $PrevImg . '
                        ' . $Question . '
                    </a>
                    <font size="1" color="#009900">&nbsp; </font>
                    <font size="1" color="#3366FF"><img src="images/icon/arr2_blu_op.gif"
                            alt="โดย" width="7" height="11" align="absmiddle" /></font>
                    <font size="1" color="#009900"> ' . $post->Name . '
                        <img src="images/icon/timelist.png" alt="วันที่" width="16"
                            height="16" align="absmiddle" /> </font>
                    <font size="1" color="#3366FF">
                        <font size="1" color="#3366FF">
                            ' . '[' . trim($post->Date, "00:00:00") . ']' . '
                        </font>
                    </font>
                </div>';

                $nestedData['DataSort'] =  $post->DataSort;

                $nestedData['edit'] = '<a href="?page=ws_post_edit&Category=' . $post->Category . '&No=' . $post->No . '&type=' . $request->type . '"><span class="glyphicon glyphicon-edit"></span></a>';

                $nestedData['delete'] = '<form id="delete-form-' . $post->No . '" method="post"
                action="' . route('ws_data_list.destroy', $post->No) . '"
                style="display: none">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
            </form>';
                $topic = "ต้องการลบหัวข้อ " . sprintf('%05d', $post->No) . " หรือไม่ ! ";
                $onclick = "event.preventDefault();
            document.getElementById('delete-form-" . $post->No . "').submit();";
                $nestedData['delete'] .= DangerModalalert('ลบหัวข้อ', $topic, 'alertdeltopic' . $post->No, '', $onclick);
                $nestedData['delete'] .= '<a href="" data-toggle="modal"
                data-target="#alertdeltopic' . $post->No . '"><span
                    class="glyphicon glyphicon-trash"></span></a>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
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
        if (count($request->json()->all())) {
            $ids = $request->json()->all();
            foreach ($ids as $i => $key) {
                $id = $key['id'];
                $position = $key['position'];
                $www_data = www_data::find($id);
                $www_data->DataSort = $position;
                if (!$www_data->save()) {
                    return response()->json('error', 200);
                }
            }
        }

        return response()->json('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chkData = www_data::find($id);
        $delCategory = $chkData->Category;
        $delDataSort = $chkData->DataSort;

        $chkDataPic = www_data_img::where('No', $chkData->No)->get();

        if ($chkData->delete()) {
            www_data_img::where('No', $id)->delete();
            if (count($chkDataPic) > 0) {
                for ($i = 0; $i < count($chkDataPic); $i++) {
                    $pathData = 'mediafiles/pic_activity/';
                    unlink($pathData . $chkDataPic[$i]->path_img);
                }
            }

            DB::update("UPDATE www_data
            SET
            DataSort = DataSort-1
            WHERE Category = :Category
            and DataSort > :DataSort", ['Category' => $delCategory, 'DataSort' => $delDataSort]);
        };

        return redirect()->back()->with('message', 'ลบหัวข้อ ' . $id . ' แล้ว');
    }
}
