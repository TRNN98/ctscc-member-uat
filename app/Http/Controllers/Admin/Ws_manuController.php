<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Ws_manuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_manu = DB::table('www_ucf_manu')
                        ->where('status', '=', '1')
                        ->get();

        $list_sel_manu = DB::table('www_ucf_manu')
                        ->where('status', '=', '1')
                        ->where('is_parent', '=', '1')
                        ->get();

        $list_sub_manu = DB::table('www_ucf_sub_manu')
                            ->select('www_ucf_manu.manu_name' , 'www_ucf_manu.is_parent' , 'www_ucf_sub_manu.*' ,'www_ucf_category.description')
                            ->join('www_ucf_manu','www_ucf_sub_manu.manu_id', '=' ,'www_ucf_manu.seq')
                            ->join('www_ucf_category','www_ucf_sub_manu.cat_id', '=' ,'www_ucf_category.seq')
                            ->where('www_ucf_manu.status', '=', '1')
                            ->where('www_ucf_sub_manu.status', '=', '1')
                            ->where('www_ucf_category.status', '=', '1')
                            ->get();

        $list_cat = DB::table('www_ucf_category')
                        ->where('status', '=', '1')
                        ->whereNotIn('www_ucf_category.type', ['A', 'S'])
                        ->get();

        //dd($list_user);
        return view('admin.part.ws_manu',compact('list_manu', 'list_sel_manu', 'list_sub_manu', 'list_cat'));
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
        if(isset($request->btn_add_manu))
        {
            $insert_manu = DB::table('www_ucf_manu')->insert([
                [
                    'manu_name' => $request->manu_name,
                    'is_parent' => $request->is_parent,
                    'url' => $request->manu_url,
                ]
            ]);

            if ($insert_manu) {
                return redirect()->back()->with('message','เพิ่มข้อมูลสำเร็จ');
            }else{
                return redirect()->back()->with('error','เพิ่มข้อมูลไม่สำเร็จ');
            }

        }

        if(isset($request->btn_add_submanu))
        {

            $insert_sub_manu = DB::table('www_ucf_sub_manu')->insert([
                [
                    'manu_id' => $request->manu_id,
                    'cat_id' => $request->cat_id,
                    'url' => $request->sub_manu_url
                ]
            ]);

            if ($insert_sub_manu) {
                return redirect()->back()->with('message','เพิ่มข้อมูลสำเร็จ');
            }else{
                return redirect()->back()->with('error','เพิ่มข้อมูลไม่สำเร็จ');
            }
        }

        return redirect()->back()->with('error','ทำรายการไม่ถูกต้อง');

    }

    public function deletedata(Request $request)
    {
        $delete = DB::table($request->tablename)->where($request->fieldname,$request->pk)->delete();
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
        // dd($request->all(),$id);
        if(isset($request->is_parent)){
        
            $updateMenu = DB::table('www_ucf_manu')
                            ->where('seq',$id)
                            ->update([
                                'manu_name' => $request->menu_name,
                                'is_parent' => (int)$request->is_parent,
                                'url' => $request->url
                            ]);
            if($updateMenu){
                return redirect()->back()->with('message','เเก้ไขข้อมูลสำเร็จ');
            }else{
                return redirect()->back()->with('error','ทำรายการไม่ถูกต้อง');
            }

        }else{
            // dd($request->all(),$id);
            $updateMenu = DB::table('www_ucf_sub_manu')
                            ->where('seq',$id)
                            ->update([
                                'manu_id' => $request->menu_id,
                                'cat_id' => $request->cat_id,
                                'url' => $request->url
                            ]);
            if($updateMenu){
                return redirect()->back()->with('message','เเก้ไขข้อมูลสำเร็จ');
            }else{
                return redirect()->back()->with('error','ทำรายการไม่ถูกต้อง');
            }
        }
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
